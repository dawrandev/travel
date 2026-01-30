@extends('layouts.main')

@section('content')
<div class="section-header">
    <h1>Слайды Hero</h1>
    <div class="section-header-button">
        <button class="btn btn-warning" data-toggle="modal" data-target="#createModal">
            <i class="fas fa-plus"></i> Добавить слайд
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
                                <th>Подзаголовок</th>
                                <th>Порядок</th>
                                <th>Статус</th>
                                <th>Действия</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($heroSlides as $slide)
                            <tr>
                                <td>{{ $slide->id }}</td>
                                <td>
                                    <img src="{{ asset('storage/' . $slide->image_path) }}" alt="slide" width="100">
                                </td>
                                <td>{{ $slide->translations->first()->title ?? 'N/A' }}</td>
                                <td>{{ $slide->translations->first()->subtitle ?? 'N/A' }}</td>
                                <td>{{ $slide->sort_order }}</td>
                                <td>
                                    @if($slide->is_active)
                                        <span class="badge badge-success">Активен</span>
                                    @else
                                        <span class="badge badge-danger">Неактивен</span>
                                    @endif
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-primary" onclick="editSlide({{ $slide->id }}, '{{ $slide->translations->first()->title ?? '' }}', '{{ $slide->translations->first()->subtitle ?? '' }}', {{ $slide->sort_order }}, {{ $slide->is_active ? 'true' : 'false' }})">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <form action="{{ route('hero-slides.destroy', $slide->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Вы уверены?');">
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

@include('pages.hero-slides.create-modal')
@include('pages.hero-slides.edit-modal')
@endsection
