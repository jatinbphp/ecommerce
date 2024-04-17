<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PaymentController extends MY_Controller {
	public function index(){
		$this->frontRenderTemplate('front/payment');
	}

	public function processPayment() {
		require_once('./vendor/stripe/stripe-php/init.php');

        \Stripe\Stripe::setApiKey('sk_test_51OtRCaSFVmTeEsbhC5dKFW7taW2OGib3qINNmyOiH7WPniWFu4yX0XWY2rP3RFOMGiNnduCoggSPHY9NOhSwVZwD00xkCBYfh4');

		header('Content-Type: application/json');

    	# retrieve json from POST body
        $json_str = file_get_contents('php://input');
        $json_obj = json_decode($json_str, true);
		

        $token = isset($json_obj['stripeToken']) ? $json_obj['stripeToken'] : '';
        $name = isset($json_obj['name']) ? $json_obj['name'] : '';
        $email = isset($json_obj['email']) ? $json_obj['email'] : '';
        $amount = isset($json_obj['amount']) ? $json_obj['amount'] : '';

        try {
			if(empty($token) || empty($name) || empty($email) || empty($amount)){
				throw new Error('Invalid data');
			}
            $charge = \Stripe\Charge::create([
                'amount' => $amount * 100, // Amount in cents
                'currency' => 'usd',
                'source' => $token,
                'description' => 'Example Charge',
                'receipt_email' => $email,
            ]);

            echo json_encode(['success' => true]);
        } catch (\Stripe\Exception\CardException $e) {
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        } catch (\Stripe\Exception\RateLimitException $e) {
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        } catch (\Stripe\Exception\InvalidRequestException $e) {
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        } catch (\Stripe\Exception\AuthenticationException $e) {
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        } catch (\Stripe\Exception\ApiConnectionException $e) {
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        } catch (\Stripe\Exception\ApiErrorException $e) {
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
    }
}