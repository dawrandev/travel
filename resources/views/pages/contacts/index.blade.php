@extends('layouts.main')

@section('content')
<div class="section-header">
    <h1>Контактная информация</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fas fa-home"></i> Панель управления</a></div>
        <div class="breadcrumb-item active">Контактная информация</div>
        <div class="breadcrumb-item">
            <button class="btn btn-warning rounded-pill" data-toggle="modal" data-target="#createModal">
                <i class="fas fa-plus"></i> Добавить контакт
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
                                        data-lightbox="contact-banner-gallery"
                                        data-title="Контакты Баннер - Изображение {{ $index + 1 }}">
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
                    <p class="text-muted">Создайте баннер для страницы "Контакты"</p>
                    <button class="btn btn-success" data-toggle="modal" data-target="#createBannerModal">
                        <i class="fas fa-plus"></i> Создать баннер
                    </button>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Contacts Section -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4><i class="fas fa-address-book"></i> Контактная информация</h4>
                <div class="card-header-action">
                    @if($contacts->first())
                    <button class="btn btn-primary" data-contact-id="{{ $contacts->first()->id }}" id="editContactBtn">
                        <i class="fas fa-edit"></i> Редактировать
                    </button>
                    @else
                    <button class="btn btn-success" data-toggle="modal" data-target="#createModal">
                        <i class="fas fa-plus"></i> Создать контакт
                    </button>
                    @endif
                </div>
            </div>
            <div class="card-body">
                @if($contacts->first())
                @php $contact = $contacts->first(); @endphp
                <div class="row">
                    <!-- Contact Details -->
                    <div class="col-md-6">
                        <h5 class="mb-3"><i class="fas fa-info-circle text-primary"></i> Основная информация</h5>

                        <div class="mb-3">
                            <label class="font-weight-bold"><i class="fas fa-phone text-success"></i> Телефон:</label>
                            <p class="ml-4"><a href="tel:{{ $contact->phone }}" class="text-dark">{{ $contact->phone }}</a></p>
                        </div>
                        @if($contact->whatsapp_phone)
                        <div class="mb-3">
                            <label class="font-weight-bold"><i class="fab fa-whatsapp text-success"></i> WhatsApp:</label>
                            <p class="ml-4"><a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $contact->whatsapp_phone) }}" target="_blank" class="text-dark">{{ $contact->whatsapp_phone }}</a></p>
                        </div>
                        @endif
                        <div class="mb-3">
                            <label class="font-weight-bold"><i class="fas fa-envelope text-danger"></i> Эл. почта:</label>
                            <p class="ml-4"><a href="mailto:{{ $contact->email }}" class="text-dark">{{ $contact->email }}</a></p>
                        </div>

                        <div class="mb-3">
                            <label class="font-weight-bold"><i class="fas fa-map-marker-alt text-warning"></i> Местоположение:</label>
                            <div class="ml-4 mt-2">
                                <div id="contactMap" style="height: 250px; border-radius: 8px;"></div>
                                <small class="text-muted mt-2 d-block">
                                    <i class="fas fa-map-pin"></i> {{ $contact->latitude }}, {{ $contact->longitude }}
                                </small>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="font-weight-bold"><i class="fas fa-share-alt text-info"></i> Социальные сети:</label>
                            <div class="ml-4 mt-2">
                                @if($contact->telegram_url)
                                <a href="{{ $contact->telegram_url }}" target="_blank" class="btn btn-primary btn-sm mr-2 mb-2">
                                    <i class="fab fa-telegram"></i>
                                    {{ $contact->telegram_username ? '@' . $contact->telegram_username : 'Telegram' }}
                                </a>
                                @endif

                                @if($contact->whatsapp_phone)
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $contact->whatsapp_phone) }}" target="_blank" class="btn btn-success btn-sm mr-2 mb-2">
                                    <i class="fab fa-whatsapp"></i> WhatsApp
                                </a>
                                @endif

                                @if($contact->instagram_url)
                                <a href="{{ $contact->instagram_url }}" target="_blank" class="btn btn-sm mr-2 mb-2" style="background-color: #E1306C; color: white;">
                                    <i class="fab fa-instagram"></i>
                                    {{ $contact->instagram_username ? '@' . $contact->instagram_username : 'Instagram' }}
                                </a>
                                @endif

                                @if($contact->facebook_url)
                                <a href="{{ $contact->facebook_url }}" target="_blank" class="btn btn-primary btn-sm mr-2 mb-2">
                                    <i class="fab fa-facebook"></i> {{ $contact->facebook_name ?? 'Facebook' }}
                                </a>
                                @endif

                                @if($contact->youtube_url)
                                <a href="{{ $contact->youtube_url }}" target="_blank" class="btn btn-danger btn-sm mr-2 mb-2">
                                    <i class="fab fa-youtube"></i> YouTube
                                </a>
                                @endif

                                @if(!$contact->telegram_url && !$contact->whatsapp_phone && !$contact->instagram_url && !$contact->facebook_url && !$contact->youtube_url)
                                <span class="badge badge-secondary">Не указаны</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Addresses by Language -->
                    <div class="col-md-6">
                        <h5 class="mb-3"><i class="fas fa-map-marked-alt text-primary"></i> Адреса</h5>
                        <div class="list-group">
                            @foreach($contact->translations as $translation)
                            <div class="list-group-item">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="mb-1">
                                            <span class="badge badge-primary">{{ strtoupper($translation->lang_code) }}</span>
                                        </h6>
                                        <p class="mb-0 text-muted">{{ $translation->address }}</p>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @else
                <div class="text-center py-5">
                    <div class="mb-3">
                        <i class="fas fa-address-book fa-3x text-info"></i>
                    </div>
                    <h5>Контакт не создан</h5>
                    <p class="text-muted">Создайте контактную информацию для вашего сайта</p>
                    <button class="btn btn-success" data-toggle="modal" data-target="#createModal">
                        <i class="fas fa-plus"></i> Создать контакт
                    </button>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div id="page-metadata"
    data-has-contact="{{ $contacts->first() ? 'true' : 'false' }}"
    data-contact-lat="{{ $contacts->first() ? $contacts->first()->latitude : '' }}"
    data-contact-lng="{{ $contacts->first() ? $contacts->first()->longitude : '' }}"
    data-languages='{!! json_encode($languages->pluck("code")->toArray()) !!}'>
