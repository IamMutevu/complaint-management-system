<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ComplaintCategory;

class ComplaintCategoriesController extends Controller
{
	public function __construct(Request $request)
    {
        $this->middleware('auth');
        $this->initialize_data();
        $this->initialize_params($request);
    }

    public function initialize_data(){
        $this->data = array(
            'complaint_categories' => ComplaintCategory::orderBy('name')->get()
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
        return view('backend.admin.complaint_categories');
    }

    public function create(){
        $complaint_category = new ComplaintCategory();

        $array = [
            'name' => $this->name
        ];

        $complaint_category->name = $this->name;

        if($complaint_category->insertOrIgnore($array)){
            return response()->json([
                'status' => 1,
                'message' => 'Complaint category added successfully'
            ]);           
        }
        else{
            return response()->json([
                'status' => 1,
                'message' => 'Complaint category already added.'
            ]);
        }
    }

	public function update(){
        $complaint_category = ComplaintCategory::findorFail($this->id);

        $complaint_category->name = $this->name;

        if($complaint_category->save()){
            return response()->json([
                'status' => 1,
                'message' => 'Complaint category updated successfully'
            ]);            
        }
    }

    public function delete(){
		$complaint_category = ComplaintCategory::findorFail($this->id);

        if($complaint_category->delete()){
            return json_encode(array(
                    'status' => 1,
                    'message' => 'Complaint Category deleted successfully.'
                ), JSON_PRETTY_PRINT);            
        }
    }

    public function getById($id){
        $complaint_category = ComplaintCategory::findorFail($id);
        return json_encode($complaint_category);
    }

    public function getList(){
        return json_encode($this->data);
    }

    public function dataTable(Request $request){
        $complaint_categories = ComplaintCategory::orderBy('name')->get();

        $data = array();
        foreach ($complaint_categories as $complaint_category) {
	        $table_row = array();
	        $table_row[] = $complaint_category->name;
	        $table_row[] = '<div class="btn-group float-right">
	                            <a href="#" class="btn-primary btn-xs btn editComplaintCategoryBtn" data-id="'.$complaint_category->id.'"><i class="fa fa-edit"></i></a>
	                            <a href="#" class="btn-danger btn-xs btn deleteComplaintCategoryBtn" data-id="'.$complaint_category->id.'" data-toggle="modal"><i class="fa fa-trash"></i></a>
	                        </div>';
	        $data[] = $table_row;        		
        }

        return json_encode(array(
            'draw' => $request->draw + 1,
            'recordsTotal' => count($complaint_categories),
            'recordsFiltered' => count($complaint_categories),
            'data' => $data), JSON_PRETTY_PRINT);
    }
}
