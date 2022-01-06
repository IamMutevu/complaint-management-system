<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>CMS | Dashboard</title>

  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('backend/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <!-- <link rel="stylesheet" href="{{ asset('backend/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}"> -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{ asset('backend/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <!-- JQVMap -->
  <link rel="stylesheet" href="{{ asset('backend/plugins/jqvmap/jqvmap.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('backend/dist/css/adminlte.min.css') }}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{ asset('backend/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{ asset('backend/plugins/daterangepicker/daterangepicker.css') }}">
  <!-- summernote -->
  <link rel="stylesheet" href="{{ asset('backend/plugins/summernote/summernote-bs4.min.css') }}">

  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">

  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">

  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  <link href="{{ asset('css/style.css') }}" rel="stylesheet">
  <link href="{{ asset('css/dropzone.min.css') }}" rel="stylesheet">
  <link href="{{ asset('css/doka.min.css') }}" rel="stylesheet">
  <link href="{{ asset('css/toastr.css') }}" rel="stylesheet">

  <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" referrerpolicy="no-referrer"></script> -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
</head>

<body class="body-background">
  <nav class=" navbar navbar-expand  navbar-dark">
    <ul class="navbar-nav">
      <li class="nav-item d-none d-sm-inline-block">
        <a href="/" class="brand-link">
          <span class="brand-text font-weight-light pl-2">
            <strong style="font-weight: 700; text-decoration: none; color: #fff">
              UCIPS
            </strong>
          </span>
        </a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->
      <li class="nav-item">
        <a class="nav-link" data-widget="navbar-search" href="#" role="button">
          <i class="fas fa-search"></i>
        </a>
        <div class="navbar-search-block">
          <form class="form-inline">
            <div class="input-group input-group-sm">
              <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
              <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                  <i class="fas fa-search"></i>
                </button>
                <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
          </form>
        </div>
      </li>

      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#" role="button" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
          <i class="fas fa-sign-out"></i>Logout
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
      </li>
    </ul>
  </nav>
  <div class="d-flex justify-content-center">
      @yield('content')
  </div>
    




<script src="{{ asset('js/jquery.validate.js') }}" defer></script>
<script src="{{ asset('js/custom.js') }}" defer></script>
<script src="{{ asset('js/dropzone.min.js') }}"></script> 
<!-- <script src="{{ asset('js/dropzone.js') }}"></script> -->
<script src="{{ asset('js/doka.min.js') }}"></script>
<script src="{{ asset('js/toastr.min.js') }}"></script>
<!-- jQuery -->
<!-- <script src="{{ asset('backend/plugins/jquery/jquery.min.js') }}"></script> -->
<!-- jQuery UI 1.11.4 -->
<script src="{{ asset('backend/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<!-- <script>
  $.widget.bridge('uibutton', $.ui.button)
</script> -->
<!-- Bootstrap 4 -->
<script src="{{ asset('backend/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- ChartJS -->
<!-- <script src="{{ asset('backend/plugins/chart.js/Chart.min.js') }}"></script> -->
<!-- Sparkline -->
<!-- <script src="{{ asset('backend/plugins/sparklines/sparkline.js') }}"></script> -->
<!-- JQVMap -->
<!-- <script src="{{ asset('backend/plugins/jqvmap/jquery.vmap.min.js') }}"></script> -->
<!-- <script src="{{ asset('backend/plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script> -->
<!-- jQuery Knob Chart -->
<!-- <script src="{{ asset('backend/plugins/jquery-knob/jquery.knob.min.js') }}"></script> -->
<!-- daterangepicker -->
<!-- <script src="{{ asset('backend/plugins/moment/moment.min.js') }}"></script> -->
<!-- <script src="{{ asset('backend/plugins/daterangepicker/daterangepicker.js') }}"></script> -->
<!-- Tempusdominus Bootstrap 4 -->
<!-- <script src="{{ asset('backe-nd/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script> -->
<!-- Summernote -->
<script src="{{ asset('backend/plugins/summernote/summernote-bs4.min.js') }}"></script>
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<!-- overlayScrollbars -->
<script src="{{ asset('backend/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('backend/dist/js/adminlte.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.5.2/bootbox.min.js"></script>

<!-- Latest compiled and minified JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>

<script>
Dropzone.autoDiscover = false;    

