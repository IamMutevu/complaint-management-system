<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Department;

class DepartmentsController extends Controller
{
	public function __construct(Request $request)
    {
        $this->middleware('auth');
        $this->initialize_data();
        $this->initialize_params($request);
    }

    public function initialize_data(){
        $this->data = array(
            'departments' => Department::orderBy('name')->get()
        );
    }

    public function initialize_params($request){
        if($request->id){
            $this->id = $request->id;
        }

        if($request->name){
            $this->name = $request->name;
        }
    }

    public function index(){
        return view('backend.admin.departments');
    }

    public function create(){
        $department = new Department();

        $array = [
            'name' => $this->name
        ];

        $department->name = $this->name;

        if($department->insertOrIgnore($array)){
            return json_encode(array(
                    'status' => 1,
                    'message' => 'Department added successfully.'
                ), JSON_PRETTY_PRINT);            
        }
        else{
            return response()->json([
                'status' => 1,
                'message' => 'Department exists',
            ]); 
        }
    }

	public function update(){
        $department = Department::findorFail($this->id);

        $department->name = $this->name;

        if($department->save()){
            return json_encode(array(
                    'status' => 1,
                    'message' => 'Department updated successfully.'
                ), JSON_PRETTY_PRINT);            
        }
    }

    public function delete(){
		$department = Department::findorFail($id);

        if($department->deleted()){
            return json_encode(array(
                    'status' => 1,
                    'message' => 'Department deleted successfully.'
                ), JSON_PRETTY_PRINT);            
        }
    }

    public function getById($id){
        $department = Department::findorFail($id);
        return json_encode($department);
    }

    public function getList(){
        return json_encode($this->data);
    }

    public function dataTable(Request $request){
        $departments = Department::orderBy('name')->get();

        $data = array();
        foreach ($departments as $department) {
	        $table_row = array();
	        $table_row[] = $department->name;
	        $table_row[] = '<div class="btn-group float-right">
	                            <a href="#" class="btn-primary btn-xs btn editDepartmentBtn" data-id="'.$department->id.'"><i class="fa fa-edit"></i></a>
	                            <a href="#" class="btn-danger btn-xs btn deleteDepartmentBtn" data-id="'.$department->id.'" data-toggle="modal"><i class="fa fa-trash"></i></a>
	                        </div>';
	        $data[] = $table_row;        		
        }

        return json_encode(array(
            'draw' => $request->draw + 1,
            'recordsTotal' => count($departments),
            'recordsFiltered' => count($departments),
            'data' => $data), JSON_PRETTY_PRINT);
    }
}
