@extends('layouts.main')

@section('content')
<div class="section-header">
    <h1>Категории</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fas fa-home"></i> Панель управления</a></div>
        <div class="breadcrumb-item active">Категории</div>
        <div class="breadcrumb-item">
            <button class="btn btn-warning rounded-pill" data-toggle="modal" data-target="#createModal">
                <i class="fas fa-plus"></i> Добавить категорию
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
                    <button class="btn btn-primary" data-banner-id="{{ $banner->id }}" id="editBannerBtn">
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
                                        data-lightbox="category-banner-gallery"
                                        data-title="Категории Баннер - Изображение {{ $index + 1 }}">
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
                    <p class="text-muted">Создайте баннер для страницы "Категории"</p>
                    <button class="btn btn-success" data-toggle="modal" data-target="#createBannerModal">
                        <i class="fas fa-plus"></i> Создать баннер
                    </button>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4>Список категорий</h4>
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
                    <table class="table table-striped" id="categoryTable">
                        <thead>
                            <tr>
                                <th>№</th>
                                <th>Название</th>
                                <th>Порядок</th>
                                <th>Статус</th>
                                <th>Действия</th>
                            </tr>
                        </thead>
                        <tbody id="categoryTableBody">
                            @foreach($categories as $category)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $category->translations->where('lang_code', 'ru')->first()->name ?? $category->translations->first()->name ?? 'N/A' }}</td>
                                <td>{{ $category->sort_order }}</td>
                                <td>
                                    @if($category->is_active)
                                    <span class="badge badge-success">Активен</span>
                                    @else
                                    <span class="badge badge-danger">Неактивен</span>
                                    @endif
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-primary" onclick="editCategory({{ $category->id }})">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <form action="{{ route('categories.destroy', $category->id) }}" method="POST" style="display:inline-block;" data-confirm-delete data-item-name="категорию">
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
@include('pages.categories.banner-create-modal')
@include('pages.categories.banner-edit-modal')
@include('pages.categories.create-modal')
@include('pages.categories.edit-modal')
@endpush

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/css/lightbox.min.css" type="text/css">
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/js/lightbox.min.js"></script>
<script>
    // Routes - Prettier formatter won't break these
    const ROUTES = {
        filter: '{{ route("categories.filter") }}',
        translations: '/categories/{id}/translations',
        bannerTranslations: '{{ route("categories.banner.translations", ["id" => "BANNER_ID"]) }}',
        destroy: '/categories/{id}'
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

        function updateTable(categories) {
            var tbody = $('#categoryTableBody');
            tbody.empty();

            if (categories.length === 0) {
                tbody.append('<tr><td colspan="5" class="text-center">Нет данных</td></tr>');
                return;
            }

            categories.forEach(function(category, index) {
                var statusBadge = category.is_active ?
                    '<span class="badge badge-success">Активен</span>' :
                    '<span class="badge badge-danger">Неактивен</span>';

                var row = '<tr>' +
                    '<td>' + (index + 1) + '</td>' +
                    '<td>' + category.name + '</td>' +
                    '<td>' + category.sort_order + '</td>' +
                    '<td>' + statusBadge + '</td>' +
                    '<td>' +
                    '<button class="btn btn-sm btn-primary" onclick="editCategory(' + category.id + ')">' +
                    '<i class="fas fa-edit"></i>' +
                    '</button> ' +
                    '<form action="/categories/' + category.id + '" method="POST" style="display:inline-block;" data-confirm-delete data-item-name="категорию">' +
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

    // Edit Category function
    function editCategory(id) {
        $.ajax({
            url: ROUTES.translations.replace('{id}', id),
            type: 'GET',
            success: function(response) {
                if (response.success) {
                    $('#editForm').attr('action', ROUTES.destroy.replace('{id}', id));
                    $('#edit_sort_order').val(response.category.sort_order);
                    $('#edit_is_active').prop('checked', response.category.is_active);

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

    // Edit Banner
    $('#editBannerBtn').on('click', function() {
        const bannerId = $(this).data('banner-id');
        const url = ROUTES.bannerTranslations.replace('BANNER_ID', bannerId);

        $.ajax({
            url: url,
            type: 'GET',
            success: function(response) {
                if (response.success) {
                    populateEditBannerModal(response);
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
    });
</script>
@endpush