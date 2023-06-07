@php
    $showToast = false;
    if ($messages = Session::get('status')) {
        $showToast = true;
        $toastType = 'success';
        $toastMessage = "<p>".$messages."</p>";
    }

    if ($errors->any()) {
        $messages = $errors->all();
        $showToast = true;
        $toastType = 'error';
        $toastMessage = '';
        foreach ($messages as $message) {
            $toastMessage .= "<p>".$message."</p>";
        }
    }
@endphp
@if ($showToast)
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 10000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    })
    Toast.fire({
        icon: '{{ $toastType }}',
        title: '{!! $toastMessage !!}'
    })
</script>
@endif
