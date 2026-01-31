@extends('layouts.main')

@section('content')
<div class="section-header">
    <h1>Слайды Баннера</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fas fa-home"></i> Панель управления</a></div>
        <div class="breadcrumb-item active">Слайды Баннера</div>
        <div class="breadcrumb-item">
            <button class="btn btn-warning rounded-pill" data-toggle="modal" data-target="#createModal">
                <i class="fas fa-plus"></i> Добавить слайд
            </button>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4>Список слайдов</h4>
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
                    <table class="table table-striped" id="heroSlideTable">
                        <thead>
                            <tr>
                                <th>№</th>
                                <th>Изображение</th>
                                <th>Заголовок</th>
                                <th>Подзаголовок</th>
                                <th>Порядок</th>
                                <th>Статус</th>
                                <th>Действия</th>
                            </tr>
                        </thead>
                        <tbody id="heroSlideTableBody">
                            @foreach($heroSlides as $slide)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <img src="{{ asset('storage/' . $slide->image_path) }}" alt="slide" width="100">
                                </td>
                                <td>{{ $slide->translations->first()->title ?? 'N/A' }}</td>
                                <td>{{ $slide->translations->first()->subtitle ?? 'N/A' }}</td>
                                <td>{{ $slide->sort_order }}</td>
                                <td>
                                    @if($slide->is_active)
                                    <span class="badge badge-success">Активен</span>
                                    @else
                                    <span class="badge badge-danger">Неактивен</span>
                                    @endif
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-primary" onclick="editSlide({{ $slide->id }})">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <form action="{{ route('hero-slides.destroy', $slide->id) }}" method="POST" style="display:inline-block;" data-confirm-delete data-item-name="слайд">
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
@include('pages.hero-slides.create-modal')
@include('pages.hero-slides.edit-modal')
@endpush

@push('scripts')
<script>
    // Routes - Prettier formatter won't break these
    const ROUTES = {
        filter: '{{ route("hero-slides.filter") }}',
        translations: '/hero-slides/{id}/translations',
        destroy: '/hero-slides/{id}'
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
        $('#slide_image_edit').on('change', function(e) {
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

        function updateTable(slides) {
            var tbody = $('#heroSlideTableBody');
            tbody.empty();

            if (slides.length === 0) {
                tbody.append('<tr><td colspan="7" class="text-center">Нет данных</td></tr>');
                return;
            }

            slides.forEach(function(slide) {
                var statusBadge = slide.is_active ?
                    '<span class="badge badge-success">Активен</span>' :
                    '<span class="badge badge-danger">Неактивен</span>';

                var row = '<tr>' +
                    '<td>' + slide.id + '</td>' +
                    '<td><img src="/storage/' + slide.image_path + '" alt="slide" width="100"></td>' +
                    '<td>' + slide.title + '</td>' +
                    '<td>' + slide.subtitle + '</td>' +
                    '<td>' + slide.sort_order + '</td>' +
                    '<td>' + statusBadge + '</td>' +
                    '<td>' +
                    '<button class="btn btn-sm btn-primary" onclick="editSlide(' + slide.id + ')">' +
                    '<i class="fas fa-edit"></i>' +
                    '</button> ' +
                    '<form action="/hero-slides/' + slide.id + '" method="POST" style="display:inline-block;" data-confirm-delete data-item-name="слайд">' +
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

    // Edit Slide function
    function editSlide(id) {
        $.ajax({
            url: ROUTES.translations.replace('{id}', id),
            type: 'GET',
            success: function(response) {
                if (response.success) {
                    $('#editSlideForm').attr('action', ROUTES.destroy.replace('{id}', id));
                    $('#edit_slide_sort_order').val(response.slide.sort_order);
                    $('#edit_slide_is_active').prop('checked', response.slide.is_active);
                    $('#slide_image_edit').next('.custom-file-label').text('Выберите изображение');

                    // Fill translations for each language
                    @foreach($languages as $language)
                    if (response.translations['{{ $language->code }}']) {
                        $('#edit_title_{{ $language->code }}').val(response.translations['{{ $language->code }}'].title);
                        $('#edit_subtitle_{{ $language->code }}').val(response.translations['{{ $language->code }}'].subtitle);
                    }
                    @endforeach

                    $('#editSlideModal').modal('show');
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