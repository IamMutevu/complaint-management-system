<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Messages\AfricasTalkingGateway;

class SMSController extends Controller{
	public function send_message($phone, $message){
		// Set your app credentials
		$username   = "sandbox";
		$apiKey     = "12d8fb7e9424131fc0a6c83fd05143fda4ef7715d318f1bad1fd95fd9a8860c1";

		$sms         = new AfricasTalkingGateway($username, $apiKey);


		// Set the numbers you want to send to in international format
		$recipients = "254".$phone;

		// Set your message
		$message = $message;

		try {
		    // Thats it, hit send and we'll take care of the rest
		    $sms->sendMessage($recipients, $message);
			$response = array(
				'status' => 1,
				'message' => "Message sent successfully to the user"
			);

		} catch (Exception $e) {
		    $response = array(
				'status' => 0,
				'message' => "An error occurred while sending message to the user. Please try again"
			);
		}

		return json_encode($response, JSON_PRETTY_PRINT);
	}

}