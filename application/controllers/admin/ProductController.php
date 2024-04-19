<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * ProductController class extends the MY_Controller class.
 * This class is responsible for handling product-related operations and interactions within the application.
 */
class ProductController extends MY_Controller
{
	protected $_data = [];
	
	/**
	 * Constructor method for the ProductsController class.
	* Initializes the parent constructor and sets up necessary data and models.
	*/
	public function __construct(){
		parent::__construct();
		$this->checkAdminLoggedIn();
		$this->data['page_title'] = 'Products';
		$this->data['form_title'] = 'Product';
		$this->load->model('Product_model');
		$this->load->model('Categories_model');
		$this->load->model('ProductImage_model');
		$this->load->model('ProductOptions_model');
		$this->load->model('ProductOptionValues_model');
	}

	/**
	 * Render the index template for the Product controller in the admin panel.
	*
	* @return void
	*/
	public function index(){
		$this->adminRenderTemplate('admin/Product/index', $this->data);
	}

	/**
	 * Validates and creates a new product based on the form input.
	* If validation fails, it reloads the create form with error messages.
	* If creation is successful, it redirects to the edit page of the newly created product.
	*
	* @return $this
	*/
	public function create(){
		$this->form_validation->set_rules('category_id', 'Category Id', 'required');
		$this->form_validation->set_rules('product_name', 'Product Name', 'required');
		$this->form_validation->set_rules('sku', 'sku', 'required');
		$this->form_validation->set_rules('description', 'Description', 'required');
		$this->form_validation->set_rules('type', 'type', 'required');
		$this->form_validation->set_rules('price', 'price', 'required|numeric');
		$this->form_validation->set_rules('status', 'status', 'required');

        if ($this->form_validation->run() == FALSE) {
        	$this->data['status'] = $this->Product_model::$status;
        	$this->data['categories'] = $this->Categories_model->getCategoryArray(false);
        	$this->data['optionsType'] = $this->getOpionType();
        	$this->data['type'] = $this->getProductType();
        	$this->adminRenderTemplate('admin/Product/create', $this->data);
        	return $this;
        }

		$data = [
			'category_id' => $this->input->post('category_id'),
			'product_name' => $this->input->post('product_name'),
			'sku' => $this->input->post('sku'),
			'description' => $this->input->post('description'),
			'type' => $this->input->post('type'),
			'price' => $this->input->post('price'),
			'status' => $this->input->post('status'),
		];

		$createId = $this->Product_model->create($data);

		if($createId) {
			$this->session->set_flashdata('success', 'Product Info has been inserted successfully!.');
			$this->data['status'] = $this->Product_model::$status;
        	$this->data['categories'] = $this->Categories_model->getCategoryArray(false);
        	$this->data['optionsType'] = $this->getOpionType();
        	$this->data['type'] = $this->getProductType();
        	$this->data['product_data'] = $this->Product_model->getDetails($createId);
        	$this->data['nextTab'] = 'product-image';
        	$this->adminRenderTemplate('admin/Product/edit', $this->data);
		} else {
			$this->session->set_flashdata('error', 'Error occurred!!');
			redirect('admin/products/product-info', 'refresh');
		}
	}

