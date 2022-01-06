@extends('layouts.app')

@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="page-title">
			<h3 class="text-black-50 float-left"><i class="nav-icon fa fa-book"></i> Departments</h3>
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
						<a class="nav-link active" data-toggle="tab" href="#departmentsTable" role="tab" aria-controls="departmentsTable" aria-selected="true">Departments</a>
					</li>
					<li class="nav-item d-none">
						<a class="nav-link" data-toggle="tab" href="#departments" role="tab" aria-controls="departments" aria-selected="false">Card View</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" data-toggle="tab" href="#newDepartment" role="tab" aria-controls="newDepartment" aria-selected="false">New</a>
					</li>
					<li class="nav-item d-none">
						<a class="nav-link" data-toggle="tab" href="#editDepartment" role="tab" aria-controls="editDepartment" aria-selected="false">Edit</a>
					</li>
					<li class="nav-item d-none">
						<a class="nav-link" data-toggle="tab" href="#viewDepartment" role="tab" aria-controls="viewDepartment" aria-selected="false">View</a>
					</li>
				</ul>
				<div class="tab-content" id="myTabContent">
					<div class="tab-pane fade show active" id="departmentsTable" role="tabpanel" aria-labelledby="departmentsTable-tab">
						<div class="mt-3">
							<table class="table table-bordered table-stripped table-display table-hover" id="departments-table">
								<thead>
									<tr>
										<th class="col-md-8">Name</th>
										<th class="col-md-2 text-right">Actions</th>
									</tr>
								</thead>
							</table>
						</div>
					</div>
					<div class="tab-pane fade" id="newDepartment" role="tabpanel" aria-labelledby="newDepartment-tab">
						<div class="mt-3">
							<form action="{{ route('department_create') }}" method="POST" enctype="multipart/form-data" class="yearOfStudy-form" id="new-yearOfStudy">
								@csrf
								<div class="card shadow p-3 mb-5 bg-white rounded">
									<div class="card-header">
										<h5 class="">Department Details</h5>
									</div>
									<div class="card-body">
										<div class="form-group row">
											<label for="name" >Name</label>
											<input type="text" class="form-control" name="name" placeholder="Inpatient Service" autocomplete="off">
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
					<div class="tab-pane fade" id="editDepartment" role="tabpanel" aria-labelledby="editDepartment-tab">
						<div class="mt-3">
							<form action="{{ route('department_update') }}" method="POST" enctype="multipart/form-data" class="yearOfStudy-form" id="edit-yearOfStudy">
								@csrf
								<input type="hidden" name="id">
								<div class="card shadow p-3 mb-5 bg-white rounded">
									<div class="card-header">
										<h5 class="">Department Details</h5>
									</div>
									<div class="card-body">
										<div class="form-group row">
											<label for="name" >Name</label>
											<input type="text" class="form-control" name="name" placeholder="Inpatient Service" autocomplete="off">
										</div>
									</div>
									<div class="card-footer text-right">
										<button type="reset" class="btn btn-sm btn-secondary cancelEditDepartmentBtn"><i class="fa fa-times"></i> Cancel</button>
										<button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-check"></i> Submit</button>	
									</div>
								</div>
							</form>						
						</div>
					</div>
					<div class="tab-pane fade" id="viewDepartment" role="tabpanel" aria-labelledby="viewDepartment-tab">
						<div class="mt-3 ml-auto">
				
							<div class="card-footer text-right">
								<button type="button" class="btn btn-sm btn-secondary closeViewDepartmentBtn"><i class="fa fa-times"></i> Close</button>
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

    // Department code //
    $("#departments-table").DataTable({
        "processing": true,
        "serverSide": true,
        responsive: true,
        "order": [],
        ajax: {
            url: '/data/department/dataTable',
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
            sEmptyTable: "No departments found"
        },
    });
    

    $("#new-yearOfStudy").validate({
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
                	$('#departments-table').DataTable().ajax.reload();
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

    $(document).on("click", ".editDepartmentBtn", function(e){
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
            url: "/data/department/get_details/"+id,
            dataType: 'JSON',
            cache: false,
            success: function (response) {
	        	var yearOfStudy = response;
	            $("#editDepartment").find('[name="name"]').val(yearOfStudy.name).end(); 
	            $("#editDepartment").find('[name="id"]').val(yearOfStudy.id).end();  

	            $('select').selectpicker('refresh');

		        $('a[role="tab"]').on('shown').removeClass('active');
		        $('div[role="tabpanel"]').on('shown').removeClass('active').removeClass('show');
		        $('a[aria-controls="editDepartment"]').addClass('active');
		        $('#editDepartment').addClass('active').addClass('show');
		        $('a[aria-controls="editDepartment"]').closest('li').removeClass('d-none');
            }
        });
    });

    $("#edit-yearOfStudy").validate({
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
                	$('#departments-table').DataTable().ajax.reload();
                    toastr.success(response.message);

			        $('a[role="tab"]').on('shown').removeClass('active');
					$('div[role="tabpanel"]').on('shown').removeClass('active').removeClass('show');
					$('a[aria-controls="departmentsTable"]').addClass('active');
					$("#departmentsTable").addClass('show').addClass('active');
			        $('a[aria-controls="yearOfStudysTable"]').addClass('active').addClass('show');
			        $('#yearOfStudysTable').addClass('active').addClass('show');
			        $('a[aria-controls="editDepartment"]').closest('li').addClass('d-none');

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
    
    $(document).on("click", ".cancelEditDepartmentBtn", function(e){
        $('a[role="tab"]').on('shown').removeClass('active');
		$('div[role="tabpanel"]').on('shown').removeClass('active').removeClass('show');
		$('a[aria-controls="pills-home"]').addClass('active');
		$("#pills-home").addClass('show').addClass('active');
        $('a[aria-controls="departmentsTable"]').addClass('active').addClass('show');
        $('#departmentsTable').addClass('active').addClass('show');
        $('a[aria-controls="editDepartment"]').closest('li').addClass('d-none');
    });

    $(document).on("click", ".viewDepartmentBtn", function(e){
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
            url: "/data/yearOfStudy/get_details/"+id,
            dataType: 'JSON',
            cache: false,
            success: function (response) {
	        	var yearOfStudy = response.profile;
	            $("#viewDepartment").find('.yearOfStudy-avatar').attr('src', `{{ asset('avatars/${yearOfStudy.avatar}') }}`);
	            $("#viewDepartment").find('.name').html(yearOfStudy.name +" " +yearOfStudy.last_name).end();
	            $("#viewDepartment").find('.phone').html('+254'+yearOfStudy.phone).end();
	            $("#viewDepartment").find('.bio').html(yearOfStudy.bio).end(); 
	            $("#viewDepartment").find('.editDepartmentBtn').attr('data-id', yearOfStudy.id).end();    


	            $('a[role="tab"]').on('shown').removeClass('active');
		        $('div[role="tabpanel"]').on('shown').removeClass('active').removeClass('show');
		        $('a[aria-controls="departmentsTable"]').addClass('active');
		        $("#departmentsTable").addClass('show').addClass('active');
		        $('a[aria-controls="viewDepartment"]').addClass('active');
		        $('a[aria-controls="pills-image-table"]').addClass('active');
		        $('#viewDepartment').addClass('active').addClass('show');
		        $('#pills-image-table').addClass('active').addClass('show');
		        $('a[aria-controls="viewDepartment"]').closest('li').removeClass('d-none');
            }
        });
    });

    $(document).on("click", ".closeViewDepartmentBtn", function(e){
        $('a[role="tab"]').on('shown').removeClass('active');
		$('div[role="tabpanel"]').on('shown').removeClass('active').removeClass('show');
        $('a[aria-controls="departmentsTable"]').addClass('active');
		$("#departmentsTable").addClass('show').addClass('active');
        $('a[aria-controls="yearOfStudysTable"]').addClass('active');
        $('#yearOfStudysTable').addClass('active').addClass('show');
        $('a[aria-controls="viewDepartment"]').closest('li').addClass('d-none');
    });

    $(document).on("click", ".deleteDepartmentBtn", function(e){
    	var id = $(this).attr('data-id');
    	bootbox.confirm({
    		message: "Are you sure you want to delete this yearOfStudy?", 
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
			            url: "/data/yearOfStudy/delete/"+id,
			            dataType: 'JSON',
			            cache: false,
			            success: function (response, textStatus, jqXHR) {
			            	$('#yearOfStudys-table').DataTable().ajax.reload();
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

    $(document).on("click", ".approveDepartmentBtn", function(e){
    	var id = $(this).attr('data-id');
    	bootbox.confirm({
    		message: "Are you sure you want to approve this yearOfStudy?", 
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
			            url: "/data/yearOfStudy/approve/"+id,
			            dataType: 'JSON',
			            cache: false,
			            success: function (response, textStatus, jqXHR) {
			            	$('#yearOfStudys-table').DataTable().ajax.reload();
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
