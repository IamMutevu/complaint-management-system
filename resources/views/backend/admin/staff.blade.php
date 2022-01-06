@extends('layouts.app')

@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="page-title">
			<h3 class="text-black-50 float-left"><i class="nav-icon fa fa-users"></i> Staff</h3>
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
						<a class="nav-link active" data-toggle="tab" href="#staffTable" role="tab" aria-controls="staffTable" aria-selected="true">Staff</a>
					</li>
					<li class="nav-item d-none">
						<a class="nav-link" data-toggle="tab" href="#staff" role="tab" aria-controls="staff" aria-selected="false">Card View</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" data-toggle="tab" href="#newStaff" role="tab" aria-controls="newStaff" aria-selected="false">New</a>
					</li>
					<li class="nav-item d-none">
						<a class="nav-link" data-toggle="tab" href="#editStaff" role="tab" aria-controls="edit  " aria-selected="false">Edit</a>
					</li>
					<li class="nav-item d-none">
						<a class="nav-link" data-toggle="tab" href="#viewStaff" role="tab" aria-controls="viewStaff" aria-selected="false">View</a>
					</li>
				</ul>
				<div class="tab-content" id="myTabContent">
					<div class="tab-pane fade show active" id="staffTable" role="tabpanel" aria-labelledby="staffTable-tab">
						<div class="mt-3">
							<table class="table table-bordered table-stripped table-display table-hover" id="staff-table">
								<thead>
									<tr>
										<th class="col-md-3">Name</th>
                                        <th class="col-md-3">Department</th>
                                        <th class="col-md-3">Email</th>
                                        <th class="col-md-2">Phone</th>
										<th class="col-md-1 text-right">Actions</th>
									</tr>
								</thead>
							</table>
						</div>
					</div>
					<div class="tab-pane fade" id="newStaff" role="tabpanel" aria-labelledby="newStaff-tab">
						<div class="mt-3">
                            <form method="post" action="{{ route('staff_create') }}" id="new-staff">
                                @csrf
                                <div class="card shadow mb-5 bg-white rounded">
                                    <div class="card-header">
                                        Staff Information
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
                                            <div class="col-md-8">
                                                <label for="phone">Phone</label>
                                                <div class="input-group mb-3">
                                                    <div class="input-group-append">
                                                        <div class="input-group-text"><span>+254</span></div>
                                                    </div>
                                                    <input type="text" name="phone" placeholder="712 345 678"  class="form-control">
                                                    
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-4">
                                                <label for="gender" data-toggle="tooltip" data-placement="right" title="Helps determine avatar">Gender</label>
                                                <select class="form-control selectpicker" name="gender">
                                                    <option></option>
                                                    <option value="Male">Male</option>
                                                    <option value="Female">Female</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-4">
                                                <label for="id_number">ID | Passport</label>
                                                <input type="text" class="form-control" name="id_number" placeholder="15552468" autocomplete="off">
                                            </div>
                                            <div class="col-md-4">
                                                <label for="email">Email</label>
                                                <input type="text" class="form-control" name="email" placeholder="johndoe@email.com" autocomplete="off">
                                            </div>
                                            <div class="col-md-4">
                                                <label for="department_id">Department</label>
                                                <select class="form-control selectpicker" name="department_id">
                                                    <option></option>
                                                </select>
                                            </div>
                                        </div> 
                                    </div>
                                    <div class="card-footer text-right">
                                        <button type="reset" class="btn btn-sm btn-secondary"><i class="fa fa-times"></i> Clear</button>
                                        <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-check"></i> Submit</button>    
                                    </div>
                                </div>
                            </form>						
						</div>
					</div>
					<div class="tab-pane fade" id="editStaff" role="tabpanel" aria-labelledby="editStaff-tab">
						<div class="mt-3">
							<form action="{{ route('staff_update') }}" method="POST" enctype="multipart/form-data" class="staff-form" id="edit-staff">
								@csrf
								<input type="hidden" name="id">
								<div class="card shadow p-3 mb-5 bg-white rounded">
									<div class="card-header">
										<h5 class="">Staff Details</h5>
									</div>
									<div class="card-body">
										<div class="form-group row">
											<label for="name" >Name</label>
											<input type="text" class="form-control" name="name" placeholder="Advertising/Public Relations" autocomplete="off">
										</div>
									</div>
									<div class="card-footer text-right">
										<button type="reset" class="btn btn-sm btn-secondary cancelEditStaffBtn"><i class="fa fa-times"></i> Cancel</button>
										<button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-check"></i> Submit</button>	
									</div>
								</div>
							</form>						
						</div>
					</div>
					<div class="tab-pane fade" id="viewStaff" role="tabpanel" aria-labelledby="viewStaff-tab">
						<div class="mt-3 ml-auto">
				
							<div class="card-footer text-right">
								<button type="button" class="btn btn-sm btn-secondary closeViewStaffBtn"><i class="fa fa-times"></i> Close</button>
							</div>			
						</div>
					</div>
				</div>
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

    $('.selectpicker').selectpicker();
    $.loadDepartments();
    
    // Staff code //
    $("#staff-table").DataTable({
        "processing": true,
        "serverSide": true,
        responsive: true,
        "order": [],
        ajax: {
            url: '/data/staff/dataTable',
            type: 'POST'
        },
        "columnDefs": [
            {
                "targets": [4],
                "orderable": false,
            },
        ],
        language: {
            searchPlaceholder: "Search",
            sEmptyTable: "No staff found"
        },
    });
    

    $("#new-staff").validate({
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
            department_id: {
                required: true,
            },
            complaint_category_id: {
                required: true,
            } 
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
            department_id: {
                required: "Department is required",
            },  
            complaint_category_id: {
                required: "Comlaint category is required",
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
                	$('#staff-table').DataTable().ajax.reload();
                    $('.selectpicker').selectpicker('refresh');
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

    $(document).on("click", ".editStaffBtn", function(e){
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
            url: "/data/staff/get_details/"+id,
            dataType: 'JSON',
            cache: false,
            success: function (response) {
	        	var staff = response;
	            $("#editStaff").find('[name="name"]').val(staff.name).end(); 
	            $("#editStaff").find('[name="id"]').val(staff.id).end();  

	            $('select').selectpicker('refresh');

		        $('a[role="tab"]').on('shown').removeClass('active');
		        $('div[role="tabpanel"]').on('shown').removeClass('active').removeClass('show');
		        $('a[aria-controls="editStaff"]').addClass('active');
		        $('#editStaff').addClass('active').addClass('show');
		        $('a[aria-controls="editStaff"]').closest('li').removeClass('d-none');
            }
        });
    });

    $("#edit-staff").validate({
        rules: {
            name: {
                required: true,
                minlength: 2
            }
        },
        messages: {
            name: {
                required: "Name is required",
                minlength: "Name should be at least 2 characters"
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
                	$('#staff-table').DataTable().ajax.reload();
                    toastr.success(response.message);

			        $('a[role="tab"]').on('shown').removeClass('active');
					$('div[role="tabpanel"]').on('shown').removeClass('active').removeClass('show');
					$('a[aria-controls="staffTable"]').addClass('active');
					$("#staffTable").addClass('show').addClass('active');
			        $('a[aria-controls="staffsTable"]').addClass('active').addClass('show');
			        $('#staffsTable').addClass('active').addClass('show');
			        $('a[aria-controls="editStaff"]').closest('li').addClass('d-none');

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
    
    $(document).on("click", ".cancelEditStaffBtn", function(e){
        $('a[role="tab"]').on('shown').removeClass('active');
		$('div[role="tabpanel"]').on('shown').removeClass('active').removeClass('show');
		$('a[aria-controls="pills-home"]').addClass('active');
		$("#pills-home").addClass('show').addClass('active');
        $('a[aria-controls="staffTable"]').addClass('active').addClass('show');
        $('#staffTable').addClass('active').addClass('show');
        $('a[aria-controls="editStaff"]').closest('li').addClass('d-none');
    });

    $(document).on("click", ".viewStaffBtn", function(e){
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
            url: "/data/staff/get_details/"+id,
            dataType: 'JSON',
            cache: false,
            success: function (response) {
	        	var staff = response.profile;
	            $("#viewStaff").find('.staff-avatar').attr('src', `{{ asset('avatars/${staff.avatar}') }}`);
	            $("#viewStaff").find('.name').html(staff.name +" " +staff.last_name).end();
	            $("#viewStaff").find('.phone').html('+254'+staff.phone).end();
	            $("#viewStaff").find('.bio').html(staff.bio).end(); 
	            $("#viewStaff").find('.editStaffBtn').attr('data-id', staff.id).end();    


	            $('a[role="tab"]').on('shown').removeClass('active');
		        $('div[role="tabpanel"]').on('shown').removeClass('active').removeClass('show');
		        $('a[aria-controls="staffTable"]').addClass('active');
		        $("#staffTable").addClass('show').addClass('active');
		        $('a[aria-controls="viewStaff"]').addClass('active');
		        $('a[aria-controls="pills-image-table"]').addClass('active');
		        $('#viewStaff').addClass('active').addClass('show');
		        $('#pills-image-table').addClass('active').addClass('show');
		        $('a[aria-controls="viewStaff"]').closest('li').removeClass('d-none');
            }
        });
    });

    $(document).on("click", ".closeViewStaffBtn", function(e){
        $('a[role="tab"]').on('shown').removeClass('active');
		$('div[role="tabpanel"]').on('shown').removeClass('active').removeClass('show');
        $('a[aria-controls="staffTable"]').addClass('active');
		$("#staffTable").addClass('show').addClass('active');
        $('a[aria-controls="staffsTable"]').addClass('active');
        $('#staffsTable').addClass('active').addClass('show');
        $('a[aria-controls="viewStaff"]').closest('li').addClass('d-none');
    });

    $(document).on("click", ".deleteStaffBtn", function(e){
    	var id = $(this).attr('data-id');
    	bootbox.confirm({
    		message: "Are you sure you want to delete this staff?", 
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
			            url: "/data/staff/delete/"+id,
			            dataType: 'JSON',
			            cache: false,
			            success: function (response, textStatus, jqXHR) {
			            	$('#staffs-table').DataTable().ajax.reload();
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

    $(document).on("click", ".approveStaffBtn", function(e){
    	var id = $(this).attr('data-id');
    	bootbox.confirm({
    		message: "Are you sure you want to approve this staff?", 
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
			            url: "/data/staff/approve/"+id,
			            dataType: 'JSON',
			            cache: false,
			            success: function (response, textStatus, jqXHR) {
			            	$('#staffs-table').DataTable().ajax.reload();
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
            var departments = '<option></option>';
            $.each(data.departments, function(k,v){
                departments += 
                    `
                        <option value='${v.id}'>${v.name}</option>
                    `;

              });
            $('[name="department_id"]').html(departments);
            $('select').selectpicker('refresh');
        });    
    }

})(jQuery);
</script>
@endsection 
