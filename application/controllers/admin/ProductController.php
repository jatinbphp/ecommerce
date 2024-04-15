<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class ProductController extends MY_Controller
{
	protected $_data = [];
	public function __construct(){
		parent::__construct();
		$this->checkAdminLoggedIn();
		$this->data['page_title'] = 'Products';
		$this->load->model('Product_model');
		$this->load->model('Categories_model');
		$this->load->model('ProductImage_model');
		$this->load->model('ProductOptions_model');
		$this->load->model('ProductOptionValues_model');
	}

	public function index(){
		$this->adminRenderTemplate('admin/Product/index', $this->data);
	}

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

	public function edit($id = null){
		if($id) {
			$this->form_validation->set_rules('category_id', 'Category ID', 'required|numeric');
			$this->form_validation->set_rules('product_name', 'Product Name', 'required');
			$this->form_validation->set_rules('sku', 'SKU', 'required');
			$this->form_validation->set_rules('description', 'Description', 'required');
			$this->form_validation->set_rules('type', 'Type', 'required');
			$this->form_validation->set_rules('price', 'Price', 'required|numeric');
			$this->form_validation->set_rules('status', 'Status', 'required');

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

			if($this->form_validation->run()){
				$productInfo = [
					'category_id' => $this->input->post('category_id'),
					'product_name' => $this->input->post('product_name'),
					'description' => $this->input->post('description'),
					'type' => $this->input->post('type'),
					'price' => $this->input->post('price'),
					'status' => $this->input->post('status'),
				];

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

	public function addProductOptionAddUpdate($input, $product_id)
    {
        $option_ids = [];
        $option_values_ids = [];

        if(!empty($input['options']['old'])){
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

            if(count($option_ids) > 0){
            	$this->db->where_not_in('id', $option_ids);
				$this->db->where('product_id', $product_id);
				$this->db->delete('products_options');

				$this->db->where_not_in('option_id', $option_ids);
				$this->db->where('product_id', $product_id);
				$this->db->delete('products_options_values');
            }

            if(count($option_values_ids) > 0){
            	$this->db->where_not_in('id', $option_values_ids);
				$this->db->where('product_id', $product_id);
				$this->db->delete('products_options_values');
            }
        }

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

	public function delete($id)
	{
		if($id) {
			$bannerDataRow = $this->Product_model->getDetails($id);
			if(isset($bannerDataRow['image'])){
				if (file_exists($bannerDataRow['image'])) {
					unlink($bannerDataRow['image']);
				}
			}
			$delete = $this->Product_model->delete($id);
			if($delete == true) {
				$this->session->set_flashdata('success', 'Product has been deleted successfully!');
				redirect('admin/products', 'refresh');
			}
			else {
				$this->session->set_flashdata('error', 'Error occurred!!');
				redirect('admin/products', 'refresh');
			}

		}
	}

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

	public function show($id){
        $banner = $this->Product_model->getDetails($id);
       	$data['banner'] = $banner;
        $html = $this->load->view('admin/Product/view', $data, true);
        echo $html;
    }

    public function getOpionType(){
    	return [
    		'color'    => 'Color',
            'select'   => 'Select',
            'checkbox' =>'Checkbox',
            'radio'    => 'Radio Button',
    	];
    }

    public function getProductType(){
    	return [
    		'sale' => 'Sale',
            'new'  => 'New',
            'hot'  => 'Hot',
    	];
    }
}
