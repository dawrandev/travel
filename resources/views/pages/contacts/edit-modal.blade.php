<div class="modal fade" id="editContactModal" tabindex="-1" role="dialog" aria-labelledby="editContactModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editContactModalLabel">Редактировать контакт</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editContactForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label">Телефон <span class="text-danger">*</span></label>
                                <input type="text" name="phone" id="edit_phone" class="form-control" placeholder="+998901234567" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" id="edit_email" class="form-control" placeholder="info@example.com" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label">WhatsApp номер</label>
                                <input type="text" name="whatsapp_phone" id="edit_whatsapp_phone" class="form-control" placeholder="+998901234567">
                            </div>
                        </div>
                    </div>

                    <ul class="nav nav-pills mb-3" id="editContactLanguageTabs" role="tablist">
                        @foreach($languages as $index => $language)
                        <li class="nav-item">
                            <a class="nav-link {{ $index == 0 ? 'active' : '' }}" id="edit-contact-tab-{{ $language->code }}" data-toggle="pill" href="#edit-contact-lang-{{ $language->code }}" role="tab">
                                {{ $language->name }}
                            </a>
                        </li>
                        @endforeach
                    </ul>

                    <div class="tab-content" id="editContactLanguageTabsContent">
                        @foreach($languages as $index => $language)
                        <div class="tab-pane fade {{ $index == 0 ? 'show active' : '' }}" id="edit-contact-lang-{{ $language->code }}" role="tabpanel">
                            <div class="form-group">
                                <label class="form-label">Адрес ({{ $language->name }}) <span class="text-danger">*</span></label>
                                <textarea name="address_{{ $language->code }}" id="edit_address_{{ $language->code }}" class="form-control" rows="3" placeholder="Введите адрес" required></textarea>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div class="row mt-3">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">Местоположение на карте</label>
                                <small class="form-text text-muted mb-2">Нажмите на карту, чтобы выбрать местоположение</small>
                                <div id="editMap" style="height: 400px; width: 100%; border-radius: 8px;"></div>
                                <input type="hidden" name="longitude" id="edit_longitude">
                                <input type="hidden" name="latitude" id="edit_latitude">
                                <div class="mt-2">
                                    <small class="text-muted">
                                        <strong>Координаты:</strong>
                                        <span id="edit_coords_display">Выберите местоположение на карте</span>
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>
                    <h6 class="mb-3">Социальные сети</h6>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Telegram URL</label>
                                <input type="url" name="telegram_url" id="edit_telegram_url" class="form-control" placeholder="https://t.me/username">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Telegram Username</label>
                                <input type="text" name="telegram_username" id="edit_telegram_username" class="form-control" placeholder="username">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Facebook URL</label>
                                <input type="url" name="facebook_url" id="edit_facebook_url" class="form-control" placeholder="https://facebook.com/username">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Facebook Name</label>
                                <input type="text" name="facebook_name" id="edit_facebook_name" class="form-control" placeholder="Page Name">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Instagram URL</label>
                                <input type="url" name="instagram_url" id="edit_instagram_url" class="form-control" placeholder="https://instagram.com/username">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Instagram Username</label>
                                <input type="text" name="instagram_username" id="edit_instagram_username" class="form-control" placeholder="username">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">YouTube URL</label>
                                <input type="url" name="youtube_url" id="edit_youtube_url" class="form-control" placeholder="https://youtube.com/@channel">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-sync-alt"></i> Обновить
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>