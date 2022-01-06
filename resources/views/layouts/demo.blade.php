<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <link href="{{ asset ('frontend/demo/css/style.css') }}?<?php echo now()?>" rel="stylesheet">
    <link href="{{ asset('css/toastr.css') }}" rel="stylesheet">

<!--     <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/js-cookie@rc/dist/js.cookie.min.js"></script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.25/b-1.7.1/fh-3.1.9/r-2.2.9/rg-1.1.3/sb-1.1.0/sl-1.3.3/datatables.min.css"/>

     <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <title>Demo site</title>
  </head>
  <body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light mt-4">
        <div class="container-fluid">
            <a class="navbar-brand" href="/">Demo site</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNavAltMarkup">
                <div class="navbar-nav">
                    <a class="nav-item nav-link active" href="/">Shop <span class="sr-only">(current)</span></a>
                    <a class="nav-item nav-link" href="/contact">Contact</a>
                    <a class="nav-item nav-link" href="#"><i class="fas fa-search"></i></a>
                    <a class="nav-item nav-link" id="checkout-link" href=""><i class="fas fa-cart-plus"></i><span class="badge badge-pill badge-danger" id="cart_count"></span></a>
                </div>
            </div>            
        </div>
    </nav>
    <div class="card-body">
        @yield('content')
    </div>
<script>
    if(getCookie("device_id") == null){
        document.cookie = "device_id=_"+uuidv4();
    }

    var device_id = getCookie("device_id");
    $("#checkout-link").attr('href', '/checkout?device_id='+device_id);
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        beforeSend: function () {
            $('.preloader').fadeIn(700);
        },
        complete: function () {
            $('.preloader').fadeOut(700);  
        },
        url: '/get_cart?device_id='+device_id, 
        method: 'GET',
        processData: false, 
        contentType: false,
        success: function (response, textStatus, jqXHR) {
            var data = JSON.parse(response);
            if(data.cart_items > 0){
                $('#cart_count').html(data.cart_items);
            }
        }

    });


    function uuidv4() {
      return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
        var r = Math.random() * 16 | 0, v = c == 'x' ? r : (r & 0x3 | 0x8);
        return v.toString(16);
      });
    }
    function setCookie(name,value,days) {
        var expires = "";
        if (days) {
            var date = new Date();
            date.setTime(date.getTime() + (days*24*60*60*1000));
            expires = "; expires=" + date.toUTCString();
        }
        document.cookie = name + "=" + (value || "")  + expires + "; path=/";
    }
    function getCookie(name) {
        var nameEQ = name + "=";
        var ca = document.cookie.split(';');
        for(var i=0;i < ca.length;i++) {
            var c = ca[i];
            while (c.charAt(0)==' ') c = c.substring(1,c.length);
            if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
        }
        return null;
    }

    $(document).on('click', '.add_to_cart', function(e){
        e.preventDefault();
        // alert($(this).attr('data-id') + getCookie("device_id"));
        var device_id = getCookie("device_id");
        var product_id = $(this).attr('data-id');


        $.ajax({
            beforeSend: function () {
                $('.preloader').fadeIn(700);
            },
            complete: function () {
                $('.preloader').fadeOut(700);  
            },
            url: '/update_cart?device_id='+device_id+'&product_id='+product_id, 
            method: 'GET',
            processData: false, 
            contentType: false,
            success: function (response, textStatus, jqXHR) {
                var data = JSON.parse(response);
                $('#cart_count').html(data.cart_items);
                toastr.options = {
                    "progressBar": true,
                    "positionClass": "toast-bottom-right",
                    "timeOut": "1000",
                };
                toastr.success(data.message);

            },
            error: function (jqXHR, textStatus, errorThrown) {
                toastr.options = {
                    "closeButton": true,
                    "progressBar": true,
                    "positionClass": "toast-bottom-right",
                    "timeOut": "10000",
                };
                toastr.error(errorThrown);
                alert("error");
            }
        });
    });

    $(document).on('click', '.shop_now', function(e){
        e.preventDefault();
        // alert($(this).attr('data-id') + getCookie("device_id"));
        var device_id = getCookie("device_id");
        var product_id = $(this).attr('data-id');


        $.ajax({
            beforeSend: function () {
                $('.preloader').fadeIn(700);
            },
            complete: function () {
                $('.preloader').fadeOut(700);  
            },
            url: '/update_cart?device_id='+device_id+'&product_id='+product_id, 
            method: 'GET',
            processData: false, 
            contentType: false,
            success: function (response, textStatus, jqXHR) {
                var data = JSON.parse(response);
                $('#cart_count').html(data.cart_items);
                toastr.options = {
                    "progressBar": true,
                    "positionClass": "toast-bottom-right",
                    "timeOut": "1000",
                };
                toastr.success(data.message);

                setTimeout(
                    function() 
                    {
                        toastr.success("You will be redirected in 3 seconds");
                        location.replace('/checkout?device_id='+device_id);
                    }, 2000);

            },
            error: function (jqXHR, textStatus, errorThrown) {
                toastr.options = {
                    "closeButton": true,
                    "progressBar": true,
                    "positionClass": "toast-bottom-right",
                    "timeOut": "10000",
                };
                toastr.error(errorThrown);
                alert("error");
            }
        });
    });
    $(document).on('click', '.clear_cart', function(e){
        e.preventDefault();
        var device_id = getCookie("device_id");

        $.ajax({
            beforeSend: function () {
                $('.preloader').fadeIn(700);
            },
            complete: function () {
                $('.preloader').fadeOut(700);  
            },
            url: '/clear_cart?device_id='+device_id, 
            method: 'GET',
            processData: false, 
            contentType: false,
            success: function (response, textStatus, jqXHR) {
                var data = JSON.parse(response);
                if(data.cart_items > 0){
                    $('#cart_count').html(data.cart_items);
                }
                toastr.options = {
                    "progressBar": true,
                    "positionClass": "toast-bottom-right",
                    "timeOut": "1000",
                };
                toastr.success(data.message);
                window.location.replace("/").delay(3000);

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
    });

    $(document).on('click', '.proceed_to_payment', function(e){
        e.preventDefault();
        // toastr.options = {
        //     "progressBar": true,
        //     "positionClass": "toast-bottom-right",
        //     "timeOut": "10000",
        // };
        // toastr.success('Functionality not enabled because this is a demo site');
        $.ajax({
            beforeSend: function () {
                $('.preloader').fadeIn(700);
            },
            complete: function () {
                $('.preloader').fadeOut(700);  
            },
            url: '/lipa', 
            method: 'GET',
            processData: false, 
            contentType: false,
            success: function (response, textStatus, jqXHR) {
                toastr.options = {
                    "progressBar": true,
                    "positionClass": "toast-bottom-right",
                    "timeOut": "1000",
                };
                toastr.success(data.message);

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
    });
</script>
<script>
    $(document).ready(function(){
        AOS.init();
    });
</script>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="{{ asset('js/toastr.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.25/b-1.7.1/fh-3.1.9/r-2.2.9/rg-1.1.3/sb-1.1.0/sl-1.3.3/datatables.min.js"></script>

  </body>
</html>