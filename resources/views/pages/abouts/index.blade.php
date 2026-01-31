@extends('layouts.main')

@section('content')
<div class="section-header">
    <h1>О нас</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fas fa-home"></i> Панель управления</a></div>
        <div class="breadcrumb-item active">О нас</div>
        <div class="breadcrumb-item">
            <button class="btn btn-warning rounded-pill" data-toggle="modal" data-target="#createModal">
                <i class="fas fa-plus"></i> Добавить запись
            </button>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4>Список записей</h4>
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
                    <table class="table table-striped" id="aboutTable">
                        <thead>
                            <tr>
                                <th>№</th>
                                <th>Изображение</th>
                                <th>Заголовок</th>
                                <th>Описание</th>
                                <th>Статус</th>
                                <th>Действия</th>
                            </tr>
                        </thead>
                        <tbody id="aboutTableBody">
                            @foreach($abouts as $about)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    @if($about->image)
                                    <img src="{{ asset('storage/' . $about->image) }}" alt="about" width="100">
                                    @else
                                    <span class="badge badge-secondary">Нет изображения</span>
                                    @endif
                                </td>
                                <td>{{ $about->translations->first()->title ?? 'N/A' }}</td>
                                <td>{{ Str::limit($about->translations->first()->description ?? 'N/A', 50) }}</td>
                                <td>
                                    @if($about->is_active)
                                    <span class="badge badge-success">Активен</span>
                                    @else
                                    <span class="badge badge-danger">Неактивен</span>
                                    @endif
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-primary" onclick="editAbout({{ $about->id }})">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <form action="{{ route('abouts.destroy', $about->id) }}" method="POST" style="display:inline-block;" data-confirm-delete data-item-name="запись">
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
@include('pages.abouts.create-modal')
@include('pages.abouts.edit-modal')
@endpush

@push('scripts')
<script>
    // Routes - Prettier formatter won't break these
    const ROUTES = {
        filter: '{{ route("abouts.filter") }}',
        translations: '/abouts/{id}/translations',
        destroy: '/abouts/{id}'
    };

    $(document).ready(function() {
        // Image file input change handler for create modal
        $('#image_create').on('change', function(e) {
            if (e.target.files.length > 0) {
                var fileName = e.target.files[0].name;
                $(this).next('.custom-file-label').text(fileName);
            }
        });

        // Image file input change handler for edit modal
        $('#about_image_edit').on('change', function(e) {
            if (e.target.files.length > 0) {
                var fileName = e.target.files[0].name;
                $(this).next('.custom-file-label').text(fileName);
            }
        });

        // Language filter
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

        function updateTable(abouts) {
            var tbody = $('#aboutTableBody');
            tbody.empty();

            if (abouts.length === 0) {
                tbody.append('<tr><td colspan="6" class="text-center">Нет данных</td></tr>');
                return;
            }

            abouts.forEach(function(about) {
                var statusBadge = about.is_active ?
                    '<span class="badge badge-success">Активен</span>' :
                    '<span class="badge badge-danger">Неактивен</span>';

                var description = about.description.length > 50 ? about.description.substring(0, 50) + '...' : about.description;

                var imageCell = about.image ?
                    '<img src="/storage/' + about.image + '" alt="about" width="100">' :
                    '<span class="badge badge-secondary">Нет изображения</span>';

                var row = '<tr>' +
                    '<td>' + about.id + '</td>' +
                    '<td>' + imageCell + '</td>' +
                    '<td>' + about.title + '</td>' +
                    '<td>' + description + '</td>' +
                    '<td>' + statusBadge + '</td>' +
                    '<td>' +
                    '<button class="btn btn-sm btn-primary" onclick="editAbout(' + about.id + ')">' +
                    '<i class="fas fa-edit"></i>' +
                    '</button> ' +
                    '<form action="/abouts/' + about.id + '" method="POST" style="display:inline-block;" data-confirm-delete data-item-name="запись">' +
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

    // Edit About function
    function editAbout(id) {
        $.ajax({
            url: ROUTES.translations.replace('{id}', id),
            type: 'GET',
            success: function(response) {
                if (response.success) {
                    $('#editAboutForm').attr('action', ROUTES.destroy.replace('{id}', id));
                    $('#edit_about_is_active').prop('checked', response.about.is_active);
                    $('#about_image_edit').next('.custom-file-label').text('Выберите изображение');

                    // Fill translations for each language
                    @foreach($languages as $language)
                    if (response.translations['{{ $language->code }}']) {
                        $('#edit_title_{{ $language->code }}').val(response.translations['{{ $language->code }}'].title);
                        $('#edit_description_{{ $language->code }}').val(response.translations['{{ $language->code }}'].description);
                    }
                    @endforeach

                    $('#editAboutModal').modal('show');
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