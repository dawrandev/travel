@extends('layouts.main')

@section('content')
<div class="section-header">
    <h1>О нас</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fas fa-home"></i> Панель управления</a></div>
        <div class="breadcrumb-item active">О нас</div>
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

<!-- About Content Section -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4><i class="fas fa-info-circle"></i> Основной контент "О нас"</h4>
                <div class="card-header-action">
                    @if($about)
                    <button class="btn btn-primary" onclick="editAbout({{ $about->id }})">
                        <i class="fas fa-edit"></i> Редактировать
                    </button>
                    @else
                    <button class="btn btn-success" data-toggle="modal" data-target="#createModal">
                        <i class="fas fa-plus"></i> Создать контент
                    </button>
                    @endif
                </div>
            </div>
            <div class="card-body">
                @if($about)
                <!-- Translations -->
                <div class="mb-4">
                    <h5><i class="fas fa-language"></i> Переводы:</h5>
                    <div class="list-group">
                        @foreach($about->translations as $translation)
                        <div class="list-group-item">
                            <h6 class="mb-2"><strong>{{ strtoupper($translation->lang_code) }}:</strong> {{ $translation->title }}</h6>
                            <p class="mb-0">{{ $translation->description }}</p>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Images Gallery -->
                <div class="mb-4">
                    <h5><i class="fas fa-images"></i> Галерея ({{ $about->images->count() }} изображений):</h5>
                    <div class="row">
                        @foreach($about->images->sortBy('sort_order') as $index => $image)
                        <div class="col-md-4 mb-3">
                            <div class="position-relative image-wrapper">
                                <a href="{{ asset('storage/' . $image->image_path) }}"
                                    data-lightbox="about-gallery"
                                    data-title="О нас - Изображение {{ $index + 1 }}">
                                    <img src="{{ asset('storage/' . $image->image_path) }}"
                                        class="img-fluid rounded shadow-sm"
                                        alt="About Image {{ $index + 1 }}"
                                        style="width: 100%; height: 200px; object-fit: cover; cursor: pointer; transition: transform 0.3s ease;">
                                </a>
                                <span class="badge badge-primary position-absolute" style="top: 10px; right: 10px;">
                                    {{ $index + 1 }}
                                </span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Status -->
                <div>
                    <h5><i class="fas fa-toggle-on"></i> Статус:</h5>
                    <span class="badge badge-{{ $about->is_active ? 'success' : 'danger' }} badge-lg">
                        {{ $about->is_active ? 'Активен' : 'Неактивен' }}
                    </span>
                </div>
                @else
                <div class="text-center py-5">
                    <div class="mb-3">
                        <i class="fas fa-info-circle fa-3x text-info"></i>
                    </div>
                    <h5>Контент не создан</h5>
                    <p class="text-muted">Создайте основной контент для страницы "О нас"</p>
                    <button class="btn btn-success" data-toggle="modal" data-target="#createModal">
                        <i class="fas fa-plus"></i> Создать контент
                    </button>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
<!-- Award Section -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4><i class="fas fa-trophy"></i> Награда</h4>
                <div class="card-header-action">
                    @if($about)
                        @if($about->award)
                        <button class="btn btn-primary" onclick="editAward({{ $about->id }}, {{ $about->award->id }})">
                            <i class="fas fa-edit"></i> Редактировать награду
                        </button>
                        @else
                        <button class="btn btn-success" data-toggle="modal" data-target="#createAwardModal">
                            <i class="fas fa-plus"></i> Добавить награду
                        </button>
                        @endif
                    @endif
                </div>
            </div>
            <div class="card-body">
                @if(!$about)
                <div class="text-center py-5">
                    <i class="fas fa-info-circle fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Сначала создайте основной контент "О нас"</h5>
                </div>
                @elseif($about->award)
                <div class="row">
                    <div class="col-md-4">
                        <h6 class="mb-3"><i class="fas fa-image"></i> Изображения ({{ $about->award->images->count() }})</h6>
                        @if($about->award->images->count())
                        <div class="row">
                            @foreach($about->award->images->sortBy('sort_order') as $index => $awardImage)
                            <div class="col-6 mb-3">
                                <div class="position-relative image-wrapper">
                                    <a href="{{ asset('storage/' . $awardImage->image_path) }}"
                                       data-lightbox="award-gallery"
                                       data-title="Award - {{ $index + 1 }}">
                                        <img src="{{ asset('storage/' . $awardImage->image_path) }}"
                                             class="img-fluid rounded shadow-sm"
                                             alt="Award Image {{ $index + 1 }}"
                                             style="width: 100%; height: 150px; object-fit: cover; cursor: pointer; transition: transform 0.3s ease;">
                                    </a>
                                    <span class="badge badge-primary position-absolute" style="top: 5px; right: 5px;">
                                        {{ $index + 1 }}
                                    </span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @else
                            <p class="text-muted">Нет изображений</p>
                        @endif
                    </div>
                    <div class="col-md-8">
                        <h6 class="mb-3"><i class="fas fa-language"></i> Описания</h6>
                        <div class="list-group mb-3">
                            @foreach($about->award->translations as $translation)
                            <div class="list-group-item">
                                <span class="badge badge-info mr-2">{{ strtoupper($translation->lang_code) }}</span>
                                {{ $translation->description }}
                            </div>
                            @endforeach
                        </div>
                        <h6><i class="fas fa-toggle-on"></i> Статус</h6>
                        <span class="badge badge-{{ $about->award->is_active ? 'success' : 'danger' }} badge-lg">
                            {{ $about->award->is_active ? 'Активен' : 'Неактивен' }}
                        </span>
                    </div>
                </div>
                @else
                <div class="text-center py-5">
                    <div class="mb-3">
                        <i class="fas fa-trophy fa-3x text-warning"></i>
                    </div>
                    <h5>Награда не добавлена</h5>
                    <p class="text-muted">Добавьте награду для страницы "О нас"</p>
                    <button class="btn btn-success" data-toggle="modal" data-target="#createAwardModal">
                        <i class="fas fa-plus"></i> Добавить награду
                    </button>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('modals')
@include('pages.abouts.banner-create-modal')
@include('pages.abouts.banner-edit-modal')
@include('pages.abouts.create-modal')
@include('pages.abouts.edit-modal')
@include('pages.abouts.award-create-modal')
@include('pages.abouts.award-edit-modal')
@endpush

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css">
<style>
    .image-wrapper:hover img {
        transform: scale(1.05);
    }

    .lightbox .lb-image {
        border-radius: 8px;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
<script>
    // Lightbox settings
    lightbox.option({
        'resizeDuration': 200,
        'wrapAround': true,
        'albumLabel': 'Изображение %1 из %2'
    });

    function editAbout(id) {
        $.ajax({
            url: '/abouts/' + id + '/translations',
            type: 'GET',
            success: function(response) {
                if (response.success) {
                    populateEditAboutModal(response);
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

    window.editBanner = function(id) {
        $.ajax({
            url: '/abouts/banner/' + id + '/translations',
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