@extends('layouts.main')

@section('content')
<div class="section-header">
    <h1>Бронирования</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fas fa-home"></i> Панель управления</a></div>
        <div class="breadcrumb-item active">Бронирования</div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4>Список бронирований</h4>
            </div>
            <div class="card-body">
                <!-- Search and Filter -->
                <div class="row mb-3">
                    <div class="col-md-5">
                        <div class="input-group">
                            <input type="text" id="searchInput" class="form-control" placeholder="Поиск по имени, email, телефону, сообщению..." value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <select id="statusFilter" class="form-control">
                            <option value="">Все статусы</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>В ожидании</option>
                            <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Подтверждено</option>
                            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Отменено</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="button" id="resetBtn" class="btn btn-secondary btn-block">
                            <i class="fas fa-redo"></i> Сбросить
                        </button>
                    </div>
                </div>

                <div id="bookingsTableContainer">
                    @include('pages.bookings.table')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('modals')
<!-- View Modal -->
<div class="modal fade" id="viewModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Детали бронирования</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body" id="bookingDetails">
                <!-- Details will be loaded here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Status Modal -->
<div class="modal fade" id="editStatusModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Изменить статус</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form id="statusForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label>Статус</label>
                        <select name="status" id="statusSelect" class="form-control" required>
                            <option value="pending">В ожидании</option>
                            <option value="confirmed">Подтверждено</option>
                            <option value="cancelled">Отменено</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                    <button type="submit" class="btn btn-primary">Сохранить</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endpush

@push('scripts')
<script>
    $(document).ready(function() {
        let searchTimeout;

        // Search function
        function loadBookings() {
            const search = $('#searchInput').val();
            const status = $('#statusFilter').val();

            $.ajax({
                url: '{{ route("bookings.index") }}',
                type: 'GET',
                data: {
                    search: search,
                    status: status
                },
                success: function(response) {
                    $('#bookingsTableContainer').html(response);
                },
                error: function(xhr) {
                    console.error('Error loading bookings:', xhr);
                }
            });
        }

        // Search input with debounce
        $('#searchInput').on('keyup', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(function() {
                loadBookings();
            }, 500);
        });

        // Status filter change
        $('#statusFilter').change(function() {
            loadBookings();
        });

        // Reset button
        $('#resetBtn').click(function() {
            $('#searchInput').val('');
            $('#statusFilter').val('');
            loadBookings();
        });

        // View booking (event delegation)
        $(document).on('click', '.view-booking', function() {
            const bookingId = $(this).data('id');

            $.ajax({
                url: '/bookings/' + bookingId + '/show',
                type: 'GET',
                success: function(booking) {
                    const tourTitle = booking.tour && booking.tour.translations.length > 0 ?
                        (booking.tour.translations.find(t => t.lang_code === 'ru') || booking.tour.translations[0]).title :
                        'Тур удален';

                    const statusLabels = {
                        'pending': 'В ожидании',
                        'confirmed': 'Подтверждено',
                        'cancelled': 'Отменено'
                    };

                    let html = `
                        <table class="table table-bordered">
                            <tr>
                                <th>Тур</th>
                                <td>${tourTitle}</td>
                            </tr>
                            <tr>
                                <th>Клиент</th>
                                <td>${booking.full_name}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>${booking.email}</td>
                            </tr>
                            <tr>
                                <th>Телефон 1</th>
                                <td>${booking.primary_phone}</td>
                            </tr>
                            <tr>
                                <th>Телефон 2</th>
                                <td>${booking.secondary_phone || '-'}</td>
                            </tr>
                            <tr>
                                <th>Количество людей</th>
                                <td>${booking.max_people}</td>
                            </tr>
                            <tr>
                                <th>Дата начала</th>
                                <td>${new Date(booking.starting_date).toLocaleDateString('ru-RU')}</td>
                            </tr>
                            <tr>
                                <th>Дата окончания</th>
                                <td>${new Date(booking.ending_date).toLocaleDateString('ru-RU')}</td>
                            </tr>
                            <tr>
                                <th>Статус</th>
                                <td>${statusLabels[booking.status] || booking.status}</td>
                            </tr>
                            <tr>
                                <th>Сообщение</th>
                                <td>${booking.message || '<span class="text-muted">Нет сообщения</span>'}</td>
                            </tr>
                            <tr>
                                <th>Создано</th>
                                <td>${new Date(booking.created_at).toLocaleString('ru-RU')}</td>
                            </tr>
                        </table>
                    `;

                    $('#bookingDetails').html(html);
                    $('#viewModal').modal('show');
                },
                error: function(xhr) {
                    console.error('Error loading booking:', xhr);
                }
            });
        });

        // Edit status (event delegation)
        $(document).on('click', '.edit-status', function() {
            const bookingId = $(this).data('id');
            const currentStatus = $(this).data('status');

            $('#statusForm').attr('action', '/bookings/' + bookingId + '/status');
            $('#statusSelect').val(currentStatus);
            $('#editStatusModal').modal('show');
        });

        // Pagination links (event delegation)
        $(document).on('click', '.pagination a', function(e) {
            e.preventDefault();
            const url = $(this).attr('href');
            const search = $('#searchInput').val();
            const status = $('#statusFilter').val();

            $.ajax({
                url: url,
                type: 'GET',
                data: {
                    search: search,
                    status: status
                },
                success: function(response) {
                    $('#bookingsTableContainer').html(response);
                },
                error: function(xhr) {
                    console.error('Error loading page:', xhr);
                }
            });
        });
    });
</script>
@endpush