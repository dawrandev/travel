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

                    <div class="row mt-3">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label class="form-label">Изображение</label>
                                <div class="custom-file">
                                    <input type="file" name="image" class="custom-file-input" id="about_image_edit" accept="image/*">
                                    <label class="custom-file-label" for="about_image_edit">Выберите изображение</label>
                                </div>
                                <small class="form-text text-muted">Оставьте пустым, если не хотите менять изображение</small>
                            </div>
                        </div>
                        <div class="col-md-4">
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
