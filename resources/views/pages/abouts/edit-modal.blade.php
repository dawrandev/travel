<div class="modal fade" id="editAboutModal" tabindex="-1" role="dialog" aria-labelledby="editAboutModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editAboutModalLabel">Редактировать "О нас"</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editAboutForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <ul class="nav nav-pills mb-3" id="editAboutLanguageTabs" role="tablist">
                        @foreach($languages as $index => $language)
                        <li class="nav-item">
                            <a class="nav-link {{ $index == 0 ? 'active' : '' }}" id="edit-about-tab-{{ $language->code }}" data-toggle="pill" href="#edit-about-lang-{{ $language->code }}" role="tab">
                                {{ $language->name }}
                            </a>
                        </li>
                        @endforeach
                    </ul>

                    <div class="tab-content" id="editAboutLanguageTabsContent">
                        @foreach($languages as $index => $language)
                        <div class="tab-pane fade {{ $index == 0 ? 'show active' : '' }}" id="edit-about-lang-{{ $language->code }}" role="tabpanel">
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

                    <hr>

                    <!-- Current Images -->
                    <h6 class="mb-3">Текущие изображения</h6>
                    <div id="currentAboutImages" class="row mb-3"></div>

                    <!-- New Images -->
                    <h6 class="mb-3">Загрузить новые изображения (опционально)</h6>
                    <div class="form-group">
                        <div id="dropzone-edit-about" class="dropzone"></div>
                        <small class="text-muted d-block mt-2">
                            <i class="fas fa-info-circle"></i> Если загрузите новые изображения, старые будут удалены.<br>
                            Если не загрузите, текущие изображения сохранятся. Макс. 5MB на изображение.
                        </small>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">Статус</label>
                                <div class="custom-control custom-checkbox mt-2">
                                    <input type="checkbox" class="custom-control-input" name="is_active" id="edit_about_is_active" value="1">
                                    <label class="custom-control-label" for="edit_about_is_active">Активен</label>
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

@push('scripts')
<script>
    let editAboutDropzone;

    $(document).ready(function() {
        // Initialize Edit About Dropzone
        editAboutDropzone = new Dropzone("#dropzone-edit-about", {
            url: "#",
            autoProcessQueue: false,
            uploadMultiple: true,
            paramName: "images",
            maxFilesize: 5,
            acceptedFiles: "image/*",
            addRemoveLinks: true,
            dictDefaultMessage: "Перетащите изображения",
            dictRemoveFile: "Удалить",
            dictCancelUpload: "Отменить",
        });

        // Handle edit form submit
        $('#editAboutForm').on('submit', function(e) {
            e.preventDefault();

            const $submitBtn = $(this).find('button[type="submit"]');
            $submitBtn.prop('disabled', true);
            const $icon = $submitBtn.find('i');
            $icon.removeClass('fa-sync-alt').addClass('fa-spinner fa-spin');

            const files = editAboutDropzone.getAcceptedFiles();
            const formData = new FormData(this);

            console.log('Files count:', files.length);

            // If new images uploaded, add them
            if (files.length > 0) {
                formData.delete('images[]');
                formData.delete('images');

                files.forEach((file, index) => {
                    formData.append('images[]', file);
                    console.log('Adding image:', file.name);
                });
            } else {
                console.log('No new images uploaded, keeping existing images');
            }

            console.log('Form data prepared, submitting...');

            // Submit via AJAX
            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    swal({
                        title: 'Успешно!',
                        text: 'О нас успешно обновлено',
                        icon: 'success',
                        button: 'ОК',
                    }).then(() => {
                        location.reload();
                    });
                },
                error: function(xhr) {
                    let errorMsg = 'Ошибка при обновлении';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMsg = xhr.responseJSON.message;
                    } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                        errorMsg = Object.values(xhr.responseJSON.errors).flat().join('\n');
                    }
                    $submitBtn.prop('disabled', false);
                    $icon.removeClass('fa-spinner fa-spin').addClass('fa-sync-alt');
                    swal({
                        title: 'Ошибка!',
                        text: errorMsg,
                        icon: 'error',
                        button: 'ОК',
                    });
                }
            });
        });

        // Reset on modal close
        $('#editAboutModal').on('hidden.bs.modal', function() {
            $('#editAboutForm')[0].reset();
            editAboutDropzone.removeAllFiles();
            $('#currentAboutImages').empty();
            const $btn = $('#editAboutForm').find('button[type="submit"]');
            $btn.prop('disabled', false);
            $btn.find('i').removeClass('fa-spinner fa-spin').addClass('fa-sync-alt');
        });
    });

    function populateEditAboutModal(response) {
        try {
            const {
                about,
                translations,
                images
            } = response;

            // Form action
            $('#editAboutForm').attr('action', '/abouts/' + about.id);

            // Status
            $('#edit_about_is_active').prop('checked', about.is_active);

            // Fill translations for each language
            @foreach($languages as $language)
            if (translations['{{ $language->code }}']) {
                $('#edit_title_{{ $language->code }}').val(translations['{{ $language->code }}'].title);
                $('#edit_description_{{ $language->code }}').val(translations['{{ $language->code }}'].description);
            }
            @endforeach

            // Display current images
            let imagesHtml = '';
            if (images && Array.isArray(images) && images.length > 0) {
                images.forEach((img, index) => {
                    imagesHtml += `
                        <div class="col-md-3 mb-3">
                            <div class="position-relative">
                                <img src="/storage/${img.image_path}" class="img-thumbnail w-100" style="height: 150px; object-fit: cover;">
                                <div class="badge badge-primary position-absolute" style="top: 5px; left: 5px;">
                                    ${index + 1}
                                </div>
                            </div>
                        </div>
                    `;
                });
            } else {
                imagesHtml = '<div class="col-12"><p class="text-muted">Нет изображений</p></div>';
            }
            $('#currentAboutImages').html(imagesHtml);

        } catch (error) {
            console.error('Error populating edit modal:', error);
            swal({
                title: 'Ошибка!',
                text: 'Ошибка при загрузке данных: ' + error.message,
                icon: 'error',
                button: 'ОК',
            });
        }
    }
</script>
@endpush