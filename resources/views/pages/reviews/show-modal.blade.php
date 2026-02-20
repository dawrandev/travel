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
                            <td class="font-weight-bold" width="30%">Имя</td>
                            <td id="show_user_name"></td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Email</td>
                            <td id="show_email"></td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Тур</td>
                            <td id="show_tour_name"></td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Статус проверки</td>
                            <td id="show_checked_status"></td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Комментарий</td>
                            <td id="show_comment"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer bg-whitesmoke">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times"></i> Закрыть
                </button>
            </div>
        </div>
    </div>
</div>
