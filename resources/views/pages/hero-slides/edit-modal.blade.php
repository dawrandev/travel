<div class="modal fade" id="editSlideModal" tabindex="-1" role="dialog" aria-labelledby="editSlideModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editSlideModalLabel">Редактировать слайд</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editSlideForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <ul class="nav nav-pills mb-3" id="editSlideLanguageTabs" role="tablist">
                        @foreach($languages as $index => $language)
                        <li class="nav-item">
                            <a class="nav-link {{ $index == 0 ? 'active' : '' }}" id="edit-slide-tab-{{ $language->code }}" data-toggle="pill" href="#edit-slide-lang-{{ $language->code }}" role="tab">
                                {{ $language->name }}
                            </a>
                        </li>
                        @endforeach
                    </ul>

                    <div class="tab-content" id="editSlideLanguageTabsContent">
                        @foreach($languages as $index => $language)
                        <div class="tab-pane fade {{ $index == 0 ? 'show active' : '' }}" id="edit-slide-lang-{{ $language->code }}" role="tabpanel">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label">Заголовок ({{ $language->name }}) <span class="text-danger">*</span></label>
                                        <input type="text" name="title_{{ $language->code }}" id="edit_title_{{ $language->code }}" class="form-control" placeholder="Введите заголовок" required>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label">Подзаголовок ({{ $language->name }}) <span class="text-danger">*</span></label>
                                        <input type="text" name="subtitle_{{ $language->code }}" id="edit_subtitle_{{ $language->code }}" class="form-control" placeholder="Введите подзаголовок" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div class="row mt-3">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">Изображение</label>
                                <div class="custom-file">
                                    <input type="file" name="image" class="custom-file-input" id="slide_image_edit" accept="image/*">
                                    <label class="custom-file-label" for="slide_image_edit">Выберите изображение</label>
                                </div>
                                <small class="form-text text-muted">Оставьте пустым, если не хотите менять изображение</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Порядок сортировки</label>
                                <input type="number" name="sort_order" id="edit_slide_sort_order" class="form-control" value="0" min="0">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Статус</label>
                                <div class="custom-control custom-checkbox mt-2">
                                    <input type="checkbox" class="custom-control-input" name="is_active" id="edit_slide_is_active" value="1">
                                    <label class="custom-control-label" for="edit_slide_is_active">Активен</label>
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
