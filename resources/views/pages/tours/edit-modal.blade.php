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

                    <!-- GIF Route Map -->
                    <h6 class="mb-3"><i class="fas fa-film"></i> Маршрутная карта (GIF)</h6>
                    <div class="form-group">
                        <div id="current_gif_map_container" class="mb-2" style="display:none;">
                            <img id="current_gif_map" src="" alt="Route GIF" style="max-height:200px; border-radius:6px;">
                            <small class="text-muted d-block">Текущий GIF</small>
                        </div>
                        <input type="file" name="gif_map" id="gif_map_edit" class="form-control-file" accept=".gif">
                        <small class="text-muted">Только GIF формат. Макс. 10MB. Если не загружать — текущий сохранится.</small>
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
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css">
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/lang/summernote-ru-RU.min.js"></script>
<script>
    let editDropzone;
    let editItineraryCounter = 0;

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
        const accommLangs = @json($languages);

        let accommTabsHtml = '';
        let accommContentHtml = '';
        accommLangs.forEach((lang, idx) => {
            const isActive = idx === 0 ? 'active' : '';
            const showActive = idx === 0 ? 'show active' : '';
            accommTabsHtml += `
                <li class="nav-item">
                    <a class="nav-link ${isActive}" data-toggle="pill" href="#edit_accomm_day_${dayNumber}_lang_${lang.code}">
                        ${lang.name}
                    </a>
                </li>
            `;
            accommContentHtml += `
                <div class="tab-pane fade ${showActive}" id="edit_accomm_day_${dayNumber}_lang_${lang.code}">
                    <div class="form-group">
                        <label>Nomi (${lang.name}) <span class="text-danger">*</span></label>
                        <input type="text" name="edit_accomm_day_${dayNumber}[name_${lang.code}]" class="form-control form-control-sm">
                    </div>
                    <div class="form-group">
                        <label>Tavsif (${lang.name})</label>
                        <textarea name="edit_accomm_day_${dayNumber}[description_${lang.code}]" class="form-control form-control-sm" rows="2"></textarea>
                    </div>
                </div>
            `;
        });

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

                <!-- Accommodation Section -->
                <div class="edit-accommodation-section mt-3 p-2" style="border: 1px dashed #ccc; border-radius:4px; background:#fff;">
                    <h6 class="mb-2" style="font-size:0.9em; color:#555;">
                        <i class="fas fa-bed"></i> Turar joy / Tavsiya
                    </h6>
                    <div class="d-flex mb-2 flex-wrap">
                        <div class="custom-control custom-radio mr-3 mb-1">
                            <input type="radio" class="custom-control-input edit-accomm-type-radio"
                                   name="edit_accomm_day_${dayNumber}[type]"
                                   id="edit_accomm_none_${dayNumber}" value="none" checked>
                            <label class="custom-control-label" for="edit_accomm_none_${dayNumber}">Yo'q</label>
                        </div>
                        <div class="custom-control custom-radio mr-3 mb-1">
                            <input type="radio" class="custom-control-input edit-accomm-type-radio"
                                   name="edit_accomm_day_${dayNumber}[type]"
                                   id="edit_accomm_hotel_${dayNumber}" value="accommodation">
                            <label class="custom-control-label" for="edit_accomm_hotel_${dayNumber}">Turar joy bor</label>
                        </div>
                        <div class="custom-control custom-radio mb-1">
                            <input type="radio" class="custom-control-input edit-accomm-type-radio"
                                   name="edit_accomm_day_${dayNumber}[type]"
                                   id="edit_accomm_rec_${dayNumber}" value="recommendation">
                            <label class="custom-control-label" for="edit_accomm_rec_${dayNumber}">Tavsiya</label>
                        </div>
                    </div>
                    <div class="edit-accomm-detail-fields" style="display:none;">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Narx ($)</label>
                                    <input type="number" name="edit_accomm_day_${dayNumber}[price]"
                                           class="form-control form-control-sm" step="0.01" min="0" placeholder="0.00">
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>Rasm (yangi yuklash)</label>
                                    <input type="file" name="edit_accomm_day_${dayNumber}[image_file]"
                                           class="form-control-file" accept="image/jpeg,image/png,image/jpg,image/webp">
                                    <div class="edit-accomm-current-image mt-1" style="display:none;">
                                        <img src="" alt="" style="max-height:60px; border-radius:4px;">
                                        <small class="text-muted d-block">Mavjud rasm</small>
                                    </div>
                                    <input type="hidden" name="edit_accomm_day_${dayNumber}[existing_image_path]">
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
        return html;
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

        // Initialize Summernote for important_info fields
        @foreach($languages as $language)
        $('#edit_important_info_{{ $language->code }}').summernote({
            height: 150,
            lang: 'ru-RU',
            toolbar: [
                ['style', ['bold', 'italic', 'underline']],
                ['para', ['ul', 'ol']],
                ['insert', ['link']],
            ]
        });
        @endforeach

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

            // Sync Summernote content to textareas
            @foreach($languages as $language)
            $('#edit_important_info_{{ $language->code }}').val($('#edit_important_info_{{ $language->code }}').summernote('code'));
            @endforeach

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

            // Collect accommodations
            const editAccommLangs = @json($languages);
            let editAccommIndex = 0;
            $('.edit-itinerary-day').each(function() {
                const $day = $(this);
                const dayNumber = $day.data('day');
                const selectedType = $day.find('.edit-accomm-type-radio:checked').val();

                if (selectedType && selectedType !== 'none') {
                    formData.append('accommodations[' + editAccommIndex + '][day_number]', dayNumber);
                    formData.append('accommodations[' + editAccommIndex + '][type]', selectedType);

                    const price = $day.find('input[name="edit_accomm_day_' + dayNumber + '[price]"]').val();
                    if (price) {
                        formData.append('accommodations[' + editAccommIndex + '][price]', price);
                    }

                    const imageInput = $day.find('input[name="edit_accomm_day_' + dayNumber + '[image_file]"]')[0];
                    if (imageInput && imageInput.files.length > 0) {
                        formData.append('accommodations[' + editAccommIndex + '][image]', imageInput.files[0]);
                    }

                    const existingImagePath = $day.find('input[name="edit_accomm_day_' + dayNumber + '[existing_image_path]"]').val();
                    if (existingImagePath) {
                        formData.append('accommodations[' + editAccommIndex + '][existing_image_path]', existingImagePath);
                    }

                    editAccommLangs.forEach(function(lang) {
                        const nameVal = $day.find('input[name="edit_accomm_day_' + dayNumber + '[name_' + lang.code + ']"]').val();
                        const descVal = $day.find('textarea[name="edit_accomm_day_' + dayNumber + '[description_' + lang.code + ']"]').val();
                        formData.append('accommodations[' + editAccommIndex + '][name_' + lang.code + ']', nameVal || '');
                        formData.append('accommodations[' + editAccommIndex + '][description_' + lang.code + ']', descVal || '');
                    });

                    editAccommIndex++;
                }
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

                xhr.send(formData);

            } catch (error) {
                $submitBtn.prop('disabled', false);
                const $icon = $submitBtn.find('i');
                $icon.removeClass('fa-spinner fa-spin').addClass('fa-sync-alt');
            }
        });

        // Show/hide accommodation fields based on type
        $(document).on('change', '.edit-accomm-type-radio', function() {
            const $section = $(this).closest('.edit-accommodation-section');
            if ($(this).val() !== 'none') {
                $section.find('.edit-accomm-detail-fields').show();
            } else {
                $section.find('.edit-accomm-detail-fields').hide();
            }
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
            $('#current_gif_map_container').hide();
            editItineraryCounter = 0;
            // Re-enable submit button
            const $btn = $('#editForm button[type="submit"]');
            $btn.prop('disabled', false);
            const $icon = $btn.find('i');
            $icon.removeClass('fa-spinner fa-spin').addClass('fa-sync-alt');
            // Reset Summernote
            @foreach($languages as $language)
            $('#edit_important_info_{{ $language->code }}').summernote('reset');
            @endforeach
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
                accommodations,
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
                $('#edit_important_info_{{ $language->code }}').summernote('code', translations['{{ $language->code }}'].important_info || '');
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

            // Accommodations - populate per day
            if (accommodations && Array.isArray(accommodations) && accommodations.length > 0) {
                const accommByDay = {};
                accommodations.forEach(acc => {
                    accommByDay[acc.day_number] = acc;
                });

                Object.keys(accommByDay).forEach(dayNum => {
                    const acc = accommByDay[dayNum];
                    const $day = $('.edit-itinerary-day[data-day="' + dayNum + '"]');
                    if ($day.length === 0) return;

                    // Set radio button
                    $day.find('#edit_accomm_' + (acc.type === 'accommodation' ? 'hotel' : 'rec') + '_' + dayNum).prop('checked', true);
                    $day.find('.edit-accomm-detail-fields').show();

                    // Set price
                    if (acc.price !== null && acc.price !== undefined) {
                        $day.find('input[name="edit_accomm_day_' + dayNum + '[price]"]').val(acc.price);
                    }

                    // Set existing image
                    if (acc.image_path) {
                        $day.find('input[name="edit_accomm_day_' + dayNum + '[existing_image_path]"]').val(acc.image_path);
                        const $imgPreview = $day.find('.edit-accomm-current-image');
                        $imgPreview.find('img').attr('src', acc.image_url || '/storage/uploads/' + acc.image_path.split('/').pop());
                        $imgPreview.show();
                    }

                    // Set language fields
                    if (acc.translations) {
                        Object.keys(acc.translations).forEach(langCode => {
                            const t = acc.translations[langCode];
                            $day.find('input[name="edit_accomm_day_' + dayNum + '[name_' + langCode + ']"]').val(t.name || '');
                            $day.find('textarea[name="edit_accomm_day_' + dayNum + '[description_' + langCode + ']"]').val(t.description || '');
                        });
                    }
                });
            }

            // GIF map
            if (tour.gif_map) {
                $('#current_gif_map').attr('src', tour.gif_map);
                $('#current_gif_map_container').show();
            } else {
                $('#current_gif_map_container').hide();
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