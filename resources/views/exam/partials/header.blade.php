<div id="header">
    @if(Route::currentRouteName() == 'exam.take-exam')
        <img src="{{ asset('images/logo.png') }}" class="logo"/>
    @else
        <a href="{{ route('exam.home' )}}">
            <img src="{{ asset('images/logo.png') }}" class="logo"/>
        </a>
    @endif
    <div class="info">
        <h3>
            {{ env('APP_NAME') }}
        </h3>
        <h3>
            {{ config('pi-academy.phone_number') }}
        </h3>
        <h3>
            Engineering and IT Entrance Preparation
        </h3>
    </div>
    <ul id="toplinks"></ul>
</div>

<nav class="navbar" role="navigation">
    <div class="faculty">
        BE/B.Arch Online Entrance Examination
        @if(Route::currentRouteName() != 'exam.take-exam')
            @if(Auth::user())
                <a class="logout" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                <form id="logout-form" action="{{ route('exam.logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            @endif
        @endif
    </div>
</nav>