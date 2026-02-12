<div class="modal fade" id="editModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Редактировать тур</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form id="editForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">

                    <!-- Basic Info -->
                    <h6 class="mb-3">Основная информация</h6>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Категория <span class="text-danger">*</span></label>
                                <select name="category_id" id="edit_category_id" class="form-control" required>
                                    @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->translations->where('lang_code', 'ru')->first()->name ?? $category->translations->first()->name ?? '' }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Цена ($)<span class="text-danger">*</span></label>
                                <input type="number" name="price" id="edit_price" class="form-control" step="0.01" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Дней <span class="text-danger">*</span></label>
                                <input type="number" name="duration_days" id="edit_duration_days" class="form-control" min="1" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Ночей</label>
                                <input type="number" name="duration_nights" id="edit_duration_nights" class="form-control" min="0">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Мин. возраст</label>
                                <input type="number" name="min_age" id="edit_min_age" class="form-control" min="0">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Макс. человек</label>
                                <input type="number" name="max_people" id="edit_max_people" class="form-control" min="1">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Телефон</label>
                                <input type="text" name="phone" id="edit_phone" class="form-control" placeholder="+998901234567">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="is_active" id="edit_is_active" value="1">
                                    <label class="custom-control-label" for="edit_is_active">Активен</label>
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
                            <a class="nav-link {{ $index == 0 ? 'active' : '' }}" data-toggle="pill" href="#edit-lang-{{ $language->code }}">
                                {{ $language->name }}
                            </a>
                        </li>
                        @endforeach
                    </ul>
                    <div class="tab-content">
                        @foreach($languages as $index => $language)
                        <div class="tab-pane fade {{ $index == 0 ? 'show active' : '' }}" id="edit-lang-{{ $language->code }}">
                            <div class="form-group">
                                <label>Название ({{ $language->name }}) <span class="text-danger">*</span></label>
                                <input type="text" name="title_{{ $language->code }}" id="edit_title_{{ $language->code }}" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Слоган ({{ $language->name }})</label>
                                <input type="text" name="slogan_{{ $language->code }}" id="edit_slogan_{{ $language->code }}" class="form-control" placeholder="Короткий слоган для тура">
                            </div>
                            <div class="form-group">
                                <label>Описание ({{ $language->name }}) <span class="text-danger">*</span></label>
                                <textarea name="description_{{ $language->code }}" id="edit_description_{{ $language->code }}" class="form-control" rows="3" required></textarea>
                            </div>
                            <div class="form-group">
                                <label>Маршруты ({{ $language->name }}) <span class="text-danger">*</span></label>
                                <textarea name="routes_{{ $language->code }}" id="edit_routes_{{ $language->code }}" class="form-control" rows="3" required></textarea>
                            </div>
                            <div class="form-group">
                                <label>Важная информация ({{ $language->name }})</label>
                                <textarea name="important_info_{{ $language->code }}" id="edit_important_info_{{ $language->code }}" class="form-control" rows="2"></textarea>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <hr>

                    <!-- Current Images -->
                    <h6 class="mb-3">Текущие изображения</h6>
                    <small class="text-muted d-block mb-2">
                        <i class="fas fa-info-circle"></i> Выберите главное изображение
                    </small>
                    <div id="currentImages" class="row mb-3"></div>
                    <input type="hidden" name="main_image_id" id="main_image_id">

                    <!-- New Images -->
                    <h6 class="mb-3">Загрузить новые изображения (опционально)</h6>
                    <div class="form-group">
                        <div id="dropzone-edit" class="dropzone"></div>
                        <small class="text-muted d-block mt-2">
                            <i class="fas fa-info-circle"></i> Если загрузите новые изображения, старые будут удалены.<br>
                            Если не загрузите, текущие изображения сохранятся.
                        </small>
                    </div>

                    <hr>

                    <!-- Itineraries -->
                    <h6 class="mb-3">Маршрут по дням <span class="text-danger">*</span></h6>
                    <button type="button" class="btn btn-sm btn-primary mb-2" id="addEditItinerary">
                        <i class="fas fa-plus"></i> Добавить день
                    </button>
                    <small class="text-muted d-block mb-2">
                        <i class="fas fa-info-circle"></i> Необходимо добавить минимум 1 день. В каждом дне можно добавить несколько временных точек.
                    </small>
                    <div id="editItinerariesContainer"></div>

                    <hr>

                    <!-- Marshrut (Route Waypoints) -->
                    <h6 class="mb-3"><i class="fas fa-map-marked-alt"></i> Точки маршрута</h6>
                    <div class="form-group">
                        <div id="edit-tour-map" style="height: 400px; border-radius: 8px;"></div>
                        <small class="text-muted">Нажмите на карту, чтобы последовательно отметить точки маршрута</small>
                        <div id="edit-waypoints-list" class="mt-2">
                            <small class="text-muted">Точки не отмечены</small>
                        </div>
                        <button type="button" class="btn btn-sm btn-danger mt-1" id="clear-edit-waypoints">
                            <i class="fas fa-trash"></i> Очистить точки
                        </button>
                    </div>

                    <hr>

                    <!-- Features -->
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
                                            <input type="radio" class="custom-control-input edit-feature-radio" name="feature_{{ $feature->id }}" id="edit_feature_included_{{ $feature->id }}" value="included" data-feature-id="{{ $feature->id }}">
                                            <label class="custom-control-label" for="edit_feature_included_{{ $feature->id }}"></label>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" class="custom-control-input edit-feature-radio" name="feature_{{ $feature->id }}" id="edit_feature_excluded_{{ $feature->id }}" value="excluded" data-feature-id="{{ $feature->id }}">
                                            <label class="custom-control-label" for="edit_feature_excluded_{{ $feature->id }}"></label>
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
                        <i class="fas fa-sync-alt"></i> Обновить
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
@endpush

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    let editDropzone;
    let editItineraryCounter = 0;
    let editMap = null;
    let editWaypointList = [];
    let editMapMarkers = [];
    let editPendingWaypoints = null;

    // Add Time to Day (Edit) - Global function
    function addEditTimeToDay(dayNumber, timeCounter, timeData = null) {
        const timeId = `day_${dayNumber}_time_${timeCounter}`;
        const eventTime = timeData && timeData.event_time ? timeData.event_time : '09:00';
        const languages = @json($languages);
        let tabsHtml = '';
        let contentHtml = '';

        languages.forEach((language, index) => {
            const isActive = index === 0 ? 'active' : '';
            const showActive = index === 0 ? 'show active' : '';
            let titleValue = '';
            let descValue = '';

            if (timeData && timeData.translations && timeData.translations[language.code]) {
                titleValue = timeData.translations[language.code].activity_title || '';
                descValue = timeData.translations[language.code].activity_description || '';
            }

            // Escape HTML entities
            titleValue = String(titleValue).replace(/"/g, '&quot;').replace(/'/g, '&#39;');
            descValue = String(descValue).replace(/"/g, '&quot;').replace(/'/g, '&#39;').replace(/\n/g, '\\n');

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
                        <input type="text" name="itineraries[${timeId}][activity_title_${language.code}]" class="form-control" value="${titleValue}" required>
                    </div>
                    <div class="form-group">
                        <label>Описание (${language.name}) <span class="text-danger">*</span></label>
                        <textarea name="itineraries[${timeId}][activity_description_${language.code}]" class="form-control" rows="2" required>${descValue}</textarea>
                    </div>
                </div>
            `;
        });

        let html = `
            <div class="mb-3 p-3 edit-time-item" data-day="${dayNumber}" data-time="${timeCounter}" style="border: 1px solid #d0d0d0; border-radius: 4px; background: #f9f9f9; position: relative;">
                <button type="button" class="btn btn-sm btn-danger remove-edit-time" style="position: absolute; top: 10px; right: 10px;">
                    <i class="fas fa-times"></i>
                </button>
                <h6 class="mb-3" style="color: #6777ef;">Время ${timeCounter}</h6>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Время <span class="text-danger">*</span></label>
                            <input type="time" name="itineraries[${timeId}][event_time]" class="form-control" value="${eventTime}" required>
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

    // Add Day (Edit) - Global function
    function addEditDay(dayNumber, dayData = null) {
        const dayId = `day_${dayNumber}`;
        let html = `
            <div class="mb-4 p-3 edit-itinerary-day" data-day="${dayNumber}" style="border: 2px solid #6777ef; border-radius: 4px; position: relative;">
                <button type="button" class="btn btn-sm btn-danger remove-edit-day" style="position: absolute; top: 10px; right: 10px;">
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
                <div class="edit-times-container" data-day="${dayNumber}">
        `;

        // Add times for this day
        if (dayData && dayData.times && dayData.times.length > 0) {
            dayData.times.forEach((timeData, index) => {
                html += addEditTimeToDay(dayNumber, index + 1, timeData);
            });
        } else {
            html += addEditTimeToDay(dayNumber, 1);
        }

        html += `
                </div>
                <button type="button" class="btn btn-sm btn-success add-edit-time-to-day" data-day="${dayNumber}">
                    <i class="fas fa-plus"></i> Добавить время
                </button>
            </div>
        `;
        return html;
    }

    // Waypoints helpers (edit)
    function initEditMap() {
        if (editMap) {
            editMap.invalidateSize();
            return;
        }
        editMap = L.map('edit-tour-map').setView([42.4667, 59.6167], 12);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(editMap);
        editMap.on('click', function(e) {
            addEditMarker(e.latlng.lat, e.latlng.lng);
        });
    }

    function addEditMarker(lat, lng) {
        editWaypointList.push({latitude: lat, longitude: lng});
        var idx = editWaypointList.length;
        var marker = L.marker([lat, lng], {
            icon: L.divIcon({
                html: '<div style="background:#6777ef;color:white;border-radius:50%;width:26px;height:26px;display:flex;align-items:center;justify-content:center;font-weight:bold;font-size:12px;border:2px solid #fff;box-shadow:0 1px 3px rgba(0,0,0,.4);">' + idx + '</div>',
                iconSize: [26, 26],
                iconAnchor: [13, 13],
                className: ''
            })
        }).addTo(editMap);
        editMapMarkers.push(marker);
        updateEditWaypointsList();
    }

    function clearEditWaypointsFn() {
        editMapMarkers.forEach(function(m) { if (editMap) editMap.removeLayer(m); });
        editMapMarkers = [];
        editWaypointList = [];
        updateEditWaypointsList();
    }

    function updateEditWaypointsList() {
        var el = document.getElementById('edit-waypoints-list');
        if (!el) return;
        if (editWaypointList.length === 0) {
            el.innerHTML = '<small class="text-muted">Hech qanday nuqta belgilanmagan</small>';
            return;
        }
        var html = '<div class="d-flex flex-wrap" style="gap:4px;">';
        editWaypointList.forEach(function(wp, i) {
            html += '<span class="badge badge-primary">' + (i + 1) + ': ' + wp.latitude.toFixed(5) + ', ' + wp.longitude.toFixed(5) + '</span>';
        });
        html += '</div>';
        el.innerHTML = html;
    }

    function populateEditWaypoints(waypoints) {
        clearEditWaypointsFn();
        if (!waypoints || waypoints.length === 0) {
            if (editMap) editMap.setView([42.4667, 59.6167], 12);
            return;
        }

        var sorted = waypoints.slice().sort(function(a, b) { return a.sort_order - b.sort_order; });
        sorted.forEach(function(wp) {
            addEditMarker(parseFloat(wp.latitude), parseFloat(wp.longitude));
        });

        if (editMap && sorted.length > 0) {
            var latlngs = sorted.map(function(wp) { return [parseFloat(wp.latitude), parseFloat(wp.longitude)]; });
            editMap.fitBounds(latlngs, {padding: [20, 20]});
        }
    }

    $(document).ready(function() {
        // Initialize Edit Dropzone
        editDropzone = new Dropzone("#dropzone-edit", {
            url: "#",
            autoProcessQueue: false,
            uploadMultiple: true,
            paramName: "images",
            maxFilesize: 5,
            acceptedFiles: "image/*",
            addRemoveLinks: true,
            dictDefaultMessage: "Перетащите изображения",
        });

        // Handle edit form submit
        $('#editForm').on('submit', function(e) {
            e.preventDefault();

            // Prevent double submission
            const $submitBtn = $(this).find('button[type="submit"]');
            if ($submitBtn.prop('disabled')) {
                return false;
            }

            // Check if at least one day is added
            const daysCount = $('.edit-itinerary-day').length;
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
            $('.edit-itinerary-day').each(function() {
                const dayNumber = $(this).data('day');
                $(this).find('.edit-time-item').each(function() {
                    globalItineraryIndex++;
                    const timeItem = $(this);
                    timeItem.find('input, textarea').each(function() {
                        const name = $(this).attr('name');
                        if (name) {
                            $(this).attr('name', name.replace(/itineraries\[day_\d+_time_\d+\]/, `itineraries[${globalItineraryIndex}]`));
                        }
                    });
                });
            });

            const files = editDropzone.getAcceptedFiles();
            const formData = new FormData(this);

            // If new images uploaded, add them
            if (files.length > 0) {
                formData.delete('images[]');
                formData.delete('images');

                files.forEach((file, index) => {
                    formData.append('images[]', file);
                });
                formData.append('main_image', 0); // First image is main
            }

            // Add feature radio buttons to FormData
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
            });

            // Disable submit button
            $submitBtn.prop('disabled', true);
            const $icon = $submitBtn.find('i');
            $icon.removeClass('fa-sync-alt').addClass('fa-spinner fa-spin');

            const formAction = $(this).attr('action');

            try {
                // Use native XMLHttpRequest instead of jQuery

                const xhr = new XMLHttpRequest();

                xhr.open('POST', formAction, true);
                xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
                xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));

                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4) {
                        if (xhr.status >= 200 && xhr.status < 300) {
                            try {
                                const response = JSON.parse(xhr.responseText);
                                swal({
                                    title: 'Успешно!',
                                    text: response.message || 'Тур успешно обновлен',
                                    icon: 'success',
                                    button: 'ОК',
                                }).then(() => {
                                    location.reload();
                                });
                            } catch (e) {
                                // Server returned HTML instead of JSON
                                swal({
                                    title: 'Успешно!',
                                    text: 'Тур успешно обновлен',
                                    icon: 'success',
                                    button: 'ОК',
                                }).then(() => {
                                    location.reload();
                                });
                            }
                        } else {
                            let errorMsg = 'Ошибка при обновлении тура';

                            try {
                                const response = JSON.parse(xhr.responseText);
                                if (response.message) {
                                    errorMsg = response.message;
                                } else if (response.errors) {
                                    errorMsg = Object.values(response.errors).flat().join('\n');
                                }
                            } catch (e) {
                                if (xhr.status === 500) {
                                    errorMsg = 'Внутренняя ошибка сервера';
                                } else if (xhr.status === 422) {
                                    errorMsg = 'Ошибка валидации данных';
                                } else if (xhr.status === 404) {
                                    errorMsg = 'Тур не найден';
                                }
                            }

                            swal({
                                title: 'Ошибка!',
                                text: errorMsg,
                                icon: 'error',
                                button: 'ОК',
                            });

                            $submitBtn.prop('disabled', false);
                            const $icon = $submitBtn.find('i');
                            $icon.removeClass('fa-spinner fa-spin').addClass('fa-sync-alt');
                        }
                    }
                };

                xhr.onerror = function() {
                    swal({
                        title: 'Ошибка!',
                        text: 'Не удалось подключиться к серверу. Проверьте интернет-соединение.',
                        icon: 'error',
                        button: 'ОК',
                    });

                    $submitBtn.prop('disabled', false);
                    const $icon = $submitBtn.find('i');
                    $icon.removeClass('fa-spinner fa-spin').addClass('fa-sync-alt');
                };

                xhr.ontimeout = function() {
                    swal({
                        title: 'Ошибка!',
                        text: 'Превышено время ожидания. Попробуйте еще раз.',
                        icon: 'error',
                        button: 'ОК',
                    });

                    $submitBtn.prop('disabled', false);
                    const $icon = $submitBtn.find('i');
                    $icon.removeClass('fa-spinner fa-spin').addClass('fa-sync-alt');
                };

                xhr.timeout = 300000; // 5 minutes

                // Add waypoints to FormData
                editWaypointList.forEach(function(wp, i) {
                    formData.append('waypoints[' + i + '][latitude]', wp.latitude);
                    formData.append('waypoints[' + i + '][longitude]', wp.longitude);
                });

                xhr.send(formData);

            } catch (error) {
                $submitBtn.prop('disabled', false);
                const $icon = $submitBtn.find('i');
                $icon.removeClass('fa-spinner fa-spin').addClass('fa-sync-alt');
            }
        });

        // Waypoints map init on modal show
        $('#editModal').on('shown.bs.modal', function() {
            initEditMap();
            if (editPendingWaypoints !== null) {
                populateEditWaypoints(editPendingWaypoints);
                editPendingWaypoints = null;
            }
        });

        $('#clear-edit-waypoints').on('click', function() {
            clearEditWaypointsFn();
        });

        // Add Edit Itinerary (Day)
        $('#addEditItinerary').click(function() {
            editItineraryCounter++;
            const html = addEditDay(editItineraryCounter);
            $('#editItinerariesContainer').append(html);
        });

        // Add Time to specific Day (Edit)
        $(document).on('click', '.add-edit-time-to-day', function() {
            const dayNumber = $(this).data('day');
            const dayContainer = $(this).closest('.edit-itinerary-day');
            const timesContainer = dayContainer.find('.edit-times-container');
            const timeCounter = timesContainer.find('.edit-time-item').length + 1;
            const html = addEditTimeToDay(dayNumber, timeCounter);
            timesContainer.append(html);
        });

        // Remove Day (Edit)
        $(document).on('click', '.remove-edit-day', function() {
            $(this).closest('.edit-itinerary-day').remove();
        });

        // Remove Time (Edit)
        $(document).on('click', '.remove-edit-time', function() {
            const timeItem = $(this).closest('.edit-time-item');
            const dayContainer = timeItem.closest('.edit-itinerary-day');
            const timesContainer = dayContainer.find('.edit-times-container');

            // Don't allow removing if it's the last time in the day
            if (timesContainer.find('.edit-time-item').length <= 1) {
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
        $('#editModal').on('hidden.bs.modal', function() {
            $('#editForm')[0].reset();
            editDropzone.removeAllFiles();
            $('#editItinerariesContainer').empty();
            $('#currentImages').empty();
            editItineraryCounter = 0;
            clearEditWaypointsFn();
            editPendingWaypoints = null;
            // Re-enable submit button
            const $btn = $('#editForm button[type="submit"]');
            $btn.prop('disabled', false);
            const $icon = $btn.find('i');
            $icon.removeClass('fa-spinner fa-spin').addClass('fa-sync-alt');
            // Remove event listeners
            $('input[name="main_image_radio"]').off('change');
        });
    });

    function populateEditModal(response) {
        try {
            const {
                tour,
                translations,
                itineraries,
                features,
                images,
                waypoints
            } = response;

            // Form action
            $('#editForm').attr('action', '/tours/' + tour.id);

            // Basic info
            $('#edit_category_id').val(tour.category_id);
            $('#edit_price').val(tour.price);
            $('#edit_duration_days').val(tour.duration_days);
            $('#edit_duration_nights').val(tour.duration_nights);
            $('#edit_min_age').val(tour.min_age);
            $('#edit_max_people').val(tour.max_people);
            $('#edit_phone').val(tour.phone);
            $('#edit_is_active').prop('checked', tour.is_active);

            // Translations
            @foreach($languages as $language)
            if (translations['{{ $language->code }}']) {
                $('#edit_title_{{ $language->code }}').val(translations['{{ $language->code }}'].title);
                $('#edit_slogan_{{ $language->code }}').val(translations['{{ $language->code }}'].slogan);
                $('#edit_description_{{ $language->code }}').val(translations['{{ $language->code }}'].description);
                $('#edit_routes_{{ $language->code }}').val(translations['{{ $language->code }}'].routes);
                $('#edit_important_info_{{ $language->code }}').val(translations['{{ $language->code }}'].important_info);
            }
            @endforeach

            // Images
            let imagesHtml = '';
            let mainImageId = null;
            if (images && Array.isArray(images)) {
                images.forEach(img => {
                    if (img.is_main) {
                        mainImageId = img.id;
                    }
                    imagesHtml += `
                    <div class="col-md-3 mb-3">
                        <div class="position-relative">
                            <img src="/storage/${img.image_path}" class="img-thumbnail w-100" style="height: 150px; object-fit: cover;">
                            <div class="custom-control custom-radio mt-2">
                                <input type="radio" class="custom-control-input" name="main_image_radio" id="main_img_${img.id}" value="${img.id}" ${img.is_main ? 'checked' : ''}>
                                <label class="custom-control-label" for="main_img_${img.id}">
                                    Главное фото
                                </label>
                            </div>
                        </div>
                    </div>
                `;
                });
            }
            $('#currentImages').html(imagesHtml);
            $('#main_image_id').val(mainImageId);

            // Handle main image selection - Remove old listeners first
            $('input[name="main_image_radio"]').off('change').on('change', function() {
                $('#main_image_id').val($(this).val());
            });

            // Itineraries - Group by day
            $('#editItinerariesContainer').empty();
            editItineraryCounter = 0;

            if (itineraries && Array.isArray(itineraries) && itineraries.length > 0) {
                // Group itineraries by day_number
                const daysMap = {};
                itineraries.forEach((it) => {
                    if (!daysMap[it.day_number]) {
                        daysMap[it.day_number] = {
                            day_number: it.day_number,
                            times: []
                        };
                    }
                    daysMap[it.day_number].times.push({
                        event_time: it.event_time,
                        translations: it.translations || {}
                    });
                });

                // Sort days
                const sortedDays = Object.keys(daysMap).sort((a, b) => parseInt(a) - parseInt(b));

                // Create day containers
                sortedDays.forEach((dayNum) => {
                    editItineraryCounter = Math.max(editItineraryCounter, parseInt(dayNum));
                    const dayData = daysMap[dayNum];
                    const html = addEditDay(parseInt(dayNum), dayData);
                    $('#editItinerariesContainer').append(html);
                });

                // Update counter to next available day
                editItineraryCounter = sortedDays.length > 0 ? Math.max(...sortedDays.map(d => parseInt(d))) : 0;
            } else {
                // No itineraries, set counter to 0
                editItineraryCounter = 0;
            }

            // Features - Clear all radio buttons first
            $('.edit-feature-radio').prop('checked', false);

            // Set radio buttons based on features object (key: feature_id, value: 'included' or 'excluded')
            for (const [featureId, status] of Object.entries(features)) {
                if (status === 'included') {
                    $(`#edit_feature_included_${featureId}`).prop('checked', true);
                } else if (status === 'excluded') {
                    $(`#edit_feature_excluded_${featureId}`).prop('checked', true);
                }
            }

            // Waypoints
            var waypointsData = waypoints || [];
            if (editMap) {
                populateEditWaypoints(waypointsData);
            } else {
                editPendingWaypoints = waypointsData;
            }
        } catch (error) {
            swal({
                title: 'Ошибка!',
                text: 'Ошибка при загрузке данных тура: ' + error.message,
                icon: 'error',
                button: 'ОК',
            });
        }
    }
</script>
@endpush