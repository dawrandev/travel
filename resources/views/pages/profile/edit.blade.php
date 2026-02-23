@extends('layouts.main')

@section('content')
    <div class="section">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Профиль администратора</h4>
                        </div>
                        <div class="card-body">
                            @if ($errors->any())
                                <div class="alert alert-danger alert-has-icon">
                                    <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
                                    <div class="alert-body">
                                        <b>Ошибка!</b>
                                        <ul class="mb-0 mt-2">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            @endif

                            @if (session('success'))
                                <div class="alert alert-success alert-has-icon">
                                    <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
                                    <div class="alert-body">
                                        <b>Успешно!</b>
                                        <p>{{ session('success') }}</p>
                                    </div>
                                </div>
                            @endif

                            <form action="{{ route('profile.update') }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="form-group">
                                    <label for="login">Логин</label>
                                    <input type="text" class="form-control @error('login') is-invalid @enderror"
                                           id="login" name="login" value="{{ old('login', Auth::user()->login) }}"
                                           required>
                                    @error('login')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="password">Новый пароль <small class="text-muted">(оставьте пустым, чтобы не менять)</small></label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                           id="password" name="password" placeholder="Введите новый пароль">
                                    @error('password')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="password_confirmation">Подтвердить пароль</label>
                                    <input type="password" class="form-control"
                                           id="password_confirmation" name="password_confirmation"
                                           placeholder="Подтвердите пароль">
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Сохранить изменения</button>
                                    <a href="{{ route('dashboard') }}" class="btn btn-secondary">Отмена</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
