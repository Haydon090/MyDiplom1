<!doctype html>
<html lang="en">
<head class="row w-100% h-3%">
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Curses</title>

</head>
<body>
    <header class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <h1>Curses</h1>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
              <li class="nav-item active">
                <a class="nav-link"  href="{{ route('dashboard') }}">Главная <span class="sr-only">(текущая)</span></a>
              </li>

              <li class="nav-item">
                <a class="nav-link " href="https://vk.com/noname3000">Контакты</a>
              </li>
            </ul>
            <li class="nav-item dropdown ml-10">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    @auth
                        {{ Auth::user()->Name }}
                    @else
                        Пользователь
                    @endauth
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    @auth
                        <a class="dropdown-item" href="{{ route('curses.myCurses') }}">Мои курсы</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Выход</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    @else
                        <a class="dropdown-item" href="{{ route('login') }}">Вход</a>
                        @if (Route::has('register'))
                            <a class="dropdown-item" href="{{ route('register') }}">Регистрация</a>
                        @endif
                    @endauth
                </div>
            </li>
          </div>
        </div>
      </header>


    <div class="container">
        @yield('content')
    </div>
    <footer class="footer bg-dark text-white mt-5">
        <div class="container">
          <span>&copy; 2024 Поликарпов Владимир П-41. Все права защищены.</span>
        </div>
      </footer>
      <!-- Bootstrap и jQuery JS-файлы (необходимы для работы некоторых компонентов) -->
      <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

</body>
</html>
