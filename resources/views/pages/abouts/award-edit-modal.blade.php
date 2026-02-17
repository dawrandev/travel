<div class="modal fade" id="editAwardModal" tabindex="-1" role="dialog" aria-labelledby="editAwardModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editAwardModalLabel">Редактировать Award</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editAwardForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <ul class="nav nav-pills mb-3" id="awardEditLangTabs" role="tablist">
                        @foreach($languages as $index => $language)
                        <li class="nav-item">
                            <a class="nav-link {{ $index == 0 ? 'active' : '' }}" data-toggle="pill" href="#award-edit-lang-{{ $language->code }}" role="tab">
                                {{ $language->name }}
                            </a>
                        </li>
                        @endforeach
                    </ul>

                    <div class="tab-content" id="awardEditLangTabsContent">
                        @foreach($languages as $index => $language)
                        <div class="tab-pane fade {{ $index == 0 ? 'show active' : '' }}" id="award-edit-lang-{{ $language->code }}" role="tabpanel">
                            <div class="form-group">
                                <label class="form-label">Описание ({{ $language->name }}) <span class="text-danger">*</span></label>
                                <textarea name="description_{{ $language->code }}" id="edit_award_description_{{ $language->code }}" class="form-control" rows="4" placeholder="Введите описание award" required></textarea>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <hr>

                    <h6 class="mb-3">Текущее изображение</h6>
                    <div id="currentAwardImages" class="row mb-3"></div>

                    <h6 class="mb-3">Загрузить новое изображение (опционально)</h6>
                    <div class="form-group">
                        <div id="dropzone-edit-award" class="dropzone"></div>
                        <small class="text-muted d-block mt-2">
                            <i class="fas fa-info-circle"></i> Если загрузите новое изображение, старое будет удалено.
                        </small>
                    </div>

                    <hr>

                    <div class="form-group">
                        <label class="form-label">Статус</label>
                        <div class="custom-control custom-checkbox mt-2">
                            <input type="checkbox" class="custom-control-input" name="is_active" id="edit_award_is_active" value="1">
                            <label class="custom-control-label" for="edit_award_is_active">Активен</label>
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
    let editAwardDropzone;

    $(document).ready(function () {
        editAwardDropzone = new Dropzone("#dropzone-edit-award", {
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

        $('#editAwardForm').on('submit', function (e) {
            e.preventDefault();

            const files = editAwardDropzone.getAcceptedFiles();
            const formData = new FormData(this);

            if (files.length > 0) {
                formData.delete('images[]');
                formData.delete('images');
                files.forEach(file => formData.append('images[]', file));
            }

            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function () {
                    swal({ title: 'Успешно!', text: 'Award успешно обновлен', icon: 'success', button: 'ОК' })
                        .then(() => location.reload());
                },
                error: function (xhr) {
                    let errorMsg = 'Ошибка при обновлении';
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        errorMsg = Object.values(xhr.responseJSON.errors).flat().join('\n');
                    }
                    swal({ title: 'Ошибка!', text: errorMsg, icon: 'error', button: 'ОК' });
                }
            });
        });

        $('#editAwardModal').on('hidden.bs.modal', function () {
            $('#editAwardForm')[0].reset();
            editAwardDropzone.removeAllFiles();
            $('#currentAwardImages').empty();
        });
    });

    function editAward(aboutId, awardId) {
        $.ajax({
            url: '/abouts/' + aboutId + '/award/' + awardId + '/translations',
            type: 'GET',
            success: function (response) {
                if (response.success) {
                    populateEditAwardModal(response, aboutId, awardId);
                    $('#editAwardModal').modal('show');
                }
            },
            error: function () {
                swal({ title: 'Ошибка!', text: 'Ошибка при загрузке данных', icon: 'error', button: 'ОК' });
            }
        });
    }

    function populateEditAwardModal(response, aboutId, awardId) {
        const { award, translations, images } = response;

        $('#editAwardForm').attr('action', '/abouts/' + aboutId + '/award/' + awardId);
        $('#edit_award_is_active').prop('checked', award.is_active);

        @foreach($languages as $language)
        if (translations['{{ $language->code }}']) {
            $('#edit_award_description_{{ $language->code }}').val(translations['{{ $language->code }}'].description);
        }
        @endforeach

        let imagesHtml = '';
        if (images && images.length > 0) {
            images.forEach((img, index) => {
                imagesHtml += `
                    <div class="col-md-3 mb-3">
                        <div class="position-relative">
                            <img src="/storage/${img.image_path}" class="img-thumbnail w-100" style="height: 150px; object-fit: cover;">
                            <span class="badge badge-primary position-absolute" style="top: 5px; left: 5px;">${index + 1}</span>
                        </div>
                    </div>`;
            });
        } else {
            imagesHtml = '<div class="col-12"><p class="text-muted">Нет изображений</p></div>';
        }
        $('#currentAwardImages').html(imagesHtml);
    }
</script>
@endpush
