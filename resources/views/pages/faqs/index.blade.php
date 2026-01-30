@extends('layouts.main')

@section('content')
<div class="section-header">
    <h1>Часто задаваемые вопросы</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fas fa-home"></i> Панель управления</a></div>
        <div class="breadcrumb-item active">Часто задаваемые вопросы</div>
        <div class="breadcrumb-item">
            <button class="btn btn-warning rounded-pill" data-toggle="modal" data-target="#createModal">
                <i class="fas fa-plus"></i> Добавить вопрос
            </button>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4>Список вопросов</h4>
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
                    <table class="table table-striped" id="faqTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Вопрос</th>
                                <th>Ответ</th>
                                <th>Порядок</th>
                                <th>Статус</th>
                                <th>Действия</th>
                            </tr>
                        </thead>
                        <tbody id="faqTableBody">
                            @foreach($faqs as $faq)
                            <tr>
                                <td>{{ $faq->id }}</td>
                                <td>{{ $faq->translations->first()->question ?? 'N/A' }}</td>
                                <td>{{ Str::limit($faq->translations->first()->answer ?? 'N/A', 50) }}</td>
                                <td>{{ $faq->sort_order }}</td>
                                <td>
                                    @if($faq->is_active)
                                    <span class="badge badge-success">Активен</span>
                                    @else
                                    <span class="badge badge-danger">Неактивен</span>
                                    @endif
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-primary" onclick="editFaq({{ $faq->id }})">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <form action="{{ route('faqs.destroy', $faq->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Вы уверены?');">
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
@include('pages.faqs.create-modal')
@include('pages.faqs.edit-modal')
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    $('#languageFilter').on('change', function() {
        var langCode = $(this).val();

        $.ajax({
            url: '{{ route('faqs.filter') }}',
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

    function updateTable(faqs) {
        var tbody = $('#faqTableBody');
        tbody.empty();

        if (faqs.length === 0) {
            tbody.append('<tr><td colspan="6" class="text-center">Нет данных</td></tr>');
            return;
        }

        faqs.forEach(function(faq) {
            var statusBadge = faq.is_active ?
                '<span class="badge badge-success">Активен</span>' :
                '<span class="badge badge-danger">Неактивен</span>';

            var answer = faq.answer.length > 50 ? faq.answer.substring(0, 50) + '...' : faq.answer;

            var row = '<tr>' +
                '<td>' + faq.id + '</td>' +
                '<td>' + faq.question + '</td>' +
                '<td>' + answer + '</td>' +
                '<td>' + faq.sort_order + '</td>' +
                '<td>' + statusBadge + '</td>' +
                '<td>' +
                    '<button class="btn btn-sm btn-primary" onclick="editFaq(' + faq.id + ')">' +
                        '<i class="fas fa-edit"></i>' +
                    '</button> ' +
                    '<form action="/faqs/' + faq.id + '" method="POST" style="display:inline-block;" onsubmit="return confirm(\'Вы уверены?\')">' +
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