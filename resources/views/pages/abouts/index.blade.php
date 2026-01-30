@extends('layouts.main')

@section('content')
<div class="section-header">
    <h1>О нас</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fas fa-home"></i> Панель управления</a></div>
        <div class="breadcrumb-item active">О нас</div>
        <div class="breadcrumb-item">
            <button class="btn btn-warning rounded-pill" data-toggle="modal" data-target="#createModal">
                <i class="fas fa-plus"></i> Добавить запись
            </button>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4>Список записей</h4>
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
                    <table class="table table-striped" id="aboutTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Изображение</th>
                                <th>Заголовок</th>
                                <th>Описание</th>
                                <th>Статус</th>
                                <th>Действия</th>
                            </tr>
                        </thead>
                        <tbody id="aboutTableBody">
                            @foreach($abouts as $about)
                            <tr>
                                <td>{{ $about->id }}</td>
                                <td>
                                    @if($about->image)
                                        <img src="{{ asset('storage/' . $about->image) }}" alt="about" width="100">
                                    @else
                                        <span class="badge badge-secondary">Нет изображения</span>
                                    @endif
                                </td>
                                <td>{{ $about->translations->first()->title ?? 'N/A' }}</td>
                                <td>{{ Str::limit($about->translations->first()->description ?? 'N/A', 50) }}</td>
                                <td>
                                    @if($about->is_active)
                                        <span class="badge badge-success">Активен</span>
                                    @else
                                        <span class="badge badge-danger">Неактивен</span>
                                    @endif
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-primary" onclick="editAbout({{ $about->id }})">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <form action="{{ route('abouts.destroy', $about->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Вы уверены?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('modals')
    @include('pages.abouts.create-modal')
    @include('pages.abouts.edit-modal')
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    $('#languageFilter').on('change', function() {
        var langCode = $(this).val();

        $.ajax({
            url: '{{ route('abouts.filter') }}',
            type: 'GET',
            data: { lang_code: langCode },
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

    function updateTable(abouts) {
        var tbody = $('#aboutTableBody');
        tbody.empty();

        if (abouts.length === 0) {
            tbody.append('<tr><td colspan="6" class="text-center">Нет данных</td></tr>');
            return;
        }

        abouts.forEach(function(about) {
            var statusBadge = about.is_active ?
                '<span class="badge badge-success">Активен</span>' :
                '<span class="badge badge-danger">Неактивен</span>';

            var description = about.description.length > 50 ? about.description.substring(0, 50) + '...' : about.description;

            var imageCell = about.image ?
                '<img src="/storage/' + about.image + '" alt="about" width="100">' :
                '<span class="badge badge-secondary">Нет изображения</span>';

            var row = '<tr>' +
                '<td>' + about.id + '</td>' +
                '<td>' + imageCell + '</td>' +
                '<td>' + about.title + '</td>' +
                '<td>' + description + '</td>' +
                '<td>' + statusBadge + '</td>' +
                '<td>' +
                    '<button class="btn btn-sm btn-primary" onclick="editAbout(' + about.id + ')">' +
                        '<i class="fas fa-edit"></i>' +
                    '</button> ' +
                    '<form action="/abouts/' + about.id + '" method="POST" style="display:inline-block;" onsubmit="return confirm(\'Вы уверены?\')">' +
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
</script>
@endpush
