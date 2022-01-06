@extends('layouts.app')

@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="page-title">
			<h3 class="text-black-50 float-left"><i class="nav-icon fa fa-book"></i> Complaint Categories</h3>
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
						<a class="nav-link active" data-toggle="tab" href="#complaintCategoriesTable" role="tab" aria-controls="complaintCategoriesTable" aria-selected="true">Complaint Categories</a>
					</li>
					<li class="nav-item d-none">
						<a class="nav-link" data-toggle="tab" href="#complaintCategories" role="tab" aria-controls="complaintCategories" aria-selected="false">Card View</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" data-toggle="tab" href="#newComplaintCategory" role="tab" aria-controls="newComplaintCategory" aria-selected="false">New</a>
					</li>
					<li class="nav-item d-none">
						<a class="nav-link" data-toggle="tab" href="#editComplaintCategory" role="tab" aria-controls="editComplaintCategory" aria-selected="false">Edit</a>
					</li>
					<li class="nav-item d-none">
						<a class="nav-link" data-toggle="tab" href="#viewComplaintCategory" role="tab" aria-controls="viewComplaintCategory" aria-selected="false">View</a>
					</li>
				</ul>
				<div class="tab-content" id="myTabContent">
					<div class="tab-pane fade show active" id="complaintCategoriesTable" role="tabpanel" aria-labelledby="complaintCategoriesTable-tab">
						<div class="mt-3">
							<table class="table table-bordered table-stripped table-display table-hover" id="complaintCategories-table">
								<thead>
									<tr>
										<th class="col-md-8">Name</th>
										<th class="col-md-2 text-right">Actions</th>
									</tr>
								</thead>
							</table>
						</div>
					</div>
					<div class="tab-pane fade" id="newComplaintCategory" role="tabpanel" aria-labelledby="newComplaintCategory-tab">
						<div class="mt-3">
							<form action="{{ route('complaint_category_create') }}" method="POST" enctype="multipart/form-data" class="complaintCategory-form" id="new-complaintCategory">
								@csrf
								<div class="card shadow p-3 mb-5 bg-white rounded">
									<div class="card-header">
										<h5 class="">Complaint Category Details</h5>
									</div>
									<div class="card-body">
										<div class="form-group row">
											<label for="name" >Name</label>
											<input type="text" class="form-control" name="name" placeholder="Service" autocomplete="off">
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
					<div class="tab-pane fade" id="editComplaintCategory" role="tabpanel" aria-labelledby="editComplaintCategory-tab">
						<div class="mt-3">
							<form action="{{ route('complaint_category_update') }}" method="POST" enctype="multipart/form-data" class="complaintCategory-form" id="edit-complaintCategory">
								@csrf
								<input type="hidden" name="id">
								<div class="card shadow p-3 mb-5 bg-white rounded">
									<div class="card-header">
										<h5 class="">Complaint Category Details</h5>
									</div>
									<div class="card-body">
										<div class="form-group row">
											<label for="name" >Name</label>
											<input type="text" class="form-control" name="name" placeholder=Service" autocomplete="off">
										</div>
									</div>
									<div class="card-footer text-right">
										<button type="reset" class="btn btn-sm btn-secondary cancelEditComplaintCategoryBtn"><i class="fa fa-times"></i> Cancel</button>
										<button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-check"></i> Submit</button>	
									</div>
								</div>
							</form>						
						</div>
					</div>
					<div class="tab-pane fade" id="viewComplaintCategory" role="tabpanel" aria-labelledby="viewComplaintCategory-tab">
						<div class="mt-3 ml-auto">
				
							<div class="card-footer text-right">
								<button type="button" class="btn btn-sm btn-secondary closeViewComplaintCategoryBtn"><i class="fa fa-times"></i> Close</button>
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

    // ComplaintCategory code //
    $("#complaintCategories-table").DataTable({
        "processing": true,
        "serverSide": true,
        responsive: true,
        "order": [],
        ajax: {
            url: '/data/complaint_category/dataTable',
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
            sEmptyTable: "No complaint categories found"
        },
    });
    

    $("#new-complaintCategory").validate({
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
                	$('#complaintCategories-table').DataTable().ajax.reload();
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

    $(document).on("click", ".editComplaintCategoryBtn", function(e){
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
            url: "/data/complaint_category/get_details/"+id,
            dataType: 'JSON',
            cache: false,
            success: function (response) {
	        	var complaintCategory = response;
	            $("#editComplaintCategory").find('[name="name"]').val(complaintCategory.name).end(); 
	            $("#editComplaintCategory").find('[name="id"]').val(complaintCategory.id).end();  

	            $('select').selectpicker('refresh');

		        $('a[role="tab"]').on('shown').removeClass('active');
		        $('div[role="tabpanel"]').on('shown').removeClass('active').removeClass('show');
		        $('a[aria-controls="editComplaintCategory"]').addClass('active');
		        $('#editComplaintCategory').addClass('active').addClass('show');
		        $('a[aria-controls="editComplaintCategory"]').closest('li').removeClass('d-none');
            }
        });
    });

    $("#edit-complaintCategory").validate({
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
                	$('#complaintCategories-table').DataTable().ajax.reload();
                    toastr.success(response.message);

			        $('a[role="tab"]').on('shown').removeClass('active');
					$('div[role="tabpanel"]').on('shown').removeClass('active').removeClass('show');
					$('a[aria-controls="complaintCategoriesTable"]').addClass('active');
					$("#complaintCategoriesTable").addClass('show').addClass('active');
			        $('a[aria-controls="complaintCategoriesTable"]').addClass('active').addClass('show');
			        $('#complaintCategoriesTable').addClass('active').addClass('show');
			        $('a[aria-controls="editComplaintCategory"]').closest('li').addClass('d-none');

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
    
    $(document).on("click", ".cancelEditComplaintCategoryBtn", function(e){
        $('a[role="tab"]').on('shown').removeClass('active');
		$('div[role="tabpanel"]').on('shown').removeClass('active').removeClass('show');
		$('a[aria-controls="pills-home"]').addClass('active');
		$("#pills-home").addClass('show').addClass('active');
        $('a[aria-controls="complaintCategoriesTable"]').addClass('active').addClass('show');
        $('#complaintCategoriesTable').addClass('active').addClass('show');
        $('a[aria-controls="editComplaintCategory"]').closest('li').addClass('d-none');
    });

    $(document).on("click", ".viewComplaintCategoryBtn", function(e){
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
            url: "/data/complaint_category/get_details/"+id,
            dataType: 'JSON',
            cache: false,
            success: function (response) {
	        	var complaintCategory = response.profile;
	            $("#viewComplaintCategory").find('.complaintCategory-avatar').attr('src', `{{ asset('avatars/${complaintCategory.avatar}') }}`);
	            $("#viewComplaintCategory").find('.name').html(complaintCategory.name +" " +complaintCategory.last_name).end();
	            $("#viewComplaintCategory").find('.phone').html('+254'+complaintCategory.phone).end();
	            $("#viewComplaintCategory").find('.bio').html(complaintCategory.bio).end(); 
	            $("#viewComplaintCategory").find('.editComplaintCategoryBtn').attr('data-id', complaintCategory.id).end();    


	            $('a[role="tab"]').on('shown').removeClass('active');
		        $('div[role="tabpanel"]').on('shown').removeClass('active').removeClass('show');
		        $('a[aria-controls="complaintCategoriesTable"]').addClass('active');
		        $("#complaintCategoriesTable").addClass('show').addClass('active');
		        $('a[aria-controls="viewComplaintCategory"]').addClass('active');
		        $('a[aria-controls="pills-image-table"]').addClass('active');
		        $('#viewComplaintCategory').addClass('active').addClass('show');
		        $('#pills-image-table').addClass('active').addClass('show');
		        $('a[aria-controls="viewComplaintCategory"]').closest('li').removeClass('d-none');
            }
        });
    });

    $(document).on("click", ".closeViewComplaintCategoryBtn", function(e){
        $('a[role="tab"]').on('shown').removeClass('active');
		$('div[role="tabpanel"]').on('shown').removeClass('active').removeClass('show');
        $('a[aria-controls="complaintCategoriesTable"]').addClass('active');
		$("#complaintCategoriesTable").addClass('show').addClass('active');
        $('a[aria-controls="complaintCategoriesTable"]').addClass('active');
        $('#complaintCategoriesTable').addClass('active').addClass('show');
        $('a[aria-controls="viewComplaintCategory"]').closest('li').addClass('d-none');
    });

    $(document).on("click", ".deleteComplaintCategoryBtn", function(e){
    	var id = $(this).attr('data-id');
    	bootbox.confirm({
    		message: "Are you sure you want to delete this complaintCategory?", 
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
			            url: "/data/complaint_category/delete/"+id,
			            dataType: 'JSON',
			            cache: false,
			            success: function (response, textStatus, jqXHR) {
			            	$('#complaintCategories-table').DataTable().ajax.reload();
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
