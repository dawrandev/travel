<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModalLabel">Добавить новую функцию</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('features.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">Иконка <span class="text-danger">*</span></label>
                                <input type="text" name="icon" id="iconInput" class="form-control" placeholder="fas fa-star" required readonly>
                                <small class="form-text text-muted">
                                    Нажмите на поле ниже, чтобы выбрать иконку из FontAwesome
                                </small>
                            </div>
                            <div class="form-group">
                                <button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#iconPickerModal">
                                    <i class="fas fa-icons"></i> Выбрать иконку
                                </button>
                            </div>
                            <div id="iconPreview" class="text-center mt-2" style="display: none;">
                                <p class="text-muted mb-2">Выбранная иконка:</p>
                                <i id="iconPreviewIcon" class="" style="font-size: 48px; color: #6777ef;"></i>
                            </div>
                        </div>
                    </div>

                    <hr>

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
                                        <label class="form-label">Название ({{ $language->name }}) <span class="text-danger">*</span></label>
                                        <input type="text" name="name_{{ $language->code }}" class="form-control" placeholder="Введите название" required>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label">Описание ({{ $language->name }}) <span class="text-danger">*</span></label>
                                        <textarea name="description_{{ $language->code }}" class="form-control" rows="4" placeholder="Введите описание" required></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
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

