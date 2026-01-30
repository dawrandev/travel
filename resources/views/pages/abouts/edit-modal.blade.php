<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Редактировать "О нас"</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <ul class="nav nav-pills mb-3" id="editLanguageTabs" role="tablist">
                        @foreach($languages as $index => $language)
                        <li class="nav-item">
                            <a class="nav-link {{ $index == 0 ? 'active' : '' }}" id="edit-tab-{{ $language->code }}" data-toggle="pill" href="#edit-lang-{{ $language->code }}" role="tab">
                                {{ $language->name }}
                            </a>
                        </li>
                        @endforeach
                    </ul>

                    <div class="tab-content" id="editLanguageTabsContent">
                        @foreach($languages as $index => $language)
                        <div class="tab-pane fade {{ $index == 0 ? 'show active' : '' }}" id="edit-lang-{{ $language->code }}" role="tabpanel">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label">Заголовок ({{ $language->name }}) <span class="text-danger">*</span></label>
                                        <input type="text" name="title_{{ $language->code }}" id="edit_title_{{ $language->code }}" class="form-control" placeholder="Введите заголовок" required>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label">Описание ({{ $language->name }}) <span class="text-danger">*</span></label>
                                        <textarea name="description_{{ $language->code }}" id="edit_description_{{ $language->code }}" class="form-control" rows="5" placeholder="Введите описание" required></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label class="form-label">Изображение</label>
                                <div class="custom-file">
                                    <input type="file" name="image" class="custom-file-input" id="image_edit" accept="image/*">
                                    <label class="custom-file-label" for="image_edit">Выберите изображение</label>
                                </div>
                                <small class="form-text text-muted">Оставьте пустым, если не хотите менять изображение</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label">Статус</label>
                                <div class="custom-control custom-checkbox mt-2">
                                    <input type="checkbox" class="custom-control-input" name="is_active" id="edit_is_active">
                                    <label class="custom-control-label" for="edit_is_active">Активен</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-sync-alt"></i> Обновить
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('image_edit').addEventListener('change', function(e) {
    if (e.target.files.length > 0) {
        var fileName = e.target.files[0].name;
        var label = e.target.nextElementSibling;
        label.innerText = fileName;
    }
});

function editAbout(id) {
    $.ajax({
        url: '/abouts/' + id + '/translations',
        type: 'GET',
        success: function(response) {
            if (response.success) {
                $('#editForm').attr('action', '/abouts/' + id);
                $('#edit_is_active').prop('checked', response.about.is_active);
                $('#image_edit').nextElementSibling.innerText = 'Выберите изображение';

                // Fill translations for each language
                @foreach($languages as $language)
                    if (response.translations['{{ $language->code }}']) {
                        $('#edit_title_{{ $language->code }}').val(response.translations['{{ $language->code }}'].title);
                        $('#edit_description_{{ $language->code }}').val(response.translations['{{ $language->code }}'].description);
                    }
                @endforeach

                $('#editModal').modal('show');
            }
        },
        error: function() {
            alert('Ошибка при загрузке данных');
        }
    });
}
</script>
