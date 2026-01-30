<!DOCTYPE html>

<html lang="ru">



<head>

    <meta charset="UTF-8">

    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Вход - Travel Admin</title>

    <link rel="stylesheet" href="{{ asset('assets/css/app.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/components.css') }}">

    <link rel='shortcut icon' type='image/x-icon' href="{{ asset('assets/img/favicon.ico') }}" />

    <style>
        /* Agar loader xalaqit bersa, uni majburiy yashiramiz */

        .loader {

            display: none !important;

        }



        body {

            background-color: #f4f6f9;

        }
    </style>

</head>



<body>

    <div id="app">

        <section class="section">

            <div class="container" style="margin-top: 12vh;">

                <div class="row">

                    <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-5 mx-auto" style="margin-top: 13vh;">

                        <div class="card card-warning shadow-lg">

                            <div class="card-header text-center d-block">

                                <h4 class="mb-0">Вход в систему</h4>

                            </div>

                            <div class="card-body">

                                <form method="POST" action="{{ route('login.post') }}">

                                    @csrf

                                    <div class="form-group">

                                        <label for="login">Логин</label>

                                        <input id="login" type="text" class="form-control" name="login" value="{{ old('login') }}" required autofocus>

                                    </div>

                                    <div class="form-group">

                                        <label for="password">Пароль</label>

                                        <input id="password" type="password" class="form-control" name="password" required>

                                    </div>

                                    <div class="form-group">

                                        <div class="custom-control custom-checkbox">

                                            <input type="checkbox" name="remember" class="custom-control-input" id="remember-me">

                                            <label class="custom-control-label" for="remember-me">Запомнить меня</label>

                                        </div>

                                    </div>

                                    <div class="form-group">

                                        <button type="submit" class="btn btn-warning btn-lg btn-block">

                                            Войти

                                        </button>

                                    </div>

                                </form>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </section>

    </div>



    <script src="{{ asset('assets/js/app.min.js') }}"></script>

    <script src="{{ asset('assets/js/scripts.js') }}"></script>

</body>



</html>