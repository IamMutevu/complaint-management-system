<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MpesaController extends Controller
{
    public function lipa($phone, $amount){
    	// $phone = "254729161741";
    	// $amount = "5";
  date_default_timezone_set('Africa/Nairobi');
   if($phone) {
  # access token
  $consumerKey = '8ko6Analv8Xg2D8uYyVoGhbskReD7HCE'; //Fill with your app Consumer Key
  $consumerSecret = 'EkTIKvFmtb2N8hbs'; // Fill with your app Secret
  # define the variales
  # provide the following details, this part is found on your test credentials on the developer account
  $BusinessShortCode = '850464';
  $Passkey = '8a5ae89f0c0d0faeb9f30ba68477205dc256c9878353cc32ac9e88f029553a6e';  
  
  /*
    This are your info, for
    $PartyA should be the ACTUAL clients phone number or your phone number, format 2547********
    $AccountRefference, it maybe invoice number, account number etc on production systems, but for test just put anything
    TransactionDesc can be anything, probably a better description of or the transaction
    $Amount this is the total invoiced amount, Any amount here will be 
    actually deducted from a clients side/your test phone number once the PIN has been entered to authorize the transaction. 
    for developer/test accounts, this money will be reversed automatically by midnight.
  */
  
  $PartyA = $phone; // This is your phone number, 
  $AccountReference = "BrightsMind";
  $TransactionDesc = 'Payment For Unit';
  $Amount = $amount;
 
  # Get the timestamp, format YYYYmmddhms -> 20181004151020
  $Timestamp = date('YmdHis');    
  
  # Get the base64 encoded string -> $password. The passkey is the M-PESA Public Key
  $Password = base64_encode($BusinessShortCode.$Passkey.$Timestamp);
  # header for access token
  $headers = ['Content-Type:application/json; charset=utf8'];
    # M-PESA endpoint urls
  $access_token_url = 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
  $initiate_url = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
  # callback url
$CallBackURL ='https://excellepro.com/demo/apps/configs/mpesahook.php';
  //$CallBackURL ='https://993f173f7526.ngrok.io/hooks/mpesa';
               
// $CallBackURL = 'https://hooks.zapier.com/hooks/catch/5108100/oln9wad/';
//$CallBackURL ='https://webhook.site/f53ad087-1985-4d88-bcb5-d3c10ab2123f';
  $curl = curl_init($access_token_url);
  curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
  curl_setopt($curl, CURLOPT_HEADER, FALSE);
  curl_setopt($curl, CURLOPT_USERPWD, $consumerKey.':'.$consumerSecret);
  $result = curl_exec($curl);
  $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
  $result = json_decode($result);
  $access_token = $result->access_token;  
  curl_close($curl);
  # header for stk push
  $stkheader = ['Content-Type:application/json','Authorization:Bearer '.$access_token];
  # initiating the transaction
  $curl = curl_init();
  curl_setopt($curl, CURLOPT_URL, $initiate_url);
  curl_setopt($curl, CURLOPT_HTTPHEADER, $stkheader); //setting custom header
  $curl_post_data = array(
    //Fill in the request parameters with valid values
    'BusinessShortCode' => $BusinessShortCode,
    'Password' => $Password,
    'Timestamp' => $Timestamp,
    'TransactionType' => 'CustomerPayBillOnline',
    'Amount' => $Amount,
    'PartyA' => $PartyA,
    'PartyB' => $BusinessShortCode,
    'PhoneNumber' => $PartyA,
   'CallBackURL' => $CallBackURL,
    'AccountReference' => $AccountReference,
    'TransactionDesc' => $TransactionDesc
  );
  $data_string = json_encode($curl_post_data);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($curl, CURLOPT_POST, true);
  curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
  $curl_response = curl_exec($curl);
 // print_r($curl_response);
  echo $curl_response;
 

   }
    }
}
