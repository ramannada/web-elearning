<nav class="navbar navbar-toggleable-md navbar-light bg-faded">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">E-Learning</a>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">

            <ul class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link" href="{{ route('lesson.list') }}">Kursus <span class="sr-only">(current)</span></a>
              </li>

              <li class="nav-item">
                <a class="nav-link" href="{{ route('article.list') }}">Artikel</a>
              </li>
            
            @if (Session::has('login'))
              <li class="nav-item">
                <a class="nav-link" href="{{ route('premium') }}">Premium</a>
              </li>
            @endif
            </ul>
@php

@endphp
            <ul class="navbar-nav ml-auto">
                @if (Session::has('login'))
                  <li class="nav-item"><a class="nav-link" href="{{ route('profile') }}">Profile</a></li>
                  <li class="nav-item"><a  class="nav-link" href="{{ route('auth.logout') }}">Sign Out</a></li>
                @else
                  <li class="nav-item"><a class="nav-link" href="{{ route('auth.get.register') }}">Sign Up</a></li>
                  <li class="nav-item"><a  class="nav-link" href="{{ route('auth.get.login') }}">Sign In</a></li>
                @endif
            </ul>

        </div>
    </div>
</nav>
