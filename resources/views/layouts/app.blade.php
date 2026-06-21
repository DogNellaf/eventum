<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/styles/app.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <title>@yield('title')</title>
</head>
<body>
    <header>
        <nav class="navbar navbar-light bg-light">
            <div class="container-fluid">
                <a href="{{ route('index') }}" class="navbar-brand me-auto">Главная</a>
                @guest
                    <a href="{{ route('register') }}" class="nav-item nav-link">Регистрация</a>
                    <a href="{{ route('login') }}" class="nav-item nav-link">Вход</a>
                @endguest
                @auth
                    @if(auth()->user()->is_admin)
                        <a href="{{ route('admin.index') }}" class="nav-item nav-link">Панель администратора</a>
                    @endif
                    <form action="{{ route('logout') }}" method="POST" class="form-inline">
                        @csrf
                        <input type="submit" class="btn btn-danger" value="Выход">
                    </form>
                @endauth
            </div>
        </nav>
    </header>
    <div class="container mt-3">
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @yield('content')
    </div>
</body>
</html>
