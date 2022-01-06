@extends('layouts.app')

@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="page-title">
			<h3 class="text-black-50 float-left"><i class="nav-icon fa fa-comments"></i> Complaints</h3>
			<ol class="breadcrumb float-right">
				<li class="breadcrumb-item"><a href="/home"><i class="fa fa-home"></i></a></li>
				<li class="breadcrumb-item">Dashboard</li>
			</ol>
		</div>
	</div>
</div>
<div class="row text-black-50">
	<div class="col-md-12 col-lg-12">
		<div class="card">
			<div class="card-body">
				<ul class="nav nav-tabs" role="tablist">
					<li class="nav-item">
						<a class="nav-link active" data-toggle="tab" href="#complaintsTable" role="tab" aria-controls="complaintsTable" aria-selected="true">Complaints</a>
					</li>
					<li class="nav-item d-none">
						<a class="nav-link" data-toggle="tab" href="#complaints" role="tab" aria-controls="complaints" aria-selected="false">Card View</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" data-toggle="tab" href="#newComplaint" role="tab" aria-controls="newComplaint" aria-selected="false">New</a>
					</li>
					<li class="nav-item d-none">
						<a class="nav-link" data-toggle="tab" href="#editComplaint" role="tab" aria-controls="editComplaint" aria-selected="false">Edit</a>
					</li>
					<li class="nav-item d-none">
						<a class="nav-link" data-toggle="tab" href="#viewComplaint" role="tab" aria-controls="viewComplaint" aria-selected="false">View</a>
					</li>
				</ul>
				<div class="tab-content" id="myTabContent">
					<div class="tab-pane fade show active" id="complaintsTable" role="tabpanel" aria-labelledby="complaintsTable-tab">
						<div class="mt-3">
							<table class="table table-bordered table-stripped table-display table-hover" id="complaints-table">
								<thead>
									<tr>
										<th class="col-md-1">#</th>
                                        <th class="col-md-2">Category</th>
                                        <th class="col-md-4">Concerned Staff</th>
                                        <th class="col-md-2">Date of concern</th>
                                        <th class="col-md-2">Status</th>
										<th class="col-md-1 text-right">Actions</th>
									</tr>
								</thead>
							</table>
						</div>
					</div>
					<div class="tab-pane fade" id="newComplaint" role="tabpanel" aria-labelledby="newComplaint-tab">
						<div class="mt-3">
                            <form method="post" action="{{ route('complaint_create') }}" id="new-complaint">
                                @csrf
                                <div class="card shadow mb-5 bg-white rounded">
                                    <div class="card-header">
                                        Complaint Information
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="complaint_category_id">Complaint Category</label>
                                            <select class="form-control selectpicker" name="complaint_category_id">
                                            </select>
                                        </div>
                                        <div class="form-group">
											<label for="description">Description</label>
											<textarea class="form-control summernote" id="complaint-description" name="description" rows="3"></textarea>
										</div>
                                        <div class="form-group row">
                                            <div class="col-md-4">
                                                <label for="department_id[]">Department(s)</label>
                                                <select class="form-control selectpicker"  data-live-search="true" name="department_id[]" multiple>
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="staff_id[]">Concerned Staff</label>
                                                <select class="form-control selectpicker"  data-live-search="true" name="staff_id[]" multiple>
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="deadline">Date of concern</label>
                                                <div class="input-group date" id="datetimepicker1" data-target-input="nearest">
                                                    <input type="text" class="form-control datetimepicker-input" data-target="#datetimepicker1" autocomplete="off" name="date_of_concern"/>
                                                    <div class="input-group-append" data-target="#datetimepicker1" data-toggle="datetimepicker">
                                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
											<div class="col-md-12">
												<label for="complaint_files" class="col-form-label">Any related files</label>
												<div class="dropzone page" id="complaint_files">
												</div>
											</div>
										</div> 
                                    </div>
                                    <div class="card-footer text-right">
                                        <button type="reset" class="btn btn-sm btn-secondary"><i class="fa fa-times"></i> Clear</button>
                                        <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-check"></i> Save</button>    
                                    </div>
                                </div>
                            </form>						
						</div>
					</div>
					<div class="tab-pane fade" id="editComplaint" role="tabpanel" aria-labelledby="editComplaint-tab">
						<div class="mt-3">
                            <form method="post" action="{{ route('complaint_update') }}" id="edit-complaint">
                                @csrf
                                <<input type="hidden" name="id">
                                <div class="card shadow mb-5 bg-white rounded">
                                    <div class="card-header">
                                        Complaint Information
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="complaint_category_id">Complaint Category</label>
                                            <select class="form-control selectpicker" name="complaint_category_id">
                                            </select>
                                        </div>
                                        <div class="form-group">
											<label for="description">Description</label>
											<textarea class="form-control summernote" id="complaint-description" name="description" rows="3"></textarea>
										</div>
                                        <div class="form-group row">
                                            <div class="col-md-4">
                                                <label for="department_id[]">Department(s)</label>
                                                <select class="form-control selectpicker"  data-live-search="true" name="department_id[]" multiple>
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="staff_id[]">Concerned Staff</label>
                                                <select class="form-control selectpicker"  data-live-search="true" name="staff_id[]" multiple>
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="deadline">Date of concern</label>
                                                <div class="input-group date" id="datetimepicker1" data-target-input="nearest">
                                                    <input type="text" class="form-control datetimepicker-input" data-target="#datetimepicker1" autocomplete="off" name="date_of_concern"/>
                                                    <div class="input-group-append" data-target="#datetimepicker1" data-toggle="datetimepicker">
                                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
											<div class="col-md-12">
												<label for="complaint_files" class="col-form-label">Any related files</label>
												<div class="dropzone page" id="complaint_files">
												</div>
											</div>
										</div> 
                                    </div>
                                    <div class="card-footer text-right">
                                        <button type="button" class="btn btn-sm btn-secondary cancelEditComplaintBtn"><i class="fa fa-times"></i> Cancel</button>
                                        <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-check"></i> Save</button>    
                                    </div>
                                </div>
                            </form>						
						</div>
					</div>
					<div class="tab-pane fade" id="viewComplaint" role="tabpanel" aria-labelledby="viewComplaint-tab">
                        <div class="mt-4 ml-auto">
                            <div class="row my-2">
                                <div class="col-4">
                                    <strong>Complaint Category:</strong>
                                </div>
                                <div class="col-8" id="complaint-category">
                                    
                                </div>
                            </div>
                            <div class="row my-2">
                                <div class="col-4">
                                    <strong>Concerned Department(s):</strong>
                                </div>
                                <div class="col-8" id="complaint-department">
                                    
                                </div>
                            </div>
                            <div class="row my-2">
                                <div class="col-4">
                                    <strong>Concerned Staff:</strong>
                                </div>
                                <div class="col-8" id="complaint-staff">
                                    
                                </div>
                            </div>
                            <hr>
                            <h6>Description</h6>
                            <hr>
                            <p id="complaint-description"></p>
                            <hr>
                            <h6>Attachments</h6>
                            <hr>
							<div class="card-footer text-right">
								<button type="button" class="btn btn-sm btn-secondary closeViewComplaintBtn"><i class="fa fa-times"></i> Close</button>
							</div>			
						</div>
					</div>
				</div>
			</div>			
		</div>
	</div>
