@extends('layouts.main')

@section('content')
<div class="section-header">
    <h1>Админ Отзывы</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fas fa-home"></i> Панель управления</a></div>
        <div class="breadcrumb-item active">Админ Отзывы</div>
        <div class="breadcrumb-item">
            <button class="btn btn-warning rounded-pill" data-toggle="modal" data-target="#createModal">
                <i class="fas fa-plus"></i> Добавить отзыв
            </button>
        </div>
    </div>
</div>

<!-- Banner Section -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4><i class="fas fa-image"></i> Баннер страницы</h4>
                <div class="card-header-action">
                    @if($banner)
                    <button class="btn btn-primary" onclick="editBanner({{ $banner->id }})">
                        <i class="fas fa-edit"></i> Редактировать баннер
                    </button>
                    @else
                    <button class="btn btn-success" data-toggle="modal" data-target="#createBannerModal">
                        <i class="fas fa-plus"></i> Создать баннер
                    </button>
                    @endif
                </div>
            </div>
            <div class="card-body">
                @if($banner)
                <div class="row">
                    <!-- Images Section -->
                    <div class="col-md-5">
                        <h6 class="mb-3"><i class="fas fa-images"></i> Изображения баннера ({{ $banner->images->count() }})</h6>
                        <div class="row">
                            @foreach($banner->images->sortBy('sort_order') as $index => $image)
                            <div class="col-md-4 mb-3">
                                <div class="position-relative image-wrapper">
                                    <a href="{{ asset('storage/' . $image->image_path) }}"
                                        data-lightbox="banner-gallery"
                                        data-title="Баннер - Изображение {{ $index + 1 }}">
                                        <img src="{{ asset('storage/' . $image->image_path) }}"
                                            class="img-fluid rounded shadow-sm"
                                            alt="Banner Image {{ $index + 1 }}"
                                            style="width: 100%; height: 120px; object-fit: cover; cursor: pointer; transition: transform 0.3s ease;">
                                    </a>
                                    <span class="badge badge-primary position-absolute" style="top: 5px; right: 5px;">
                                        {{ $index + 1 }}
                                    </span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Translations Section -->
                    <div class="col-md-7">
                        <h6 class="mb-3"><i class="fas fa-language"></i> Заголовки баннера</h6>
                        <div class="list-group">
                            @foreach($banner->translations as $translation)
                            <div class="list-group-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <span class="badge badge-info mr-2">{{ strtoupper($translation->lang_code) }}</span>
                                        <span>{{ $translation->title }}</span>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <div class="mt-3">
                            <h6><i class="fas fa-toggle-on"></i> Статус</h6>
                            <span class="badge badge-{{ $banner->is_active ? 'success' : 'danger' }} badge-lg">
                                {{ $banner->is_active ? 'Активен' : 'Неактивен' }}
                            </span>
                        </div>
                    </div>
                </div>
                @else
                <div class="text-center py-5">
                    <div class="mb-3">
                        <i class="fas fa-image fa-3x text-warning"></i>
                    </div>
                    <h5>Баннер не создан</h5>
                    <p class="text-muted">Создайте баннер для страницы "О нас"</p>
                    <button class="btn btn-success" data-toggle="modal" data-target="#createBannerModal">
                        <i class="fas fa-plus"></i> Создать баннер
                    </button>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Reviews Section -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4>Админ Отзывы</h4>
                <div class="card-header-action d-flex align-items-center" style="gap: 10px;">
                    <input type="text" class="form-control" id="searchInput" placeholder="Поиск по имени, городу, комментарию..." style="width: 300px;">

                    <select class="form-control" id="languageFilter" style="width: 150px;">
                        @foreach($languages as $language)
                        <option value="{{ $language->code }}" {{ $language->code == 'ru' ? 'selected' : '' }}>
                            {{ $language->name }}
                        </option>
                        @endforeach
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
                                <th>Город</th>
                                <th>Тур</th>
                                <th>Рейтинг</th>
                                <th class="text-center">Видео</th>
                                <th class="text-center">Ссылка</th>
                                <th>Комментарий</th>
                                <th>Порядок</th>
                                <th>Статус</th>
                                <th>Действия</th>
                            </tr>
                        </thead>
                        <tbody id="reviewTableBody">
                            @foreach($reviews as $review)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $review->user_name }}</td>
                                <td>{{ $review->translations->where('lang_code', 'ru')->first()->city ?? 'N/A' }}</td>
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

                                <td class="text-center">
                                    @if($review->video_url)
                                    <a href="{{ $review->video_url }}" target="_blank" class="text-danger" title="Смотреть на YouTube">
                                        <i class="fab fa-youtube fa-2x"></i>
                                    </a>
                                    @else
                                    <span class="text-muted">Нет видео</span>
                                    @endif
                                </td>

                                <td class="text-center">
                                    @if($review->review_url)
                                    <a href="{{ $review->review_url }}" target="_blank" class="btn btn-sm btn-info" title="Перейти к отзыву">
                                        <i class="fas fa-external-link-alt"></i> Ссылка
                                    </a>
                                    @else
                                    <span class="text-muted">-</span>
                                    @endif
                                </td>

                                <td>{{ Str::limit($review->translations->where('lang_code', 'ru')->first()->comment ?? 'N/A', 50) }}</td>
                                <td>{{ $review->sort_order }}</td>
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
                                    <button class="btn btn-sm btn-primary" onclick="editReview({{ $review->id }})" title="Редактировать">
                                        <i class="fas fa-edit"></i>
                                    </button>
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
@include('pages.reviews.banner-create-modal')
@include('pages.reviews.banner-edit-modal')
@include('pages.reviews.create-modal')
@include('pages.reviews.edit-modal')
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

        // Search input with debounce
        $('#searchInput').on('keyup', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(function() {
                filterReviews();
            }, 500); // Wait 500ms after user stops typing
        });

        // Language filter
        $('#languageFilter').on('change', function() {
            filterReviews();
        });

        function filterReviews() {
            var search = $('#searchInput').val();
            var langCode = $('#languageFilter').val();

            console.log('Filter AJAX called:', {search, langCode, adminOnly: true});

            $.ajax({
                url: ROUTES.filter,
                type: 'GET',
                data: {
                    search: search,
                    lang_code: langCode,
                    adminOnly: true
                },
                success: function(response) {
                    console.log('Filter response:', response);
                    if (response.success) {
                        console.log('Updating table with', response.data.length, 'reviews');
                        updateTable(response.data);
                    }
                },
                error: function(xhr) {
                    console.error('Filter AJAX error:', xhr);
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
            var tbody = $('#reviewTableBody');
            tbody.empty();

            if (reviews.length === 0) {
                tbody.append('<tr><td colspan="11" class="text-center">Нет данных</td></tr>');
                return;
            }

            reviews.forEach(function(review, index) {
                var statusBadge = review.is_active ?
                    '<span class="badge badge-success">Активен</span>' :
                    '<span class="badge badge-danger">Неактивен</span>';

                var stars = '';
                for (var i = 1; i <= 5; i++) {
                    stars += (i <= review.rating) ?
                        '<i class="fas fa-star text-warning"></i>' :
                        '<i class="far fa-star text-warning"></i>';
                }

                var videoContent = review.video_url ?
                    '<a href="' + review.video_url + '" target="_blank" class="text-danger" title="Смотреть на YouTube">' +
                    '<i class="fab fa-youtube fa-2x"></i></a>' :
                    '<span class="text-muted">Нет видео</span>';

                var reviewLinkContent = review.review_url ?
                    '<a href="' + review.review_url + '" target="_blank" class="btn btn-sm btn-info" title="Перейти к отзыву">' +
                    '<i class="fas fa-external-link-alt"></i> Ссылка</a>' :
                    '<span class="text-muted">-</span>';

                var comment = review.comment && review.comment.length > 50 ?
                    review.comment.substring(0, 50) + '...' :
                    (review.comment || 'N/A');

                var row = '<tr>' +
                    '<td>' + (index + 1) + '</td>' +
                    '<td>' + review.user_name + '</td>' +
                    '<td>' + (review.city || 'N/A') + '</td>' +
                    '<td>' + (review.tour_name || 'N/A') + '</td>' +
                    '<td>' + stars + '</td>' +
                    '<td class="text-center">' + videoContent + '</td>' +
                    '<td class="text-center">' + reviewLinkContent + '</td>' +
                    '<td>' + comment + '</td>' +
                    '<td>' + review.sort_order + '</td>' +
                    '<td>' + statusBadge + '</td>' +
                    '<td style="white-space: nowrap;">' +
                    '<button class="btn btn-sm btn-info" onclick="showReview(' + review.id + ')" title="Просмотр">' +
                    '<i class="fas fa-eye"></i>' +
                    '</button> ' +
                    '<button class="btn btn-sm btn-primary" onclick="editReview(' + review.id + ')" title="Редактировать">' +
                    '<i class="fas fa-edit"></i>' +
                    '</button> ' +
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

    window.editReview = function(id) {
        $.ajax({
            url: ROUTES.translations.replace('{id}', id),
            type: 'GET',
            success: function(response) {
                if (response.success) {
                    $('#editForm').attr('action', ROUTES.destroy.replace('{id}', id));
                    $('#edit_tour_id').val(response.review.tour_id);
                    $('#edit_user_name').val(response.review.user_name);
                    $('#edit_rating').val(response.review.rating);
                    $('#edit_video_url').val(response.review.video_url);
                    $('#edit_review_url').val(response.review.review_url);
                    $('#edit_sort_order').val(response.review.sort_order);
                    $('#edit_is_active').prop('checked', response.review.is_active);

                    @foreach($languages as $language)
                    if (response.translations['{{ $language->code }}']) {
                        $('#edit_city_{{ $language->code }}').val(response.translations['{{ $language->code }}'].city);
                        $('#edit_comment_{{ $language->code }}').val(response.translations['{{ $language->code }}'].comment);
                    }
                    @endforeach

                    $('#editModal').modal('show');
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

    window.editBanner = function(id) {
        $.ajax({
            url: '/reviews/banner/' + id + '/translations',
            type: 'GET',
            success: function(response) {
                if (response.success) {
                    window.populateEditBannerModal(response);
                    $('#editBannerModal').modal('show');
                }
            },
            error: function(xhr) {
                swal({
                    title: 'Ошибка!',
                    text: 'Ошибка при загрузке данных баннера',
                    icon: 'error',
                    button: 'ОК',
                });
            }
        });
    };
</script>
@endpush