@extends('layouts.main')

@section('content')
<div class="section-header">
    <h1>О нас</h1>
    <div class="section-header-button">
        <button class="btn btn-warning" data-toggle="modal" data-target="#createModal">
            <i class="fas fa-plus"></i> Добавить запись
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
                                <th>Изображение</th>
                                <th>Заголовок</th>
                                <th>Описание</th>
                                <th>Статус</th>
                                <th>Действия</th>
                            </tr>
                        </thead>
                        <tbody>
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
                                    <button class="btn btn-sm btn-primary" onclick="editAbout({{ $about->id }}, '{{ addslashes($about->translations->first()->title ?? '') }}', '{{ addslashes($about->translations->first()->description ?? '') }}', {{ $about->is_active ? 'true' : 'false' }})">
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

@include('pages.abouts.create-modal')
@include('pages.abouts.edit-modal')
@endsection
