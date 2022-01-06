<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Complaint Management System</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css"
          integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog=="
          crossorigin="anonymous"/>

  <link rel="stylesheet" href="{{ asset('backend/plugins/fontawesome-free/css/all.min.css') }}">

  <link href="{{ asset('frontend/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('frontend/vendor/icofont/icofont.min.css') }}" rel="stylesheet">
  <link href="{{ asset('frontend/vendor/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
  <link href="{{ asset('frontend/vendor/ionicons/css/ionicons.min.css') }}" rel="stylesheet">
  <link href="{{ asset('frontend/vendor/animate.css/animate.min.css') }}" rel="stylesheet">
  <link href="{{ asset('frontend/vendor/venobox/venobox.css') }}" rel="stylesheet">
  <link href="{{ asset('frontend/vendor/owl.carousel/assets/owl.carousel.min.css') }}" rel="stylesheet">
  <link href="{{ asset('frontend/vendor/aos/aos.css') }}" rel="stylesheet">

  <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
  <!-- Template Main CSS File -->
  <link href="{{ asset('frontend/css/style.css') }}" rel="stylesheet">
<link href="{{ asset('css/app.css') }}" rel="stylesheet">
<link href="{{ asset('css/toastr.css') }}" rel="stylesheet">

</head>
<body class="hold-transition register-page">
  <header id="header" class="fixed-top">
    <div class="container-fluid">
      <div class="row justify-content-center">
        <div class="col-xl-11 d-flex align-items-center">
          <h4 class="logo mr-auto" style="font-size: 20px !important"><a href="/">Patient Complaint Management System</a></h4>
          <!-- Uncomment below if you prefer to use an image logo -->
          <!-- <a href="index.html" class="logo mr-auto"><img src="{{ asset('frontend/img/logo.png') }}" alt="" class="img-fluid"></a>-->

          <nav class="nav-menu d-none d-lg-block">
            <ul>
              <li><a href="/">Home</a></li>

              @if(Auth::user())
                <li><a href="/home">Dashboard</a></li>
              @else
                <li class="active"><a href="{{ route('patient_identification') }}">File a complaint</a></li>
                <!-- <li><a href="/register">Sign up</a></li> -->
              @endif


            </ul>
          </nav><!-- .nav-menu -->
        </div>
      </div>

    </div>
  </header>
    <div class="register-box">
        <div class="register-logo">
            <a href="{{ url('/home') }}"><b></b></a>
        </div>

        <div class="card">
            <!-- <div class="card-header">
                <i class="fas fa-sign-in-alt"></i> Register
            </div> -->
            <div class="card-body register-card-body">
            <div class="jumbotron jumbotron-fluid py-2">
                <div class="container">
                    <p class="lead" style="font-size: 1rem !important">Choose a method to identify you and get a One Time Password (OTP) via SMS to Your Registered Phone Number</p>
                </div>
            </div>
                <form>
                    @csrf
                    <div class="form-group">
                        <select class="form-control selectpicker" name="verification_method">
                        <option value="">Select a method</option>
                            <option value="id">ID | Passport</option>
                            <option value="phone">Phone</option>
                            <option value="email">Email</option>
                        </select>
                    </div>
                </form>
                <form method="post" action="{{ route('register_patient_user') }}" id="idForm" class="d-none">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="text" name="id_number" class="form-control" placeholder="Enter your ID | Passport here" autocomplete ="off">
                        <div class="input-group-append">
                            <div class="input-group-text"><span class="fa fa-id-card"></span></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block">Verify</button>
                    </div>
                </form>

                <form method="post" action="{{ route('register_patient_user') }}" id="emailForm" class="d-none">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="emai" name="email" class="form-control" placeholder="Enter email here" autocomplete ="off">
                        <div class="input-group-append">
                            <div class="input-group-text"><span class="fas fa-envelope"></span></div>
                        </div>
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block">Verify</button>
                    </div>
                </form>

                <form method="post" action="{{ route('register_patient_user') }}" id="phoneForm" class="d-none">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="text" name="phone" class="form-control" placeholder="Enter phone here" autocomplete ="off">
                        <div class="input-group-append">
                            <div class="input-group-text"><span class="fas fa-phone"></span></div>
                        </div>
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block">Verify</button>
                    </div>
                </form>

                <form method="post" action="{{ route('authenticate_patient_user') }}" id="authenticationForm" class="d-none">
                    @csrf
                    <input type="hidden" name="id"/>
                    <div class="input-group mb-3">
                        <input type="password" name="password" class="form-control" placeholder="Enter OTP here" autocomplete ="off">
                        <div class="input-group-append">
                            <div class="input-group-text"><span class="fas fa-lock"></span></div>
                        </div>
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block">Proceed</button>
                    </div>
                </form>
                <!-- <a href="{{ route('login') }}" class="text-center">I already have a membership</a> -->
            </div>
            <!-- /.form-box -->
        </div><!-- /.card -->

        <!-- /.form-box -->
    </div>
