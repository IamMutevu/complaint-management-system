<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Complaint;
use App\ComplaintDepartment;
use App\ComplaintStaff;
use Auth;

class ComplaintsController extends Controller
{
    private $id = null;
    private $complaint_category_id = null;
    private $description = null;
    private $department_id = null;
    private $staff_id = null;
    private $files = null;
    private $date_of_concern = null;
    private $complaint = null;

	public function __construct(Request $request)
    {
        $this->middleware('auth');
        $this->initialize_data();
        $this->initialize_params($request);
    }

    public function initialize_data(){
        $this->data = array(
            'complaints' => Complaint::with('complaint_category', 'complainant.patient', 'departments', 'staff')->get()
        );
    }

    public function initialize_params($request){
        if($request->id){
            $this->id = $request->id;
        }
        else{
            if($request->date_of_concern){
                $this->date_of_concern = Carbon::createFromFormat('m/d/Y H:i a', $request->date_of_concern)->format('Y-m-d');
            }
        }

        if($request->complaint_category_id){
            $this->complaint_category_id = $request->complaint_category_id;
        }
        if($request->description){
            $this->description = $request->description;
        }
        if($request->department_id){
            $this->department_id = $request->department_id;
        }
        if($request->staff_id){
            $this->staff_id = $request->staff_id;
        }
        if($request->files){
            $this->files = $request->files;
        }

    }

    public function index(){
        if(Auth::user()->role == "patient"){
            return view('backend.patient.complaints');
        }
        return view('backend.admin.complaints');
    }

    public function create(){
        $complaint = new Complaint();

        $complaint->complaint_category_id = $this->complaint_category_id;
        $complaint->description = $this->description;
        $complaint->date_of_concern = $this->date_of_concern;
        $complaint->user_id = Auth::user()->id;


        if($complaint->save()){
            foreach($this->department_id as $department){
                $complaint_department = new ComplaintDepartment();
                $complaint_department->complaint_id = $complaint->id;
                $complaint_department->department_id = $department;
                $complaint_department->save();
            }

            foreach($this->staff_id as $staff){
                $complaint_staff = new ComplaintStaff();
                $complaint_staff->complaint_id = $complaint->id;
                $complaint_staff->staff_id = $staff;
                $complaint_staff->save();
            }

            //send message to admin
            $sms = new SMSController();
            $message = "A complaint has been added by a patient. Please log in to the system to review";
            $result = json_decode($sms->send_message("718504479", $message), true);

            if($result['status'] == 1){ 
                return response()->json([
                    'status' => 1,
                    'message' => 'Complaint added successfully'
                ]); 
            }          
        }
        else{
            return response()->json([
                'status' => 1,
                'message' => 'Complaint not added because a complaint with a similar email address exists'
            ]);  
        }
    }

	public function update(){
        $this->complaint = Complaint::findorFail($this->id);

        $this->complaint->complaint_category_id = $this->complaint_category_id;
        $this->complaint->description = $this->description;
        $this->complaint->date_of_concern = $this->complaint->date_of_concern;
        $this->complaint->user_id = Auth::user()->id;

        if($this->complaint->save()){
            // $this->complaint->departments->delete();
            // $this->complaint->staff->delete();
            $this->deleteRelatingFields();

            foreach($this->department_id as $department){
                $complaint_department = new ComplaintDepartment();
                $complaint_department->complaint_id = $this->complaint->id;
                $complaint_department->department_id = $department;
                $complaint_department->save();
            }

            foreach($this->staff_id as $staff){
                $complaint_staff = new ComplaintStaff();
                $complaint_staff->complaint_id = $this->complaint->id;
                $complaint_staff->staff_id = $staff;
                $complaint_staff->save();
            }
            
            return response()->json([
                'status' => 1,
                'message' => 'Complaint updated successfully'
            ]);           
        }
        else{
            return abort(500, 'An error occured. Please refresh the page and try again'); 
        }
    }

    public function delete(){
		$complaint = Complaint::findorFail($this->id);

        if($complaint->delete()){
            return response()->json([
                'status' => 1,
                'message' => 'Complaint deleted successfully'
            ]);            
        }
    }

    public function getById($id){
        $complaint = Complaint::findorFail($id)->load('staff', 'complainant.patient', 'departments', 'complaint_category');
        return json_encode($complaint);
    }

    public function getList(){
        return json_encode($this->data);
    }

