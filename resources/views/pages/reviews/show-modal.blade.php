<div class="modal fade" id="showModal" tabindex="-1" role="dialog" aria-labelledby="showModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="showModalLabel">
                    <i class="fas fa-eye"></i> Просмотр отзыва
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered table-sm">
                    <tbody>
                        <tr>
                            <td class="font-weight-bold" width="30%">Имя пользователя</td>
                            <td id="show_user_name"></td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Тур</td>
                            <td id="show_tour_name"></td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Рейтинг</td>
                            <td id="show_rating"></td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Порядок</td>
                            <td id="show_sort_order"></td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Статус</td>
                            <td id="show_status"></td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Видео URL</td>
                            <td id="show_video_url"></td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Ссылка на отзыв</td>
                            <td id="show_review_url"></td>
                        </tr>
                    </tbody>
                </table>

                <hr>

                <h6 class="mb-3"><i class="fas fa-language"></i> Переводы</h6>

                <div id="translationsAccordion">
                    @foreach($languages as $index => $language)
                    <div class="mb-2">
                        <div class="bg-light p-2 border rounded">
                            <a class="d-block text-dark" data-toggle="collapse" href="#collapse{{ $language->code }}" role="button" aria-expanded="{{ $index == 0 ? 'true' : 'false' }}">
                                <strong><i class="fas fa-chevron-down"></i> {{ $language->name }} ({{ strtoupper($language->code) }})</strong>
                            </a>
                        </div>
                        <div class="collapse {{ $index == 0 ? 'show' : '' }}" id="collapse{{ $language->code }}" data-parent="#translationsAccordion">
                            <div class="border border-top-0 rounded-bottom p-3">
                                <div class="mb-2">
                                    <strong>Город:</strong>
                                    <p class="mb-0" id="show_city_{{ $language->code }}"></p>
                                </div>
                                <div>
                                    <strong>Комментарий:</strong>
                                    <p class="mb-0" id="show_comment_{{ $language->code }}"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="modal-footer bg-whitesmoke">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times"></i> Закрыть
                </button>
            </div>
        </div>
    </div>
</div>
