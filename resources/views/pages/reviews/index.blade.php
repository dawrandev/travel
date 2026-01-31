@extends('layouts.main')

@section('content')
<div class="section-header">
    <h1>Отзывы</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fas fa-home"></i> Панель управления</a></div>
        <div class="breadcrumb-item active">Отзывы</div>
        <div class="breadcrumb-item">
            <button class="btn btn-warning rounded-pill" data-toggle="modal" data-target="#createModal">
                <i class="fas fa-plus"></i> Добавить отзыв
            </button>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4>Список отзывов</h4>
                <div class="card-header-action">
                    <select class="form-control" id="languageFilter" style="width: 150px;">
                        @foreach($languages as $language)
                        <option value="{{ $language->code }}" {{ $language->code == 'en' ? 'selected' : '' }}>
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
                                <td>{{ $review->translations->first()->city ?? 'N/A' }}</td>
                                <td>{{ $review->tour->translations->first()->title ?? 'N/A' }}</td>
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

                                <td>{{ Str::limit($review->translations->first()->comment ?? 'N/A', 50) }}</td>
                                <td>{{ $review->sort_order }}</td>
                                <td>
                                    @if($review->is_active)
                                    <span class="badge badge-success">Активен</span>
                                    @else
                                    <span class="badge badge-danger">Неактивен</span>
                                    @endif
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-primary" onclick="editReview({{ $review->id }})">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <form action="{{ route('reviews.destroy', $review->id) }}" method="POST" style="display:inline-block;" data-confirm-delete data-item-name="отзыв">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
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
@include('pages.reviews.create-modal')
@include('pages.reviews.edit-modal')
@endpush

@push('scripts')
<script>
    const ROUTES = {
        filter: '{{ route("reviews.filter") }}',
        translations: '/reviews/{id}/translations',
        destroy: '/reviews/{id}'
    };

    $(document).ready(function() {
        $('#languageFilter').on('change', function() {
            var langCode = $(this).val();

            $.ajax({
                url: ROUTES.filter,
                type: 'GET',
                data: {
                    lang_code: langCode
                },
                success: function(response) {
                    if (response.success) {
                        updateTable(response.data);
                    }
                },
                error: function() {
                    alert('Ошибка при загрузке данных');
                }
            });
        });

        function updateTable(reviews) {
            var tbody = $('#reviewTableBody');
            tbody.empty();

            if (reviews.length === 0) {
                tbody.append('<tr><td colspan="10" class="text-center">Нет данных</td></tr>');
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
                    '<td>' + comment + '</td>' +
                    '<td>' + review.sort_order + '</td>' +
                    '<td>' + statusBadge + '</td>' +
                    '<td>' +
                    '<button class="btn btn-sm btn-primary" onclick="editReview(' + review.id + ')">' +
                    '<i class="fas fa-edit"></i>' +
                    '</button> ' +
                    '<form action="/reviews/' + review.id + '" method="POST" style="display:inline-block;" data-confirm-delete data-item-name="отзыв">' +
                    '@csrf @method("DELETE")' +
                    '<button type="submit" class="btn btn-sm btn-danger">' +
                    '<i class="fas fa-trash"></i>' +
                    '</button>' +
                    '</form>' +
                    '</td>' +
                    '</tr>';

                tbody.append(row);
            });
        }
    });

    function editReview(id) {
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
    }
</script>
@endpush