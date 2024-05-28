<?php

defined('BASEPATH') OR exit('No direct script access allowed');


/**
 * SettingsController class extends MY_Controller.
 * This controller is responsible for handling settings-related functionalities.
 */
class SettingsController extends MY_Controller
{
	protected $_data = [];

    /**
     * Constructor for the SettingsController class.
    * Initializes the parent constructor.
    * Checks if the admin is logged in.
    * Sets the page title to 'Settings'.
    * Loads the Settings_model.
    */
	public function __construct(){
		parent::__construct();
		$this->checkAdminLoggedIn();
		$this->data['page_title'] = 'Settings';
		$this->load->model('Settings_model');
	}

    /**
     * Loads the Categories_model, retrieves settings and category data, and prepares data for editing settings.
    * Sets selected header and footer categories based on settings data.
    * Renders the admin edit template with the prepared data.
    *
    * @return $this
    */
	public function edit()
    {
        $this->load->model('Categories_model');

        $settings_data = $this->Settings_model->getSettingsById(1);
        $categories_data = $this->Categories_model->getCategoryArray(false);

        $selected_header_categories = [];
        $selected_footer_categories = [];

        if (isset($settings_data['header_menu_categories']) && $settings_data['header_menu_categories'] !== null) {
            $selected_header_categories = explode(',', $settings_data['header_menu_categories']);
        }

        if (isset($settings_data['footer_menu_categories']) && $settings_data['footer_menu_categories'] !== null) {
            $selected_footer_categories = explode(',', $settings_data['footer_menu_categories']);
        }
            
        $this->data['categories_data'] = $categories_data;
        $this->data['settings_data'] = $settings_data;
        $this->data['selected_header_categories'] = $selected_header_categories;
        $this->data['selected_footer_categories'] = $selected_footer_categories;

        $this->adminRenderTemplate('admin/Setting/edit', $this->data);
        return $this;
    }

    /**
     * Update the settings with the data provided by the user input.
     * The function retrieves user input for email address, phone number, address, social media URLs, and menu categories.
     * It then updates the settings in the database using the Settings_model.
     * If header or footer menu categories are provided, they are stored as comma-separated values.
     * Finally, a success message is set in the session flashdata and the user is redirected to the settings edit page.
     */
    public function update()
    {
        $this->form_validation->set_rules('order_cancel_period', 'Order Cancel Period', 'numeric');
        $this->form_validation->set_rules('shipping_charges', 'Shipping Charges', 'numeric');

        if ($this->form_validation->run() == FALSE) {
            $error_messages = validation_errors();
            $this->session->set_flashdata('error', $error_messages);
            redirect('admin/settings/edit');
        }
        
        $isStripeLiveMode = $this->input->post('is_stripe_live_mode');
        $stripeMode = 0;
        if(!empty($isStripeLiveMode) && $isStripeLiveMode == 'on'){
            $stripeMode = 1;
        }

        $data = [
			'email_address' => $this->input->post('email_address'),
			'phone_number' => $this->input->post('phone_number'),
            'address' => $this->input->post('address'),
            'facebook_url' => $this->input->post('facebook_url'),
            'youtube_url' => $this->input->post('youtube_url'),
            'instagram_url' => $this->input->post('instagram_url'),
            'linkedin_url' => $this->input->post('linkedin_url'),
            'twitter_url' => $this->input->post('twitter_url'),
            'order_cancel_period'=>$this->input->post('order_cancel_period'),
            'shipping_charges'=>$this->input->post('shipping_charges'),
            'stripe_publishable_key'=>$this->input->post('stripe_publishable_key'),
            'stripe_secret_key'=>$this->input->post('stripe_secret_key'),
            'live_stripe_publishable_key'=>$this->input->post('live_stripe_publishable_key'),
            'live_stripe_secret_key'=>$this->input->post('live_stripe_secret_key'),
            'is_stripe_live_mode'=>$stripeMode,
		];

        $data['header_menu_categories'] = $data['footer_menu_categories'] = '';
        if(!empty($this->input->post('header_menu_categories')))
        {
            $data['header_menu_categories'] = implode(',', $this->input->post('header_menu_categories'));
        }

        if(!empty($this->input->post('footer_menu_categories')))
        {
            $data['footer_menu_categories'] = implode(',', $this->input->post('footer_menu_categories'));
        }

        $this->Settings_model->update(1, $data);
		
        $this->session->set_flashdata('success', 'Settings successfully updated.');

		redirect('admin/settings/edit', 'refresh');
    }

    /**
	 * Update the Stripe mode settings based on the input value.
	*
	* This function retrieves the 'islivemode' value from the input POST data, converts it to a boolean value,
	* and updates the 'is_stripe_live_mode' setting in the database using the Settings_model.
	* If the setting value is 'true', it is stored as 1, otherwise as 0.
	*
	* @return void
	*/
	public function updateStripeMode() {
		$settingValue = $this->input->post('islivemode');
		$data['is_stripe_live_mode'] = ($settingValue == 'true'  ? 1 : 0);
		$this->Settings_model->update(1, $data);
		echo 1;
	}
}
