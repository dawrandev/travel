@extends('layouts.main')

@section('content')
<div class="section-header">
    <h1>Языки</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fas fa-home"></i> Панель управления</a></div>
        <div class="breadcrumb-item active">Языки</div>
        <div class="breadcrumb-item">
            <button class="btn btn-warning rounded-pill" data-toggle="modal" data-target="#createLanguageModal">
                <i class="fas fa-plus"></i> Добавить язык
            </button>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4>Список языков</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>№</th>
                                <th>Название</th>
                                <th>Код</th>
                                <th>Статус</th>
                                <th>Действия</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($languages as $language)
                            <tr>
                                <td>{{ ($languages->currentPage() - 1) * $languages->perPage() + $loop->iteration }}</td>
                                <td>{{ $language->name }}</td>
                                <td><span class="badge badge-info">{{ $language->code }}</span></td>
                                <td>
                                    @if($language->is_active)
                                    <span class="badge badge-success">Активен</span>
                                    @else
                                    <span class="badge badge-danger">Неактивен</span>
                                    @endif
                                </td>
                                <td>
                                    <button class="btn btn-primary" onclick="editLanguage({{ $language->id }})"
                                        style="width: 30px; height: 30px; display: inline-flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-edit"></i>
                                    </button>

                                    <form action="{{ route('languages.destroy', $language->id) }}" method="POST" style="display:inline-block;" data-confirm-delete data-item-name="язык">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger"
                                            style="width: 30px; height: 30px; display: inline-flex; align-items: center; justify-content: center;">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center">Нет данных</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                {{ $languages->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@push('modals')
@include('pages.languages.create-modal')
@include('pages.languages.edit-modal')
@endpush

@push('scripts')
<script>
    const ROUTES = {
        update: '/languages/{id}',
        destroy: '/languages/{id}'
    };

    function editLanguage(id) {
        $.ajax({
            url: ROUTES.update.replace('{id}', id),
            type: 'GET',
            success: function(response) {
                if (response.success) {
                    $('#editForm').attr('action', ROUTES.update.replace('{id}', id));
                    $('#editName').val(response.language.name);
                    $('#editCode').val(response.language.code);
                    $('#editIsActive').prop('checked', response.language.is_active);
                    $('#editLanguageModal').modal('show');
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
</script>
@endpush
