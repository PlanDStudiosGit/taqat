<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <title>{{ config('app.name') }} | {{ $pageName }}</title>
    <!-- Meta Tag -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="{{ config('app.description') }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Mulish:wght@200;300;400;500;600;700;800;900&display=swap"
          rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&display=swap" rel="stylesheet">

    <link rel="shortcut icon" href="{{ asset('img/logo.png') }}">
    <!-- CSS style  links-->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('css/normalize.css') }}">
    {{ $pluginCss }}
    <link rel="stylesheet" href="{{ asset('css/style.css?v=1.004') }}">
    <link rel="stylesheet" href="{{ asset('css/responsive.css') }}">
    <!-- Js script links-->
    <script src="{{ asset('js/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    {{-- <meta name="csrf-token" content="{{ csrf_token() }}"> --}}


    


</head>
<body>
<!-- loader -->
<div class="loaders">
    <div class="loader"></div>
</div>
<!-- loader -->


<!-- main-area -->
<section class="main-area">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">

                <!-- Left Navigation -->

                <x-admin.left-navigation :pageName="$pageName"/>

                <!-- Left Navigation -->

                <!-- main-contents -->
                <div class="main-contents">

                    <!-- header-area -->

                    <x-admin.top-header :breadCrumbs="$breadCrumbs"/>

                    <!-- header-area -->
                    <!-- count-cars -->

                    {{$slot}}

                </div>
                <!-- main-contents -->

            </div>
        </div>
    </div>
</section>
<!-- main-area -->

@php
    $showToast = false;
    if ($messages = Session::get('success')) {
        $showToast = true;
        $toastType = 'success';
        $toastMessage = "<p>".$messages."</p>";
    }

    if ($messages = Session::get('error')) {
        $messages = $messages->all();
        $showToast = true;
        $toastType = 'error';
        $toastMessage = '';
        foreach ($messages as $message) {
            $toastMessage .= "<p>".$message."</p>";
        }
    }
@endphp
<!-- Js script links-->
<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if($showToast)
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })

Toast.fire({
    icon: "{{ $toastType }}",
    title: '{!! $toastMessage !!}'
});
</script>
@endif
<script>
$(document).ready(function () {
    $('.loaders').fadeOut();
    //mobile menu
    $(".mob").click(function () {
        $(".menu-area").addClass("mobile");

        return false;
    });


    $(".closes").click(function () {
        $(".menu-area").removeClass("mobile");

        return false;
    });


    $('.menu li a').click(function () {
        $('.menu li a').removeClass("active");
        $(this).addClass("active");
    });

    //action-link
    $('.action-link li a').click(function () {
        $('.action-link li a').removeClass("active");
        $(this).addClass("active");
        return false;
    });

    $(".menuwidth").click(function () {
        $(".menu-area").toggleClass("menu-full");
        $(".hide-item").toggleClass("show-item");
        $(".small-logo").toggleClass("show-logo");
        $(".main-contents").toggleClass("menu-full-body");

    });

    $(".menu-area ul li").click(function () {
        // $('.sub-menu').removeClass("submenu");
        $(this).find(".sub-menu").toggleClass("submenu");
        $(this).find(".drop-icon").toggleClass("roted");
    });

    $('form').submit(function() {
        $('.loaders').show();
    });
});
function selectImage(identifier) {
    $('#'+identifier).trigger('click');
}
$(document).on("click", ".deleteprocess", function (e) {
    var tag = this;
    e.preventDefault();
    swal.fire({
        title: 'Are you sure you want to delete this '+$(tag).data('type')+'?',
        text: "This action cannot be undone",
        type: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!'
    }).then(function (result) {
        if (result.value) {
            $('.deleteform'+$(tag).data('type')+$(tag).data('id')).submit();
        } else {
            return false;
        }
    });
});
</script>




</body>
</html>
