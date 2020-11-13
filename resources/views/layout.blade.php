<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <meta name="csrf-token" content="{{ csrf_token() }}">

        <link rel="stylesheet" href="{{asset('css/app.css')}}">



        <script  src="https://code.jquery.com/jquery-3.5.1.min.js"
			  integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
              crossorigin="anonymous"></script>
              <script
			  src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
			  integrity="sha256-4+XzXVhsDmqanXGHaHvgh1gMQKX40OUvDEBTu8JcmNs="
			  crossorigin="anonymous"></script>
        <title>@yield('title','Caol')</title>
        <script src="{{ asset('js/app.js') }}" ></script>

    </head>
<body>
<div id="app" class="d-flex flex-column h-screen justify-content-between">
    <header>
        <nav class="navbar navbar-light navbar-expand-sm bg-white shadow-sm">
            <div class="container">
              <a class="navbar-brand" href="{{ route ('comercial') }}">
              <img src="{{ asset('img/logo.gif') }}" alt="Logo"  style="opacity: .8">
              </a>
          <button class="navbar-toggler" type="button"
              data-toggle="collapse"
              data-target="#navbarSupportedContent"
              aria-controls="navbarSupportedContent"
              aria-expanded="false"
              aria-label="{{ __('Toggle navigation') }}"
              >
              <span class="navbar-toggler-icon"></span>

          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">

          <ul class="nav">
          <li class="nav-item"><a class='nav-link' href="#">Agence</a></li>
          <li class="nav-item"><a class='nav-link' href="#">Projetos</a></li>
          <li class="nav-item"><a class='nav-link' href="#">Administrativo</a></li>
          <li class="nav-item"><a class='nav-link' href="{{ route ('comercial') }}">Comercial</a></li>
          <li class="nav-item"><a class='nav-link' href="#">Financeiro</a></li>
          <li class="nav-item"><a class='nav-link' href="#">Usuário</a></li>
          <li class="nav-item"><a class='nav-link' href="#">Sair</a></li>
          </ul>
          </div>
            </div>

          </nav>
    </header>

<main>
@yield('contenido')
</main>

<footer class="bg-white text-center text-black-50 py-3 shadow">{{ config('app.name') }} | Copyright @ {{ date('Y') }}</footer>
</div>
</body>