<!-- /.register-box -->

<script src="{{ asset('js/app.js') }}" defer></script>
<script src="{{ asset('js/jquery.validate.js') }}" defer></script>
<script src="{{ asset('js/toastr.min.js') }}"></script>
<script>
  $(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // $('.selectpicker').selectpicker();

    toastr.options = {
        "closeButton": true,
        "progressBar": true,
        "positionClass": "toast-bottom-right",
        "timeOut": "10000",
    };

    $(document).on('change', '[name="verification_method"]', function(){
        if($(this).val() == 'phone'){
            $('#phoneForm').removeClass('d-none');

            $('#emailForm').addClass('d-none');
            $('#idForm').addClass('d-none');
            $('#authenticationForm').addClass('d-none');
        }
        else if($(this).val() == 'id'){
            $('#idForm').removeClass('d-none');

            $('#emailForm').addClass('d-none');
            $('#phoneForm').addClass('d-none');
            $('#authenticationForm').addClass('d-none');
        }
        else if($(this).val() == 'email'){
            $('#emailForm').removeClass('d-none');

            $('#idForm').addClass('d-none');
            $('#phoneForm').addClass('d-none');
            $('#authenticationForm').addClass('d-none');
        }
        else{
            $('#emailForm').addClass('d-none');
            $('#idForm').addClass('d-none');
            $('#phoneForm').addClass('d-none');
            $('#authenticationForm').addClass('d-none');
        }
    });

    $("#idForm").validate({
        rules: {
            id_number: {
                required: true,
                minlength: 2
            },
        },
        submitHandler: function(form) {
        	var formData = new FormData(form);
            formData.append("verification_method", $('[name="verification_method"]').val())
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
                    toastr.success(response.message);
                    $('[name="id"]').val(response.id);
                    $("#idForm").addClass('d-none');
                    $('#authenticationForm').removeClass('d-none');
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    toastr.options = {
                        "closeButton": true,
                        "progressBar": true,
                        "positionClass": "toast-bottom-right",
                        "timeOut": "10000",
                    };
                    toastr.error(jqXHR.responseJSON.message);
                }
            });


        }
    });

    $("#emailForm").validate({
        rules: {
            email: {
                required: true,
                minlength: 2
            },
        },
        submitHandler: function(form) {
        	var formData = new FormData(form);
            formData.append("verification_method", $('[name="verification_method"]').val())
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
                    toastr.success(response.message);
                    $('[name="id"]').val(response.id);
                    $("#emailForm").addClass('d-none');
                    $('#authenticationForm').removeClass('d-none');
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    toastr.options = {
                        "closeButton": true,
                        "progressBar": true,
                        "positionClass": "toast-bottom-right",
                        "timeOut": "10000",
                    };
                    toastr.error(jqXHR.responseJSON.message);
                }
            });


        }
    });

    $("#phoneForm").validate({
        rules: {
            phone: {
                required: true,
                minlength: 2
            },
        },
        submitHandler: function(form) {
        	var formData = new FormData(form);
            formData.append("verification_method", $('[name="verification_method"]').val())
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
                    toastr.success(response.message);
                    $('[name="id"]').val(response.id);
                    $("#phoneForm").addClass('d-none');
                    $('#authenticationForm').removeClass('d-none');
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    toastr.options = {
                        "closeButton": true,
                        "progressBar": true,
                        "positionClass": "toast-bottom-right",
                        "timeOut": "10000",
                    };
                    toastr.error(jqXHR.responseJSON.message);
                }
            });


        }
    });

    $("#authenticationForm").validate({
        rules: {
            password: {
                required: true,
                minlength: 4
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
                    toastr.success(response.message);
                    setTimeout(
                        function() 
                        {
                            toastr.success("You will be redirected in 3 seconds");
                            location.replace('/home');
                        }, 2000);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    toastr.options = {
                        "closeButton": true,
                        "progressBar": true,
                        "positionClass": "toast-bottom-right",
                        "timeOut": "10000",
                    };
                    toastr.error(jqXHR.responseJSON.message);
                }
            });


        }
    });
});
</script>
</body>
</html>