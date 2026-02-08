@extends('layouts.main')

@section('content')
<div class="section-header">
    <h1>Часто задаваемые вопросы</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fas fa-home"></i> Панель управления</a></div>
        <div class="breadcrumb-item active">Часто задаваемые вопросы</div>
        <div class="breadcrumb-item">
            <button class="btn btn-warning rounded-pill" data-toggle="modal" data-target="#createModal">
                <i class="fas fa-plus"></i> Добавить вопрос
            </button>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4>Список вопросов</h4>
                <div class="card-header-action d-flex align-items-center" style="gap: 10px;">
                    <!-- Search Input -->
                    <input type="text" class="form-control" id="searchInput" placeholder="Поиск по вопросу..." style="width: 250px;">

                    <!-- Language Filter -->
                    <select class="form-control" id="languageFilter" style="width: 150px;">
                        @foreach($languages as $language)
                        <option value="{{ $language->code }}" {{ $language->code == 'en' ? 'selected' : '' }}>
                            {{ $language->name }}
                        </option>
                        @endforeach
                    </select>

                    <!-- Category Filter -->
                    <select class="form-control" id="categoryFilter" style="width: 180px;">
                        <option value="">Все категории</option>
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->translations->where('lang_code', 'ru')->first()->name ?? $category->translations->first()->name ?? 'N/A' }}</option>
                        @endforeach
                    </select>

                    <!-- Tour Filter -->
                    <select class="form-control" id="tourFilter" style="width: 200px;">
                        <option value="">Все туры</option>
                        @foreach($tours as $tour)
                        <option value="{{ $tour->id }}">{{ $tour->translations->where('lang_code', 'ru')->first()->title ?? $tour->translations->first()->title }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="faqTable">
                        <thead>
                            <tr>
                                <th>№</th>
                                <th>Вопрос</th>
                                <th>Тур</th>
                                <th>Категория</th>
                                <th>Ответ</th>
                                <th>Порядок</th>
                                <th>Статус</th>
                                <th>Действия</th>
                            </tr>
                        </thead>
                        <tbody id="faqTableBody">
                            @foreach($faqs as $faq)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $faq->translations->first()->question ?? 'N/A' }}</td>
                                <td>
                                    @if($faq->tour)
                                    <span class="badge badge-info">{{ $faq->tour->translations->first()->title ?? 'N/A' }}</span>
                                    @else
                                    <span class="badge badge-secondary">Общий</span>
                                    @endif
                                </td>
                                <td>
                                    @if($faq->category)
                                    <span class="badge badge-primary">
                                        {{ $faq->category->translations->first()->name ?? 'N/A' }}
                                    </span>
                                    @else
                                    <span class="badge badge-secondary">Без категории</span>
                                    @endif
                                </td>
                                <td>{{ Str::limit($faq->translations->first()->answer ?? 'N/A', 50) }}</td>
                                <td>{{ $faq->sort_order }}</td>
                                <td>
                                    @if($faq->is_active)
                                    <span class="badge badge-success">Активен</span>
                                    @else
                                    <span class="badge badge-danger">Неактивен</span>
                                    @endif
                                </td>
                                <td style="white-space: nowrap;">
                                    <button class="btn btn-sm btn-primary" onclick="editFaq({{ $faq->id }})">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <form action="{{ route('faqs.destroy', $faq->id) }}" method="POST" style="display:inline-block;" data-confirm-delete data-item-name="вопрос">
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
                {{ $faqs->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@push('modals')
@include('pages.faqs.create-modal')
@include('pages.faqs.edit-modal')
@endpush

@push('scripts')
<script>
    // Routes - Prettier formatter won't break these
    const ROUTES = {
        filter: '{{ route("faqs.filter") }}',
        translations: '/faqs/{id}/translations',
        destroy: '/faqs/{id}'
    };

    $(document).ready(function() {
        let searchTimeout;

        // Search input with debounce
        $('#searchInput').on('keyup', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(function() {
                filterFaqs();
            }, 500); // Wait 500ms after user stops typing
        });

        // Language filter
        $('#languageFilter').on('change', function() {
            filterFaqs();
        });

        // Category filter
        $('#categoryFilter').on('change', function() {
            filterFaqs();
        });

        // Tour filter
        $('#tourFilter').on('change', function() {
            filterFaqs();
        });

        function filterFaqs() {
            var search = $('#searchInput').val();
            var langCode = $('#languageFilter').val();
            var categoryId = $('#categoryFilter').val();
            var tourId = $('#tourFilter').val();

            $.ajax({
                url: ROUTES.filter,
                type: 'GET',
                data: {
                    search: search,
                    lang_code: langCode,
                    category_id: categoryId,
                    tour_id: tourId
                },
                success: function(response) {
                    if (response.success) {
                        updateTable(response.data);
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

        function updateTable(faqs) {
            var tbody = $('#faqTableBody');
            tbody.empty();

            if (faqs.length === 0) {
                tbody.append('<tr><td colspan="8" class="text-center">Нет данных</td></tr>');
                return;
            }

            // faq ning yoniga "index" parametrini qo'shamiz
            faqs.forEach(function(faq, index) {
                var statusBadge = faq.is_active ?
                    '<span class="badge badge-success">Активен</span>' :
                    '<span class="badge badge-danger">Неактивен</span>';

                var tourBadge = faq.tour_title ?
                    '<span class="badge badge-info">' + faq.tour_title + '</span>' :
                    '<span class="badge badge-secondary">Общий</span>';

                var categoryBadge = faq.category_name ?
                    '<span class="badge badge-primary">' + faq.category_name + '</span>' :
                    '<span class="badge badge-secondary">Без категории</span>';

                var answer = faq.answer.length > 50 ? faq.answer.substring(0, 50) + '...' : faq.answer;

                var row = '<tr>' +
                    '<td>' + (index + 1) + '</td>' +
                    '<td>' + faq.question + '</td>' +
                    '<td>' + tourBadge + '</td>' +
                    '<td>' + categoryBadge + '</td>' +
                    '<td>' + answer + '</td>' +
                    '<td>' + faq.sort_order + '</td>' +
                    '<td>' + statusBadge + '</td>' +
                    '<td style="white-space: nowrap;">' +
                    '<button class="btn btn-sm btn-primary" onclick="editFaq(' + faq.id + ')">' +
                    '<i class="fas fa-edit"></i>' +
                    '</button> ' +
                    '<form action="/faqs/' + faq.id + '" method="POST" style="display:inline-block;" data-confirm-delete data-item-name="вопрос">' +
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

    // Edit FAQ function
    function editFaq(id) {
        $.ajax({
            url: ROUTES.translations.replace('{id}', id),
            type: 'GET',
            success: function(response) {
                if (response.success) {
                    $('#editForm').attr('action', ROUTES.destroy.replace('{id}', id));
                    $('#edit_tour_id').val(response.faq.tour_id || '');
                    $('#edit_faq_category_id').val(response.faq.faq_category_id || '');
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
            error: function(xhr) {
                swal({
                    title: 'Ошибка!',
                    text: 'Ошибка при загрузке данных',
                    icon: 'error',
                    button: 'ОК',
                });
            }
        });
    }
</script>
@endpush