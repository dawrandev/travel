@extends('layouts.main')

@section('content')
<div class="section-header">
    <h1>Отзывы клиентов</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fas fa-home"></i> Панель управления</a></div>
        <div class="breadcrumb-item active">Отзывы клиентов</div>
    </div>
</div>

<!-- Reviews Section -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4>
                    Отзывы клиентов
                    @if($pendingCount > 0)
                    <span class="badge badge-warning ml-2">Ожидают проверки: {{ $pendingCount }}</span>
                    @endif
                </h4>
                <div class="card-header-action d-flex align-items-center" style="gap: 10px;">
                    <input type="text" class="form-control" id="searchInput" placeholder="Поиск по имени, городу, комментарию..." style="width: 300px;">

                    <select class="form-control" id="statusFilter" style="width: 200px;">
                        <option value="">Все отзывы</option>
                        <option value="1">Одобренные</option>
                        <option value="0">Ожидают проверки</option>
                    </select>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="reviewTable">
                        <thead>
                            <tr>
                                <th>№</th>
                                <th>Имя</th>
                                <th>Email</th>
                                <th>Тур</th>
                                <th>Рейтинг</th>
                                <th>Комментарий</th>
                                <th>Статус проверки</th>
                                <th>Статус</th>
                                <th>Действия</th>
                            </tr>
                        </thead>
                        <tbody id="reviewTableBody">
                            @foreach($reviews as $review)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $review->user_name }}</td>
                                <td>
                                    <a href="mailto:{{ $review->email }}">{{ $review->email ?? 'N/A' }}</a>
                                </td>
                                <td>{{ $review->tour->translations->where('lang_code', 'ru')->first()->title ?? 'N/A' }}</td>
                                <td>
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <=$review->rating)
                                        <i class="fas fa-star text-warning"></i>
                                        @else
                                        <i class="far fa-star text-warning"></i>
                                        @endif
                                        @endfor
                                </td>

                                <td>{{ Str::limit($review->translations->where('lang_code', 'ru')->first()->comment ?? $review->translations->first()->comment ?? 'N/A', 50) }}</td>

                                <td>
                                    @if($review->is_checked)
                                    <span class="badge badge-success">Одобрен</span>
                                    @else
                                    <span class="badge badge-warning">Ожидает</span>
                                    @endif
                                </td>

                                <td>
                                    @if($review->is_active)
                                    <span class="badge badge-success">Активен</span>
                                    @else
                                    <span class="badge badge-danger">Неактивен</span>
                                    @endif
                                </td>

                                <td style="white-space: nowrap;">
                                    <button class="btn btn-sm btn-info" onclick="showReview({{ $review->id }})" title="Просмотр">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    @if(!$review->is_checked)
                                    <form action="{{ route('reviews.approve', $review->id) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-sm btn-success" title="Одобрить">
                                            <i class="fas fa-check"></i> Одобрить
                                        </button>
                                    </form>
                                    @endif
                                    <form action="{{ route('reviews.destroy', $review->id) }}" method="POST" style="display:inline-block;" data-confirm-delete data-item-name="отзыв">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Удалить">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('modals')
@include('pages.reviews.show-modal')
@endpush

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css">

@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>

