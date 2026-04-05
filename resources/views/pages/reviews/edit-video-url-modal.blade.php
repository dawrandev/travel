<div class="modal fade" id="editVideoUrlModal" tabindex="-1" role="dialog" aria-labelledby="editVideoUrlModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="editVideoUrlForm">
                @csrf
                @method('PUT')
                <div class="modal-header bg-warning text-white">
                    <h5 class="modal-title" id="editVideoUrlModalLabel">
                        <i class="fas fa-video"></i> Редактировать видео URL
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="edit_review_id" name="review_id">

                    <div class="form-group">
                        <label class="font-weight-bold">Отзыв от:</label>
                        <p id="edit_user_name_display" class="mb-0"></p>
                    </div>

                    <div class="form-group">
                        <label for="edit_video_url">Видео URL <small class="text-muted">(необязательно)</small></label>
                        <input type="url" class="form-control" id="edit_video_url" name="video_url" placeholder="https://youtube.com/watch?v=...">
                        <small class="form-text text-muted">Введите полный URL видео (например, YouTube, Vimeo)</small>
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times"></i> Отмена
                    </button>
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-save"></i> Сохранить
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
