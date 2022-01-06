@extends('layouts.app')

@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="page-title">
			<h3 class="text-black-50 float-left"><i class="nav-icon fa fa-users"></i> Patients</h3>
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
						<a class="nav-link active" data-toggle="tab" href="#patientsTable" role="tab" aria-controls="patientsTable" aria-selected="true">Patients</a>
					</li>
					<li class="nav-item d-none">
						<a class="nav-link" data-toggle="tab" href="#patients" role="tab" aria-controls="patients" aria-selected="false">Card View</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" data-toggle="tab" href="#newPatient" role="tab" aria-controls="newPatient" aria-selected="false">New</a>
					</li>
					<li class="nav-item d-none">
						<a class="nav-link" data-toggle="tab" href="#editPatient" role="tab" aria-controls="editPatient" aria-selected="false">Edit</a>
					</li>
					<li class="nav-item d-none">
						<a class="nav-link" data-toggle="tab" href="#viewPatient" role="tab" aria-controls="viewPatient" aria-selected="false">View</a>
					</li>
				</ul>
				<div class="tab-content" id="myTabContent">
					<div class="tab-pane fade show active" id="patientsTable" role="tabpanel" aria-labelledby="patientsTable-tab">
						<div class="mt-3">
							<table class="table table-bordered table-stripped table-display table-hover" id="patients-table">
								<thead>
									<tr>
										<th class="col-md-3">Name</th>
                                        <th class="col-md-2">Date of birth</th>
                                        <th class="col-md-2">ID | Passport</th>
                                        <th class="col-md-3">Email</th>
										<th class="col-md-1 text-right">Actions</th>
									</tr>
								</thead>
							</table>
						</div>
					</div>
					<div class="tab-pane fade" id="newPatient" role="tabpanel" aria-labelledby="newPatient-tab">
						<div class="mt-3">
                            <form method="post" action="{{ route('patient_create') }}" id="new-patient">
                                @csrf
                                <div class="card shadow mb-5 bg-white rounded">
                                    <div class="card-header">
                                        Patient Information
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group row">
                                            <div class="col-md-4">
                                                <label for="first_name" >First name</label>
                                                <input type="text" class="form-control" name="first_name" placeholder="John" autocomplete="off">
                                            </div>
                                            <div class="col-md-4">
                                                <label for="last_name" >Middle name (Optional)</label>
                                                <input type="text" class="form-control" name="middle_name" placeholder="Montel" autocomplete="off">
                                            </div>
                                            <div class="col-md-4">
                                                <label for="last_name">Last name</label>
                                                <input type="text" class="form-control" name="last_name" placeholder="Doe" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-7">
                                                <label for="phone">Phone</label>
                                                <div class="input-group mb-3">
                                                    <div class="input-group-append">
                                                        <div class="input-group-text"><span>+254</span></div>
                                                    </div>
                                                    <input type="text" name="phone" placeholder="712 345 678"  class="form-control">
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-5">
                                                <label for="gender" data-toggle="tooltip" data-placement="right" title="Helps determine avatar">Gender</label>
                                                <select class="form-control selectpicker" name="gender">
                                                    <option value="Male">Male</option>
                                                    <option value="Female">Female</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-4">
                                                <label for="last_name">ID | Passport</label>
                                                <input type="text" class="form-control" name="id_number" placeholder="15552468" autocomplete="off">
                                            </div>
                                            <div class="col-md-4">
                                                <label for="email">Email</label>
                                                <input type="text" class="form-control" name="email" placeholder="johndoe@email.com" autocomplete="off">
                                            </div>
                                            <div class="col-md-4">
                                                <label for="deadline">Date of birth</label>
                                                <div class="input-group date" id="datetimepicker1" data-target-input="nearest">
                                                    <input type="text" class="form-control datetimepicker-input" data-target="#datetimepicker1" autocomplete="off" name="date_of_birth"/>
                                                    <div class="input-group-append" data-target="#datetimepicker1" data-toggle="datetimepicker">
                                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                    </div>
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
					<div class="tab-pane fade" id="editPatient" role="tabpanel" aria-labelledby="editPatient-tab">
						<div class="mt-3">
                            <form method="post" action="{{ route('patient_update') }}" id="edit-patient">
                                @csrf
                                <<input type="hidden" name="id">
                                <div class="card shadow mb-5 bg-white rounded">
                                    <div class="card-header">
                                        Patient Information
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group row">
                                            <div class="col-md-4">
                                                <label for="first_name" >First name</label>
                                                <input type="text" class="form-control" name="first_name" placeholder="John" autocomplete="off">
                                            </div>
                                            <div class="col-md-4">
                                                <label for="last_name" >Middle name (Optional)</label>
                                                <input type="text" class="form-control" name="middle_name" placeholder="Montel" autocomplete="off">
                                            </div>
                                            <div class="col-md-4">
                                                <label for="last_name">Last name</label>
                                                <input type="text" class="form-control" name="last_name" placeholder="Doe" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-7">
                                                <label for="phone">Phone</label>
                                                <div class="input-group mb-3">
                                                    <div class="input-group-append">
                                                        <div class="input-group-text"><span>+254</span></div>
                                                    </div>
                                                    <input type="text" name="phone" placeholder="712 345 678"  class="form-control">
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-5">
                                                <label for="gender" data-toggle="tooltip" data-placement="right" title="Helps determine avatar">Gender</label>
                                                <select class="form-control selectpicker" name="gender">
                                                    <option value="Male">Male</option>
                                                    <option value="Female">Female</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-4">
                                                <label for="last_name">ID | Passport</label>
                                                <input type="text" class="form-control" name="id_number" placeholder="15552468" autocomplete="off">
                                            </div>
                                            <div class="col-md-4">
                                                <label for="email">Email</label>
                                                <input type="text" class="form-control" name="email" placeholder="johndoe@email.com" autocomplete="off">
                                            </div>
                                            <div class="col-md-4">
                                                <label for="deadline">Date of birth</label>
                                                <div class="input-group date" id="update-date-of-birth" data-target-input="nearest">
                                                    <input type="text" class="form-control datetimepicker-input" data-target="#update-date-of-birth" autocomplete="off" name="date_of_birth"/>
                                                    <div class="input-group-append" data-target="#update-date-of-birth" data-toggle="datetimepicker">
                                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> 
                                    </div>
                                    <div class="card-footer text-right">
                                        <button type="button" class="btn btn-sm btn-secondary cancelEditPatientBtn"> Cancel</button>
                                        <button type="submit" class="btn btn-sm btn-primary"> Update</button>    
                                    </div>
                                </div>
                            </form>						
						</div>
					</div>
					<div class="tab-pane fade" id="viewPatient" role="tabpanel" aria-labelledby="viewPatient-tab">
						<div class="mt-3 ml-auto">
				
							<div class="card-footer text-right">
								<button type="button" class="btn btn-sm btn-secondary closeViewPatientBtn"><i class="fa fa-times"></i> Close</button>
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
        A patient with the same email or ID | Passport number exists. These fields ought to be unique for each patient. 
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

    $('#datetimepicker1').datetimepicker();
    $('#update-date-of-birth').datetimepicker();
    $('.selectpicker').selectpicker();
    
    // Patient code //
    $("#patients-table").DataTable({
        "processing": true,
        "serverSide": true,
        responsive: true,
        "order": [],
        ajax: {
            url: '/data/patient/dataTable',
            type: 'POST'
        },
        "columnDefs": [
            {
                "targets": [1],
                "orderable": false,
            },
        ],
        language: {
            searchPlaceholder: "Search",
            sEmptyTable: "No patients found"
        },
    });
    
    $("#new-patient").validate({
        rules: {
            first_name: {
                required: true,
                minlength: 2
            },
            last_name: {
                required: true,
                minlength: 2
            }, 
            phone: {
                required: true,
                minlength: 9,
                maxlength: 9
            }, 
            email: {
                required: true,
                minlength: 2
            }, 
            date_of_birth: {
                required: true,
            }, 
        },
        messages: {
            first_name: {
                required: "First name is required",
                minlength: "First name should be at least 2 characters"
            }, 
            last_name: {
                required: "Last name is required",
                minlength: "Last name should be at least 2 characters"
            }, 
            phone: {
                required: "Phone is required",
                minlength: "Phone should be 9 characters"
            },
            email: {
                required: "Email is required",
                minlength: "Email should be at least 2 characters"
            }, 
            date_of_birth: {
                required: "Date of birth is required",
            },  
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
                url: "/data/patient/check_duplicate", 
                method: 'POST',
                data: formData,
                processData: false,
                dataType: 'json', 
                contentType: false,
                success: function (response, textStatus, jqXHR) {
                    if(response.length < 1){
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
                                $('#patients-table').DataTable().ajax.reload();
                                $('select').selectpicker('refresh');
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
                    else{
                        $("#staticBackdrop").modal("show");
                    }

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

    $(document).on("click", ".editPatientBtn", function(e){
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
            url: "/data/patient/get_details/"+id,
            dataType: 'JSON',
            cache: false,
            success: function (response) {
	        	var patient = response;
	            $("#editPatient").find('[name="first_name"]').val(patient.first_name).end(); 
                $("#editPatient").find('[name="middle_name"]').val(patient.middle_name).end();
                $("#editPatient").find('[name="last_name"]').val(patient.last_name).end();
                $("#editPatient").find('[name="phone"]').val(patient.phone).end();
                $("#editPatient").find('[name="gender"]').val(patient.gender).end();
                $("#editPatient").find('[name="id_number"]').val(patient.id_number).end();
                $("#editPatient").find('[name="email"]').val(patient.email).end();
                $("#editPatient").find('[name="date_of_birth"]').val(patient.date_of_birth).end();
	            $("#editPatient").find('[name="id"]').val(patient.id).end();  

	            $('select').selectpicker('refresh');

		        $('a[role="tab"]').on('shown').removeClass('active');
		        $('div[role="tabpanel"]').on('shown').removeClass('active').removeClass('show');
		        $('a[aria-controls="editPatient"]').addClass('active');
		        $('#editPatient').addClass('active').addClass('show');
		        $('a[aria-controls="editPatient"]').closest('li').removeClass('d-none');
            }
        });
    });

    $("#edit-patient").validate({
        rules: {
            first_name: {
                required: true,
                minlength: 2
            },
            last_name: {
                required: true,
                minlength: 2
            }, 
            phone: {
                required: true,
                minlength: 9,
                maxlength: 9
            }, 
            email: {
                required: true,
                minlength: 2
            }, 
            date_of_birth: {
                required: true,
            }, 
        },
        messages: {
            first_name: {
                required: "First name is required",
                minlength: "First name should be at least 2 characters"
            }, 
            last_name: {
                required: "Last name is required",
                minlength: "Last name should be at least 2 characters"
            }, 
            phone: {
                required: "Phone is required",
                minlength: "Phone should be 9 characters"
            },
            email: {
                required: "Email is required",
                minlength: "Email should be at least 2 characters"
            }, 
            date_of_birth: {
                required: "Date of birth is required",
            },  
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
                    $('select').selectpicker('refresh');
                	$('#patients-table').DataTable().ajax.reload();
                    toastr.success(response.message);

			        $('a[role="tab"]').on('shown').removeClass('active');
					$('div[role="tabpanel"]').on('shown').removeClass('active').removeClass('show');
					$('a[aria-controls="patientsTable"]').addClass('active');
					$("#patientsTable").addClass('show').addClass('active');
			        $('a[aria-controls="patientsTable"]').addClass('active').addClass('show');
			        $('#patientsTable').addClass('active').addClass('show');
			        $('a[aria-controls="editPatient"]').closest('li').addClass('d-none');

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
    
    $(document).on("click", ".cancelEditPatientBtn", function(e){
        $('a[role="tab"]').on('shown').removeClass('active');
		$('div[role="tabpanel"]').on('shown').removeClass('active').removeClass('show');
		$('a[aria-controls="pills-home"]').addClass('active');
		$("#pills-home").addClass('show').addClass('active');
        $('a[aria-controls="patientsTable"]').addClass('active').addClass('show');
        $('#patientsTable').addClass('active').addClass('show');
        $('a[aria-controls="editPatient"]').closest('li').addClass('d-none');
    });

    $(document).on("click", ".viewPatientBtn", function(e){
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
            url: "/data/patient/get_details/"+id,
            dataType: 'JSON',
            cache: false,
            success: function (response) {
	        	var patient = response.profile;
	            $("#viewPatient").find('.patient-avatar').attr('src', `{{ asset('avatars/${patient.avatar}') }}`);
	            $("#viewPatient").find('.name').html(patient.name +" " +patient.last_name).end();
	            $("#viewPatient").find('.phone').html('+254'+patient.phone).end();
	            $("#viewPatient").find('.bio').html(patient.bio).end(); 
	            $("#viewPatient").find('.editPatientBtn').attr('data-id', patient.id).end();    


	            $('a[role="tab"]').on('shown').removeClass('active');
		        $('div[role="tabpanel"]').on('shown').removeClass('active').removeClass('show');
		        $('a[aria-controls="patientsTable"]').addClass('active');
		        $("#patientsTable").addClass('show').addClass('active');
		        $('a[aria-controls="viewPatient"]').addClass('active');
		        $('a[aria-controls="pills-image-table"]').addClass('active');
		        $('#viewPatient').addClass('active').addClass('show');
		        $('#pills-image-table').addClass('active').addClass('show');
		        $('a[aria-controls="viewPatient"]').closest('li').removeClass('d-none');
            }
        });
    });

    $(document).on("click", ".closeViewPatientBtn", function(e){
        $('a[role="tab"]').on('shown').removeClass('active');
		$('div[role="tabpanel"]').on('shown').removeClass('active').removeClass('show');
        $('a[aria-controls="patientsTable"]').addClass('active');
		$("#patientsTable").addClass('show').addClass('active');
        $('a[aria-controls="patientsTable"]').addClass('active');
        $('#patientsTable').addClass('active').addClass('show');
        $('a[aria-controls="viewPatient"]').closest('li').addClass('d-none');
    });

    $(document).on("click", ".deletePatientBtn", function(e){
    	var id = $(this).attr('data-id');
    	bootbox.confirm({
    		message: "Are you sure you want to delete this patient?", 
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
			            url: "/data/patient/delete/"+id,
			            dataType: 'JSON',
			            cache: false,
			            success: function (response, textStatus, jqXHR) {
			            	$('#patients-table').DataTable().ajax.reload();
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

    $(document).on("click", ".approvePatientBtn", function(e){
    	var id = $(this).attr('data-id');
    	bootbox.confirm({
    		message: "Are you sure you want to approve this patient?", 
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
			            url: "/data/patient/approve/"+id,
			            dataType: 'JSON',
			            cache: false,
			            success: function (response, textStatus, jqXHR) {
			            	$('#patients-table').DataTable().ajax.reload();
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
</script>
@endsection 
