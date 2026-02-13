<div class="modal fade" id="createBannerModal" tabindex="-1" role="dialog" aria-labelledby="createBannerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createBannerModalLabel">Создать баннер</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="createBannerForm">
                @csrf
                <div class="modal-body">
                    <!-- Language Tabs -->
                    <ul class="nav nav-pills mb-3" id="createBannerLanguageTabs" role="tablist">
                        @foreach($languages as $index => $language)
                        <li class="nav-item">
                            <a class="nav-link {{ $index == 0 ? 'active' : '' }}" id="create-banner-tab-{{ $language->code }}" data-toggle="pill" href="#create-banner-lang-{{ $language->code }}" role="tab">
                                {{ $language->name }}
                            </a>
                        </li>
                        @endforeach
                    </ul>

                    <div class="tab-content" id="createBannerLanguageTabsContent">
                        @foreach($languages as $index => $language)
                        <div class="tab-pane fade {{ $index == 0 ? 'show active' : '' }}" id="create-banner-lang-{{ $language->code }}" role="tabpanel">
                            <div class="form-group">
                                <label class="form-label">Заголовок баннера ({{ $language->name }}) <span class="text-danger">*</span></label>
                                <input type="text" name="banner_title_{{ $language->code }}" class="form-control" placeholder="Введите заголовок" required>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <hr>

                    <!-- Dropzone for 3 Images -->
                    <div class="form-group">
                        <label class="form-label">Изображения баннера (3 изображения) <span class="text-danger">*</span></label>
                        <div id="dropzone-create-banner" class="dropzone"></div>
                        <small class="text-muted">Необходимо загрузить ровно 3 изображения. Макс. 10MB на изображение.</small>
                    </div>

                    <hr>

                    <!-- Status -->
                    <div class="form-group">
                        <label class="form-label">Статус</label>
                        <div class="custom-control custom-checkbox mt-2">
                            <input type="checkbox" class="custom-control-input" name="is_active" id="banner_is_active_create" value="1" checked>
                            <label class="custom-control-label" for="banner_is_active_create">Активен</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i> Создать
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
    let createBannerDropzone;

    $(document).ready(function() {
        // Initialize Dropzone
        createBannerDropzone = new Dropzone("#dropzone-create-banner", {
            url: "#",
            autoProcessQueue: false,
            uploadMultiple: true,
            paramName: "images",
            maxFiles: 3,
            maxFilesize: 10,
            acceptedFiles: "image/*",
            addRemoveLinks: true,
            dictDefaultMessage: "Перетащите изображения сюда или нажмите для выбора",
            dictRemoveFile: "Удалить",
            dictMaxFilesExceeded: "Можно загрузить только 3 изображения",
            init: function() {
                this.on("maxfilesexceeded", function(file) {
                    this.removeFile(file);
                    swal({
                        title: 'Предупреждение',
                        text: 'Можно загрузить только 3 изображения',
                        icon: 'warning',
                        button: 'ОК'
                    });
                });
            }
        });

        // Form submission
        $('#createBannerForm').on('submit', function(e) {
            e.preventDefault();

            // Validate exactly 3 images
            if (createBannerDropzone.files.length !== 3) {
                swal({
                    title: 'Ошибка',
                    text: 'Необходимо загрузить ровно 3 изображения',
                    icon: 'error',
                    button: 'ОК'
                });
                return;
            }

            const $submitBtn = $(this).find('button[type="submit"]');
            $submitBtn.prop('disabled', true);
            const $icon = $submitBtn.find('i');
            $icon.removeClass('fa-save').addClass('fa-spinner fa-spin');

            // Create FormData
            let formData = new FormData();

            // Add images
            createBannerDropzone.files.forEach((file, index) => {
                formData.append('images[]', file);
            });

            // Add other form fields
            $('#createBannerForm').find('input[type!="file"], textarea, select').each(function() {
                if ($(this).attr('type') === 'checkbox') {
                    if ($(this).is(':checked')) {
                        formData.append($(this).attr('name'), $(this).val());
                    }
                } else {
                    formData.append($(this).attr('name'), $(this).val());
                }
            });

            // Submit via AJAX
            $.ajax({
                url: "{{ route('contacts.banner.store') }}",
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    swal({
                        title: 'Успешно',
                        text: 'Баннер успешно создан',
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
                    $icon.removeClass('fa-spinner fa-spin').addClass('fa-save');
                    swal({
                        title: 'Ошибка',
                        text: errorMessage,
                        icon: 'error',
                        button: 'ОК'
                    });
                }
            });
        });

        // Reset on modal close
        $('#createBannerModal').on('hidden.bs.modal', function() {
            $('#createBannerForm')[0].reset();
            createBannerDropzone.removeAllFiles();
            const $btn = $('#createBannerForm').find('button[type="submit"]');
            $btn.prop('disabled', false);
            $btn.find('i').removeClass('fa-spinner fa-spin').addClass('fa-save');
        });
    });
</script>
@endpush