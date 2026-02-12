<div class="modal fade" id="createModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Добавить новый тур</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form action="{{ route('tours.store') }}" method="POST" enctype="multipart/form-data" id="createForm">
                @csrf
                <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">

                    <!-- Basic Info -->
                    <h6 class="mb-3">Основная информация</h6>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Категория <span class="text-danger">*</span></label>
                                <select name="category_id" class="form-control" required>
                                    <option value="">Выберите категорию</option>
                                    @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->translations->where('lang_code', 'ru')->first()->name ?? $category->translations->first()->name ?? '' }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Цена ($)<span class="text-danger">*</span></label>
                                <input type="number" name="price" class="form-control" step="0.01" min="0" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Дней <span class="text-danger">*</span></label>
                                <input type="number" name="duration_days" class="form-control" min="1" value="1" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Ночей</label>
                                <input type="number" name="duration_nights" class="form-control" min="0" value="0">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Мин. возраст</label>
                                <input type="number" name="min_age" class="form-control" min="0">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Макс. человек</label>
                                <input type="number" name="max_people" class="form-control" min="1">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Телефон</label>
                                <input type="text" name="phone" class="form-control" placeholder="+998901234567">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="is_active" id="is_active_create" value="1" checked>
                                    <label class="custom-control-label" for="is_active_create">Активен</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <!-- Translations -->
                    <h6 class="mb-3">Переводы</h6>
                    <ul class="nav nav-pills mb-3" role="tablist">
                        @foreach($languages as $index => $language)
                        <li class="nav-item">
                            <a class="nav-link {{ $index == 0 ? 'active' : '' }}" data-toggle="pill" href="#create-lang-{{ $language->code }}">
                                {{ $language->name }}
                            </a>
                        </li>
                        @endforeach
                    </ul>
                    <div class="tab-content">
                        @foreach($languages as $index => $language)
                        <div class="tab-pane fade {{ $index == 0 ? 'show active' : '' }}" id="create-lang-{{ $language->code }}">
                            <div class="form-group">
                                <label>Название ({{ $language->name }}) <span class="text-danger">*</span></label>
                                <input type="text" name="title_{{ $language->code }}" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Слоган ({{ $language->name }})</label>
                                <input type="text" name="slogan_{{ $language->code }}" class="form-control" placeholder="Короткий слоган для тура">
                            </div>
                            <div class="form-group">
                                <label>Описание ({{ $language->name }}) <span class="text-danger">*</span></label>
                                <textarea name="description_{{ $language->code }}" class="form-control" rows="3" required></textarea>
                            </div>
                            <div class="form-group">
                                <label>Маршруты ({{ $language->name }}) <span class="text-danger">*</span></label>
                                <textarea name="routes_{{ $language->code }}" class="form-control" rows="3" required></textarea>
                            </div>
                            <div class="form-group">
                                <label>Важная информация ({{ $language->name }})</label>
                                <textarea name="important_info_{{ $language->code }}" class="form-control" rows="2"></textarea>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <hr>

                    <!-- Images -->
                    <h6 class="mb-3">Изображения <span class="text-danger">*</span></h6>
                    <div class="form-group">
                        <div id="dropzone-create" class="dropzone"></div>
                        <small class="text-muted">Макс. 5MB на изображение. Первое изображение будет главным.</small>
                    </div>

                    <hr>

                    <!-- Itineraries -->
                    <h6 class="mb-3">Маршрут по дням <span class="text-danger">*</span></h6>
                    <button type="button" class="btn btn-sm btn-primary mb-2" id="addItinerary">
                        <i class="fas fa-plus"></i> Добавить день
                    </button>
                    <small class="text-muted d-block mb-2">
                        <i class="fas fa-info-circle"></i> Необходимо добавить минимум 1 день. В каждом дне можно добавить несколько временных точек.
                    </small>
                    <div id="itinerariesContainer"></div>

                    <hr>

                    <!-- Marshrut (Route Waypoints) -->
                    <h6 class="mb-3"><i class="fas fa-map-marked-alt"></i> Marshrut nuqtalari</h6>
                    <div class="form-group">
                        <div id="create-tour-map" style="height: 400px; border-radius: 8px;"></div>
                        <small class="text-muted">Xaritaga bosib marshrut nuqtalarini ketma-ket belgilang</small>
                        <div id="create-waypoints-list" class="mt-2">
                            <small class="text-muted">Hech qanday nuqta belgilanmagan</small>
                        </div>
                        <button type="button" class="btn btn-sm btn-danger mt-1" id="clear-create-waypoints">
                            <i class="fas fa-trash"></i> Nuqtalarni tozalash
                        </button>
                    </div>

                    <hr>

                    <!-- Features/Inclusions -->
                    <h6 class="mb-3">Функции тура</h6>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th style="width: 50%;">Функция</th>
                                    <th class="text-center" style="width: 25%;">
                                        <span class="badge badge-success">Включено</span>
                                    </th>
                                    <th class="text-center" style="width: 25%;">
                                        <span class="badge badge-danger">Не включено</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($features as $feature)
                                <tr>
                                    <td>
                                        <i class="{{ $feature->icon }}" style="color: #6777ef;"></i>
                                        {{ $feature->translations->where('lang_code', 'ru')->first()->name ?? $feature->translations->first()->name ?? '' }}
                                    </td>
                                    <td class="text-center">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" class="custom-control-input" name="feature_{{ $feature->id }}" id="feature_included_{{ $feature->id }}" value="included">
                                            <label class="custom-control-label" for="feature_included_{{ $feature->id }}"></label>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" class="custom-control-input" name="feature_{{ $feature->id }}" id="feature_excluded_{{ $feature->id }}" value="excluded">
                                            <label class="custom-control-label" for="feature_excluded_{{ $feature->id }}"></label>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <small class="text-muted">
                            <i class="fas fa-info-circle"></i> Функция uchun "Включено" yoki "Не включено" tanlang. Tanlashni xohlamasangiz, hech narsani belgilamang.
                        </small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-save"></i> Сохранить
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css">
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
@endpush

