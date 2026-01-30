<div class="modal fade" id="editModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Редактировать слайд</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form id="editForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label>Заголовок *</label>
                        <input type="text" name="title" id="edit_title" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Подзаголовок *</label>
                        <input type="text" name="subtitle" id="edit_subtitle" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Изображение</label>
                        <input type="file" name="image" class="form-control" accept="image/*">
                        <small class="form-text text-muted">Оставьте пустым, если не хотите менять</small>
                    </div>
                    <div class="form-group">
                        <label>Порядок сортировки</label>
                        <input type="number" name="sort_order" id="edit_sort_order" class="form-control" value="0" min="0">
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" name="is_active" id="edit_is_active">
                            <label class="custom-control-label" for="edit_is_active">Активен</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                    <button type="submit" class="btn btn-warning">Обновить</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function editSlide(id, title, subtitle, sortOrder, isActive) {
    document.getElementById('editForm').action = '/hero-slides/' + id;
    document.getElementById('edit_title').value = title;
    document.getElementById('edit_subtitle').value = subtitle;
    document.getElementById('edit_sort_order').value = sortOrder;
    document.getElementById('edit_is_active').checked = isActive;
    $('#editModal').modal('show');
}
</script>
