@extends('layouts.main')

@section('content')
<div class="section-header">
    <h1>Часто задаваемые вопросы</h1>
    <div class="section-header-button">
        <button class="btn btn-warning" data-toggle="modal" data-target="#createModal">
            <i class="fas fa-plus"></i> Добавить вопрос
        </button>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="table-1">
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
                        <tbody>
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
                                    <button class="btn btn-sm btn-primary" onclick="editFaq({{ $faq->id }}, '{{ addslashes($faq->translations->first()->question ?? '') }}', '{{ addslashes($faq->translations->first()->answer ?? '') }}', {{ $faq->sort_order }}, {{ $faq->is_active ? 'true' : 'false' }})">
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

@include('pages.faqs.create-modal')
@include('pages.faqs.edit-modal')
@endsection