	/**
	 * Edit a product with the given ID.
	*
	* @param int|null $id
	*/
	public function edit($id = null){
		if($id) {
			$this->form_validation->set_rules('category_id', 'Category ID', 'required|numeric');
			$this->form_validation->set_rules('product_name', 'Product Name', 'required');
			$this->form_validation->set_rules('sku', 'SKU', 'required');
			$this->form_validation->set_rules('description', 'Description', 'required');
			$this->form_validation->set_rules('type', 'Type', 'required');
			$this->form_validation->set_rules('price', 'Price', 'required|numeric');
			$this->form_validation->set_rules('status', 'Status', 'required');

			/**
			* Validates the options and option values in the provided data array.
			*
			* This method iterates over the 'options' array in the data and sets validation rules for each option.
			* It then iterates over the 'option_values' array in the data, setting validation rules for each option value.
			*
			* @param array $data The data array containing 'options' and 'option_values'
			*/
			if (isset($data['options']) && is_array($data['options'])) {
			    foreach ($data['options'] as $key => $value) {
			        $this->form_validation->set_rules("options[{$key}]", "Option Type [{$key}]", 'required');
			    }
			}

			if (isset($data['option_values']) && is_array($data['option_values'])) {
			    foreach ($data['option_values'] as $key => $values) {
			        if (is_array($values)) {
			            foreach ($values as $subkey => $value) {
			                $this->form_validation->set_rules("option_values[{$key}][{$subkey}]", "Option Value [{$key}][{$subkey}]", 'required');
			            }
			        }
			    }
			}

			/**
			* Validates form input and updates product information in the database.
			* If validation is successful, it updates the product information, uploads images, and adds product options.
			* If validation fails, it retrieves product details and necessary data for editing.
			*
			* @return void
			*/
			if($this->form_validation->run()){
				$productInfo = [
					'category_id' => $this->input->post('category_id'),
					'product_name' => $this->input->post('product_name'),
					'description' => $this->input->post('description'),
					'type' => $this->input->post('type'),
					'price' => $this->input->post('price'),
					'status' => $this->input->post('status'),
				];

				/**
				 * Upload images and get their paths, then create product images in the database.
				 *
				 * @return array|null An array of image paths if images were uploaded, otherwise null.
				 */
				if($paths = $this->uploadImagesAndgetPath()){
					foreach ($paths as $path) {
		                $this->ProductImage_model->create(
		                	[
		                    	'product_id' => $id,
		                    	'image' =>  $path,
		                	]
		                );
		            }
				}

				/**
				 * Add or update a product option based on the input data and product ID.
				 *
				 * @param array $postData The input data containing the product option details.
				 * @param int $productId The ID of the product to which the option belongs.
				 */
				$this->addProductOptionAddUpdate($this->input->post(), $id);

				$update = $this->Product_model->edit($productInfo, $id);
				if($update == true) {
					$this->session->set_flashdata('success', 'Product has been updated successfully!.');
					redirect('admin/products', 'refresh');
				} else {
					$this->session->set_flashdata('error', 'Error occurred!!');
					redirect('admin/products/edit/'.$id, 'refresh');
				}
			} else {
				$productData = $this->Product_model->getDetails($id);
				$this->data['product_data'] = $productData;
				$this->data['status'] = $this->Product_model::$status;
        		$this->data['categories'] = $this->Categories_model->getCategoryArray(false);
        		$this->data['optionsType'] = $this->getOpionType();
        		$this->data['type'] = $this->getProductType();
        		$this->data['product_images'] = $this->ProductImage_model->getDetails($id);
        		$this->data['product_options'] = $this->ProductOptions_model->getOptionsWithValues($id);

				$this->adminRenderTemplate('admin/Product/edit', $this->data);
			}
		}
	}

