<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AuthController extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('user_model');
        $this->load->model('countries_model');
        $this->load->library('email');
    }

    //This function is use for display signUp Page
    public function index() {
        $this->userRedirectIfLoggedIn();
        $countryCode = $this->countries_model->getCountryData();
        $this->load->view('front/auth/signUp',['countryCode' => $countryCode]); 
    }

    //This function is use for display otp Page
    public function optCheckView()
    {
        $this->userRedirectIfOtpNotSent();
        $this->load->view('front/auth/otpCheck');
    }

    public function logIn() {
        $this->userRedirectIfLoggedIn();
        $this->load->view('front/auth/signIn'); 
    }

    public function dashboard() {
        $this->load->view('front/Home/homePage'); 
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect('signIn');
    }

    public function forgotPassword(){
        $this->load->view('front/auth/forgotPassword'); 
    }

    public function setNewPassword($token){
        $user = $this->user_model->getUserByResetToken($token);

        if ($user) {
            $this->load->view('front/auth/resetPassword', array('token' => $token));
        } else {
            redirect(base_url('forgotPassword'));
        }
    }

    public function updateNewPassword()
    {
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]|callback_strong_password_check');
        $this->form_validation->set_rules('confirm_password', 'Retype Password', 'trim|required|matches[password]');

        $getTokenVal = $this->input->post('token');
        if ($this->form_validation->run() == FALSE) {
            $error_messages = validation_errors();
            $this->session->set_flashdata('error', $error_messages);
            redirect(base_url('setNewPassword/' . $getTokenVal));
        }

        $getTokenChk = $this->user_model->getUserByResetToken($getTokenVal);

        if($getTokenChk)
        {
            $password = $this->input->post('password');
            if ($this->user_model->updatePasswordByResetToken($getTokenVal, $password)) {
                $this->session->set_flashdata('success_message', 'Your password has been reset successfully. You can now log in with your new password');
                redirect(base_url('signIn'));
            } 
            else
            {
                $this->session->set_flashdata('error', 'Failed to update password. Please try again.');
                redirect(base_url('setNewPassword/' . $getTokenVal));
            }
        }
        else
        {
            redirect(base_url('forgotPassword'));
        }
    }

    public function sendForgotPasswordMail(){
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        if ($this->form_validation->run() == FALSE) {
            $error_messages = validation_errors();
            $this->session->set_flashdata('error', $error_messages);
            redirect(base_url('forgotPassword'));
        }

        $email = $this->input->post('email');
        $getEmailFlag = $this->user_model->isEmailExists($email);

        if($getEmailFlag)
        {   
            $getUsrData = $this->user_model->getUserDataByEmail($email,2);
            $getUsrId = (isset($getUsrData->id)) ? $getUsrData->id : 0;
            $token = md5(uniqid(rand(), true)).$getUsrId;
            $this->user_model->saveResetToken($email, $token);
            $reset_link = base_url('setNewPassword/' . $token);
            $this->email->from('noreply@gorentonline.com', 'Support');
            $this->email->to($email);
            $this->email->subject('Password Reset Request');

            $message = $this->load->view('front/EmailTemplates/forgotPasswordEmail',['reset_link' => $reset_link],true);

            //$message = "<p>Click this link to reset your password: <a href='$reset_link'>$reset_link</a></p>";
            $this->email->message($message);
            if ($this->email->send()) {
                $this->session->set_flashdata('success_message', "Instructions for resetting your password have been emailed to <strong>".$email."</strong>");
                redirect(base_url('forgotPassword'));
            } else {
                $this->session->set_flashdata('error', $this->email->print_debugger());
                redirect(base_url('forgotPassword'));
            }
        }
        else
        {
            $this->session->set_flashdata('error', 'Email is not found');
            redirect(base_url('forgotPassword'));
        }
    }


   public function storeUser()
   {    
        $this->form_validation->set_rules('fname', 'First Name', 'required');
        $this->form_validation->set_rules('lname', 'Last Name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]|callback_strong_password_check');
        $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[password]');
        $this->form_validation->set_rules('mobileNo', 'Mobile No', 'required');
        $this->form_validation->set_rules('countryCode', 'Country Code', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('front/auth/signUp');
        }
        else {

            $data = array(
                'first_name' => $this->input->post('fname'),
                'last_name' => $this->input->post('lname'),
                'email' => $this->input->post('email'),
                'phone' => $this->input->post('mobileNo'),
                'country_code' => $this->input->post('countryCode'),
                'role' => 2,
                'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            );

             if ($this->user_model->register_user($data)) {
                $this->session->set_flashdata('success_message', 'You are successfully registered');
                $this->user_model->resetLoginAttempts($this->input->post('email'));

                $getOtpCode = $this->generateOTP();
                $this->session->set_userdata('user_email', $this->input->post('email'));
                $this->session->set_userdata('otp_sent', 'true');

                $this->db->where('email', $this->input->post('email'));
                $this->db->update('users', array('otp_code' =>$getOtpCode));

                $this->sendUserOtpCodeEmail($this->input->post('email'),$getOtpCode);
                redirect('otpCheck');
            } else {
                echo 'Registration failed. Please try again.';
            }
        }
   }

   public function strong_password_check($password) {
        if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{6,}$/', $password)) {
            $this->form_validation->set_message('password_check', 'Your password must contain at least one lowercase letter, one uppercase letter, and one digit');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function authUser() {
        $email = $this->input->post('email');
        $password = $this->input->post('password');
        $user = $this->user_model->authenticate($email, $password, 2);
        if ($user) {
            $this->session->set_userdata('user_data', $user);
            $this->session->set_userdata('user_email', $email);
            $this->session->set_userdata('otp_sent', 'true');
            $this->user_model->resetLoginAttempts($email);

            $getOtpCode = $this->generateOTP();
            $this->db->where('id', $user->id);
            $this->db->update('users', array('otp_code' =>$getOtpCode));

            $this->sendUserOtpCodeEmail($email,$getOtpCode);

            redirect('otpCheck');
        } else {
             $this->incrementLoginAttempts($email);
             $this->session->set_flashdata('error', 'Email or password is incorrect.Please check your email and password');
             redirect(base_url('signIn'));
        }
    }

    public function sendUserOtpCodeEmail($email,$otpCode)
    {
        $this->email->from('noreply@gorentonline.com', 'Support');
        $this->email->to($email);
        $this->email->subject('Your One-Time Password (OTP) for Verification');

        $message = $this->load->view('front/EmailTemplates/otpEmail',['otpCode' => $otpCode],true);

        $this->email->message($message);
        if ($this->email->send()) {
            $this->session->set_flashdata('success_message', 'Your One-Time Password (OTP) has been emailed to <strong>'.$email.'</strong>');
            redirect(base_url('otpCheck'));
        } else {
            $this->session->set_flashdata('error', 'OTP email is not sent due to :'.$this->email->print_debugger()." So please signIn again.");
            redirect(base_url('signIn'));
        }
    }

   public function check_email_exists() {
        $email = $this->input->post('email');
        $result = $this->user_model->isEmailExists($email);
        if($result)
        {
            echo json_encode(false);
        }
         else {
            echo json_encode(true);
        }
    }

     private function incrementLoginAttempts($email) {
        $user = $this->user_model->getUserByUsername($email);
        
        if ($user) {

            if($user->login_attempts < 5)
            {
                $this->user_model->incrementLoginAttempts($user->id);
                $this->session->set_flashdata('error', 'Invalid email or password');
            }
            else
            {
                $this->db->where('id', $user->id);
                $this->db->update('users', array('status' => 'inactive'));
                $this->session->set_flashdata('error', 'You have reached the maximum login attempts. Please contact customer service.');
            }
        }
    }

    private function generateOTP() {
        $length = 6;
        $otp = "";
        $characters = "0123456789";
        $charLength = strlen($characters);
        for ($i = 0; $i < $length; $i++) {
            $otp .= $characters[rand(0, $charLength - 1)];
        }
        return $otp;
    }

     public function verifyOTP() {
        $otp_entered = $this->input->post('otp');
        $email = $this->session->userdata('user_email');
        $user = $this->db->get_where('users', array('email' => $email))->row();

        if ($user) {
            $stored_otp = $user->otp_code;

            if ($otp_entered == $stored_otp) {
                $this->session->set_flashdata('success', 'OTP verified successfully. User authenticated.');
                $this->user_model->resetOtp($user->id);

                $userdata = array(
                    'id ' => $user->id,
                    'first_name' => $user->first_name,
                    'last_name' => $user->last_name,
                    'email' => $user->email,
                    'role' => $user->role,
                    'phone' => $user->phone,
                    'status' => $user->status,
                    'login_attempts' => $user->login_attempts,
                    'logged_in' => true
                );

                $this->session->set_userdata('userId', $user->id);

                $this->session->set_userdata($userdata);
                redirect(base_url());
            } else {
                $this->session->set_flashdata('error', 'Invalid OTP. Please try again.');
                redirect('otpCheck');
            }
        } else {
            $this->session->set_flashdata('error', 'User not found.');
            redirect('otpCheck');
        }
    }
}