</div>
<div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Duplicate found</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        A complaint with the same email or ID | Passport number exists. These fields ought to be unique for each complaint. 
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Understood</button>
      </div>
    </div>
  </div>
</div>
<script>
  $(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.loadComplaintCategories();
    // $.loadStaff();
    $.loadDepartments();
    $.loadComplaints();

    $('#datetimepicker1').datetimepicker();
    $('#update-date-of-birth').datetimepicker();
    $('.selectpicker').selectpicker();
    $('#complaint_files').initDropzone();
    $('.summernote').summernote({
        height: 200,          
        minHeight: null,           
        maxHeight: null,  
    });
    

    $(document).on("change", "[name='department_id[]']", function(e){
        var departments = $(this).val();
        // alert(departments);
        $.loadStaff(departments);
    });

    // Complaint code //
    $("#complaints-table").DataTable({
        "processing": true,
        "serverSide": true,
        responsive: true,
        "order": [],
        ajax: {
            url: '/data/complaint/dataTable',
            type: 'POST'
        },
        "columnDefs": [
            {
                "targets": [5],
                "orderable": false,
            },
        ],
        language: {
            searchPlaceholder: "Search",
            sEmptyTable: "No complaints found"
        },
    });
    
    $("#new-complaint").validate({
        rules: {
            complaint_category_id: {
                required: true
            },
            description: {
                required: true,
                minlength: 20
            }
        },
        messages: {
            complaint_category_id: {
                required: "Complaint category is required"
            }, 
            description: {
                required: "Description is required",
                minlength: "Description should be at least 20 characters"
            }
        },
        submitHandler: function(form) {
        	var formData = new FormData(form);
            $.ajax({
                beforeSend: function () {
                    $('#overlay').removeClass('d-none');
                },
                complete: function () {
                    $('#overlay').addClass('d-none');  
                },
                url: $(form).attr('action'), 
                method: 'POST',
                data: formData,
                processData: false,
                dataType: 'json', 
                contentType: false,
                success: function (response, textStatus, jqXHR) {
                    form.reset();
                    $('#complaints-table').DataTable().ajax.reload();
                    $('select').selectpicker('refresh')
                    $('.summernote').summernote('code', ""); 
                    toastr.success(response.message);

                },
                error: function (jqXHR, textStatus, errorThrown) {
                    toastr.options = {
                        "closeButton": true,
                        "progressBar": true,
                        "positionClass": "toast-bottom-right",
                        "timeOut": "10000",
                    };
                    toastr.error(errorThrown);
                }
            });


        }
    });

    $(document).on("click", ".editComplaintBtn", function(e){
    	e.preventDefault();
        var id = $(this).attr('data-id');
        
        $.ajax({
            beforeSend: function () {
                $('#overlay').removeClass('d-none');
            },
            complete: function () {
                $('#overlay').addClass('d-none');

            },
            type: 'GET',
            url: "/data/complaint/get_details/"+id,
            dataType: 'JSON',
            cache: false,
            success: function (response) {
	        	var complaint = response;
	            $("#editComplaint").find('[name="complaint_category_id"]').selectpicker('val', complaint.complaint_category_id); 
                $("#editComplaint").find('[name="description"]').summernote('code', complaint.description); 
                $("#editComplaint").find('[name="date_of_concern"]').val(complaint.date_of_concern).end();
	            $("#editComplaint").find('[name="id"]').val(complaint.id).end();  

                var staff_selections = [];
                var department_selections = [];
                $.each(complaint.staff, function(k,v){
                    staff_selections.push(v.id);
                });
                $.each(complaint.departments, function(k,v){
                    department_selections.push(v.id);
                });

                $("#editComplaint").find('[name="staff_id[]"]').selectpicker('val', staff_selections); 
                $("#editComplaint").find('[name="department_id[]"]').selectpicker('val', department_selections); 
	            $('select').selectpicker('refresh');

		        $('a[role="tab"]').on('shown').removeClass('active');
		        $('div[role="tabpanel"]').on('shown').removeClass('active').removeClass('show');
		        $('a[aria-controls="editComplaint"]').addClass('active');
		        $('#editComplaint').addClass('active').addClass('show');
		        $('a[aria-controls="editComplaint"]').closest('li').removeClass('d-none');
            }
        });
    });

    $("#edit-complaint").validate({
        rules: {
            complaint_category_id: {
                required: true
            },
            description: {
                required: true,
                minlength: 20
            }
        },
        messages: {
            complaint_category_id: {
                required: "Complaint category is required"
            }, 
            description: {
                required: "Description is required",
                minlength: "Description should be at least 20 characters"
            }
        },
        submitHandler: function(form) {
            var formData = new FormData(form);
            $.ajax({
                beforeSend: function () {
                    $('#overlay').removeClass('d-none');
                },
                complete: function () {
                    $('#overlay').addClass('d-none');  
                },
                url: $(form).attr('action'), 
                method: 'POST',
                data: formData,
                processData: false,
                dataType: 'json', 
                contentType: false,
                success: function (response, textStatus, jqXHR) {
                	form.reset();
                	$('#complaints-table').DataTable().ajax.reload();
                    toastr.success(response.message);

			        $('a[role="tab"]').on('shown').removeClass('active');
					$('div[role="tabpanel"]').on('shown').removeClass('active').removeClass('show');
					$('a[aria-controls="complaintsTable"]').addClass('active');
					$("#complaintsTable").addClass('show').addClass('active');
			        $('a[aria-controls="complaintsTable"]').addClass('active').addClass('show');
			        $('#complaintsTable').addClass('active').addClass('show');
			        $('a[aria-controls="editComplaint"]').closest('li').addClass('d-none');

                },
                error: function (jqXHR, textStatus, errorThrown) {
                    toastr.options = {
                        "closeButton": true,
                        "progressBar": true,
                        "positionClass": "toast-bottom-right",
                        "timeOut": "10000",
                    };
                    toastr.error(errorThrown);
                }

            });
        }
    });
    
    $(document).on("click", ".cancelEditComplaintBtn", function(e){
        $('a[role="tab"]').on('shown').removeClass('active');
		$('div[role="tabpanel"]').on('shown').removeClass('active').removeClass('show');
		$('a[aria-controls="pills-home"]').addClass('active');
		$("#pills-home").addClass('show').addClass('active');
        $('a[aria-controls="complaintsTable"]').addClass('active').addClass('show');
        $('#complaintsTable').addClass('active').addClass('show');
        $('a[aria-controls="editComplaint"]').closest('li').addClass('d-none');
    });

    $(document).on("click", ".viewComplaintBtn", function(e){
    	e.preventDefault();
        var id = $(this).attr('data-id');

        $.ajax({
            beforeSend: function () {
                $('#overlay').removeClass('d-none');
            },
            complete: function () {
                $('#overlay').addClass('d-none');  
            },
            type: 'GET',
            url: "/data/complaint/get_details/"+id,
            dataType: 'JSON',
            cache: false,
            success: function (response) {
	        	var complaint = response;
	            $("#viewComplaint").find('#complaint-category').html(complaint.complaint_category.name).end();
	            $("#viewComplaint").find('#complaint-description').html(complaint.description).end();

                var departments = "";
                $.each(complaint.departments , function(k, v){
                    departments += ` <span class="badge badge-info">${v.name}</span> `;
                });
                $("#viewComplaint").find('#complaint-department').html(departments).end();
  
                var staff = "";
                $.each(complaint.staff , function(k, v){
                    staff += v.first_name + " " + v.last_name + " | ";
                });
                $("#viewComplaint").find('#complaint-staff').html(staff).end();

	            $('a[role="tab"]').on('shown').removeClass('active');
		        $('div[role="tabpanel"]').on('shown').removeClass('active').removeClass('show');
		        $('a[aria-controls="viewComplaint"]').addClass('active');
		        $('#viewComplaint').addClass('active').addClass('show');
		        $('a[aria-controls="viewComplaint"]').closest('li').removeClass('d-none');
            }
        });
    });

    $(document).on("click", ".closeViewComplaintBtn", function(e){
        $('a[role="tab"]').on('shown').removeClass('active');
		$('div[role="tabpanel"]').on('shown').removeClass('active').removeClass('show');
        $('a[aria-controls="complaintsTable"]').addClass('active');
		$("#complaintsTable").addClass('show').addClass('active');
        $('a[aria-controls="complaintsTable"]').addClass('active');
        $('#complaintsTable').addClass('active').addClass('show');
        $('a[aria-controls="viewComplaint"]').closest('li').addClass('d-none');
    });

    $(document).on("click", ".deleteComplaintBtn", function(e){
    	var id = $(this).attr('data-id');
    	bootbox.confirm({
    		message: "Are you sure you want to delete this complaint?", 
    		centerVertical: true,
    		callback: function(result){ 
		    	if(result){
			        $.ajax({
			            beforeSend: function () {
			                $('#overlay').removeClass('d-none');
			            },
			            complete: function () {
			                $('#overlay').addClass('d-none');  
			            },
			            type: 'GET',
			            url: "/data/complaint/delete/"+id,
			            dataType: 'JSON',
			            cache: false,
			            success: function (response, textStatus, jqXHR) {
			            	$('#complaints-table').DataTable().ajax.reload();
			                toastr.success(response.message);

			            },
			            error: function (jqXHR, textStatus, errorThrown) {
			                toastr.options = {
			                    "closeButton": true,
			                    "progressBar": true,
			                    "positionClass": "toast-bottom-right",
			                    "timeOut": "10000",
			                };
			                toastr.error(errorThrown);
			            }
			        }); 	    		
		    	}
			}
		});
    });  

    $(document).on("click", ".approveComplaintBtn", function(e){
    	var id = $(this).attr('data-id');
    	bootbox.confirm({
    		message: "Are you sure you want to approve this complaint?", 
    		centerVertical: true,
    		callback: function(result){ 
		    	if(result){
			        $.ajax({
			            beforeSend: function () {
			                $('#overlay').removeClass('d-none');
			            },
			            complete: function () {
			                $('#overlay').addClass('d-none');  
			            },
			            type: 'GET',
			            url: "/data/complaint/approve/"+id,
			            dataType: 'JSON',
			            cache: false,
			            success: function (response, textStatus, jqXHR) {
			            	$('#complaints-table').DataTable().ajax.reload();
			                toastr.success(response.message);

			            },
			            error: function (jqXHR, textStatus, errorThrown) {
			                toastr.options = {
			                    "closeButton": true,
			                    "progressBar": true,
			                    "positionClass": "toast-bottom-right",
			                    "timeOut": "10000",
			                };
			                toastr.error(errorThrown);
			            }
			        }); 	    		
		    	}
			}
		});
    });   
});