<script>
    const ROUTES = {
        filter: '{{ route("reviews.filter") }}',
        translations: '/reviews/{id}/translations',
        destroy: '/reviews/{id}'
    };

    $(document).ready(function() {
        let searchTimeout;

        // Search input with debounce - only trigger on typing, not on load
        $('#searchInput').on('keyup', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(function() {
                filterReviews();
            }, 500); // Wait 500ms after user stops typing
        });

        // Status filter - trigger AJAX
        $('#statusFilter').on('change', function() {
            filterReviews();
        });

        function filterReviews() {
            var search = $('#searchInput').val();
            var isChecked = $('#statusFilter').val();

            console.log('Filter called with:', { search, isChecked, adminOnly: false });

            $.ajax({
                url: ROUTES.filter,
                type: 'GET',
                data: {
                    search: search,
                    is_checked: isChecked,
                    lang_code: 'ru',
                    adminOnly: false
                },
                success: function(response) {
                    console.log('Filter response:', response);
                    if (response.success) {
                        console.log('Updating table with', response.data.length, 'reviews');
                        updateTable(response.data);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Filter error:', xhr, status, error);
                    swal({
                        title: 'Ошибка!',
                        text: 'Ошибка при загрузке данных',
                        icon: 'error',
                        button: 'ОК'
                    });
                }
            });
        }

        function updateTable(reviews) {
            console.log('updateTable called with reviews:', reviews);
            var tbody = $('#reviewTableBody');
            tbody.empty();

            if (reviews.length === 0) {
                tbody.append('<tr><td colspan="9" class="text-center">Нет данных</td></tr>');
                return;
            }

            reviews.forEach(function(review, index) {
                var statusBadge = review.is_active ?
                    '<span class="badge badge-success">Активен</span>' :
                    '<span class="badge badge-danger">Неактивен</span>';

                var checkedBadge = review.is_checked ?
                    '<span class="badge badge-success">Одобрен</span>' :
                    '<span class="badge badge-warning">Ожидает</span>';

                var stars = '';
                for (var i = 1; i <= 5; i++) {
                    stars += (i <= review.rating) ?
                        '<i class="fas fa-star text-warning"></i>' :
                        '<i class="far fa-star text-warning"></i>';
                }

                var comment = review.comment && review.comment.length > 50 ?
                    review.comment.substring(0, 50) + '...' :
                    (review.comment || 'N/A');

                var approveBtn = !review.is_checked ?
                    '<form action="/reviews/' + review.id + '/approve" method="POST" style="display:inline-block;">' +
                    '@csrf @method("PUT")' +
                    '<button type="submit" class="btn btn-sm btn-success" title="Одобрить">' +
                    '<i class="fas fa-check"></i> Одобрить' +
                    '</button>' +
                    '</form>' : '';

                var row = '<tr>' +
                    '<td>' + (index + 1) + '</td>' +
                    '<td>' + review.user_name + '</td>' +
                    '<td><a href="mailto:' + review.email + '">' + (review.email || 'N/A') + '</a></td>' +
                    '<td>' + (review.tour_name || 'N/A') + '</td>' +
                    '<td>' + stars + '</td>' +
                    '<td>' + comment + '</td>' +
                    '<td>' + checkedBadge + '</td>' +
                    '<td>' + statusBadge + '</td>' +
                    '<td style="white-space: nowrap;">' +
                    '<button class="btn btn-sm btn-info" onclick="showReview(' + review.id + ')" title="Просмотр">' +
                    '<i class="fas fa-eye"></i>' +
                    '</button> ' +
                    approveBtn +
                    '<form action="/reviews/' + review.id + '" method="POST" style="display:inline-block;" data-confirm-delete data-item-name="отзыв">' +
                    '@csrf @method("DELETE")' +
                    '<button type="submit" class="btn btn-sm btn-danger" title="Удалить">' +
                    '<i class="fas fa-trash"></i>' +
                    '</button>' +
                    '</form>' +
                    '</td>' +
                    '</tr>';

                tbody.append(row);
            });
        }
    });

    window.showReview = function(id) {
        $.ajax({
            url: ROUTES.translations.replace('{id}', id),
            type: 'GET',
            success: function(response) {
                if (response.success) {
                    $('#show_user_name').text(response.review.user_name);

                    // Get tour name from Russian translation
                    var tourName = 'N/A';
                    @foreach($tours as $tour)
                    if ({{ $tour->id }} == response.review.tour_id) {
                        tourName = '{{ $tour->translations->where("lang_code", "ru")->first()->title ?? "N/A" }}';
                    }
                    @endforeach
                    $('#show_tour_name').text(tourName);

                    // Rating stars
                    var stars = '';
                    for (var i = 1; i <= 5; i++) {
                        stars += (i <= response.review.rating) ?
                            '<i class="fas fa-star text-warning"></i> ' :
                            '<i class="far fa-star text-warning"></i> ';
                    }
                    $('#show_rating').html(stars);

                    // Video URL
                    if (response.review.video_url) {
                        $('#show_video_url').html('<a href="' + response.review.video_url + '" target="_blank" class="btn btn-sm btn-danger"><i class="fab fa-youtube"></i> Смотреть видео</a>');
                    } else {
                        $('#show_video_url').html('<span class="text-muted">Нет видео</span>');
                    }

                    // Review URL
                    if (response.review.review_url) {
                        $('#show_review_url').html('<a href="' + response.review.review_url + '" target="_blank" class="btn btn-sm btn-info"><i class="fas fa-external-link-alt"></i> Перейти к отзыву</a>');
                    } else {
                        $('#show_review_url').html('<span class="text-muted">Нет ссылки</span>');
                    }

                    $('#show_sort_order').text(response.review.sort_order);

                    // Status
                    var statusBadge = response.review.is_active ?
                        '<span class="badge badge-success badge-lg">Активен</span>' :
                        '<span class="badge badge-danger badge-lg">Неактивен</span>';
                    $('#show_status').html(statusBadge);

                    // Translations
                    @foreach($languages as $language)
                    if (response.translations['{{ $language->code }}']) {
                        $('#show_city_{{ $language->code }}').text(response.translations['{{ $language->code }}'].city || 'N/A');
                        $('#show_comment_{{ $language->code }}').text(response.translations['{{ $language->code }}'].comment || 'N/A');
                    } else {
                        $('#show_city_{{ $language->code }}').text('N/A');
                        $('#show_comment_{{ $language->code }}').text('N/A');
                    }
                    @endforeach

                    $('#showModal').modal('show');
                }
            },
            error: function() {
                swal({
                    title: 'Ошибка!',
                    text: 'Ошибка при загрузке данных',
                    icon: 'error',
                    button: 'ОК'
                });
            }
        });
    };
</script>
@endpush