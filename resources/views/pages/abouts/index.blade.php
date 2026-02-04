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
                    <div class="col-md-4">
                        <img src="{{ asset('storage/' . $banner->image) }}" class="img-fluid rounded" alt="Banner">
                    </div>
                    <div class="col-md-8">
                        <h5>Заголовки баннера:</h5>
                        <ul class="list-group">
                            @foreach($banner->translations as $translation)
                            <li class="list-group-item d-flex justify-content-between">
                                <span><strong>{{ strtoupper($translation->lang_code) }}:</strong> {{ $translation->title }}</span>
                            </li>
                            @endforeach
                        </ul>
                        <div class="mt-3">
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
                        @foreach($about->images->sortBy('sort_order') as $image)
                        <div class="col-md-3 mb-3">
                            <img src="{{ asset('storage/' . $image->image_path) }}" class="img-fluid rounded mb-2" alt="Image" style="height: 200px; width: 100%; object-fit: cover;">
                            <div class="text-center">
                                <span class="badge badge-primary">Порядок: {{ $image->sort_order + 1 }}</span>
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
@endsection

@push('modals')
@include('pages.abouts.banner-create-modal')
@include('pages.abouts.banner-edit-modal')
@include('pages.abouts.create-modal')
@include('pages.abouts.edit-modal')
@endpush

@push('scripts')
<script>
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

    function editBanner(id) {
        $.ajax({
            url: '/abouts/banner/' + id + '/translations',
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
    }
</script>
@endpush