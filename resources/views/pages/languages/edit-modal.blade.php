<div class="modal fade" id="editLanguageModal" tabindex="-1" role="dialog" aria-labelledby="editLanguageModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editLanguageModalLabel">Редактировать язык</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label class="form-label">Название языка <span class="text-danger">*</span></label>
                        <input type="text" id="editName" name="name" class="form-control" placeholder="Например: English, Русский" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Код <span class="text-danger">*</span></label>
                        <input type="text" id="editCode" name="code" class="form-control" placeholder="Например: en, ru, uz" maxlength="10" required>
                    </div>

                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="editIsActive" name="is_active">
                            <label class="custom-control-label" for="editIsActive">Активен</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-save"></i> Обновить
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
