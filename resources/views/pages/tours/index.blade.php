@extends('layouts.main')

@section('content')
<div class="section-header">
    <h1>Туры</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fas fa-home"></i> Панель управления</a></div>
        <div class="breadcrumb-item active">Туры</div>
        <div class="breadcrumb-item">
            <button class="btn btn-warning rounded-pill" data-toggle="modal" data-target="#createModal">
                <i class="fas fa-plus"></i> Добавить тур
            </button>
        </div>
    </div>
</div>

<!-- Categories Filter -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body text-center">
                <button class="btn btn-outline-primary m-1 category-filter active" data-category="">
                    Все категории
                </button>
                @foreach($categories as $category)
                <button class="btn btn-outline-primary m-1 category-filter" data-category="{{ $category->id }}">
                    {{ $category->translations->where('lang_code', 'ru')->first()->name ?? $category->translations->first()->name ?? 'N/A' }}
                </button>
                @endforeach
            </div>
        </div>
    </div>
</div>

<!-- Tours Grid -->
<div class="row" id="toursGrid">
    @forelse($tours as $tour)
    <div class="col-lg-4 col-md-6 col-12 mb-4 tour-card" data-category="{{ $tour->category_id }}">
        <div class="card card-primary">
            <div class="card-img-top" style="height: 200px; overflow: hidden; position: relative;">
                @php
                    $mainImage = $tour->images->where('is_main', true)->first() ?? $tour->images->first();
                @endphp
                @if($mainImage)
                <img src="{{ asset('storage/' . $mainImage->image_path) }}" alt="{{ $tour->translations->first()->title ?? '' }}" style="width: 100%; height: 100%; object-fit: cover;">
                @else
                <div style="width: 100%; height: 100%; background: #f0f0f0; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-image fa-3x text-muted"></i>
                </div>
                @endif
                <div style="position: absolute; top: 10px; right: 10px;">
                    <span class="badge badge-{{ $tour->is_active ? 'success' : 'danger' }}">
                        {{ $tour->is_active ? 'Активен' : 'Неактивен' }}
                    </span>
                </div>
            </div>
            <div class="card-body">
                <h5 class="card-title">{{ $tour->translations->where('lang_code', 'ru')->first()->title ?? $tour->translations->first()->title ?? 'N/A' }}</h5>
                <p class="text-muted mb-2">
                    <i class="fas fa-tag"></i> {{ $tour->category->translations->where('lang_code', 'ru')->first()->name ?? $tour->category->translations->first()->name ?? 'N/A' }}
                </p>
                <p class="text-muted mb-2">
                    <i class="fas fa-clock"></i> {{ $tour->duration_days }} дней / {{ $tour->duration_nights }} ночей
                </p>
                <p class="text-primary mb-2">
                    <strong><i class="fas fa-money-bill-wave"></i> {{ number_format($tour->price, 0, ',', ' ') }} сўм</strong>
                </p>
                <p class="card-text" style="font-size: 13px;">{{ Str::limit($tour->translations->where('lang_code', 'ru')->first()->description ?? $tour->translations->first()->description ?? '', 80) }}</p>
                <div class="btn-group w-100" role="group">
                    <button type="button" class="btn btn-info btn-sm" onclick="showTour({{ $tour->id }})">
                        <i class="fas fa-eye"></i> Просмотр
                    </button>
                    <button type="button" class="btn btn-primary btn-sm" onclick="editTour({{ $tour->id }})">
                        <i class="fas fa-edit"></i> Изменить
                    </button>
                    <form action="{{ route('tours.destroy', $tour->id) }}" method="POST" style="display:inline;" data-confirm-delete data-item-name="тур">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="alert alert-info text-center">
            <i class="fas fa-info-circle"></i> Туров не найдено
        </div>
    </div>
    @endforelse
</div>

<!-- Pagination -->
<div class="row">
    <div class="col-12 d-flex justify-content-center mt-4">
        {{ $tours->links() }}
    </div>
</div>
@endsection

@push('modals')
@include('pages.tours.create-modal')
@include('pages.tours.edit-modal')
@include('pages.tours.show-modal')
@endpush

@push('scripts')
<script>
    $(document).ready(function() {
        // Category filter
        $('.category-filter').click(function() {
            $('.category-filter').removeClass('active');
            $(this).addClass('active');

            var categoryId = $(this).data('category');

            if (categoryId === '') {
                $('.tour-card').show();
            } else {
                $('.tour-card').hide();
                $('.tour-card[data-category="' + categoryId + '"]').show();
            }
        });
    });

    function showTour(id) {
        // Will implement in show-modal
        $.get('/tours/' + id, function(response) {
            if (response.success) {
                populateShowModal(response.tour);
                $('#showModal').modal('show');
            }
        });
    }

    function editTour(id) {
        // Will implement in edit-modal
        $.get('/tours/' + id + '/translations', function(response) {
            if (response.success) {
                populateEditModal(response);
                $('#editModal').modal('show');
            }
        });
    }
</script>
@endpush
