<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\SMSController;
use Illuminate\Support\Facades\Hash;
use App\Patient;
use App\User;
use Auth;

class PagesController extends Controller
{
    private $request = null;
    private $id = null;
    private $id_number = null;
    private $email = null;
    private $phone = null;
    private $verification_method = null;
    private $password = null;

    public function __construct(Request $request)
    {
        // $this->initialize_data();
        $this->initialize_params($request);
    }

    public function initialize_params($request){
        $this->request = $request;

        if($request->id){
            $this->id = $request->id;
        }
        if($request->id_number){
            $this->id_number = $request->id_number;
        }
        if($request->email){
            $this->email = $request->email;
        }
        if($request->phone){
            $this->phone = $request->phone;
        }
        if($request->verification_method){
            $this->verification_method = $request->verification_method;
        }
        if($request->password){
            $this->password = $request->password;
        }

    }

    public function identification(){
        return view('backend.patient.patient_login');
    }

    public function register_patient_user(){
        if($this->verification_method == "id"){
            $patient = Patient::all()->where('id_number', $this->id_number)->first();
        }
        elseif($this->verification_method == "email"){
            $patient = Patient::all()->where('email', $this->email)->first();
        }
        elseif($this->verification_method == "phone"){
            $patient = Patient::all()->where('phone', $this->phone)->first();
        }
        else{
            return response()->json([
                'status' => 1,
                'message' => 'Please select a valid identification method'
            ]); 
        }

        if($patient == null){
            return abort(401, 'Patient not found. Please try an alternative method to identify you');
        }
        else{
            if($patient->user_id != null){
                $user = User::findorFail($patient->user_id);

                $password = $this->generateOTP();
                $user->password = Hash::make($password);
            }
            else{
                $user = new User();
            
                $password = $this->generateOTP();
                $user->email = $patient->email; 
                $user->password = Hash::make($password);
                $user->role = "patient";
            }
            

            if($user->save()){
                $patient->user_id = $user->id;
                $patient->save();

                $message = "Hello, your request to generate a One Time Password (OTP) has been received. Your OTP is " .$password;

                //send message to user's phone number
                $sms = new SMSController();
                $result = json_decode($sms->send_message($patient->phone, $message), true);
                
                if($result['status'] == 1){ 
                    return response()->json([
                        'status' => 1,
                        'message' => 'A One Time Password (OTP) has been sent to the phone number recorded during your registration with us. Please use it to log in',
                        'password' => $password,
                        'id' => $user->id
                    ]);   
                }
                else{
                    return abort(500, 'An error occurred while processing your request. Please try again. If this error persists, please try an alternative method to identify you'); 
                }
            }
            else{
                return abort(500, 'An error occurred while processing your request. Please try again. If this error persists, please try an alternative method to identify you');   
            }
        }
    }

    public function authenticate_patient_user(){
        $user = User::findorFail($this->id);

        if(Hash::check($this->password, $user->password)){
            Auth::login($user);
            return response()->json([
                'status' => 1,
                'message' => 'Login successful',
            ]); 
        }

        // $credentials = ['email' => $this->email, 'password' => $this->password];
        // if (Auth::attempt($credentials)) {
        //     $request->session()->regenerate();

        //     return response()->json([
        //         'status' => 1,
        //         'message' => 'Login successful',
        //     ]); 
        // }
        else{
            return abort(401, 'Invalid password. Please try again '); 
        }
    }

    private function generateOTP(){
        $chars = "0123456789";
        $password = substr(str_shuffle($chars),0,4);
        return $password;
    }
}
