@extends('layouts.main')

@section('content')
<div class="section-header">
    <h1>Функции</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fas fa-home"></i> Панель управления</a></div>
        <div class="breadcrumb-item active">Функции</div>
        <div class="breadcrumb-item">
            <button class="btn btn-warning rounded-pill" data-toggle="modal" data-target="#createModal">
                <i class="fas fa-plus"></i> Добавить функцию
            </button>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4>Список функций</h4>
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
                    <table class="table table-striped" id="featureTable">
                        <thead>
                            <tr>
                                <th>№</th>
                                <th>Иконка</th>
                                <th>Название</th>
                                <th>Описание</th>
                                <th>Действия</th>
                            </tr>
                        </thead>
                        <tbody id="featureTableBody">
                            @foreach($features as $feature)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    @if($feature->icon)
                                    <i class="{{ $feature->icon }}" style="font-size: 32px; color: #6777ef;"></i>
                                    @else
                                    <span class="badge badge-secondary">Нет иконки</span>
                                    @endif
                                </td>
                                <td>{{ $feature->translations->first()->name ?? 'N/A' }}</td>
                                <td>{{ Str::limit($feature->translations->first()->description ?? 'N/A', 60) }}</td>
                                <td>
                                    <button class="btn btn-primary" onclick="editFeature({{ $feature->id }})"
                                        style="width: 30px; height: 30px; display: inline-flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-edit"></i>
                                    </button>

                                    <form action="{{ route('features.destroy', $feature->id) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger"
                                            style="width: 30px; height: 30px; display: inline-flex; align-items: center; justify-content: center;">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $features->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@push('modals')
@include('pages.features.create-modal')
@include('pages.features.edit-modal')
@endpush

<!-- Icon Picker Modal (Outside of push to ensure proper z-index) -->
<div class="modal fade" id="iconPickerModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Выбрать иконку</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="text" id="iconSearch" class="form-control mb-3" placeholder="Поиск иконки...">
                <div id="iconList" style="max-height: 400px; overflow-y: auto; display: grid; grid-template-columns: repeat(auto-fill, minmax(80px, 1fr)); gap: 10px;">
                    <!-- Icons will be loaded here -->
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Ensure icon picker modal appears above other modals */
    #iconPickerModal {
        z-index: 1060 !important;
    }

    #iconPickerModal+.modal-backdrop {
        z-index: 1055 !important;
    }
</style>

