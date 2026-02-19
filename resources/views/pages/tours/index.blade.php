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
            <div class="card-body d-flex flex-column" style="min-height: 380px;">
                <h5 class="card-title" style="min-height: 50px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">{{ $tour->translations->where('lang_code', 'ru')->first()->title ?? $tour->translations->first()->title ?? 'N/A' }}</h5>

                <div class="tour-details-minimal mb-3">
                    <p class="text-muted mb-1" style="font-size: 13px;">
                        <i class="fas fa-tag fa-fw text-primary"></i> {{ $tour->category->translations->where('lang_code', 'ru')->first()->name ?? $tour->category->translations->first()->name ?? 'N/A' }}
                    </p>

                    <p class="text-muted mb-1" style="font-size: 13px;">
                        <i class="fas fa-clock fa-fw text-primary"></i> {{ $tour->duration_days }} д. / {{ $tour->duration_nights }} н.
                    </p>

                    @if($tour->phone)
                    <p class="text-muted mb-1" style="font-size: 13px;">
                        <i class="fas fa-phone-alt fa-fw text-success"></i>
                        <a href="tel:{{ $tour->phone }}" class="text-muted" style="text-decoration: none;">{{ $tour->phone }}</a>
                    </p>
                    @endif
                </div>

                <div class="mb-3">
                    <span class="text-primary font-weight-bold" style="font-size: 1.1rem;">
                        {{ number_format($tour->price, 0, ',', ' ') }} <i class="fas fa-dollar fa-sm"></i>
                    </span>
                </div>

                <p class="card-text text-muted flex-grow-1" style="font-size: 12px; line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;">
                    {{ Str::limit($tour->translations->where('lang_code', 'ru')->first()->description ?? $tour->translations->first()->description ?? '', 70) }}
                </p>

                <div class="btn-group w-100 mt-auto" role="group">
                    <button type="button" class="btn btn-outline-info btn-sm" onclick="showTour({{ $tour->id }})">
                        <i class="fas fa-eye"></i>
                    </button>
                    <button type="button" class="btn btn-outline-primary btn-sm" onclick="editTour({{ $tour->id }})">
                        <i class="fas fa-edit"></i>
                    </button>
                    <form action="{{ route('tours.destroy', $tour->id) }}" method="POST" class="d-inline w-25" data-confirm-delete>
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger btn-sm w-100" style="border-top-left-radius: 0; border-bottom-left-radius: 0;">
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
        $.get('/tours/' + id + '/translations', function(response) {
            if (response.success) {
                populateEditModal(response);
                $('#editModal').modal('show');
            }
        });
    }
</script>
@endpush