    public function dataTable(Request $request){
        $complaints = Complaint::with('complaint_category', 'complainant.patient', 'departments', 'staff', 'user')->get();

        $data = array();
        if(Auth::user()->role == "patient"){
            foreach ($complaints as $complaint) {
                if($complaint->user_id == Auth::user()->id){
                    $table_row = array();
                    $table_row[] = "#".$complaint->id;
                    $table_row[] = $complaint->complaint_category['name'];
                    $concerned_staff = '';
                    foreach($complaint->staff as $staff){
                        $concerned_staff .= $staff->first_name ." " .$staff->last_name ." | ";
                    }
                    $table_row[] = $concerned_staff;
                    $table_row[] = Carbon::parse($complaint->date_of_concern)->toFormattedDateString();
                    if($complaint->status == "0"){
                        $status = '<span class="badge badge-warning">Pending</span>';
                    }
                    else{
                        $status = '<span class="badge badge-success">Closed</span>';
                    }
                    $table_row[] = $status;
                    
                    if($complaint->status == 1){
                        $buttons = '<div class="btn-group float-right">
                                        <a href="#" class="btn-secondary btn-xs btn viewComplaintBtn" data-id="'.$complaint->id.'"><i class="fa fa-eye"></i></a>
                                    </div>';
                    }
                    else{
                        $buttons = '<div class="btn-group float-right">
                                        <a href="#" class="btn-secondary btn-xs btn viewComplaintBtn" data-id="'.$complaint->id.'"><i class="fa fa-eye"></i></a>
                                        <a href="#" class="btn-primary btn-xs btn editComplaintBtn" data-id="'.$complaint->id.'"><i class="fa fa-edit"></i></a>
                                        <a href="#" class="btn-danger btn-xs btn deleteComplaintBtn" data-id="'.$complaint->id.'" data-toggle="modal"><i class="fa fa-trash"></i></a>
                                    </div>';
                    }
                    $table_row[] = $buttons;
                    $data[] = $table_row;  
                }
            }
        }
        else{
            foreach ($complaints as $complaint) {
                $table_row = array();
                $table_row[] = "#".$complaint->id;
                $table_row[] = $complaint->complainant['patient']['first_name'] ." " .$complaint->complainant['patient']['last_name'];
                $table_row[] = $complaint->complaint_category['name'];
                $table_row[] = Carbon::parse($complaint->date_of_concern)->toFormattedDateString();
                if($complaint->status == "0"){
                    $status = '<span class="badge badge-warning">Pending</span>';
                }
                else{
                    $status = '<span class="badge badge-success">Closed</span>';
                }
                $table_row[] = $status;
                if($complaint->status == 1){
                    $buttons = '<div class="btn-group float-right">
                                    <a href="#" class="btn-secondary btn-xs btn viewComplaintBtn" data-id="'.$complaint->id.'"><i class="fa fa-eye"></i></a>
                                </div>';
                }
                else{
                    $buttons = '<div class="btn-group float-right">
                                    <a href="#" class="btn-success btn-xs btn approveComplaintBtn" data-id="'.$complaint->id.'">Close</a>
                                    <a href="#" class="btn-secondary btn-xs btn viewComplaintBtn" data-id="'.$complaint->id.'"><i class="fa fa-eye"></i></a>
                                </div>';
                }
                $table_row[] = $buttons;
                $data[] = $table_row;        		
            }
        }


        return json_encode(array(
            'draw' => $request->draw + 1,
            'recordsTotal' => count($complaints),
            'recordsFiltered' => count($complaints),
            'data' => $data), JSON_PRETTY_PRINT);
    }

    public function checkDuplicate(){
        return Complaint::all()->where('email', $this->email);
    }

    public function closeComplaint(){
        $this->complaint = Complaint::findorFail($this->id);

        $this->complaint->status = 1;
        if($this->complaint->save()){
            $this->sendPatientMessage();
            return response()->json([
                'status' => 1,
                'message' => 'Complaint closed successfully' 
            ]);   
        }
    }

    public function sendAdminMessage(){
        $sms = new SMSController();
        $sms->send_message("718504479", "A complaint has been added by a patient. Please log in to the system to review");
    }

    public function sendPatientMessage(){
        $sms = new SMSController();
        $sms->send_message($this->complaint->complainant['patient']['phone'], "Your complaint #" .$this->complaint->id ." has been reviewed and closed.");
    }

    private function deleteRelatingFields(){
        $complaint_staff = ComplaintStaff::all()->where('complaint_id', $this->complaint->id);
        foreach($complaint_staff as $staff){
            $staff->delete();
        }

        $complaint_departments = ComplaintDepartment::all()->where('complaint_id', $this->complaint->id);
        foreach($complaint_departments as $department){
            $department->delete();
        }
    }

}