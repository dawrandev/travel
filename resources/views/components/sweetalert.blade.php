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

{{-- Dynamic Delete Confirmation --}}
<script>
// Handle all forms with data-confirm-delete attribute
document.addEventListener('submit', function(e) {
    const form = e.target;

    // Check if form has delete confirmation attribute
    if (form.hasAttribute('data-confirm-delete')) {
        e.preventDefault();
        e.stopPropagation();

        const itemName = form.getAttribute('data-item-name') || 'элемент';
        const title = form.getAttribute('data-confirm-title') || 'Вы уверены?';
        const text = form.getAttribute('data-confirm-text') || `Вы действительно хотите удалить этот ${itemName}? Это действие нельзя отменить!`;

        swal({
            title: title,
            text: text,
            icon: 'warning',
            buttons: {
                cancel: {
                    text: 'Отмена',
                    value: null,
                    visible: true,
                    className: 'btn btn-secondary',
                    closeModal: true,
                },
                confirm: {
                    text: 'Да, удалить!',
                    value: true,
                    visible: true,
                    className: 'btn btn-danger',
                    closeModal: true
                }
            },
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                // Remove the attribute to prevent loop
                form.removeAttribute('data-confirm-delete');
                form.submit();
            }
        });

        return false;
    }
}, true);
</script>