// const doka = Doka.create();
var avatar = Doka.create({
    cropAspectRatioOptions: [
        {
            label: 'Avatar',
            value: '1:1'
        }
    ]
});
var team = Doka.create({
    cropAspectRatioOptions: [
        {
            label: 'Team',
            value: '3:4'
        }
    ]
});

var user_doka = Doka.create({
    cropAspectRatioOptions: [
        {
            label: 'Square',
            value: '1:1'
        }
    ]
});

var category = Doka.create({
    cropAspectRatioOptions: [
        {
            label: 'Category',
            value: '960:640'
        }
    ]
});

var service = Doka.create({
    cropAspectRatioOptions: [
        {
            label: 'Category',
            value: '16:9'
        }
    ]
});

var banner = Doka.create({
    cropAspectRatioOptions: [
        {
            label: 'Banner',
            value: '20:9'
        }
    ]
});



$.fn.initDropzone = function(){
    var id = $(this).attr('id');
    if ($(this.element).hasClass('single')){
      var limit = 1;
    } 
    else{
      var limit = 25;
    }

    var total_size = 0.0;
    return new Dropzone("#"+id+"",{
        url: "/admin/dropzone",
        maxFilesize: 8, // MB
        addRemoveLinks: true,
        maxFiles: 1, 
        acceptedFiles: 'image/*,application/pdf,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/msword',
        dictDefaultMessage: 'Drop a file or click here to upload',
        dictRemoveFile: "Remove",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        transformFile: function(file, done){
          myDropZone = this;
            if (file.type === 'image/jpeg' || file.type === 'image/png') {
                if (!$(this.element).hasClass('logo')) {
                    if ($(this.element).hasClass('square')) {
                        user_doka.edit(file).then(function (output) {
                            var blob = output.file;
                            myDropZone.createThumbnail(
                                blob,
                                myDropZone.options.thumbnailWidth,
                                myDropZone.options.thumbnailHeight,
                                myDropZone.options.thumbnailMethod,
                                false,
                                function (dataURL) {
                                    myDropZone.emit('thumbnail', file, dataURL);
                                    done(blob);
                                }
                            ); 
                        });
                    }
                    else if ($(this.element).hasClass('team')) {
                        team.edit(file).then(function (output) {
                            var blob = output.file;
                            myDropZone.createThumbnail(
                                blob,
                                myDropZone.options.thumbnailWidth,
                                myDropZone.options.thumbnailHeight,
                                myDropZone.options.thumbnailMethod,
                                false,
                                function (dataURL) {
                                    myDropZone.emit('thumbnail', file, dataURL);
                                    done(blob);
                                }
                            ); 
                        });
                    }
                    else if ($(this.element).hasClass('avatar')) {
                        avatar.edit(file).then(function (output) {
                            var blob = output.file;
                            myDropZone.createThumbnail(
                                blob,
                                myDropZone.options.thumbnailWidth,
                                myDropZone.options.thumbnailHeight,
                                myDropZone.options.thumbnailMethod,
                                false,
                                function (dataURL) {
                                    myDropZone.emit('thumbnail', file, dataURL);
                                    done(blob);
                                }
                            ); 
                        });
                    }
                    else if ($(this.element).hasClass('service')) {
                        service.edit(file).then(function (output) {
                            var blob = output.file;
                            myDropZone.createThumbnail(
                                blob,
                                myDropZone.options.thumbnailWidth,
                                myDropZone.options.thumbnailHeight,
                                myDropZone.options.thumbnailMethod,
                                false,
                                function (dataURL) {
                                    myDropZone.emit('thumbnail', file, dataURL);
                                    done(blob);
                                }
                            ); 
                        });
                    }
                    else if ($(this.element).hasClass('banner')) {
                        banner.edit(file).then(function (output) {
                            var blob = output.file;
                            myDropZone.createThumbnail(
                                blob,
                                myDropZone.options.thumbnailWidth,
                                myDropZone.options.thumbnailHeight,
                                myDropZone.options.thumbnailMethod,
                                false,
                                function (dataURL) {
                                    myDropZone.emit('thumbnail', file, dataURL);
                                    done(blob);
                                }
                            ); 
                        });
                    }
                    else {
                        var doka = Doka.create();
                        doka.edit(file).then(function (output) {
                            var blob = output.file;
                            myDropZone.createThumbnail(
                                blob,
                                myDropZone.options.thumbnailWidth,
                                myDropZone.options.thumbnailHeight,
                                myDropZone.options.thumbnailMethod,
                                false,
                                function (dataURL) {
                                    myDropZone.emit('thumbnail', file, dataURL);
                                    done(blob);
                                }
                            ); 
                        });
                    }
                }
                else {
                    myDropZone.createThumbnail(
                        file,
                        myDropZone.options.thumbnailWidth,
                        myDropZone.options.thumbnailHeight,
                        myDropZone.options.thumbnailMethod,
                        false,
                        function (dataURL) {
                            myDropZone.emit('thumbnail', file, dataURL);
                            done(file);
                        }
                    );
                }   
            }
            else {
                done(file);
            }
        },
        accept: function (file, done) {
            if (total_size > this.options.maxFilesize) {
                file.status = Dropzone.CANCELED;
                this._errorProcessing([file], 'Maximum file size limit reached', null);
                setTimeout(() => {
                    this.removeFile(file);
                }, 5000);
            }
            else {
                done();
            }
        },
        init: function () {
            this.on('sending', function (file, xhr, formData) {
                switch ($(this.element).attr('for')) {
                    case 'uploadFile':
                        data = [
                            {
                                name: 'object',
                                value: 'FileManager'
                            },
                            {
                                name: 'action',
                                value: 'upload'
                            },
                        ];
                        for (var i = 0; i < data.length; i++) {
                            if (data[i].name == 'action') {
                                data[i].value = 'upload';
                            }
                            formData.append(data[i].name, data[i].value);
                        }
                        break;

                    case 'uploadPhoto':
                        data = [
                            {
                                name: 'object',
                                value: 'Gallery'
                            },
                            {
                                name: 'action',
                                value: 'upload'
                            },
                        ];
                        for (var i = 0; i < data.length; i++) {
                            if (data[i].name == 'action') {
                                data[i].value = 'upload';
                            }
                            formData.append(data[i].name, data[i].value);
                        }
                        break;
                
                    default:
                        data = [
                            {
                                name: 'object',
                                value: 'Dropzone'
                            },
                            {
                                name: 'action',
                                value: 'upload'
                            },
                        ];
                        for (var i = 0; i < data.length; i++) {
                            if (data[i].name == 'action') {
                                data[i].value = 'upload';
                            }
                            formData.append(data[i].name, data[i].value);
                        }
                        $(this.element).closest('form').find('[type="submit"]').prop('disabled', true);
                        break;
                }
            });
            this.on('success', function (file, resp) {
                var field_name = $(this.element).attr('data-name');
                if (resp.name) {
                  var field_name = $(this.element).attr('data-name');
                  if($('input[name="category_cover_image"]').length){
                    $('input[name="category_cover_image"]').val(resp.path).attr('data-tracker', 'dropzone-element').attr('data-original-name', resp.original_name);
                  }
                  else{
                    $(this.element).closest('form').append('<input type="hidden" name="'+field_name+'" value="' + resp.path + '" data-tracker="dropzone-element" data-original-name="'+resp.original_name + '" >')
                  }
                  
                }
                $(this.element).closest('form').find('[type="submit"]').prop('disabled', false);
            });
            this.on('removedfile', function (file) {
                var field_name = $(this.element).attr('data-name');
                if(file.previewElement.id != ""){
                    var name = file.previewElement.id;
                }else{
                    var name = file.name;
                }
                var original_name = $('input[name="'+field_name+'"][data-original-name="' + name + '"]').val();
                $.ajax({
                    headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  },
                  type: 'POST',
                  url: "/admin/dropzone_delete",
                  data: {filename: original_name},
                  success: function (data){
                    file.previewElement.remove();
                        $('input[name="'+field_name+'"][data-original-name="' + name + '"]').remove()
                    },
                    error: function(e) {
                        console.log(e);
                    }
                  });
            });
            this.on('addedfile', function (file) {
                total_size += parseFloat((file.size / (1024 * 1024)).toFixed(2));
                if ($(this.element).hasClass('multiple')) { 
                    var allowedFiles = $(this.element).attr('data-files');
                    if (this.options.maxFiles == 1) {
                        this.options.maxFiles = allowedFiles;
                    }
                }
            });
        }     
    });            
}


</script>


</body>
</html>
