<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModalLabel">Добавить новую категорию</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('categories.store') }}" method="POST">
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
                            <div class="form-group">
                                <label class="form-label">Название ({{ $language->name }}) <span class="text-danger">*</span></label>
                                <input type="text" name="name_{{ $language->code }}" class="form-control" placeholder="Введите название категории" required>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div class="row mt-3">
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