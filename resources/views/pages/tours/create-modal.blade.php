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
                                <textarea name="important_info_{{ $language->code }}" id="create_important_info_{{ $language->code }}" class="form-control" rows="2"></textarea>
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

                    <!-- GIF Route Map -->
                    <h6 class="mb-3"><i class="fas fa-film"></i> Маршрутная карта (GIF)</h6>
                    <div class="form-group">
                        <input type="file" name="gif_map" id="gif_map_create" class="form-control-file" accept=".gif">
                        <small class="text-muted">Только GIF формат. Макс. 10MB.</small>
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
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css">
@endpush

@push('scripts')
<script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/lang/summernote-ru-RU.min.js"></script>
<script>
    Dropzone.autoDiscover = false;

    let createDropzone;
    let itineraryCounter = 0;

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

        // Initialize Summernote for important_info fields
        @foreach($languages as $language)
        $('#create_important_info_{{ $language->code }}').summernote({
            height: 150,
            lang: 'ru-RU',
            toolbar: [
                ['style', ['bold', 'italic', 'underline']],
                ['para', ['ul', 'ol']],
                ['insert', ['link']],
            ]
        });
        @endforeach

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

            // Sync Summernote content to textareas
            @foreach($languages as $language)
            $('#create_important_info_{{ $language->code }}').val($('#create_important_info_{{ $language->code }}').summernote('code'));
            @endforeach

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

            // Collect accommodations
            const accommLangsForSubmit = @json($languages);
            let accommIndex = 0;
            $('.itinerary-day').each(function() {
                const $day = $(this);
                const dayNumber = $day.data('day');
                const selectedType = $day.find('.accomm-type-radio:checked').val();

                if (selectedType && selectedType !== 'none') {
                    formData.append('accommodations[' + accommIndex + '][day_number]', dayNumber);
                    formData.append('accommodations[' + accommIndex + '][type]', selectedType);

                    const price = $day.find('input[name="accomm_day_' + dayNumber + '[price]"]').val();
                    if (price) {
                        formData.append('accommodations[' + accommIndex + '][price]', price);
                    }

                    const imageInput = $day.find('input[name="accomm_day_' + dayNumber + '[image_file]"]')[0];
                    if (imageInput && imageInput.files.length > 0) {
                        formData.append('accommodations[' + accommIndex + '][image]', imageInput.files[0]);
                    }

                    accommLangsForSubmit.forEach(function(lang) {
                        const nameVal = $day.find('input[name="accomm_day_' + dayNumber + '[name_' + lang.code + ']"]').val();
                        const descVal = $day.find('textarea[name="accomm_day_' + dayNumber + '[description_' + lang.code + ']"]').val();
                        formData.append('accommodations[' + accommIndex + '][name_' + lang.code + ']', nameVal || '');
                        formData.append('accommodations[' + accommIndex + '][description_' + lang.code + ']', descVal || '');
                    });

                    accommIndex++;
                }
            });

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
            const accommLangs = @json($languages);

            let accommTabsHtml = '';
            let accommContentHtml = '';
            accommLangs.forEach((lang, idx) => {
                const isActive = idx === 0 ? 'active' : '';
                const showActive = idx === 0 ? 'show active' : '';
                accommTabsHtml += `
                    <li class="nav-item">
                        <a class="nav-link ${isActive}" data-toggle="pill" href="#accomm_day_${dayNumber}_lang_${lang.code}">
                            ${lang.name}
                        </a>
                    </li>
                `;
                accommContentHtml += `
                    <div class="tab-pane fade ${showActive}" id="accomm_day_${dayNumber}_lang_${lang.code}">
                        <div class="form-group">
                            <label>Nomi (${lang.name}) <span class="text-danger">*</span></label>
                            <input type="text" name="accomm_day_${dayNumber}[name_${lang.code}]" class="form-control form-control-sm">
                        </div>
                        <div class="form-group">
                            <label>Tavsif (${lang.name})</label>
                            <textarea name="accomm_day_${dayNumber}[description_${lang.code}]" class="form-control form-control-sm" rows="2"></textarea>
                        </div>
                    </div>
                `;
            });

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

                    <!-- Accommodation Section -->
                    <div class="accommodation-section mt-3 p-2" style="border: 1px dashed #ccc; border-radius:4px; background:#fff;">
                        <h6 class="mb-2" style="font-size:0.9em; color:#555;">
                            <i class="fas fa-bed"></i> Turar joy / Tavsiya
                        </h6>
                        <div class="d-flex mb-2 flex-wrap">
                            <div class="custom-control custom-radio mr-3 mb-1">
                                <input type="radio" class="custom-control-input accomm-type-radio"
                                       name="accomm_day_${dayNumber}[type]"
                                       id="accomm_none_${dayNumber}" value="none" checked>
                                <label class="custom-control-label" for="accomm_none_${dayNumber}">Yo'q</label>
                            </div>
                            <div class="custom-control custom-radio mr-3 mb-1">
                                <input type="radio" class="custom-control-input accomm-type-radio"
                                       name="accomm_day_${dayNumber}[type]"
                                       id="accomm_hotel_${dayNumber}" value="accommodation">
                                <label class="custom-control-label" for="accomm_hotel_${dayNumber}">Turar joy bor</label>
                            </div>
                            <div class="custom-control custom-radio mb-1">
                                <input type="radio" class="custom-control-input accomm-type-radio"
                                       name="accomm_day_${dayNumber}[type]"
                                       id="accomm_rec_${dayNumber}" value="recommendation">
                                <label class="custom-control-label" for="accomm_rec_${dayNumber}">Tavsiya</label>
                            </div>
                        </div>
                        <div class="accomm-detail-fields" style="display:none;">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Narx ($)</label>
                                        <input type="number" name="accomm_day_${dayNumber}[price]"
                                               class="form-control form-control-sm" step="0.01" min="0" placeholder="0.00">
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label>Rasm</label>
                                        <input type="file" name="accomm_day_${dayNumber}[image_file]"
                                               class="form-control-file" accept="image/jpeg,image/png,image/jpg,image/webp">
                                    </div>
                                </div>
                            </div>
                            <ul class="nav nav-pills mb-2" role="tablist">
                                ${accommTabsHtml}
                            </ul>
                            <div class="tab-content">
                                ${accommContentHtml}
                            </div>
                        </div>
                    </div>
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

        // Show/hide accommodation fields based on type
        $(document).on('change', '.accomm-type-radio', function() {
            const $section = $(this).closest('.accommodation-section');
            if ($(this).val() !== 'none') {
                $section.find('.accomm-detail-fields').show();
            } else {
                $section.find('.accomm-detail-fields').hide();
            }
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
            // Re-enable submit button
            const $btn = $('#createForm button[type="submit"]');
            $btn.prop('disabled', false);
            const $icon = $btn.find('i');
            $icon.removeClass('fa-spinner fa-spin').addClass('fa-save');
            // Reset Summernote
            @foreach($languages as $language)
            $('#create_important_info_{{ $language->code }}').summernote('reset');
            @endforeach
        });
    });
</script>
@endpush