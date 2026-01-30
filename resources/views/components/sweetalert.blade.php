@if(session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        swal({
            title: 'Успешно!',
            text: '{{ session('success') }}',
            icon: 'success',
            button: 'ОК',
        });
    });
</script>
@endif

@if(session('error'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        swal({
            title: 'Ошибка!',
            text: '{{ session('error') }}',
            icon: 'error',
            button: 'ОК',
        });
    });
</script>
@endif

@if($errors->any())
<script>
    document.addEventListener('DOMContentLoaded', function() {
        swal({
            title: 'Ошибка валидации!',
            text: '{{ $errors->first() }}',
            icon: 'warning',
            button: 'ОК',
        });
    });
</script>
@endif
