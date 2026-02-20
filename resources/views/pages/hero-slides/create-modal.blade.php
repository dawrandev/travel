<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModalLabel">Добавить новый слайд</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="createHeroSlideForm" action="{{ route('hero-slides.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <ul class="nav nav-pills mb-3" id="languageTabs" role="tablist">
                        @foreach($languages as $index => $language)
                        <li class="nav-item">
                            <a class="nav-link {{ $index == 0 ? 'active' : '' }}" id="tab-{{ $language->code }}" data-toggle="pill" href="#lang-{{ $language->code }}" role="tab">
                                {{ $language->name }}
                            </a>
                        </li>
                        @endforeach
                    </ul>

                    <div class="tab-content" id="languageTabsContent">
                        @foreach($languages as $index => $language)
                        <div class="tab-pane fade {{ $index == 0 ? 'show active' : '' }}" id="lang-{{ $language->code }}" role="tabpanel">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label">Заголовок ({{ $language->name }}) <span class="text-danger">*</span></label>
                                        <input type="text" name="title_{{ $language->code }}" class="form-control" placeholder="Введите заголовок" required>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label">Подзаголовок ({{ $language->name }}) <span class="text-danger">*</span></label>
                                        <input type="text" name="subtitle_{{ $language->code }}" class="form-control" placeholder="Введите подзаголовок" required>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label">Описание ({{ $language->name }})</label>
                                        <textarea name="description_{{ $language->code }}" class="form-control" rows="3" placeholder="Введите описание"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div class="row mt-3">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">Изображение <span class="text-danger">*</span></label>
                                <div class="custom-file">
                                    <input type="file" name="image" class="custom-file-input" id="image_create" accept="image/*" required>
                                    <label class="custom-file-label" for="image_create">Выберите изображение</label>
                                </div>
                                <small class="form-text text-muted">Форматы: JPG, PNG, GIF (макс. 2MB)</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Порядок сортировки</label>
                                <input type="number" name="sort_order" class="form-control" value="0" min="0">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Статус</label>
                                <div class="custom-control custom-checkbox mt-2">
                                    <input type="checkbox" class="custom-control-input" name="is_active" id="is_active_create" value="1" checked>
                                    <label class="custom-control-label" for="is_active_create">Активен</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-save"></i> Сохранить
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        $('#createHeroSlideForm').on('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const $submitBtn = $(this).find('button[type="submit"]');
            $submitBtn.prop('disabled', true);
            const $icon = $submitBtn.find('i');
            $icon.removeClass('fa-save').addClass('fa-spinner fa-spin');

            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    swal({
                        title: 'Успешно!',
                        text: 'Слайд успешно создан',
                        icon: 'success',
                        button: 'ОК',
                    }).then(() => {
                        location.reload();
                    });
                },
                error: function(xhr) {
                    let errorMsg = 'Ошибка при создании';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMsg = xhr.responseJSON.message;
                    } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                        errorMsg = Object.values(xhr.responseJSON.errors).flat().join('\n');
                    }
                    $submitBtn.prop('disabled', false);
                    $icon.removeClass('fa-spinner fa-spin').addClass('fa-save');
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
        $('#createModal').on('hidden.bs.modal', function() {
            $('#createHeroSlideForm')[0].reset();
            const $btn = $('#createHeroSlideForm').find('button[type="submit"]');
            $btn.prop('disabled', false);
            $btn.find('i').removeClass('fa-spinner fa-spin').addClass('fa-save');
        });
    });
</script>
@endpush
