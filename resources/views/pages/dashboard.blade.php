@extends('layouts.main')

@section('content')
<div class="section-header">
    <h1>Панель управления</h1>
</div>

<div class="row">
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
            <div class="card-icon bg-warning">
                <i class="far fa-images"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4>Слайды</h4>
                </div>
                <div class="card-body">
                    {{ \App\Models\HeroSlide::count() }}
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
            <div class="card-icon bg-warning">
                <i class="far fa-question-circle"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4>Вопросы</h4>
                </div>
                <div class="card-body">
                    {{ \App\Models\Faq::count() }}
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
            <div class="card-icon bg-warning">
                <i class="far fa-file"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4>О нас</h4>
                </div>
                <div class="card-body">
                    {{ \App\Models\About::count() }}
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
            <div class="card-icon bg-warning">
                <i class="fas fa-circle"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4>Активные</h4>
                </div>
                <div class="card-body">
                    {{ \App\Models\HeroSlide::where('is_active', true)->count() }}
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4>Добро пожаловать в панель управления Travel</h4>
            </div>
            <div class="card-body">
                <p>Используйте меню слева для управления контентом сайта.</p>
            </div>
        </div>
    </div>
</div>
@endsection
