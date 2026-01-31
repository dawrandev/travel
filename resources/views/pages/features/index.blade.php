@extends('layouts.main')

@section('content')
<div class="section-header">
    <h1>Функции</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fas fa-home"></i> Панель управления</a></div>
        <div class="breadcrumb-item active">Функции</div>
        <div class="breadcrumb-item">
            <button class="btn btn-warning rounded-pill" data-toggle="modal" data-target="#createModal">
                <i class="fas fa-plus"></i> Добавить функцию
            </button>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4>Список функций</h4>
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
                    <table class="table table-striped" id="featureTable">
                        <thead>
                            <tr>
                                <th>№</th>
                                <th>Иконка</th>
                                <th>Название</th>
                                <th>Описание</th>
                                <th>Действия</th>
                            </tr>
                        </thead>
                        <tbody id="featureTableBody">
                            @foreach($features as $feature)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <div style="font-size: 24px; color: #6777ef;">
                                        <i class="{{ $feature->icon }}"></i>
                                    </div>
                                </td>
                                <td>{{ $feature->translations->first()->name ?? 'N/A' }}</td>
                                <td>{{ Str::limit($feature->translations->first()->description ?? 'N/A', 60) }}</td>
                                <td>
                                    <button class="btn btn-sm btn-primary" onclick="editFeature({{ $feature->id }})">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <form action="{{ route('features.destroy', $feature->id) }}" method="POST" style="display:inline-block;" data-confirm-delete data-item-name="функцию">
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
@include('pages.features.create-modal')
@include('pages.features.edit-modal')
@endpush

@push('scripts')
<script>
    // Routes - Prettier formatter won't break these
    const ROUTES = {
        filter: '{{ route("features.filter") }}',
        translations: '/features/{id}/translations',
        destroy: '/features/{id}'
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

        function updateTable(features) {
            var tbody = $('#featureTableBody');
            tbody.empty();

            if (features.length === 0) {
                tbody.append('<tr><td colspan="5" class="text-center">Нет данных</td></tr>');
                return;
            }

            features.forEach(function(feature, index) {
                var description = feature.description.length > 60 ? feature.description.substring(0, 60) + '...' : feature.description;

                var row = '<tr>' +
                    '<td>' + (index + 1) + '</td>' +
                    '<td><div style="font-size: 24px; color: #6777ef;"><i class="' + feature.icon + '"></i></div></td>' +
                    '<td>' + feature.name + '</td>' +
                    '<td>' + description + '</td>' +
                    '<td>' +
                    '<button class="btn btn-sm btn-primary" onclick="editFeature(' + feature.id + ')">' +
                    '<i class="fas fa-edit"></i>' +
                    '</button> ' +
                    '<form action="/features/' + feature.id + '" method="POST" style="display:inline-block;" data-confirm-delete data-item-name="функцию">' +
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

    // Edit Feature function
    function editFeature(id) {
        $.ajax({
            url: ROUTES.translations.replace('{id}', id),
            type: 'GET',
            success: function(response) {
                if (response.success) {
                    $('#editForm').attr('action', ROUTES.destroy.replace('{id}', id));
                    $('#edit_icon').val(response.feature.icon);
                    $('#edit_icon_preview').html('<i class="' + response.feature.icon + '"></i>');

                    // Fill translations for each language
                    @foreach($languages as $language)
                    if (response.translations['{{ $language->code }}']) {
                        $('#edit_name_{{ $language->code }}').val(response.translations['{{ $language->code }}'].name);
                        $('#edit_description_{{ $language->code }}').val(response.translations['{{ $language->code }}'].description);
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