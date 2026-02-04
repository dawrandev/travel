<div class="modal fade" id="createBannerModal" tabindex="-1" role="dialog" aria-labelledby="createBannerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createBannerModalLabel">Создать баннер</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('reviews.banner.store') }}" method="POST" enctype="multipart/form-data" id="createBannerForm">
                @csrf
                <div class="modal-body">
                    <!-- Language Tabs -->
                    <ul class="nav nav-pills mb-3" id="createBannerLanguageTabs" role="tablist">
                        @foreach($languages as $index => $language)
                        <li class="nav-item">
                            <a class="nav-link {{ $index == 0 ? 'active' : '' }}" id="create-banner-tab-{{ $language->code }}" data-toggle="pill" href="#create-banner-lang-{{ $language->code }}" role="tab">
                                {{ $language->name }}
                            </a>
                        </li>
                        @endforeach
                    </ul>

                    <div class="tab-content" id="createBannerLanguageTabsContent">
                        @foreach($languages as $index => $language)
                        <div class="tab-pane fade {{ $index == 0 ? 'show active' : '' }}" id="create-banner-lang-{{ $language->code }}" role="tabpanel">
                            <div class="form-group">
                                <label class="form-label">Заголовок баннера ({{ $language->name }}) <span class="text-danger">*</span></label>
                                <input type="text" name="banner_title_{{ $language->code }}" class="form-control" placeholder="Введите заголовок" required>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <hr>

                    <!-- Banner Image -->
                    <div class="form-group">
                        <label class="form-label">Изображение баннера <span class="text-danger">*</span></label>
                        <div class="custom-file">
                            <input type="file" name="banner_image" class="custom-file-input" id="banner_image_create" accept="image/*" required>
                            <label class="custom-file-label" for="banner_image_create">Выберите изображение</label>
                        </div>
                        <small class="form-text text-muted">Рекомендуемый размер: 1920x600px. Макс. 10MB</small>
                    </div>

                    <!-- Preview -->
                    <div class="form-group">
                        <div id="banner_preview_create" style="display: none;">
                            <label class="form-label">Предпросмотр:</label>
                            <img id="banner_preview_img_create" class="img-fluid rounded" style="max-height: 300px;" alt="Preview">
                        </div>
                    </div>

                    <hr>

                    <!-- Status -->
                    <div class="form-group">
                        <label class="form-label">Статус</label>
                        <div class="custom-control custom-checkbox mt-2">
                            <input type="checkbox" class="custom-control-input" name="is_active" id="banner_is_active_create" value="1" checked>
                            <label class="custom-control-label" for="banner_is_active_create">Активен</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i> Создать
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        // Image preview for create banner
        $('#banner_image_create').on('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                $(this).next('.custom-file-label').text(file.name);

                const reader = new FileReader();
                reader.onload = function(e) {
                    $('#banner_preview_img_create').attr('src', e.target.result);
                    $('#banner_preview_create').show();
                }
                reader.readAsDataURL(file);
            }
        });

        // Reset on modal close
        $('#createBannerModal').on('hidden.bs.modal', function() {
            $('#createBannerForm')[0].reset();
            $('#banner_image_create').next('.custom-file-label').text('Выберите изображение');
            $('#banner_preview_create').hide();
        });
    });
</script>
@endpush
