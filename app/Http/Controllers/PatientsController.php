<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Patient;

class PatientsController extends Controller
{
    private $id = null;
    private $first_name = null;
    private $middle_name = null;
    private $last_name = null;
    private $phone = null;
    private $gender = null;
    private $id_number = null;
    private $email = null;
    private $date_of_birth = null;

	public function __construct(Request $request)
    {
        $this->middleware('auth');
        $this->initialize_data();
        $this->initialize_params($request);
    }

    public function initialize_data(){
        $this->data = array(
            'patients' => Patient::orderBy('first_name')->get()
        );
    }

    public function initialize_params($request){
        if($request->id){
            $this->id = $request->id;
        }

        if($request->first_name){
            $this->first_name = $request->first_name;
        }
        if($request->middle_name){
            $this->middle_name = $request->middle_name;
        }
        if($request->last_name){
            $this->last_name = $request->last_name;
        }
        if($request->phone){
            $this->phone = $request->phone;
        }
        if($request->gender){
            $this->gender = $request->gender;
        }
        if($request->id_number){
            $this->id_number = $request->id_number;
        }
        if($request->email){
            $this->email = $request->email;
        }
        if($request->date_of_birth){
            $this->date_of_birth = Carbon::createFromFormat('d/m/Y', $request->date_of_birth)->format('Y-m-d');
        }
    }

    public function index(){
        return view('backend.admin.patients');
    }

    public function create(){
        $patient = new Patient();

        $array = [
            'first_name' => $this->first_name,
            'middle_name' => $this->middle_name,
            'last_name' => $this->last_name,
            'phone' => $this->phone,
            'gender' => $this->gender,
            'id_number' => $this->id_number,
            'email' => $this->email,
            'date_of_birth' => $this->date_of_birth,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ];

        $patient->first_name = $this->first_name;

        if($patient->insertOrIgnore($array)){
            return response()->json([
                'status' => 1,
                'message' => 'Patient added successfully'
            ]);           
        }
        else{
            return response()->json([
                'status' => 1,
                'message' => 'Patient not added because a patient with a similar email address exists'
            ]);  
        }
    }

	public function update(){
        $patient = Patient::findorFail($this->id);

        $patient->first_name = $this->first_name;
        $patient->middle_name = $this->middle_name;
        $patient->last_name = $this->last_name;
        $patient->phone = $this->phone;
        $patient->gender = $this->gender;
        $patient->id_number = $this->id_number;
        $patient->email = $this->email;
        $patient->date_of_birth = $this->date_of_birth;
        $patient->created_at = $patient->created_at;
        $patient->updated_at = Carbon::now();

        if($patient->save()){
            return response()->json([
                'status' => 1,
                'message' => 'Patient updated successfully'
            ]);           
        }
        else{
            return abort(500, 'An error occured. Please refresh the page and try again'); 
        }
    }

    public function delete(){
		$patient = Patient::findorFail($this->id);

        if($patient->delete()){
            return response()->json([
                'status' => 1,
                'message' => 'Patient deleted successfully'
            ]);            
        }
    }

    public function getById($id){
        $patient = Patient::findorFail($id);
        $patient->date_of_birth = Carbon::createFromFormat('Y-m-d', $patient->date_of_birth)->format('m/d/Y h:i a');
        return json_encode($patient);
    }

    public function getList(){
        return json_encode($this->data);
    }

    public function dataTable(Request $request){
        $patients = Patient::orderBy('first_name')->get();

        $data = array();
        foreach ($patients as $patient) {
	        $table_row = array();
	        $table_row[] = $patient->first_name ." " .$patient->middle_name ." " .$patient->last_name;
            $table_row[] = Carbon::parse($patient->date_of_birth)->toFormattedDateString();
            $table_row[] = $patient->id_number;
            $table_row[] = $patient->email;
	        $table_row[] = '<div class="btn-group float-right">
	                            <a href="#" class="btn-primary btn-xs btn editPatientBtn" data-id="'.$patient->id.'"><i class="fa fa-edit"></i></a>
	                            <a href="#" class="btn-danger btn-xs btn deletePatientBtn" data-id="'.$patient->id.'" data-toggle="modal"><i class="fa fa-trash"></i></a>
	                        </div>';
	        $data[] = $table_row;        		
        }

        return json_encode(array(
            'draw' => $request->draw + 1,
            'recordsTotal' => count($patients),
            'recordsFiltered' => count($patients),
            'data' => $data), JSON_PRETTY_PRINT);
    }

    public function checkDuplicate(){
        return Patient::all()->where('email', $this->email);
    }

}
