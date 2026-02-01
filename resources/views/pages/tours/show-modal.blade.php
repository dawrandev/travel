<div class="modal fade" id="showModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Просмотр тура</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Images Carousel -->
                <div id="showImagesCarousel" class="carousel slide mb-4" data-ride="carousel">
                    <div class="carousel-inner" id="showCarouselInner">
                        <!-- Will be populated by JS -->
                    </div>
                    <a class="carousel-control-prev" href="#showImagesCarousel" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    </a>
                    <a class="carousel-control-next" href="#showImagesCarousel" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    </a>
                </div>

                <!-- Tour Info -->
                <h4 id="showTitle"></h4>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <p><strong>Категория:</strong> <span id="showCategory"></span></p>
                        <p><strong>Цена:</strong> <span id="showPrice"></span></p>
                        <p><strong>Продолжительность:</strong> <span id="showDuration"></span></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Минимальный возраст:</strong> <span id="showMinAge"></span></p>
                        <p><strong>Макс. человек:</strong> <span id="showMaxPeople"></span></p>
                        <p><strong>Статус:</strong> <span id="showStatus"></span></p>
                    </div>
                </div>

                <h5>Описание</h5>
                <p id="showDescription"></p>

                <h5>Маршруты</h5>
                <p id="showRoutes"></p>

                <h5>Важная информация</h5>
                <p id="showImportantInfo"></p>

                <!-- Itineraries -->
                <h5>Маршрут по дням</h5>
                <ul class="nav nav-pills mb-3" id="showItinerariesTabs" role="tablist">
                    <!-- Tabs will be populated by JS -->
                </ul>
                <div class="tab-content" id="showItinerariesContent">
                    <!-- Tab content will be populated by JS -->
                </div>

                <!-- Features -->
                <div class="row">
                    <div class="col-md-6">
                        <h5 class="text-success"><i class="fas fa-check-circle"></i> Включено</h5>
                        <div id="showIncluded"></div>
                    </div>
                    <div class="col-md-6">
                        <h5 class="text-danger"><i class="fas fa-times-circle"></i> Не включено</h5>
                        <div id="showExcluded"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function populateShowModal(tour) {
        // Images
        let carouselHtml = '';
        tour.images.forEach((img, index) => {
            carouselHtml += `
                <div class="carousel-item ${index === 0 ? 'active' : ''}">
                    <img src="/storage/${img.image_path}" class="d-block w-100" style="max-height: 400px; object-fit: cover;">
                    ${img.is_main ? '<span class="badge badge-warning" style="position: absolute; top: 10px; left: 10px;">Главное фото</span>' : ''}
                </div>
            `;
        });
        $('#showCarouselInner').html(carouselHtml);

        // Find Russian translations
        const ruTranslation = tour.translations.find(t => t.lang_code === 'ru') || tour.translations[0];
        const ruCategory = tour.category.translations.find(t => t.lang_code === 'ru') || tour.category.translations[0];

        // Info
        $('#showTitle').text(ruTranslation?.title || 'N/A');
        $('#showCategory').text(ruCategory?.name || 'N/A');
        $('#showPrice').text(parseFloat(tour.price).toLocaleString('ru-RU') + ' сўм');
        $('#showDuration').text(tour.duration_days + ' дней / ' + tour.duration_nights + ' ночей');
        $('#showMinAge').text(tour.min_age || 'Не указан');
        $('#showMaxPeople').text(tour.max_people || 'Не указан');
        $('#showStatus').html(tour.is_active ? '<span class="badge badge-success">Активен</span>' : '<span class="badge badge-danger">Неактивен</span>');

        $('#showDescription').text(ruTranslation?.description || '');
        $('#showRoutes').text(ruTranslation?.routes || '');
        $('#showImportantInfo').text(ruTranslation?.important_info || 'Не указана');

        // Itineraries - Group by day
        if (tour.itineraries && tour.itineraries.length > 0) {
            // Group itineraries by day_number
            const itinerariesByDay = {};
            tour.itineraries.forEach(it => {
                if (!itinerariesByDay[it.day_number]) {
                    itinerariesByDay[it.day_number] = [];
                }
                itinerariesByDay[it.day_number].push(it);
            });

            // Sort days
            const days = Object.keys(itinerariesByDay).sort((a, b) => a - b);

            // Create tabs
            let tabsHtml = '';
            let tabContentHtml = '';

            days.forEach((day, index) => {
                const isActive = index === 0 ? 'active' : '';

                // Tab navigation
                tabsHtml += `
                    <li class="nav-item">
                        <a class="nav-link ${isActive}" id="day-${day}-tab" data-toggle="pill" href="#day-${day}" role="tab">
                            День ${day}
                        </a>
                    </li>
                `;

                // Tab content
                let dayContent = '';
                itinerariesByDay[day].forEach(it => {
                    const ruItTranslation = it.translations.find(t => t.lang_code === 'ru') || it.translations[0];
                    dayContent += `
                        <div class="mb-3 pb-3" style="border-bottom: 1px solid #e0e0e0;">
                            <div class="d-flex align-items-center mb-2">
                                <i class="fas fa-clock mr-2" style="color: #6777ef;"></i>
                                <strong>${it.event_time}</strong>
                            </div>
                            <h6 class="mb-2">${ruItTranslation?.activity_title || ''}</h6>
                            <p class="text-muted mb-0">${ruItTranslation?.activity_description || ''}</p>
                        </div>
                    `;
                });

                tabContentHtml += `
                    <div class="tab-pane fade ${isActive} show" id="day-${day}" role="tabpanel">
                        ${dayContent}
                    </div>
                `;
            });

            $('#showItinerariesTabs').html(tabsHtml);
            $('#showItinerariesContent').html(tabContentHtml);
        } else {
            $('#showItinerariesTabs').html('');
            $('#showItinerariesContent').html('<p class="text-muted">Маршрут не указан</p>');
        }

        // Features - Separate included and excluded
        let includedHtml = '';
        let excludedHtml = '';

        tour.features.forEach(feature => {
            const ruFeature = feature.translations.find(t => t.lang_code === 'ru') || feature.translations[0];
            const featureItem = `
                <div class="mb-2">
                    <i class="${feature.icon}" style="color: #6777ef;"></i> ${ruFeature?.name || ''}
                </div>
            `;

            // Check if feature is included (pivot.is_included)
            if (feature.pivot && feature.pivot.is_included) {
                includedHtml += featureItem;
            } else {
                excludedHtml += featureItem;
            }
        });

        $('#showIncluded').html(includedHtml || '<p class="text-muted">Нет функций</p>');
        $('#showExcluded').html(excludedHtml || '<p class="text-muted">Нет функций</p>');
    }
</script>
@endpush
