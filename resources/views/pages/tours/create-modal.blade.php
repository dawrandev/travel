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
                                <label>Цена (сўм) <span class="text-danger">*</span></label>
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
                        <i class="fas fa-info-circle"></i> Необходимо добавить минимум 1 день
                    </small>
                    <div id="itinerariesContainer"></div>

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
@endpush

@push('scripts')
<script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
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

        // Handle form submit
        $('#createForm').on('submit', function(e) {
            e.preventDefault();

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

            // Check if at least one itinerary is added
            const itinerariesCount = $('.itinerary-item').length;
            if (itinerariesCount === 0) {
                swal({
                    title: 'Ошибка!',
                    text: 'Добавьте хотя бы один день в маршрут',
                    icon: 'error',
                    button: 'ОК',
                });
                return false;
            }

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
                        text: 'Тур успешно создан',
                        icon: 'success',
                        button: 'ОК',
                    }).then(() => {
                        location.reload();
                    });
                },
                error: function(xhr) {
                    let errorMsg = 'Ошибка при создании тура';
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

        // Add Itinerary
        $('#addItinerary').click(function() {
            itineraryCounter++;
            let html = `
                <div class="mb-3 p-3 itinerary-item" style="border: 1px solid #e0e0e0; border-radius: 4px; position: relative;">
                    <button type="button" class="btn btn-sm btn-danger remove-itinerary" style="position: absolute; top: 10px; right: 10px;">
                        <i class="fas fa-times"></i>
                    </button>
                    <h6 class="mb-3" style="color: #6777ef;">День ${itineraryCounter}</h6>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Номер дня <span class="text-danger">*</span></label>
                                <input type="number" name="itineraries[${itineraryCounter}][day_number]" class="form-control" value="${itineraryCounter}" min="1" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Время <span class="text-danger">*</span></label>
                                <input type="time" name="itineraries[${itineraryCounter}][event_time]" class="form-control" value="09:00" required>
                            </div>
                        </div>
                    </div>
                    @foreach($languages as $language)
                    <div class="form-group">
                        <label>Активность ({{ $language->name }}) <span class="text-danger">*</span></label>
                        <input type="text" name="itineraries[${itineraryCounter}][activity_title_{{ $language->code }}]" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Описание ({{ $language->name }}) <span class="text-danger">*</span></label>
                        <textarea name="itineraries[${itineraryCounter}][activity_description_{{ $language->code }}]" class="form-control" rows="2" required></textarea>
                    </div>
                    @endforeach
                </div>
            `;
            $('#itinerariesContainer').append(html);
        });

        // Remove Itinerary
        $(document).on('click', '.remove-itinerary', function() {
            $(this).closest('.itinerary-item').remove();
        });

        // Reset on modal close
        $('#createModal').on('hidden.bs.modal', function() {
            $('#createForm')[0].reset();
            createDropzone.removeAllFiles();
            $('#itinerariesContainer').empty();
            itineraryCounter = 0;
        });
    });
</script>
@endpush