	/**
	 * Add or update product options and their values based on the input data.
	*
	* This method processes the input data to add or update product options and their values for a given product.
	*
	* @param array $input The input data containing information about product options and values.
	* @param int $product_id The ID of the product for which the options and values are being added or updated.
	* @return void
	*/
	public function addProductOptionAddUpdate($input, $product_id)
    {
        $option_ids = [];
        $option_values_ids = [];

        if(!empty($input['options']['old'])){
            /**
             * Update product options and their values based on the input data.
             *
             * This code iterates over the old options and their values, updates existing values or creates new ones,
             * and then iterates over the new options and their values to create them.
             *
             * @param array $input The input data containing old and new options and values
             * @param int $product_id The ID of the product to update options for
             * @return void
             */
            foreach ($input['options']['old'] as $key => $value) {
                $inputOption = [
                    'product_id' => $product_id,
                    'option_name' => isset($value['name']) ? $value['name'] : '',
                    'option_type' => isset($value['type']) ? $value['type'] : '',
                ];
                $this->ProductOptions_model->edit($inputOption, $key, $product_id);
                $option_ids[] = $key;
               
                if(!empty($input['option_values']['old'][$key])){
                    foreach ($input['option_values']['old'][$key] as $oKey => $oValue) {
                        $option_value = $this->ProductOptionValues_model->getDetails($oKey, $key, $product_id);
                        $inputOptionValues = [
                            'product_id' => $product_id,
                            'option_id' => $key,
                            'option_value' => $oValue,
                            /*'option_price' => $input['option_price']['old'][$key][$oKey],*/
                        ];

                        if(empty($option_value)){
                            $option_new_value = $this->ProductOptionValues_model->create($inputOptionValues);

                            $option_values_ids[] = $option_new_value;
                        } else {
                        	$this->ProductOptionValues_model->edit($inputOptionValues, $oKey, $key, $product_id);
                            $option_values_ids[] = $oKey;
                        }
                    }
                }

                if(!empty($input['option_values']['new'][$key])){
                    foreach ($input['option_values']['new'][$key] as $oKey => $oValue) {
                        $inputOptionValues = [
                            'product_id' => $product_id,
                            'option_id' => $key,
                            'option_value' => $oValue,
                            /*'option_price' => $input['option_price']['new'][$key][$oKey],*/
                        ];
                        $option_new_value = $this->ProductOptionValues_model->create($inputOptionValues);

                        $option_values_ids[] = $option_new_value;
                    }
                }
            }

            /**
             * Delete records from the 'products_options' and 'products_options_values' tables based on the provided option IDs and product ID.
             *
             * @param array $option_ids An array of option IDs to exclude from deletion
             * @param int $product_id The ID of the product
             */
            if(count($option_ids) > 0){
            	$this->db->where_not_in('id', $option_ids);
				$this->db->where('product_id', $product_id);
				$this->db->delete('products_options');

				$this->db->where_not_in('option_id', $option_ids);
				$this->db->where('product_id', $product_id);
				$this->db->delete('products_options_values');
            }

            /**
             * Delete records from the 'products_options_values' table where the 'id' is not in the provided array of option values IDs and the 'product_id' matches the given product ID.
             *
             * @param array $option_values_ids
             * @param int $product_id
             */
            if(count($option_values_ids) > 0){
            	$this->db->where_not_in('id', $option_values_ids);
				$this->db->where('product_id', $product_id);
				$this->db->delete('products_options_values');
            }
        }

        /**
         * Create new product options and their values based on the input data.
         *
         * This method iterates over the 'new' options and their values in the input array.
         * For each new option, it creates a record in the ProductOptions_model and then
         * iterates over the corresponding new option values to create records in the
         * ProductOptionValues_model.
         *
         * @param array $input The input data containing new options and their values
         * @param int $product_id The ID of the product to which the options belong
         * @return void
         */
        if(!empty($input['options']['new'])){
            foreach ($input['options']['new'] as $key => $value) {
                if(!empty($value)){
                    $inputOption = [
                        'product_id' => $product_id,
                        'option_name' => isset($value['name']) ? $value['name'] : '',
                    	'option_type' => isset($value['type']) ? $value['type'] : '',
                    ];

                    $optionId = $this->ProductOptions_model->create($inputOption);

                    if(!empty($input['option_values']['new'][$key])){
                        foreach ($input['option_values']['new'][$key] as $oKey => $oValue) {
                            $inputOptionValues = [
                                'product_id' => $product_id,
                                'option_id' => $optionId,
                                'option_value' => $oValue,
                                /*'option_price' => $input['option_price']['new'][$key][$oKey],*/
                            ];
                            $this->ProductOptionValues_model->create($inputOptionValues);
                        }
                    }
                }
            }
        }
    }

	/**
	 * Uploads images and returns their file paths.
	*
	* This method uploads images from the 'file' input field, saves them in the 'uploads/products/' directory,
	* and returns an array of file paths for the uploaded images.
	*
	* @return array An array of file paths for the uploaded images
	*/
	public function uploadImagesAndgetPath() {
	    $imagePaths = [];

	    if (!empty($_FILES['file']['name'][0])) {
	        $this->load->library('upload');

	        $config['upload_path'] = 'uploads/products/';
	        $config['allowed_types'] = 'gif|jpg|jpeg|png';
	        $config['max_size'] = 106610;
	        $config['encrypt_name'] = TRUE;

	        $this->upload->initialize($config);

	        // Loop through each file in the array
	        foreach ($_FILES['file']['name'] as $key => $value) {
	            $_FILES['userfile']['name'] = $_FILES['file']['name'][$key];
	            $_FILES['userfile']['type'] = $_FILES['file']['type'][$key];
	            $_FILES['userfile']['tmp_name'] = $_FILES['file']['tmp_name'][$key];
	            $_FILES['userfile']['error'] = $_FILES['file']['error'][$key];
	            $_FILES['userfile']['size'] = $_FILES['file']['size'][$key];

	            if ($this->upload->do_upload('userfile')) {
	                $uploadData = $this->upload->data();
	                $imagePath = 'uploads/products/' . $uploadData['file_name'];
	                $imagePaths[] = $imagePath;
	            } else {
	                // Handle upload errors if needed
	                //$error = $this->upload->display_errors();
	                //echo $error;
	            }
	        }
	    }

	    return $imagePaths;
	}

