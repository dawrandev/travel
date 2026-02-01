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
                                <label>Цена (сўм) <span class="text-danger">*</span></label>
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
                        <i class="fas fa-info-circle"></i> Необходимо добавить минимум 1 день
                    </small>
                    <div id="editItinerariesContainer"></div>

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

@push('scripts')
<script>
    let editDropzone;
    let editItineraryCounter = 0;

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

            // Check if at least one itinerary is added
            const itinerariesCount = $('.edit-itinerary-item').length;
            if (itinerariesCount === 0) {
                swal({
                    title: 'Ошибка!',
                    text: 'Добавьте хотя бы один день в маршрут',
                    icon: 'error',
                    button: 'ОК',
                });
                return false;
            }

            const files = editDropzone.getAcceptedFiles();
            const formData = new FormData(this);

            console.log('Files count:', files.length);

            // If new images uploaded, add them
            if (files.length > 0) {
                formData.delete('images[]');
                formData.delete('images');

                files.forEach((file, index) => {
                    formData.append('images[]', file);
                    console.log('Adding image:', file.name);
                });
                formData.append('main_image', 0); // First image is main
            } else {
                console.log('No new images uploaded, keeping existing images');
            }

            console.log('Form data prepared, submitting...');

            // Submit via AJAX
            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    swal({
                        title: 'Успешно!',
                        text: 'Тур успешно обновлен',
                        icon: 'success',
                        button: 'ОК',
                    }).then(() => {
                        location.reload();
                    });
                },
                error: function(xhr) {
                    let errorMsg = 'Ошибка при обновлении тура';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMsg = xhr.responseJSON.message;
                    } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                        errorMsg = Object.values(xhr.responseJSON.errors).flat().join('\n');
                    }
                    swal({
                        title: 'Ошибка!',
                        text: errorMsg,
                        icon: 'error',
                        button: 'ОК',
                    });
                }
            });
        });

        // Add Edit Itinerary
        $('#addEditItinerary').click(function() {
            editItineraryCounter++;
            let html = `
                <div class="mb-3 p-3 edit-itinerary-item" style="border: 1px solid #e0e0e0; border-radius: 4px; position: relative;">
                    <button type="button" class="btn btn-sm btn-danger remove-edit-itinerary" style="position: absolute; top: 10px; right: 10px;"><i class="fas fa-times"></i></button>
                    <h6 class="mb-3" style="color: #6777ef;">День ${editItineraryCounter}</h6>
                    <div class="row">
                        <div class="col-md-6">
                            <label>Номер дня <span class="text-danger">*</span></label>
                            <input type="number" name="itineraries[${editItineraryCounter}][day_number]" class="form-control" value="${editItineraryCounter}" required>
                        </div>
                        <div class="col-md-6">
                            <label>Время <span class="text-danger">*</span></label>
                            <input type="time" name="itineraries[${editItineraryCounter}][event_time]" class="form-control" value="09:00" required>
                        </div>
                    </div>
                    @foreach($languages as $language)
                    <div class="form-group">
                        <label>Активность ({{ $language->name }}) <span class="text-danger">*</span></label>
                        <input type="text" name="itineraries[${editItineraryCounter}][activity_title_{{ $language->code }}]" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Описание ({{ $language->name }}) <span class="text-danger">*</span></label>
                        <textarea name="itineraries[${editItineraryCounter}][activity_description_{{ $language->code }}]" class="form-control" rows="2" required></textarea>
                    </div>
                    @endforeach
                </div>
            `;
            $('#editItinerariesContainer').append(html);
        });

        $(document).on('click', '.remove-edit-itinerary', function() {
            $(this).closest('.edit-itinerary-item').remove();
        });
    });

    function populateEditModal(response) {
        const { tour, translations, itineraries, features, images } = response;

        // Form action
        $('#editForm').attr('action', '/tours/' + tour.id);

        // Basic info
        $('#edit_category_id').val(tour.category_id);
        $('#edit_price').val(tour.price);
        $('#edit_duration_days').val(tour.duration_days);
        $('#edit_duration_nights').val(tour.duration_nights);
        $('#edit_min_age').val(tour.min_age);
        $('#edit_max_people').val(tour.max_people);
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
        $('#currentImages').html(imagesHtml);
        $('#main_image_id').val(mainImageId);

        // Handle main image selection
        $('input[name="main_image_radio"]').on('change', function() {
            $('#main_image_id').val($(this).val());
        });

        // Itineraries
        $('#editItinerariesContainer').empty();
        editItineraryCounter = 0;
        itineraries.forEach((it, index) => {
            editItineraryCounter++;
            let html = `
                <div class="mb-3 p-3 edit-itinerary-item" style="border: 1px solid #e0e0e0; border-radius: 4px; position: relative;">
                    <button type="button" class="btn btn-sm btn-danger remove-edit-itinerary" style="position: absolute; top: 10px; right: 10px;"><i class="fas fa-times"></i></button>
                    <h6 class="mb-3" style="color: #6777ef;">День ${it.day_number}</h6>
                    <div class="row">
                        <div class="col-md-6">
                            <label>Номер дня <span class="text-danger">*</span></label>
                            <input type="number" name="itineraries[${editItineraryCounter}][day_number]" class="form-control" value="${it.day_number}" required>
                        </div>
                        <div class="col-md-6">
                            <label>Время <span class="text-danger">*</span></label>
                            <input type="time" name="itineraries[${editItineraryCounter}][event_time]" class="form-control" value="${it.event_time}" required>
                        </div>
                    </div>`;

            @foreach($languages as $language)
            html += `
                <div class="form-group">
                    <label>Активность ({{ $language->name }}) <span class="text-danger">*</span></label>
                    <input type="text" name="itineraries[${editItineraryCounter}][activity_title_{{ $language->code }}]" class="form-control" value="${it.translations['{{ $language->code }}']?.activity_title || ''}" required>
                </div>
                <div class="form-group">
                    <label>Описание ({{ $language->name }}) <span class="text-danger">*</span></label>
                    <textarea name="itineraries[${editItineraryCounter}][activity_description_{{ $language->code }}]" class="form-control" rows="2" required>${it.translations['{{ $language->code }}']?.activity_description || ''}</textarea>
                </div>
            `;
            @endforeach

            html += `</div>`;
            $('#editItinerariesContainer').append(html);
        });

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
    }
</script>
@endpush
