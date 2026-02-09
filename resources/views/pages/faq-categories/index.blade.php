@extends('layouts.main')

@section('content')
<div class="section-header">
    <h1>Категории FAQ</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fas fa-home"></i> Панель управления</a></div>
        <div class="breadcrumb-item active">Категории FAQ</div>
        <div class="breadcrumb-item">
            <button class="btn btn-warning rounded-pill" data-toggle="modal" data-target="#createModal">
                <i class="fas fa-plus"></i> Добавить категорию
            </button>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4>Список категорий FAQ</h4>
                <div class="card-header-action">
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
                    <table class="table table-striped" id="faqCategoryTable">
                        <thead>
                            <tr>
                                <th>№</th>
                                <th>Название</th>
                                <th>Порядок</th>
                                <th>Статус</th>
                                <th>Действия</th>
                            </tr>
                        </thead>
                        <tbody id="faqCategoryTableBody">
                            @foreach($faqCategories as $faqCategory)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $faqCategory->translations->where('lang_code', 'ru')->first()->name ?? $faqCategory->translations->first()->name ?? 'N/A' }}</td>
                                <td>{{ $faqCategory->sort_order }}</td>
                                <td>
                                    @if($faqCategory->is_active)
                                    <span class="badge badge-success">Активен</span>
                                    @else
                                    <span class="badge badge-danger">Неактивен</span>
                                    @endif
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-primary" onclick="editFaqCategory({{ $faqCategory->id }})">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <form action="{{ route('faq-categories.destroy', $faqCategory->id) }}" method="POST" style="display:inline-block;" data-confirm-delete data-item-name="категорию FAQ">
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
@include('pages.faq-categories.create-modal')
@include('pages.faq-categories.edit-modal')
@endpush

@push('scripts')
<script>
    // Routes - Prettier formatter won't break these
    const ROUTES = {
        filter: '{{ route("faq-categories.filter") }}',
        translations: '/faq-categories/{id}/translations',
        destroy: '/faq-categories/{id}'
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

        function updateTable(faqCategories) {
            var tbody = $('#faqCategoryTableBody');
            tbody.empty();

            if (faqCategories.length === 0) {
                tbody.append('<tr><td colspan="5" class="text-center">Нет данных</td></tr>');
                return;
            }

            faqCategories.forEach(function(faqCategory, index) {
                var statusBadge = faqCategory.is_active ?
                    '<span class="badge badge-success">Активен</span>' :
                    '<span class="badge badge-danger">Неактивен</span>';

                var row = '<tr>' +
                    '<td>' + (index + 1) + '</td>' +
                    '<td>' + faqCategory.name + '</td>' +
                    '<td>' + faqCategory.sort_order + '</td>' +
                    '<td>' + statusBadge + '</td>' +
                    '<td>' +
                    '<button class="btn btn-sm btn-primary" onclick="editFaqCategory(' + faqCategory.id + ')">' +
                    '<i class="fas fa-edit"></i>' +
                    '</button> ' +
                    '<form action="/faq-categories/' + faqCategory.id + '" method="POST" style="display:inline-block;" data-confirm-delete data-item-name="категорию FAQ">' +
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

    // Edit FAQ Category function
    function editFaqCategory(id) {
        $.ajax({
            url: ROUTES.translations.replace('{id}', id),
            type: 'GET',
            success: function(response) {
                if (response.success) {
                    $('#editForm').attr('action', ROUTES.destroy.replace('{id}', id));
                    $('#edit_sort_order').val(response.faqCategory.sort_order);
                    $('#edit_is_active').prop('checked', response.faqCategory.is_active);

                    // Fill translations for each language
                    @foreach($languages as $language)
                    if (response.translations['{{ $language->code }}']) {
                        $('#edit_name_{{ $language->code }}').val(response.translations['{{ $language->code }}'].name);
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
