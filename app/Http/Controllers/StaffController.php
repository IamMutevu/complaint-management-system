<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Staff;
use Carbon\Carbon;

class StaffController extends Controller
{
    private $id = null;
    private $first_name = null;
    private $middle_name = null;
    private $last_name = null;
    private $phone = null;
    private $gender = null;
    private $id_number = null;
    private $email = null;
    private $department_id = null;
    private $request = null;


	public function __construct(Request $request)
    {
        $this->middleware('auth');
        $this->initialize_data();
        $this->initialize_params($request);
    }

    public function initialize_data(){
        $this->data = array(
            'staff' => Staff::orderBy('first_name')->get()
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
        if($request->department_id){
            $this->department_id = $request->department_id;
        }

        $this->request = $request;
    }

    public function index(){
        return view('backend.admin.staff');
    }

    public function create(){ 
        $staff = new Staff();


        $array = [
            'first_name' => $this->first_name,
            'middle_name' => $this->middle_name,
            'last_name' => $this->last_name,
            'phone' => $this->phone,
            'gender' => $this->gender,
            'id_number' => $this->id_number,
            'email' => $this->email,
            'department_id' => $this->department_id,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ];


        if($staff->insertOrIgnore($array)){
            return json_encode(array(
                    'status' => 1,
                    'message' => 'Staff added successfully.'
                ), JSON_PRETTY_PRINT);            
        }
        else{
            return abort(500, 'An error occured. Please refresh the page and try again'); 
        }
    }

	public function update(){
        $staff = Staff::findorFail($this->id);

        $staff->first_name = $this->first_name;

        if($staff->save()){
            return json_encode(array(
                    'status' => 1,
                    'message' => 'Staff updated successfully.'
                ), JSON_PRETTY_PRINT);            
        }
    }

    public function delete(){
		$staff = Staff::findorFail($id);

        if($staff->deleted()){
            return json_encode(array(
                    'status' => 1,
                    'message' => 'Staff deleted successfully.'
                ), JSON_PRETTY_PRINT);            
        }
    }

    public function getById($id){
        $staff = Staff::findorFail($id);
        return json_encode($staff);
    }

    public function getList(){
        return json_encode($this->data);
    }

    public function getListDepartmentFilter(){
        $selected_departments = explode(",",$this->request->input('departments'));

        $staff = Staff::all()->whereIn('department_id', $selected_departments);

        $data = array(
            'staff' => $staff
        );
        return json_encode($data);
    }

    public function dataTable(Request $request){
        $staffs = Staff::all();

        $data = array();
        foreach ($staffs as $staff) {
	        $table_row = array();
	        $table_row[] = $staff->first_name ." " .$staff->middle_name ." " .$staff->last_name;
            $table_row[] = $staff->department['name'];
            $table_row[] = $staff->email;
            $table_row[] = "+254".$staff->phone;
	        $table_row[] = '<div class="btn-group float-right">
	                            <a href="#" class="btn-primary btn-xs btn editStaffBtn" data-id="'.$staff->id.'"><i class="fa fa-edit"></i></a>
	                            <a href="#" class="btn-danger btn-xs btn deleteStaffBtn" data-id="'.$staff->id.'" data-toggle="modal"><i class="fa fa-trash"></i></a>
	                        </div>';
	        $data[] = $table_row;        		
        }

        return json_encode(array(
            'draw' => $request->draw + 1,
            'recordsTotal' => count($staffs),
            'recordsFiltered' => count($staffs),
            'data' => $data), JSON_PRETTY_PRINT);
    }
}
