<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>
    <!-- Meta Tag -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Responsive HTML Business Template">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Mulish:wght@200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&display=swap" rel="stylesheet">

    <link rel="shortcut icon" href="{{ asset('img/logo.png') }}">
    <!-- CSS style  links-->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('css/normalize.css') }}">

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/responsive.css') }}">
{{--    {!! RecaptchaV3::initJs() !!}--}}
</head>
<body>
<!-- loader -->
<div class="loaders">
    <div class="loader"></div>
</div>
<!-- loader -->


<!-- login-area -->
<section class="login-area">
    <div class="container-fluid">
        <div class="row justify-content-center align-items-center">
            {{-- <div class="col-md-6 col-lg-7">
                <div class="row">
                    <div class="login-left"></div>
                </div>  
            </div> --}}
            <div class="col-md-6 col-lg-6" >
                <div class="row " >
                    <div class="login-right" style="height: 500px; margin-top:70px">
                        <div class="login">
                            {{$slot}}
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
<!-- login-area -->



<!-- Js script links-->
<script src="{{ asset('js/jquery-3.2.1.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>

<script>
    $(document).ready(function() {
        $('.loaders').fadeOut();
        $('.input').focus(function(){
            $(this).parent().find(".label-txt").addClass('label-active');
            $(this).addClass('input-active');

        });

        $(".input").focusout(function(){
            if ($(this).val() == '') {
                $(this).parent().find(".label-txt").removeClass('label-active');
                $(this).removeClass('input-active');
            };
        });

        $(".hide-eye").hide();

        $(".show-eye").click(function() {
            $('#passwodfield').attr("type", 'text');
            $(".hide-eye").show();
            $(".show-eye").hide();
        });

        $(".hide-eye").click(function() {
            $('#passwodfield').attr("type", 'password');
            $(".hide-eye").hide();
            $(".show-eye").show();
        });
    })
</script>
</body>
</html>
