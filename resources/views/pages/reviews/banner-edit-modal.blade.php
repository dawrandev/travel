<div class="modal fade" id="editBannerModal" tabindex="-1" role="dialog" aria-labelledby="editBannerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editBannerModalLabel">Редактировать баннер</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editBannerForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <!-- Language Tabs -->
                    <ul class="nav nav-pills mb-3" id="editBannerLanguageTabs" role="tablist">
                        @foreach($languages as $index => $language)
                        <li class="nav-item">
                            <a class="nav-link {{ $index == 0 ? 'active' : '' }}" id="edit-banner-tab-{{ $language->code }}" data-toggle="pill" href="#edit-banner-lang-{{ $language->code }}" role="tab">
                                {{ $language->name }}
                            </a>
                        </li>
                        @endforeach
                    </ul>

                    <div class="tab-content" id="editBannerLanguageTabsContent">
                        @foreach($languages as $index => $language)
                        <div class="tab-pane fade {{ $index == 0 ? 'show active' : '' }}" id="edit-banner-lang-{{ $language->code }}" role="tabpanel">
                            <div class="form-group">
                                <label class="form-label">Заголовок баннера ({{ $language->name }}) <span class="text-danger">*</span></label>
                                <input type="text" name="banner_title_{{ $language->code }}" id="edit_banner_title_{{ $language->code }}" class="form-control" placeholder="Введите заголовок" required>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <hr>

                    <!-- Current Image -->
                    <div class="form-group">
                        <label class="form-label">Текущее изображение:</label>
                        <div id="current_banner_image" class="mb-2">
                            <img id="current_banner_img" class="img-fluid rounded" style="max-height: 200px;" alt="Current Banner">
                        </div>
                    </div>

                    <!-- New Image -->
                    <div class="form-group">
                        <label class="form-label">Новое изображение (опционально)</label>
                        <div class="custom-file">
                            <input type="file" name="banner_image" class="custom-file-input" id="banner_image_edit" accept="image/*">
                            <label class="custom-file-label" for="banner_image_edit">Выберите изображение</label>
                        </div>
                        <small class="form-text text-muted">Оставьте пустым, если не хотите менять изображение. Рекомендуемый размер: 1920x600px. Макс. 10MB</small>
                    </div>

                    <!-- New Preview -->
                    <div class="form-group">
                        <div id="banner_preview_edit" style="display: none;">
                            <label class="form-label">Предпросмотр нового изображения:</label>
                            <img id="banner_preview_img_edit" class="img-fluid rounded" style="max-height: 300px;" alt="Preview">
                        </div>
                    </div>

                    <hr>

                    <!-- Status -->
                    <div class="form-group">
                        <label class="form-label">Статус</label>
                        <div class="custom-control custom-checkbox mt-2">
                            <input type="checkbox" class="custom-control-input" name="is_active" id="banner_is_active_edit" value="1">
                            <label class="custom-control-label" for="banner_is_active_edit">Активен</label>
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

@push('scripts')
<script>
    $(document).ready(function() {
        // Image preview for edit banner
        $('#banner_image_edit').on('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                $(this).next('.custom-file-label').text(file.name);

                const reader = new FileReader();
                reader.onload = function(e) {
                    $('#banner_preview_img_edit').attr('src', e.target.result);
                    $('#banner_preview_edit').show();
                }
                reader.readAsDataURL(file);
            }
        });

        // Reset on modal close
        $('#editBannerModal').on('hidden.bs.modal', function() {
            $('#editBannerForm')[0].reset();
            $('#banner_image_edit').next('.custom-file-label').text('Выберите изображение');
            $('#banner_preview_edit').hide();
        });
    });

    function populateEditBannerModal(response) {
        try {
            const {
                banner,
                translations
            } = response;

            // Form action
            $('#editBannerForm').attr('action', '/reviews/banner/' + banner.id);

            // Status
            $('#banner_is_active_edit').prop('checked', banner.is_active);

            // Fill translations
            @foreach($languages as $language)
            if (translations['{{ $language->code }}']) {
                $('#edit_banner_title_{{ $language->code }}').val(translations['{{ $language->code }}'].title);
            }
            @endforeach

            // Display current image
            if (banner.image) {
                $('#current_banner_img').attr('src', '/storage/' + banner.image);
                $('#current_banner_image').show();
            }

        } catch (error) {
            console.error('Error populating edit banner modal:', error);
            swal({
                title: 'Ошибка!',
                text: 'Ошибка при загрузке данных баннера: ' + error.message,
                icon: 'error',
                button: 'ОК',
            });
        }
    }
</script>
@endpush