@push('scripts')
<script>
    // Routes - Prettier formatter won't break these
    const ROUTES = {
        filter: '{{ route("features.filter") }}',
        translations: '/features/{id}/translations',
        destroy: '/features/{id}'
    };

    $(document).ready(function() {
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

        function updateTable(features) {
            var tbody = $('#featureTableBody');
            tbody.empty();

            if (features.length === 0) {
                tbody.append('<tr><td colspan="5" class="text-center">Нет данных</td></tr>');
                return;
            }

            features.forEach(function(feature, index) {
                var description = feature.description.length > 60 ? feature.description.substring(0, 60) + '...' : feature.description;

                var iconHtml = feature.icon ?
                    '<i class="' + feature.icon + '" style="font-size: 32px; color: #6777ef;"></i>' :
                    '<span class="badge badge-secondary">Нет иконки</span>';

                var row = '<tr>' +
                    '<td>' + (index + 1) + '</td>' +
                    '<td>' + iconHtml + '</td>' +
                    '<td>' + feature.name + '</td>' +
                    '<td>' + description + '</td>' +
                    '<td>' +
                    '<button class="btn btn-sm btn-primary" onclick="editFeature(' + feature.id + ')">' +
                    '<i class="fas fa-edit"></i>' +
                    '</button> ' +
                    '<form action="/features/' + feature.id + '" method="POST" style="display:inline-block;" data-confirm-delete data-item-name="функцию">' +
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

    // Edit Feature function
    function editFeature(id) {
        $.ajax({
            url: ROUTES.translations.replace('{id}', id),
            type: 'GET',
            success: function(response) {
                if (response.success) {
                    $('#editForm').attr('action', ROUTES.destroy.replace('{id}', id));

                    // Show current icon if exists
                    if (response.feature.icon) {
                        $('#editIconInput').val(response.feature.icon);
                        $('#editIconPreviewIcon').attr('class', response.feature.icon);
                        $('#editIconPreview').show();
                    } else {
                        $('#editIconInput').val('');
                        $('#editIconPreview').hide();
                    }

                    // Fill translations for each language
                    @foreach($languages as $language)
                    if (response.translations['{{ $language->code }}']) {
                        $('#edit_name_{{ $language->code }}').val(response.translations['{{ $language->code }}'].name);
                        $('#edit_description_{{ $language->code }}').val(response.translations['{{ $language->code }}'].description);
                    }
                    @endforeach

                    $('#editModal').modal('show');
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

    // ========== ICON PICKER ==========
    // Popular FontAwesome 6 Free icons
    const faIcons = [
        'fa-star', 'fa-heart', 'fa-user', 'fa-home', 'fa-search', 'fa-envelope', 'fa-cog', 'fa-bell',
        'fa-plane', 'fa-car', 'fa-bus', 'fa-train', 'fa-ship', 'fa-bicycle', 'fa-motorcycle', 'fa-taxi',
        'fa-hotel', 'fa-bed', 'fa-utensils', 'fa-coffee', 'fa-wine-glass', 'fa-pizza-slice', 'fa-hamburger',
        'fa-map', 'fa-map-marker-alt', 'fa-location-dot', 'fa-compass', 'fa-globe', 'fa-mountain', 'fa-tree',
        'fa-sun', 'fa-moon', 'fa-cloud', 'fa-snowflake', 'fa-wind', 'fa-umbrella', 'fa-rainbow',
        'fa-camera', 'fa-image', 'fa-video', 'fa-music', 'fa-headphones', 'fa-microphone', 'fa-film',
        'fa-book', 'fa-bookmark', 'fa-newspaper', 'fa-pen', 'fa-pencil', 'fa-brush', 'fa-paint-brush',
        'fa-shopping-cart', 'fa-shopping-bag', 'fa-credit-card', 'fa-money-bill', 'fa-wallet', 'fa-gift',
        'fa-trophy', 'fa-medal', 'fa-award', 'fa-ribbon', 'fa-gem', 'fa-crown', 'fa-certificate',
        'fa-calendar', 'fa-clock', 'fa-stopwatch', 'fa-hourglass', 'fa-alarm-clock', 'fa-timer',
        'fa-phone', 'fa-mobile', 'fa-fax', 'fa-comment', 'fa-comments', 'fa-message', 'fa-inbox',
        'fa-flag', 'fa-tag', 'fa-tags', 'fa-thumbs-up', 'fa-thumbs-down', 'fa-check',
        'fa-times', 'fa-plus', 'fa-minus', 'fa-circle', 'fa-square', 'fa-triangle', 'fa-star-half',
        'fa-fire', 'fa-bolt', 'fa-rocket', 'fa-shuttle-space', 'fa-helicopter', 'fa-parachute-box',
        'fa-anchor', 'fa-life-ring', 'fa-sailboat', 'fa-person-swimming', 'fa-fish', 'fa-whale',
        'fa-paw', 'fa-dog', 'fa-cat', 'fa-horse', 'fa-bird', 'fa-spider', 'fa-frog', 'fa-hippo',
        'fa-suitcase', 'fa-briefcase', 'fa-bag-shopping', 'fa-basket-shopping', 'fa-luggage-cart',
        'fa-ticket', 'fa-passport', 'fa-id-card', 'fa-key', 'fa-lock', 'fa-unlock', 'fa-shield',
        'fa-wifi', 'fa-bluetooth', 'fa-battery-full', 'fa-plug', 'fa-lightbulb', 'fa-laptop', 'fa-desktop',
        'fa-mobile-screen', 'fa-tablet', 'fa-tv', 'fa-keyboard', 'fa-mouse', 'fa-print', 'fa-floppy-disk',
        'fa-database', 'fa-server', 'fa-hard-drive', 'fa-cloud-arrow-down', 'fa-cloud-arrow-up',
        'fa-code', 'fa-terminal', 'fa-bug', 'fa-file-code', 'fa-folder', 'fa-file', 'fa-download',
        'fa-upload', 'fa-share', 'fa-link', 'fa-paperclip', 'fa-scissors', 'fa-copy', 'fa-paste',
        'fa-magnifying-glass', 'fa-magnifying-glass-plus', 'fa-magnifying-glass-minus', 'fa-eye', 'fa-eye-slash',
        'fa-arrows-rotate', 'fa-rotate', 'fa-gear', 'fa-wrench', 'fa-screwdriver', 'fa-hammer', 'fa-tools'
    ];

    let selectedIconInput = null;
    let selectedIconPreview = null;

    // Load icons into picker
    function loadIcons() {
        const iconList = $('#iconList');
        iconList.empty();

        faIcons.forEach(icon => {
            const iconClass = 'fas ' + icon;
            const iconElement = $('<div>')
                .addClass('text-center p-2 border rounded cursor-pointer icon-item')
                .attr('data-icon', iconClass)
                .css({
                    'cursor': 'pointer',
                    'transition': 'all 0.3s'
                })
                .html('<i class="' + iconClass + '" style="font-size: 24px;"></i><br><small style="font-size: 9px;">' + icon.replace('fa-', '') + '</small>')
                .hover(
                    function() {
                        $(this).css('background-color', '#f0f0f0');
                    },
                    function() {
                        $(this).css('background-color', '');
                    }
                )
                .click(function() {
                    selectIcon(iconClass);
                });
            iconList.append(iconElement);
        });
    }

    // Select icon
    function selectIcon(iconClass) {
        if (selectedIconInput) {
            selectedIconInput.val(iconClass);
            if (selectedIconPreview) {
                selectedIconPreview.attr('class', iconClass).show();
                selectedIconPreview.parent().show();
            }
        }
        $('#iconPickerModal').modal('hide');
    }

    // Open icon picker for CREATE modal
    $(document).on('click', '#createModal button[data-target="#iconPickerModal"]', function(e) {
        e.preventDefault();
        selectedIconInput = $('#iconInput');
        selectedIconPreview = $('#iconPreviewIcon');

        // Close create modal temporarily
        $('#createModal').modal('hide');

        // Open icon picker
        setTimeout(function() {
            loadIcons();
            $('#iconPickerModal').modal('show');
        }, 300);
    });

    // Open icon picker for EDIT modal
    $(document).on('click', '#editModal button[data-target="#iconPickerModal"]', function(e) {
        e.preventDefault();
        selectedIconInput = $('#editIconInput');
        selectedIconPreview = $('#editIconPreviewIcon');

        // Close edit modal temporarily
        $('#editModal').modal('hide');

        // Open icon picker
        setTimeout(function() {
            loadIcons();
            $('#iconPickerModal').modal('show');
        }, 300);
    });

    // When icon picker closes, reopen the previous modal
    let previousModal = null;

    $(document).on('show.bs.modal', '#iconPickerModal', function() {
        // Determine which modal was open before
        if ($('#createModal').hasClass('show') || selectedIconInput && selectedIconInput.attr('id') === 'iconInput') {
            previousModal = '#createModal';
        } else if ($('#editModal').hasClass('show') || selectedIconInput && selectedIconInput.attr('id') === 'editIconInput') {
            previousModal = '#editModal';
        }
    });

    $(document).on('hidden.bs.modal', '#iconPickerModal', function() {
        // Reopen previous modal
        if (previousModal) {
            setTimeout(function() {
                $(previousModal).modal('show');
                previousModal = null;
            }, 300);
        }

        // Reset search
        $('#iconSearch').val('');
        $('.icon-item').show();
    });

    // Search icons
    $('#iconSearch').on('input', function() {
        const search = $(this).val().toLowerCase();
        $('.icon-item').each(function() {
            const icon = $(this).attr('data-icon').toLowerCase();
            if (icon.includes(search)) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });

    // Reset edit modal when it closes
    $('#editModal').on('hidden.bs.modal', function() {
        $('#editIconInput').val('');
        $('#editIconPreview').hide();
    });
</script>
@endpush