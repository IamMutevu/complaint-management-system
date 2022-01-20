<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Complaint;
use App\ComplaintUpdate;
use App\ComplaintUpdateAttachment;
use App\ComplaintDepartment;
use App\ComplaintStaff;
use Auth;

class ComplaintUpdatesController extends Controller
{
    private $id = null;
    private $complaint_update_id = null;
    private $description = null;
    private $status = null;
    private $request = null;

    public function __construct(Request $request)
    {
        $this->middleware('auth');
        $this->initialize_data();
        $this->initialize_params($request);
    }

    public function initialize_data(){

    }

    public function initialize_params($request){
        if($request->id){
            $this->id = $request->id;
        }
        if($request->complaint_id){
            $this->complaint_id = $request->complaint_id;
        }
        if($request->description){
            $this->description = $request->description;
        }
        if($request->status){
            $this->status = $request->status;
        }
        $this->request = $request;

    }

    public function create(){
        $complaint_update = new ComplaintUpdate();

        $complaint_update->complaint_id = $this->complaint_id;
        $complaint_update->description = $this->description;
        $complaint_update->user_id = Auth::user()->id;

        // Get complaint 
        $complaint = Complaint::findorFail($this->complaint_id)->load('staff', 'complainant.patient', 'departments', 'complaint_category', 'complaint_attachments');

        if($complaint_update->save()){
            // Update complaint status
            $complaint->status = $this->status;
            $complaint->save();
        
            $sms = new SMSController();

            if($this->status == "Closed"){
                $message = "Complaint marked with id #".$complaint->id ." has been closed. We highly value your feedback.";
            }
            else{
                $message = "An update has been made to complaint marked with #".$complaint->id .". Please login to the system and review";
            }

            if($complaint->complainant['id'] == Auth::user()->id){
                //send message to admin
                $result = json_decode($sms->send_message("718504479", $message), true);
            }
            else{
                //send message to patient
                $result = json_decode($sms->send_message($complaint->complainant['patient']['phone'], $message), true);
            }


            if($result['status'] == 1){ 
                return response()->json([
                    'status' => 1,
                    'message' => 'Complaint update added successfully'
                ]); 
            }          
        }
        else{
            return response()->json([
                'status' => 1,
                'message' => 'A problem occurred. Please try again.'
            ]);  
        }
    }

    

    public function getList(){
        return json_encode($this->data);
    }

