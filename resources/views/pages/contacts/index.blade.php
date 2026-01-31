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

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4>Список контактов</h4>
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
                    <table class="table table-striped" id="contactTable">
                        <thead>
                            <tr>
                                <th>№</th>
                                <th>Телефон</th>
                                <th>Эл. почта</th>
                                <th>Адрес</th>
                                <th>Телеграм</th>
                                <th>Инстаграм</th>
                                <th>Фейсбук</th>
                                <th>Ютуб</th>
                                <th>Действия</th>
                            </tr>
                        </thead>
                        <tbody id="contactTableBody">
                            @foreach($contacts as $contact)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $contact->phone }}</td>
                                <td>{{ $contact->email }}</td>
                                <td>{{ Str::limit($contact->translations->first()->address ?? 'N/A', 50) }}</td>

                                <td>
                                    @if($contact->telegram_url)
                                    <a href="{{ $contact->telegram_url }}" target="_blank" class="text-info">
                                        <i class="fab fa-telegram"></i>
                                        {{ $contact->telegram_username ? '@' . $contact->telegram_username : 'Перейти' }}
                                    </a>
                                    @else
                                    <span class="badge badge-secondary">Нет</span>
                                    @endif
                                </td>

                                <td>
                                    @if($contact->instagram_url)
                                    <a href="{{ $contact->instagram_url }}" target="_blank" style="color: #E1306C;"><i class="fab fa-instagram"></i></a>
                                    @else
                                    <span class="badge badge-secondary">Нет</span>
                                    @endif
                                </td>

                                <td>
                                    @if($contact->facebook_url)
                                    <a href="{{ $contact->facebook_url }}" target="_blank" class="text-primary"><i class="fab fa-facebook"></i></a>
                                    @else
                                    <span class="badge badge-secondary">Нет</span>
                                    @endif
                                </td>

                                <td>
                                    @if($contact->youtube_url)
                                    <a href="{{ $contact->youtube_url }}" target="_blank" class="text-danger"><i class="fab fa-youtube"></i></a>
                                    @else
                                    <span class="badge badge-secondary">Нет</span>
                                    @endif
                                </td>

                                <td>
                                    <button class="btn btn-sm btn-primary" onclick="editContact({{ $contact->id }})">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <form action="{{ route('contacts.destroy', $contact->id) }}" method="POST" style="display:inline-block;" data-confirm-delete data-item-name="контакт">
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
@include('pages.contacts.create-modal')
@include('pages.contacts.edit-modal')
@endpush

@push('scripts')
<script>
    // Routes - Prettier formatter won't break these
    const ROUTES = {
        filter: '{{ route("contacts.filter") }}',
        translations: '/contacts/{id}/translations',
        destroy: '/contacts/{id}'
    };

    $(document).ready(function() {
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

        function updateTable(contacts) {
            var tbody = $('#contactTableBody');
            tbody.empty();

            if (contacts.length === 0) {
                tbody.append('<tr><td colspan="7" class="text-center">Нет данных</td></tr>');
                return;
            }

            contacts.forEach(function(contact, index) {
                var telegramCell = contact.telegram_username ?
                    '<a href="' + contact.telegram_url + '" target="_blank">@' + contact.telegram_username + '</a>' :
                    '<span class="badge badge-secondary">Нет</span>';

                var instagramCell = contact.instagram_url ?
                    '<a href="' + contact.instagram_url + '" target="_blank"><i class="fab fa-instagram"></i></a>' :
                    '<span class="badge badge-secondary">Нет</span>';

                var address = contact.address.length > 50 ? contact.address.substring(0, 50) + '...' : contact.address;

                var row = '<tr>' +
                    '<td>' + (index + 1) + '</td>' +
                    '<td>' + contact.phone + '</td>' +
                    '<td>' + contact.email + '</td>' +
                    '<td>' + address + '</td>' +
                    '<td>' + telegramCell + '</td>' +
                    '<td>' + instagramCell + '</td>' +
                    '<td>' +
                    '<button class="btn btn-sm btn-primary" onclick="editContact(' + contact.id + ')">' +
                    '<i class="fas fa-edit"></i>' +
                    '</button> ' +
                    '<form action="/contacts/' + contact.id + '" method="POST" style="display:inline-block;" data-confirm-delete data-item-name="контакт">' +
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

    // Leaflet Maps
    let createMap, editMap;
    let createMarker, editMarker;

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
                    $('#edit_telegram_url').val(response.contact.telegram_url);
                    $('#edit_telegram_username').val(response.contact.telegram_username);
                    $('#edit_instagram_url').val(response.contact.instagram_url);
                    $('#edit_facebook_url').val(response.contact.facebook_url);
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
</script>
@endpush