</div>
@endsection

@push('modals')
@include('pages.contacts.banner-create-modal')
@include('pages.contacts.banner-edit-modal')
@include('pages.contacts.create-modal')
@include('pages.contacts.edit-modal')
@endpush

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
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
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>

<script>
    $(document).ready(function() {
        // 1. Metadata o'qish
        const meta = $('#page-metadata');
        const hasContact = meta.data('has-contact') === true || meta.data('has-contact') === 'true';
        const contactLat = meta.data('contact-lat');
        const contactLng = meta.data('contact-lng');
        const languages = meta.data('languages');

        // Global xarita o'zgaruvchilari
        let createMap, editMap, contactMap;
        let createMarker, editMarker, contactMarker;

        // 2. Lightbox sozlamalari
        lightbox.option({
            'resizeDuration': 200,
            'wrapAround': true,
            'albumLabel': 'Изображение %1 из %2'
        });

        // 3. Asosiy sahifadagi xarita (Read-only)
        if (hasContact && contactLat && contactLng) {
            contactMap = L.map('contactMap', {
                scrollWheelZoom: false,
                dragging: true,
                zoomControl: true
            }).setView([contactLat, contactLng], 15);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(contactMap);

            L.marker([contactLat, contactLng]).addTo(contactMap)
                .bindPopup(`<b>Местоположение</b><br>Lat: ${contactLat}<br>Lng: ${contactLng}`)
                .openPopup();
        }

        // 4. Create Modal xaritasi
        $('#createModal').on('shown.bs.modal', function() {
            if (!createMap) {
                createMap = L.map('createMap').setView([41.311081, 69.240562], 13);
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(createMap);

                createMap.on('click', function(e) {
                    const lat = e.latlng.lat;
                    const lng = e.latlng.lng;
                    if (createMarker) createMap.removeLayer(createMarker);
                    createMarker = L.marker([lat, lng]).addTo(createMap);

                    $('#create_latitude').val(lat);
                    $('#create_longitude').val(lng);
                    $('#create_coords_display').text(`Широта: ${lat.toFixed(6)}, Долгота: ${lng.toFixed(6)}`);
                });
            }
            setTimeout(() => createMap.invalidateSize(), 200);
        });

        // 5. Contact Edit funksiyasi
        $('#editContactBtn').on('click', function() {
            const id = $(this).data('contact-id');
            $.ajax({
                url: `/contacts/${id}/translations`,
                type: 'GET',
                success: function(response) {
                    if (response.success) {
                        $('#editContactForm').attr('action', `/contacts/${id}`);

                        // Formani to'ldirish
                        const c = response.contact;
                        $('#edit_phone').val(c.phone || '');
                        $('#edit_email').val(c.email || '');
                        $('#edit_latitude').val(c.latitude || '');
                        $('#edit_longitude').val(c.longitude || '');
                        $('#edit_whatsapp_phone').val(c.whatsapp_phone || '');
                        $('#edit_telegram_url').val(c.telegram_url || '');
                        $('#edit_telegram_username').val(c.telegram_username || '');
                        $('#edit_instagram_url').val(c.instagram_url || '');
                        $('#edit_instagram_username').val(c.instagram_username || '');
                        $('#edit_facebook_url').val(c.facebook_url || '');
                        $('#edit_facebook_name').val(c.facebook_name || '');
                        $('#edit_youtube_url').val(c.youtube_url || '');

                        // Tarjimalar
                        languages.forEach(lang => {
                            if (response.translations[lang]) {
                                $(`#edit_address_${lang}`).val(response.translations[lang].address);
                            }
                        });

                        $('#editContactModal').modal('show');
                    }
                },
                error: () => swal('Ошибка!', 'Не удалось загрузить данные', 'error')
            });
        });

        // 6. Edit Modal xaritasi (shown bo'lganda yangilash)
        $('#editContactModal').on('shown.bs.modal', function() {
            const lat = parseFloat($('#edit_latitude').val());
            const lng = parseFloat($('#edit_longitude').val());

            if (!editMap) {
                editMap = L.map('editMap').setView([41.311081, 69.240562], 13);
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(editMap);

                editMap.on('click', function(e) {
                    const newLat = e.latlng.lat;
                    const newLng = e.latlng.lng;
                    if (editMarker) editMap.removeLayer(editMarker);
                    editMarker = L.marker([newLat, newLng]).addTo(editMap);
                    $('#edit_latitude').val(newLat);
                    $('#edit_longitude').val(newLng);
                    $('#edit_coords_display').text(`Широта: ${newLat.toFixed(6)}, Долгота: ${newLng.toFixed(6)}`);
                });
            }

            if (lat && lng) {
                editMap.setView([lat, lng], 15);
                if (editMarker) editMap.removeLayer(editMarker);
                editMarker = L.marker([lat, lng]).addTo(editMap);
                $('#edit_coords_display').text(`Широта: ${lat.toFixed(6)}, Долгота: ${lng.toFixed(6)}`);
            }

            setTimeout(() => editMap.invalidateSize(), 200);
        });

        // 7. Banner Edit funksiyasi
        $('#editBannerBtn').on('click', function() {
            const id = $(this).data('banner-id');
            $.ajax({
                url: `/contacts/banner/${id}/translations`,
                type: 'GET',
                success: function(response) {
                    if (response.success) {
                        if (typeof populateEditBannerModal === "function") {
                            populateEditBannerModal(response);
                        }
                        $('#editBannerModal').modal('show');
                    }
                },
                error: () => swal('Ошибка!', 'Не удалось загрузить баннер', 'error')
            });
        });
    });
</script>
@endpush