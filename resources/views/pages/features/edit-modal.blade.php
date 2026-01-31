<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Редактировать функцию</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">Иконка <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="edit_icon_preview" style="font-size: 24px; width: 60px; justify-content: center;">
                                            <i class="fas fa-star"></i>
                                        </span>
                                    </div>
                                    <input type="text" name="icon" id="edit_icon" class="form-control" placeholder="fas fa-star" required>
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editIconPickerModal">
                                            <i class="fas fa-icons"></i> Выбрать иконку
                                        </button>
                                    </div>
                                </div>
                                <small class="form-text text-muted">Используйте классы FontAwesome (например: fas fa-star, far fa-heart, fab fa-facebook)</small>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <ul class="nav nav-pills mb-3" id="editLanguageTabs" role="tablist">
                        @foreach($languages as $index => $language)
                        <li class="nav-item">
                            <a class="nav-link {{ $index == 0 ? 'active' : '' }}" id="edit-tab-{{ $language->code }}" data-toggle="pill" href="#edit-lang-{{ $language->code }}" role="tab">
                                {{ $language->name }}
                            </a>
                        </li>
                        @endforeach
                    </ul>

                    <div class="tab-content" id="editLanguageTabsContent">
                        @foreach($languages as $index => $language)
                        <div class="tab-pane fade {{ $index == 0 ? 'show active' : '' }}" id="edit-lang-{{ $language->code }}" role="tabpanel">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label">Название ({{ $language->name }}) <span class="text-danger">*</span></label>
                                        <input type="text" name="name_{{ $language->code }}" id="edit_name_{{ $language->code }}" class="form-control" placeholder="Введите название" required>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label">Описание ({{ $language->name }}) <span class="text-danger">*</span></label>
                                        <textarea name="description_{{ $language->code }}" id="edit_description_{{ $language->code }}" class="form-control" rows="4" placeholder="Введите описание" required></textarea>
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
                        <i class="fas fa-sync-alt"></i> Обновить
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Icon Picker Modal -->
<div class="modal fade" id="editIconPickerModal" tabindex="-1" role="dialog" aria-labelledby="editIconPickerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editIconPickerModalLabel">Выбрать иконку</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <input type="text" id="editIconSearch" class="form-control" placeholder="Поиск иконки...">
                </div>
                <div id="editIconList" style="max-height: 400px; overflow-y: auto;">
                    <div class="row" id="editIconGrid">
                        <!-- Icons will be loaded here -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function loadEditIcons() {
        const iconGrid = $('#editIconGrid');
        iconGrid.empty();

        popularIcons.forEach(function(icon) {
            const iconHtml = `
                <div class="col-2 text-center mb-3">
                    <button type="button" class="btn btn-light edit-icon-select-btn" data-icon="${icon}" style="width: 100%; padding: 15px;">
                        <i class="${icon}" style="font-size: 24px;"></i>
                    </button>
                </div>
            `;
            iconGrid.append(iconHtml);
        });
    }

    $(document).ready(function() {
        $('#editIconPickerModal').on('show.bs.modal', function() {
            loadEditIcons();
        });

        $(document).on('click', '.edit-icon-select-btn', function() {
            const selectedIcon = $(this).data('icon');
            $('#edit_icon').val(selectedIcon);
            $('#edit_icon_preview').html('<i class="' + selectedIcon + '"></i>');
            $('#editIconPickerModal').modal('hide');
        });

        $('#edit_icon').on('input', function() {
            const iconClass = $(this).val();
            $('#edit_icon_preview').html('<i class="' + iconClass + '"></i>');
        });

        $('#editIconSearch').on('input', function() {
            const searchTerm = $(this).val().toLowerCase();
            $('.edit-icon-select-btn').each(function() {
                const icon = $(this).data('icon').toLowerCase();
                if (icon.includes(searchTerm)) {
                    $(this).parent().show();
                } else {
                    $(this).parent().hide();
                }
            });
        });
    });
</script>
@endpush