(function($){
    $.loadDepartments = function (){
        $('select').selectpicker();
        $.get("/data/department/get_list", function(data, status){
            var data = JSON.parse(data);
            var departments = '';
            $.each(data.departments, function(k,v){
                departments += 
                    `
                        <option value='${v.id}'>${v.name}</option>
                    `;

              });
            $('[name="department_id[]"]').html(departments);
            $('select').selectpicker('refresh');
        });    
    }

    $.loadStaff = function (departments){
        $('select').selectpicker();
        $.get("/data/staff/get_list_department_filter?departments="+departments, function(data, status){
            var data = JSON.parse(data);
            var staff = '';
            $.each(data.staff, function(k,v){
                staff += 
                    `
                        <option value='${v.id}'>${v.first_name} ${v.last_name}</option>
                    `;

              });
            $('[name="staff_id[]"]').html(staff);
            $('select').selectpicker('refresh');
        });    
    }

    $.loadComplaintCategories = function (){
        $('select').selectpicker();
        $.get("/data/complaint_category/get_list", function(data, status){
            var data = JSON.parse(data);
            var complaint_categories = '<option></option>';
            $.each(data.complaint_categories, function(k,v){
                complaint_categories += 
                    `
                        <option value='${v.id}'>${v.name}</option>
                    `;

              });
            $('[name="complaint_category_id"]').html(complaint_categories);
            $('select').selectpicker('refresh');
        });    
    }

    $.loadComplaints = function (){
        $('select').selectpicker();
        $.get("/data/complaint/get_list", function(data, status){
            var data = JSON.parse(data);
            // var complaint_categories = '<option></option>';
            // $.each(data.complaint_categories, function(k,v){
            //     complaint_categories += 
            //         `
            //             <option value='${v.id}'>${v.name}</option>
            //         `;

            //   });
            // $('[name="complaint_category_id"]').html(complaint_categories);
            // $('select').selectpicker('refresh');
        });    
    }

})(jQuery);
</script>
@endsection 