	/**
	 * Remove an image from the server and delete its record from the database.
	*
	* @return bool Returns true if the image was successfully removed and the record was deleted, false otherwise.
	*/
	public function removeimage()
	{
		$id      = $this->input->post('id');
		$imgName = $this->input->post('img_name');
		
		if($id && $imgName) {
			unlink($imgName);
			$this->ProductImage_model->delete($id);
			echo true;
		}
		echo false;
	}

	/**
	 * Delete a product and its associated data from the database.
	*
	* @param int $id The ID of the product to delete
	*/
	public function delete($id)
	{
		if($id) {
			$delete = $this->Product_model->delete($id);
			if($delete == true) {
				$this->ProductImage_model->deleteProductImages($id);
				$this->ProductOptions_model->deleteProductOptions($id);
				$this->ProductOptionValues_model->deleteProductOptionsValues($id);
				echo true;
			}
			echo false;
		}
	}

	/**
	 * Fetches products data to display in a DataTable.
	* Retrieves product data from the Product_model and formats it for display.
	* Includes product ID, name, SKU, price, status button, creation date, and edit/delete/view buttons.
	* Returns the formatted data as JSON for DataTable rendering.
	*/
	public function fetchProducts()
	{
		$data    = [];
		$allData = $this->Product_model->make_datatables();

		foreach ($allData as $row) {
			$productData = [];
			$productData[] = "#".$row->id;
			$productData[] = $row->product_name;
			$productData[] = $row->sku;
			$productData[] = $row->price;
			$productData[] = $this->getStatusButton($row->id, $row->status, 'products');
			$productData[] = $row->created_at;
			$productData[] = '<a href="' . base_url('admin/products/edit/' . $row->id) . '" class="btn btn-sm btn-info"  style="margin-right:5px;"><i class="fa fa-edit"></i></a><a href="javascript:void(0);" class="btn btn-sm btn-danger deleteRecord" style="margin-right:5px;" data-id="' . $row->id . '" data-controller="products" data-title="products"><i class="fa fa-trash"></i></a><a href="javascript:void(0)" title="View Product" data-id="'. $row->id .'" class="btn btn-sm btn-warning tip  view-info" data-title="Product Details" data-url="'.base_url('admin/products/show/' . $row->id).'">
            	<i class="fa fa-eye"></i></a>';

			$data[] = $productData;
		}

		$output = [
			"draw"            => intval($_POST["draw"]),
			"recordsTotal"    => $this->Product_model->get_all_data(),
			"recordsFiltered" => $this->Product_model->get_filtered_data(),
			"data"            => $data,
		];
		echo json_encode($output);
	}

    /**
     * Get the available option types.
     *
     * @return array
     */
    public function getOpionType(){
    	return [
			'select'   => 'Select',
    		'color'    => 'Color',
            'checkbox' =>'Checkbox',
            'radio'    => 'Radio Button',
    	];
    }

    /**
     * Get an array of product types with their corresponding labels.
     *
     * @return array
     */
    public function getProductType(){
    	return [
    		'sale' => 'Sale',
            'new'  => 'New',
            'hot'  => 'Hot',
    	];
    }

    /**
     * Display the details of a product with the given ID.
     *
     * @param int $id The ID of the product to display.
     * @return void
     */
    public function show($id){
        $product = $this->Product_model->getDetails($id);
        $productImage = $this->ProductImage_model->getDetails($id);
       	$data['product'] = $product;
       	$data['product_image'] = $productImage;
       	$data['product_options'] = $this->ProductOptions_model->getOptionsWithValues($id);
        $html = $this->load->view('admin/Product/view', $data, true);
        echo $html;
    }
}