@push('scripts')
<script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    Dropzone.autoDiscover = false;

    let createDropzone;
    let itineraryCounter = 0;
    let createMap = null;
    let createWaypointList = [];
    let createMapMarkers = [];

    $(document).ready(function() {
        // Initialize Dropzone
        createDropzone = new Dropzone("#dropzone-create", {
            url: "#",
            autoProcessQueue: false,
            uploadMultiple: true,
            paramName: "images",
            maxFilesize: 5,
            acceptedFiles: "image/*",
            addRemoveLinks: true,
            dictDefaultMessage: "Перетащите изображения сюда или нажмите для выбора",
        });

        // Handle form submit
        $('#createForm').on('submit', function(e) {
            e.preventDefault();

            // Prevent double submission
            const $submitBtn = $(this).find('button[type="submit"]');
            if ($submitBtn.prop('disabled')) {
                return false;
            }

            const files = createDropzone.getAcceptedFiles();
            if (files.length === 0) {
                swal({
                    title: 'Ошибка!',
                    text: 'Загрузите хотя бы одно изображение',
                    icon: 'error',
                    button: 'ОК',
                });
                return false;
            }

            // Check if at least one day is added
            const daysCount = $('.itinerary-day').length;
            if (daysCount === 0) {
                swal({
                    title: 'Ошибка!',
                    text: 'Добавьте хотя бы один день в маршрут',
                    icon: 'error',
                    button: 'ОК',
                });
                return false;
            }

            // Reindex all itineraries before submit
            let globalItineraryIndex = 0;
            $('.itinerary-day').each(function() {
                const dayNumber = $(this).data('day');
                $(this).find('.time-item').each(function() {
                    globalItineraryIndex++;
                    const timeItem = $(this);
                    timeItem.find('input, textarea').each(function() {
                        const name = $(this).attr('name');
                        if (name && name.includes('itineraries[')) {
                            // Replace day_X_time_Y with sequential index
                            const newName = name.replace(/itineraries\[day_\d+_time_\d+\]/, `itineraries[${globalItineraryIndex}]`);
                            $(this).attr('name', newName);
                        }
                    });
                });
            });

            // Create FormData from form
            const formData = new FormData(this);

            // Remove any existing image fields
            formData.delete('images[]');
            formData.delete('images');

            // Add images to FormData
            files.forEach((file, index) => {
                formData.append('images[]', file);
                console.log('Adding image:', file.name);
            });
            formData.append('main_image', 0); // First image is main

            // Add feature radio buttons to FormData
            // Remove any existing feature fields first
            const existingFeatureKeys = [];
            for (let key of formData.keys()) {
                if (key.startsWith('feature_')) {
                    existingFeatureKeys.push(key);
                }
            }
            existingFeatureKeys.forEach(key => formData.delete(key));

            // Add selected feature radio buttons
            $('input[type="radio"][name^="feature_"]:checked').each(function() {
                const name = $(this).attr('name');
                const value = $(this).val();
                formData.append(name, value);
                console.log('Adding feature:', name, '=', value);
            });

            // Add waypoints to FormData
            createWaypointList.forEach(function(wp, i) {
                formData.append('waypoints[' + i + '][latitude]', wp.latitude);
                formData.append('waypoints[' + i + '][longitude]', wp.longitude);
            });

            console.log('Form data prepared, submitting...');

            // Disable submit button
            $submitBtn.prop('disabled', true);
            const $icon = $submitBtn.find('i');
            $icon.removeClass('fa-save').addClass('fa-spinner fa-spin');

            const formAction = $(this).attr('action');

            // Use native XMLHttpRequest
            const xhr = new XMLHttpRequest();
            xhr.open('POST', formAction, true);
            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
            xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));

            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4) {
                    if (xhr.status >= 200 && xhr.status < 300) {
                        const response = JSON.parse(xhr.responseText);
                        swal({
                            title: 'Успешно!',
                            text: 'Тур успешно создан',
                            icon: 'success',
                            button: 'ОК',
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        let errorMsg = 'Ошибка при создании тура';
                        try {
                            const response = JSON.parse(xhr.responseText);
                            if (response.message) {
                                errorMsg = response.message;
                            } else if (response.errors) {
                                errorMsg = Object.values(response.errors).flat().join('\n');
                            }
                        } catch (e) {
                            console.error('Failed to parse error response:', e);
                        }
                        swal({
                            title: 'Ошибка!',
                            text: errorMsg,
                            icon: 'error',
                            button: 'ОК',
                        });
                        // Re-enable submit button on error
                        $submitBtn.prop('disabled', false);
                        $icon.removeClass('fa-spinner fa-spin').addClass('fa-save');
                    }
                }
            };

            xhr.onerror = function() {
                swal({
                    title: 'Ошибка!',
                    text: 'Не удалось подключиться к серверу',
                    icon: 'error',
                    button: 'ОК',
                });
                $submitBtn.prop('disabled', false);
                $icon.removeClass('fa-spinner fa-spin').addClass('fa-save');
            };

            xhr.send(formData);
        });

        // Waypoints map
        function initCreateMap() {
            if (createMap) {
                createMap.invalidateSize();
                return;
            }
            createMap = L.map('create-tour-map').setView([42.4667, 59.6167], 12);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(createMap);
            createMap.on('click', function(e) {
                addCreateMarker(e.latlng.lat, e.latlng.lng);
            });
        }

        function addCreateMarker(lat, lng) {
            createWaypointList.push({latitude: lat, longitude: lng});
            var idx = createWaypointList.length;
            var marker = L.marker([lat, lng], {
                icon: L.divIcon({
                    html: '<div style="background:#6777ef;color:white;border-radius:50%;width:26px;height:26px;display:flex;align-items:center;justify-content:center;font-weight:bold;font-size:12px;border:2px solid #fff;box-shadow:0 1px 3px rgba(0,0,0,.4);">' + idx + '</div>',
                    iconSize: [26, 26],
                    iconAnchor: [13, 13],
                    className: ''
                })
            }).addTo(createMap);
            createMapMarkers.push(marker);
            updateCreateWaypointsList();
        }

        function clearCreateWaypointsFn() {
            createMapMarkers.forEach(function(m) { if (createMap) createMap.removeLayer(m); });
            createMapMarkers = [];
            createWaypointList = [];
            updateCreateWaypointsList();
        }

        function updateCreateWaypointsList() {
            var el = document.getElementById('create-waypoints-list');
            if (!el) return;
            if (createWaypointList.length === 0) {
                el.innerHTML = '<small class="text-muted">Hech qanday nuqta belgilanmagan</small>';
                return;
            }
            var html = '<div class="d-flex flex-wrap" style="gap:4px;">';
            createWaypointList.forEach(function(wp, i) {
                html += '<span class="badge badge-primary">' + (i + 1) + ': ' + wp.latitude.toFixed(5) + ', ' + wp.longitude.toFixed(5) + '</span>';
            });
            html += '</div>';
            el.innerHTML = html;
        }

        $('#createModal').on('shown.bs.modal', function() {
            initCreateMap();
        });

        $('#clear-create-waypoints').on('click', function() {
            clearCreateWaypointsFn();
        });

        // Add Itinerary (Day)
        $('#addItinerary').click(function() {
            itineraryCounter++;
            addDay(itineraryCounter);
        });

        // Add Time to Day
        function addTimeToDay(dayNumber, timeCounter) {
            const timeId = `day_${dayNumber}_time_${timeCounter}`;
            const languages = @json($languages);
            let tabsHtml = '';
            let contentHtml = '';

            languages.forEach((language, index) => {
                const isActive = index === 0 ? 'active' : '';
                const showActive = index === 0 ? 'show active' : '';
                tabsHtml += `
                    <li class="nav-item">
                        <a class="nav-link ${isActive}" data-toggle="pill" href="#${timeId}_lang_${language.code}">
                            ${language.name}
                        </a>
                    </li>
                `;
                contentHtml += `
                    <div class="tab-pane fade ${showActive}" id="${timeId}_lang_${language.code}">
                        <div class="form-group">
                            <label>Активность (${language.name}) <span class="text-danger">*</span></label>
                            <input type="text" name="itineraries[${timeId}][activity_title_${language.code}]" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Описание (${language.name}) <span class="text-danger">*</span></label>
                            <textarea name="itineraries[${timeId}][activity_description_${language.code}]" class="form-control" rows="2" required></textarea>
                        </div>
                    </div>
                `;
            });

            let html = `
                <div class="mb-3 p-3 time-item" data-day="${dayNumber}" data-time="${timeCounter}" style="border: 1px solid #d0d0d0; border-radius: 4px; background: #f9f9f9; position: relative;">
                    <button type="button" class="btn btn-sm btn-danger remove-time" style="position: absolute; top: 10px; right: 10px;">
                        <i class="fas fa-times"></i>
                    </button>
                    <h6 class="mb-3" style="color: #6777ef;">Время ${timeCounter}</h6>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Время <span class="text-danger">*</span></label>
                                <input type="time" name="itineraries[${timeId}][event_time]" class="form-control" value="09:00" required>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="itineraries[${timeId}][day_number]" value="${dayNumber}">
                    
                    <!-- Language Tabs -->
                    <ul class="nav nav-pills mb-3" role="tablist">
                        ${tabsHtml}
                    </ul>
                    <div class="tab-content">
                        ${contentHtml}
                    </div>
                </div>
            `;
            return html;
        }

        // Add Day
        function addDay(dayNumber) {
            let dayTimeCounter = 1;
            const dayId = `day_${dayNumber}`;
            let html = `
                <div class="mb-4 p-3 itinerary-day" data-day="${dayNumber}" style="border: 2px solid #6777ef; border-radius: 4px; position: relative;">
                    <button type="button" class="btn btn-sm btn-danger remove-day" style="position: absolute; top: 10px; right: 10px;">
                        <i class="fas fa-times"></i> Удалить день
                    </button>
                    <h5 class="mb-3" style="color: #6777ef;">
                        <i class="fas fa-calendar-day"></i> День ${dayNumber}
                    </h5>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Номер дня <span class="text-danger">*</span></label>
                                <input type="number" class="form-control day-number-input" value="${dayNumber}" min="1" required readonly>
                            </div>
                        </div>
                    </div>
                    <div class="times-container" data-day="${dayNumber}">
                        ${addTimeToDay(dayNumber, dayTimeCounter)}
                    </div>
                    <button type="button" class="btn btn-sm btn-success add-time-to-day" data-day="${dayNumber}">
                        <i class="fas fa-plus"></i> Добавить время
                    </button>
                </div>
            `;
            $('#itinerariesContainer').append(html);
        }

        // Add Time to specific Day
        $(document).on('click', '.add-time-to-day', function() {
            const dayNumber = $(this).data('day');
            const dayContainer = $(this).closest('.itinerary-day');
            const timesContainer = dayContainer.find('.times-container');
            const timeCounter = timesContainer.find('.time-item').length + 1;
            const html = addTimeToDay(dayNumber, timeCounter);
            timesContainer.append(html);
        });

        // Remove Day
        $(document).on('click', '.remove-day', function() {
            $(this).closest('.itinerary-day').remove();
        });

        // Remove Time
        $(document).on('click', '.remove-time', function() {
            const timeItem = $(this).closest('.time-item');
            const dayContainer = timeItem.closest('.itinerary-day');
            const timesContainer = dayContainer.find('.times-container');

            // Don't allow removing if it's the last time in the day
            if (timesContainer.find('.time-item').length <= 1) {
                swal({
                    title: 'Ошибка!',
                    text: 'В каждом дне должно быть минимум одно время',
                    icon: 'error',
                    button: 'ОК',
                });
                return;
            }

            timeItem.remove();
        });

        // Reset on modal close
        $('#createModal').on('hidden.bs.modal', function() {
            $('#createForm')[0].reset();
            createDropzone.removeAllFiles();
            $('#itinerariesContainer').empty();
            itineraryCounter = 0;
            clearCreateWaypointsFn();
            // Re-enable submit button
            const $btn = $('#createForm button[type="submit"]');
            $btn.prop('disabled', false);
            const $icon = $btn.find('i');
            $icon.removeClass('fa-spinner fa-spin').addClass('fa-save');
        });
    });
</script>
@endpush