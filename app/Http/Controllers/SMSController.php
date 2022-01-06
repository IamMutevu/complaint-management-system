<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Messages\AfricasTalkingGateway;

class SMSController extends Controller{
	public function send_message($phone, $message){
		// Set your app credentials
		$username   = "Alabee";
		$apiKey     = "7355ff2bf0847addf6605845c557f068fef1517231753653d63fd2a123e30f42";

		$sms         = new AfricasTalkingGateway($username, $apiKey);


		// Set the numbers you want to send to in international format
		$recipients = "254".$phone;

		// Set your message
		$message = $message;

		try {
		    // Thats it, hit send and we'll take care of the rest
		    // $sms->sendMessage($recipients, $message);
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