<div class="modal fade" id="editBannerModal" tabindex="-1" role="dialog" aria-labelledby="editBannerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editBannerModalLabel">Редактировать баннер</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editBannerForm">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit_banner_id" name="banner_id">
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

                    <!-- Dropzone for Images -->
                    <div class="form-group">
                        <label class="form-label">Изображения баннера</label>
                        <div id="dropzone-edit-banner" class="dropzone"></div>
                        <small class="text-muted">Текущие изображения показаны ниже. Можете загрузить до 3 новых изображений (макс. 10MB на изображение).</small>
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

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
@endpush

@push('scripts')
<script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
<script>
    Dropzone.autoDiscover = false;

    let editBannerDropzone;
    let currentBannerImages = [];

    function initializeEditBannerDropzone() {
        // Destroy existing dropzone if it exists
        const existingElement = document.getElementById('dropzone-edit-banner');
        if (existingElement && existingElement.dropzone) {
            existingElement.dropzone.destroy();
        }

        // Initialize Dropzone for edit
        editBannerDropzone = new Dropzone("#dropzone-edit-banner", {
            url: "#",
            autoProcessQueue: false,
            uploadMultiple: true,
            paramName: "images",
            maxFiles: 3,
            maxFilesize: 10,
            acceptedFiles: "image/*",
            addRemoveLinks: true,
            dictDefaultMessage: "Перетащите файлы сюда или нажмите для выбора (до 3 изображений)",
            dictRemoveFile: "Удалить",
            dictMaxFilesExceeded: "Можно загрузить только 3 изображения",
            init: function() {
                this.on("maxfilesexceeded", function(file) {
                    this.removeFile(file);
                    swal({
                        title: 'Предупреждение',
                        text: 'Можно загрузить максимум 3 изображения',
                        icon: 'warning',
                        button: 'ОК'
                    });
                });
            }
        });
    }

    $(document).ready(function() {
        // Initialize Dropzone on first load
        initializeEditBannerDropzone();

        // Form submission
        $('#editBannerForm').on('submit', function(e) {
            e.preventDefault();

            const bannerId = $('#edit_banner_id').val();

            // Check if new images are uploaded
            const newFiles = editBannerDropzone.files.filter(f => !f.mock);

            // If new images uploaded, can be 1-3 images
            if (newFiles.length > 3) {
                swal({
                    title: 'Ошибка',
                    text: 'Можно загрузить максимум 3 изображения',
                    icon: 'error',
                    button: 'ОК'
                });
                return;
            }

            const $submitBtn = $(this).find('button[type="submit"]');
            $submitBtn.prop('disabled', true);
            const $icon = $submitBtn.find('i');
            $icon.removeClass('fa-sync-alt').addClass('fa-spinner fa-spin');

            // Create FormData
            let formData = new FormData();
            formData.append('_method', 'PUT');

            // Add new images if uploaded
            if (newFiles.length > 0) {
                newFiles.forEach((file, index) => {
                    formData.append('images[]', file);
                });
            }

            // Add other form fields
            $('#editBannerForm').find('input[type!="file"], textarea, select').each(function() {
                if ($(this).attr('type') === 'checkbox') {
                    if ($(this).is(':checked')) {
                        formData.append($(this).attr('name'), $(this).val());
                    }
                } else if ($(this).attr('name') !== '_method') {
                    formData.append($(this).attr('name'), $(this).val());
                }
            });

            // Submit via AJAX
            $.ajax({
                url: "/categories/banner/" + bannerId,
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    swal({
                        title: 'Успешно',
                        text: 'Баннер успешно обновлен',
                        icon: 'success',
                        button: 'ОК'
                    }).then(() => {
                        location.reload();
                    });
                },
                error: function(xhr) {
                    let errorMessage = 'Произошла ошибка';
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        errorMessage = Object.values(xhr.responseJSON.errors).flat().join('\n');
                    } else if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }
                    $submitBtn.prop('disabled', false);
                    $icon.removeClass('fa-spinner fa-spin').addClass('fa-sync-alt');
                    swal({
                        title: 'Ошибка',
                        text: errorMessage,
                        icon: 'error',
                        button: 'ОК'
                    });
                }
            });
        });

        // Re-initialize Dropzone when modal is shown
        $('#editBannerModal').on('shown.bs.modal', function() {
            initializeEditBannerDropzone();
        });

        // Reset on modal close
        $('#editBannerModal').on('hidden.bs.modal', function() {
            $('#editBannerForm')[0].reset();
            if (editBannerDropzone) {
                editBannerDropzone.removeAllFiles();
            }
            currentBannerImages = [];
            const $btn = $('#editBannerForm').find('button[type="submit"]');
            $btn.prop('disabled', false);
            $btn.find('i').removeClass('fa-spinner fa-spin').addClass('fa-sync-alt');
        });
    });

    window.populateEditBannerModal = function(response) {
        try {
            const {
                banner,
                translations,
                images
            } = response;

            // Set banner ID
            $('#edit_banner_id').val(banner.id);

            // Status
            $('#banner_is_active_edit').prop('checked', banner.is_active);

            // Fill translations
            @foreach($languages as $language)
            if (translations['{{ $language->code }}']) {
                $('#edit_banner_title_{{ $language->code }}').val(translations['{{ $language->code }}'].title);
            }
            @endforeach

            // Initialize Dropzone if not already done
            if (!editBannerDropzone) {
                initializeEditBannerDropzone();
            }

            // Clear dropzone
            if (editBannerDropzone) {
                editBannerDropzone.removeAllFiles();
            }
            currentBannerImages = [];

            // Display current images as mockFiles
            if (images && images.length > 0) {
                setTimeout(() => {
                    images.forEach((image, index) => {
                        const mockFile = {
                            name: `Изображение ${index + 1}`,
                            size: 12345,
                            mock: true
                        };

                        editBannerDropzone.emit("addedfile", mockFile);
                        editBannerDropzone.emit("thumbnail", mockFile, '/storage/' + image.image_path);
                        editBannerDropzone.emit("complete", mockFile);

                        currentBannerImages.push(mockFile);
                    });
                }, 100);
            }

        } catch (error) {
            console.error('Error populating edit banner modal:', error);
            swal({
                title: 'Ошибка',
                text: 'Ошибка при загрузке данных баннера: ' + error.message,
                icon: 'error',
                button: 'ОК'
            });
        }
    }
</script>
@endpush
