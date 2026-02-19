<div class="modal fade" id="createAwardModal" tabindex="-1" role="dialog" aria-labelledby="createAwardModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createAwardModalLabel">Добавить награду</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ $about ? route('abouts.award.store', $about->id) : '#' }}" method="POST" enctype="multipart/form-data" id="createAwardForm">
                @csrf
                <div class="modal-body">
                    <ul class="nav nav-pills mb-3" id="awardCreateLangTabs" role="tablist">
                        @foreach($languages as $index => $language)
                        <li class="nav-item">
                            <a class="nav-link {{ $index == 0 ? 'active' : '' }}" data-toggle="pill" href="#award-create-lang-{{ $language->code }}" role="tab">
                                {{ $language->name }}
                            </a>
                        </li>
                        @endforeach
                    </ul>

                    <div class="tab-content" id="awardCreateLangTabsContent">
                        @foreach($languages as $index => $language)
                        <div class="tab-pane fade {{ $index == 0 ? 'show active' : '' }}" id="award-create-lang-{{ $language->code }}" role="tabpanel">
                            <div class="form-group">
                                <label class="form-label">Описание ({{ $language->name }}) <span class="text-danger">*</span></label>
                                <textarea name="description_{{ $language->code }}" class="form-control" rows="4" placeholder="Введите описание award" required></textarea>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <hr>

                    <h6 class="mb-3">Изображение <span class="text-danger">*</span></h6>
                    <div class="form-group">
                        <div id="dropzone-create-award" class="dropzone"></div>
                        <small class="text-muted">Макс. 5MB. Форматы: jpeg, png, jpg, webp.</small>
                    </div>

                    <hr>

                    <div class="form-group">
                        <label class="form-label">Статус</label>
                        <div class="custom-control custom-checkbox mt-2">
                            <input type="checkbox" class="custom-control-input" name="is_active" id="award_create_is_active" value="1" checked>
                            <label class="custom-control-label" for="award_create_is_active">Активен</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                    <button type="submit" class="btn btn-warning" id="createAwardSubmitBtn">
                        <i class="fas fa-save"></i> Сохранить
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    let createAwardDropzone;

    $(document).ready(function () {
        createAwardDropzone = new Dropzone("#dropzone-create-award", {
            url: "#",
            autoProcessQueue: false,
            uploadMultiple: true,
            paramName: "images",
            maxFilesize: 5,
            acceptedFiles: "image/*",
            addRemoveLinks: true,
            dictDefaultMessage: "Перетащите изображение сюда или нажмите для выбора",
            dictRemoveFile: "Удалить",
            dictCancelUpload: "Отменить",
        });

        $('#createAwardForm').on('submit', function (e) {
            e.preventDefault();

            const files = createAwardDropzone.getAcceptedFiles();
            if (files.length === 0) {
                swal({ title: 'Ошибка!', text: 'Загрузите изображение', icon: 'error', button: 'ОК' });
                return;
            }

            const $submitBtn = $('#createAwardSubmitBtn');
            $submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Сохранение...');

            const formData = new FormData(this);
            formData.delete('images[]');
            formData.delete('images');
            files.forEach(file => formData.append('images[]', file));

            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function () {
                    swal({ title: 'Успешно!', text: 'Награда успешно создана', icon: 'success', button: 'ОК' })
                        .then(() => location.reload());
                },
                error: function (xhr) {
                    let errorMsg = 'Ошибка при создании';
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        errorMsg = Object.values(xhr.responseJSON.errors).flat().join('\n');
                    }
                    swal({ title: 'Ошибка!', text: errorMsg, icon: 'error', button: 'ОК' });
                    $submitBtn.prop('disabled', false).html('<i class="fas fa-save"></i> Сохранить');
                }
            });
        });

        $('#createAwardModal').on('hidden.bs.modal', function () {
            $('#createAwardForm')[0].reset();
            createAwardDropzone.removeAllFiles();
        });
    });
</script>
@endpush
