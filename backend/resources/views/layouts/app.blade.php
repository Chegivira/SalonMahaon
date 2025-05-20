<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Салон красоты "Махаон"</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
<!-- Хедер -->
<header>
    <nav>
        <ul>
            <li><a href="{{ url('/') }}">Главная</a></li>
            @guest
                <li><a href="{{ route('login') }}">Войти</a></li>
                <li><a href="{{ route('register') }}">Регистрация</a></li>
            @else
                <li><a href="{{ route('profile') }}">{{ Auth::user()->last_name }} {{ Auth::user()->first_name }}</a></li>
                <li>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit">Выйти</button>
                    </form>
                </li>
            @endguest
        </ul>
    </nav>
</header>

<main>
    @yield('content')
</main>
</body>
</html>
