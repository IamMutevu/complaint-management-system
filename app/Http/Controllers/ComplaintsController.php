<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Complaint;
use App\ComplaintDepartment;
use App\ComplaintAttachment;
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
    protected $uploaded_complaint_files = null;
    private $request = null;

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

        if($request->date_of_concern){
            $this->date_of_concern = Carbon::createFromFormat('d/m/Y', $request->date_of_concern)->format('Y-m-d');
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
        if($request->complaint_files){
            $this->files = $request->complaint_files;
        }
        $this->request = $request;
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
        $complaint->status = "Pending";
        $complaint->user_id = Auth::user()->id;


        if($complaint->save()){
            $this->id = $complaint->id;

            foreach($this->department_id as $department){
                $complaint_department = new ComplaintDepartment();
                $complaint_department->complaint_id = $complaint->id;
                $complaint_department->department_id = $department;
                $complaint_department->save();
            }

            if($this->staff_id){
                foreach($this->staff_id as $staff){
                    $complaint_staff = new ComplaintStaff();
                    $complaint_staff->complaint_id = $complaint->id;
                    $complaint_staff->staff_id = $staff;
                    $complaint_staff->save();
                }
            }


            $this->path = storage_path('tmp/dropzone');
            $this->uploadAttachments();
            $this->attachFiles();

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
        $complaint = Complaint::findorFail($this->id);

        $complaint->complaint_category_id = $this->complaint_category_id;
        $complaint->description = $this->description;
        $complaint->date_of_concern = $this->date_of_concern;
        $complaint->status = "Pending";
        $complaint->user_id = Auth::user()->id;

        if($complaint->save()){
            $this->deleteRelatingFields();

            foreach($this->department_id as $department){
                $complaint_department = new ComplaintDepartment();
                $complaint_department->complaint_id = $complaint->id;
                $complaint_department->department_id = $department;
                $complaint_department->save();
            }

            if($this->staff_id){
                foreach($this->staff_id as $staff){
                    $complaint_staff = new ComplaintStaff();
                    $complaint_staff->complaint_id = $complaint->id;
                    $complaint_staff->staff_id = $staff;
                    $complaint_staff->save();
                }
            }
            
            $this->path = public_path('files');
            $this->uploadAttachments();
            $this->attachFiles();

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

        $this->detachFiles();

        if($complaint->delete()){
            return response()->json([
                'status' => 1,
                'message' => 'Complaint deleted successfully'
            ]);            
        }
    }

    public function getById($id){
        $complaint = Complaint::findorFail($id)->load('staff', 'complainant.patient', 'departments', 'complaint_category', 'complaint_attachments');
        if($this->request->query('q') == 'mark_as_read'){
            $complaint->status = "Received";
            $complaint->save();

            // Send message to patient
            $sms = new SMSController();
            $message = "Your complaint, marked with id #".$complaint->id ." has been received and will be attended to. We highly value your feedback.";
            $result = json_decode($sms->send_message($complaint->complainant['patient']['phone'], $message), true);
        }

        $complaint->formatted_date = Carbon::createFromFormat('Y-m-d', $complaint->date_of_concern)->format('d/m/Y');
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
                    if($complaint->status == "Pending"){
                        $status = '<span class="badge badge-warning">Pending</span>';
                    }
                    else if($complaint->status == "Received"){
                        $status = '<span class="badge badge-primary">Received</span>';
                    }
                    else{
                        $status = '<span class="badge badge-success">Closed</span>';
                    }
                    $table_row[] = $status;
                    
                    if($complaint->status != "Pending"){
                        $buttons = '<div class="btn-group float-right">
                                        <a href="#" class="btn-secondary btn-xs btn viewComplaintBtn" data-id="'.$complaint->id.'"><i class="fa fa-eye"></i></a>
                                    </div>';
                    }
                    else{
                        $buttons = '<div class="btn-group float-right">
                                        <a href="#" class="btn-secondary btn-xs btn viewComplaintBtn" data-id="'.$complaint->id.'" data-status="'.$complaint->status.'"><i class="fa fa-eye"></i></a>
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
                if($complaint->status == "Pending"){
                    $table_row = array();
                    $table_row[] = "<strong style='color:#000'>#" .$complaint->id."</strong>";
                    $table_row[] = "<strong style='color:#000'>" .$complaint->complainant['patient']['first_name'] ." " .$complaint->complainant['patient']['last_name'] ."</strong";
                    $table_row[] = "<strong style='color:#000'>" .$complaint->complaint_category['name'] ."</strong>";
                    $table_row[] = "<strong style='color:#000'>" .Carbon::parse($complaint->date_of_concern)->toFormattedDateString() ."</strong>";
                    if($complaint->status == "Pending"){
                        $status = '<span class="badge badge-warning">Pending</span>';
                    }
                    else if($complaint->status == "Received"){
                        $status = '<span class="badge badge-primary">Received</span>';
                    }
                    else{
                        $status = '<span class="badge badge-success">Closed</span>';
                    }
                    $table_row[] = $status;
                    if($complaint->status == "Closed"){
                        $buttons = '<div class="btn-group float-right">
                                        <a href="#" class="btn-secondary btn-xs btn viewComplaintBtn" data-id="'.$complaint->id.'" data-status="'.$complaint->status.'"><i class="fa fa-eye"></i></a>
                                    </div>';
                    }
                    else{
                        $buttons = '<div class="btn-group float-right">
                                        <a href="#" class="btn-info btn-xs btn updateComplaintBtn" data-id="'.$complaint->id.'">Update</a>
                                        <a href="#" class="btn-secondary btn-xs btn viewComplaintBtn" data-id="'.$complaint->id.'" data-status="'.$complaint->status.'"><i class="fa fa-eye"></i></a>
                                    </div>';
                    }
                    $table_row[] = $buttons;
                    $data[] = $table_row;  
                }   
                else{
                    $table_row = array();
                    $table_row[] = "#".$complaint->id;
                    $table_row[] = $complaint->complainant['patient']['first_name'] ." " .$complaint->complainant['patient']['last_name'];
                    $table_row[] = $complaint->complaint_category['name'];
                    $table_row[] = Carbon::parse($complaint->date_of_concern)->toFormattedDateString();
                    if($complaint->status == "Pending"){
                        $status = '<span class="badge badge-warning">Pending</span>';
                    }
                    else if($complaint->status == "Received"){
                        $status = '<span class="badge badge-primary">Received</span>';
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
                                        <a href="#" class="btn-info btn-xs btn updateComplaintBtn" data-id="'.$complaint->id.'">Update</a>
                                        <a href="#" class="btn-secondary btn-xs btn viewComplaintBtn" data-id="'.$complaint->id.'"><i class="fa fa-eye"></i></a>
                                    </div>';
                    }
                    $table_row[] = $buttons;
                    $data[] = $table_row;  
                }   		
            }
        }


        return json_encode(array(
            'draw' => $request->draw + 1,
            'recordsTotal' => count($complaints),
            'recordsFiltered' => count($complaints),
            'data' => $data), JSON_PRETTY_PRINT);
    }

    public function uploadAttachments(){
        $this->uploaded_complaint_files = array();

        if($this->files){
            for($i = 0; $i < count($this->files); $i++){
                $path = $this->path;
                $new_path = public_path('files');
                $path_parts = pathinfo($this->files[$i]);
                $extension = $path_parts['extension'];
                $filename = strtolower(preg_replace('/[[:space:]]+/', '-', $this->generateRandomString()) .'-'.uniqid() .'.' .$extension);
                if(file_exists($this->files[$i])){
                    $oldname = $this->files[$i];
                    $newname = $new_path .'/'.$filename;

                    if (!file_exists($new_path)) {
                        mkdir($new_path, 0777, true);
                    }
                    copy($this->files[$i], $newname);
                }    

                $uploadedImage = array(
                    'filename' => $filename,
                    'path' => $newname
                );
                $this->uploaded_complaint_files[] = $uploadedImage;          
            }
        }
    }

    public function attachFiles(){
        if(count($this->uploaded_complaint_files) > 0){
            foreach ($this->uploaded_complaint_files as $file) {
                $complaint_file = new ComplaintAttachment;
                $complaint_file->attachment = $file['filename'];
                $complaint_file->attachment_path = $file['path'];
                $complaint_file->complaint_id = $this->id;
                $complaint_file->save();
            }
        }
    }

    public function detachFiles(){
        $complaint_files = ComplaintAttachment::all()->where('complaint_id', $this->id);
        foreach ($complaint_files as $file) {
            $file->delete();
            unlink($file->path);
        }
    }

    public function checkDuplicate(){
        return Complaint::all()->where('email', $this->email);
    }

    public function closeComplaint(){
        $complaint = Complaint::findorFail($this->id);

        $complaint->status = 1;
        if($complaint->save()){
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
        $sms->send_message($complaint->complainant['patient']['phone'], "Your complaint #" .$complaint->id ." has been reviewed and closed.");
    }

    private function deleteRelatingFields(){
        $complaint_staff = ComplaintStaff::all()->where('complaint_id', $this->id);
        foreach($complaint_staff as $staff){
            $staff->delete();
        }

        $complaint_departments = ComplaintDepartment::all()->where('complaint_id', $this->id);
        foreach($complaint_departments as $department){
            $department->delete();
        }
    }

    private function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}