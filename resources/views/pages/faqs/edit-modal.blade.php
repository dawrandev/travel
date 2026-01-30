<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Редактировать вопрос</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
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
                                        <label class="form-label">Вопрос ({{ $language->name }}) <span class="text-danger">*</span></label>
                                        <input type="text" name="question_{{ $language->code }}" id="edit_question_{{ $language->code }}" class="form-control" placeholder="Введите вопрос" required>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label">Ответ ({{ $language->name }}) <span class="text-danger">*</span></label>
                                        <textarea name="answer_{{ $language->code }}" id="edit_answer_{{ $language->code }}" class="form-control" rows="5" placeholder="Введите ответ" required></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Порядок сортировки</label>
                                <input type="number" name="sort_order" id="edit_sort_order" class="form-control" value="0" min="0">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Статус</label>
                                <div class="custom-control custom-checkbox mt-2">
                                    <input type="checkbox" class="custom-control-input" name="is_active" id="edit_is_active">
                                    <label class="custom-control-label" for="edit_is_active">Активен</label>
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

<script>
function editFaq(id) {
    $.ajax({
        url: '/faqs/' + id + '/translations',
        type: 'GET',
        success: function(response) {
            if (response.success) {
                $('#editForm').attr('action', '/faqs/' + id);
                $('#edit_sort_order').val(response.faq.sort_order);
                $('#edit_is_active').prop('checked', response.faq.is_active);

                // Fill translations for each language
                @foreach($languages as $language)
                    if (response.translations['{{ $language->code }}']) {
                        $('#edit_question_{{ $language->code }}').val(response.translations['{{ $language->code }}'].question);
                        $('#edit_answer_{{ $language->code }}').val(response.translations['{{ $language->code }}'].answer);
                    }
                @endforeach

                $('#editModal').modal('show');
            }
        },
        error: function() {
            alert('Ошибка при загрузке данных');
        }
    });
}
</script>
