<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <link rel="stylesheet" href="{{asset('css/bootstrap-datepicker.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/jquery-ui.css')}}">
    @yield('css')
    <script src="{{asset('js/jquery-3.6.0.min.js')}}"></script>
    <title></title>
  </head>
  <body >
    <h1 >
        <span>
          <a class="dropdown-item" href="{{ route('logout') }}"  onclick="event.preventDefault(); document.getElementById('logout-form').submit();"> {{ __('Logout') }}</a>
        </span>
        <span >/</span>
        <span >
          <a href="{{route('caisse')}}">Entrée de fond de caisse</a>
        </span>
        <span >/</span>
        <strong itemprop="name" class="mr-2 flex-self-stretch">
          <a  href="{{route('caisse')}}/list/<?php echo date("Y-m-d"); ?>"><?php echo date("d M Y"); ?></a>
        </strong>
      </h1>
    @yield('body')
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
        @csrf
    </form>
  </body>
  @yield('javascript')
</html>
