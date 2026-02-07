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
                    <button class="btn btn-primary" onclick="editContact({{ $contacts->first()->id }})">
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
                                    <i class="fab fa-instagram"></i> Instagram
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
@endsection

@push('modals')
@include('pages.contacts.banner-create-modal')
@include('pages.contacts.banner-edit-modal')
@include('pages.contacts.create-modal')
@include('pages.contacts.edit-modal')
@endpush

@push('scripts')
<script>
    // Routes
    const ROUTES = {
        translations: '/contacts/{id}/translations',
        destroy: '/contacts/{id}'
    };

    // Leaflet Maps
    let createMap, editMap, contactMap;
    let createMarker, editMarker, contactMarker;

    // Initialize Contact Map (read-only)
    @if($contacts - > first())
    $(document).ready(function() {
        @php $contact = $contacts - > first();
        @endphp
        const lat = {
            {
                $contact - > latitude
            }
        };
        const lng = {
            {
                $contact - > longitude
            }
        };

        contactMap = L.map('contactMap', {
            scrollWheelZoom: false,
            dragging: true,
            touchZoom: true,
            doubleClickZoom: true,
            zoomControl: true
        }).setView([lat, lng], 15);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(contactMap);

        // Add marker
        contactMarker = L.marker([lat, lng]).addTo(contactMap);
        contactMarker.bindPopup('<b>Местоположение</b><br>Широта: ' + lat + '<br>Долгота: ' + lng).openPopup();
    });
    @endif

    // Initialize Create Map
    $('#createModal').on('shown.bs.modal', function() {
        if (!createMap) {
            // Default center: Tashkent, Uzbekistan
            createMap = L.map('createMap').setView([41.311081, 69.240562], 13);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(createMap);

            createMap.on('click', function(e) {
                const lat = e.latlng.lat;
                const lng = e.latlng.lng;

                // Remove previous marker
                if (createMarker) {
                    createMap.removeLayer(createMarker);
                }

                // Add new marker
                createMarker = L.marker([lat, lng]).addTo(createMap);

                // Update hidden inputs and display
                $('#create_latitude').val(lat);
                $('#create_longitude').val(lng);
                $('#create_coords_display').text(`Широта: ${lat.toFixed(6)}, Долгота: ${lng.toFixed(6)}`);
            });
        }

        setTimeout(() => {
            createMap.invalidateSize();
        }, 200);
    });

    // Reset create map on modal close
    $('#createModal').on('hidden.bs.modal', function() {
        if (createMarker) {
            createMap.removeLayer(createMarker);
            createMarker = null;
        }
        $('#create_latitude').val('');
        $('#create_longitude').val('');
        $('#create_coords_display').text('Выберите местоположение на карте');
    });

    // Edit Contact function
    function editContact(id) {
        $.ajax({
            url: ROUTES.translations.replace('{id}', id),
            type: 'GET',
            success: function(response) {
                if (response.success) {
                    $('#editContactForm').attr('action', ROUTES.destroy.replace('{id}', id));
                    $('#edit_phone').val(response.contact.phone);
                    $('#edit_email').val(response.contact.email);
                    $('#edit_longitude').val(response.contact.longitude);
                    $('#edit_latitude').val(response.contact.latitude);
                    $('#edit_whatsapp_phone').val(response.contact.whatsapp_phone); // QOSHILDI
                    $('#edit_telegram_url').val(response.contact.telegram_url);
                    $('#edit_telegram_username').val(response.contact.telegram_username);
                    $('#edit_instagram_url').val(response.contact.instagram_url);
                    $('#edit_facebook_url').val(response.contact.facebook_url);
                    $('#edit_facebook_name').val(response.contact.facebook_name); // QOSHILDI
                    $('#edit_youtube_url').val(response.contact.youtube_url);

                    // Fill translations for each language
                    @foreach($languages as $language)
                    if (response.translations['{{ $language->code }}']) {
                        $('#edit_address_{{ $language->code }}').val(response.translations['{{ $language->code }}'].address);
                    }
                    @endforeach

                    // Initialize edit map
                    $('#editContactModal').modal('show');

                    // Wait for modal to be fully shown
                    setTimeout(() => {
                        if (!editMap) {
                            editMap = L.map('editMap').setView([41.311081, 69.240562], 13);

                            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                            }).addTo(editMap);

                            editMap.on('click', function(e) {
                                const lat = e.latlng.lat;
                                const lng = e.latlng.lng;

                                if (editMarker) {
                                    editMap.removeLayer(editMarker);
                                }

                                editMarker = L.marker([lat, lng]).addTo(editMap);
                                $('#edit_latitude').val(lat);
                                $('#edit_longitude').val(lng);
                                $('#edit_coords_display').text(`Широта: ${lat.toFixed(6)}, Долгота: ${lng.toFixed(6)}`);
                            });
                        }

                        // Set existing coordinates if available
                        if (response.contact.latitude && response.contact.longitude) {
                            const lat = parseFloat(response.contact.latitude);
                            const lng = parseFloat(response.contact.longitude);

                            editMap.setView([lat, lng], 15);

                            if (editMarker) {
                                editMap.removeLayer(editMarker);
                            }

                            editMarker = L.marker([lat, lng]).addTo(editMap);
                            $('#edit_coords_display').text(`Широта: ${lat.toFixed(6)}, Долгота: ${lng.toFixed(6)}`);
                        }

                        editMap.invalidateSize();
                    }, 300);
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

    // Reset edit map on modal close
    $('#editContactModal').on('hidden.bs.modal', function() {
        if (editMarker) {
            editMap.removeLayer(editMarker);
            editMarker = null;
        }
    });

    function editBanner(id) {
        $.ajax({
            url: '/contacts/banner/' + id + '/translations',
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