    public function dataTable(Request $request){
        $complaint_updates = Complaint::with('complaint_category', 'complainant.patient', 'departments', 'staff', 'user')->get();

        $data = array();
        if(Auth::user()->role == "patient"){
            foreach ($complaint_updates as $complaint_update) {
                if($complaint_update->user_id == Auth::user()->id){
                    $table_row = array();
                    $table_row[] = "#".$complaint_update->id;
                    $table_row[] = $complaint_update->complaint_category['name'];
                    $concerned_staff = '';
                    foreach($complaint_update->staff as $staff){
                        $concerned_staff .= $staff->first_name ." " .$staff->last_name ." | ";
                    }
                    $table_row[] = $concerned_staff;
                    $table_row[] = Carbon::parse($complaint_update->date_of_concern)->toFormattedDateString();
                    if($complaint_update->status == "Pending"){
                        $status = '<span class="badge badge-warning">Pending</span>';
                    }
                    else if($complaint_update->status == "Received"){
                        $status = '<span class="badge badge-primary">Received</span>';
                    }
                    else{
                        $status = '<span class="badge badge-success">Closed</span>';
                    }
                    $table_row[] = $status;
                    
                    if($complaint_update->status != "Pending"){
                        $buttons = '<div class="btn-group float-right">
                                        <a href="#" class="btn-secondary btn-xs btn viewComplaintBtn" data-id="'.$complaint_update->id.'"><i class="fa fa-eye"></i></a>
                                    </div>';
                    }
                    else{
                        $buttons = '<div class="btn-group float-right">
                                        <a href="#" class="btn-secondary btn-xs btn viewComplaintBtn" data-id="'.$complaint_update->id.'" data-status="'.$complaint_update->status.'"><i class="fa fa-eye"></i></a>
                                        <a href="#" class="btn-primary btn-xs btn editComplaintBtn" data-id="'.$complaint_update->id.'"><i class="fa fa-edit"></i></a>
                                        <a href="#" class="btn-danger btn-xs btn deleteComplaintBtn" data-id="'.$complaint_update->id.'" data-toggle="modal"><i class="fa fa-trash"></i></a>
                                    </div>';
                    }
                    $table_row[] = $buttons;
                    $data[] = $table_row;  
                }
            }
        }
        else{
            foreach ($complaint_updates as $complaint_update) {
                if($complaint_update->status == "Pending"){
                    $table_row = array();
                    $table_row[] = "<strong style='color:#000'>#" .$complaint_update->id."</strong>";
                    $table_row[] = "<strong style='color:#000'>" .$complaint_update->complainant['patient']['first_name'] ." " .$complaint_update->complainant['patient']['last_name'] ."</strong";
                    $table_row[] = "<strong style='color:#000'>" .$complaint_update->complaint_category['name'] ."</strong>";
                    $table_row[] = "<strong style='color:#000'>" .Carbon::parse($complaint_update->date_of_concern)->toFormattedDateString() ."</strong>";
                    if($complaint_update->status == "Pending"){
                        $status = '<span class="badge badge-warning">Pending</span>';
                    }
                    else if($complaint_update->status == "Received"){
                        $status = '<span class="badge badge-primary">Received</span>';
                    }
                    else{
                        $status = '<span class="badge badge-success">Closed</span>';
                    }
                    $table_row[] = $status;
                    if($complaint_update->status == "Closed"){
                        $buttons = '<div class="btn-group float-right">
                                        <a href="#" class="btn-secondary btn-xs btn viewComplaintBtn" data-id="'.$complaint_update->id.'" data-status="'.$complaint_update->status.'"><i class="fa fa-eye"></i></a>
                                    </div>';
                    }
                    else{
                        $buttons = '<div class="btn-group float-right">
                                        <a href="#" class="btn-info btn-xs btn updateComplaintBtn" data-id="'.$complaint_update->id.'">Update</a>
                                        <a href="#" class="btn-secondary btn-xs btn viewComplaintBtn" data-id="'.$complaint_update->id.'" data-status="'.$complaint_update->status.'"><i class="fa fa-eye"></i></a>
                                    </div>';
                    }
                    $table_row[] = $buttons;
                    $data[] = $table_row;  
                }   
                else{
                    $table_row = array();
                    $table_row[] = "#".$complaint_update->id;
                    $table_row[] = $complaint_update->complainant['patient']['first_name'] ." " .$complaint_update->complainant['patient']['last_name'];
                    $table_row[] = $complaint_update->complaint_category['name'];
                    $table_row[] = Carbon::parse($complaint_update->date_of_concern)->toFormattedDateString();
                    if($complaint_update->status == "Pending"){
                        $status = '<span class="badge badge-warning">Pending</span>';
                    }
                    else if($complaint_update->status == "Received"){
                        $status = '<span class="badge badge-primary">Received</span>';
                    }
                    else{
                        $status = '<span class="badge badge-success">Closed</span>';
                    }
                    $table_row[] = $status;
                    if($complaint_update->status == 1){
                        $buttons = '<div class="btn-group float-right">
                                        <a href="#" class="btn-secondary btn-xs btn viewComplaintBtn" data-id="'.$complaint_update->id.'"><i class="fa fa-eye"></i></a>
                                    </div>';
                    }
                    else{
                        $buttons = '<div class="btn-group float-right">
                                        <a href="#" class="btn-info btn-xs btn updateComplaintBtn" data-id="'.$complaint_update->id.'">Update</a>
                                        <a href="#" class="btn-secondary btn-xs btn viewComplaintBtn" data-id="'.$complaint_update->id.'"><i class="fa fa-eye"></i></a>
                                    </div>';
                    }
                    $table_row[] = $buttons;
                    $data[] = $table_row;  
                }           
            }
        }


        return json_encode(array(
            'draw' => $request->draw + 1,
            'recordsTotal' => count($complaint_updates),
            'recordsFiltered' => count($complaint_updates),
            'data' => $data), JSON_PRETTY_PRINT);
    }
}