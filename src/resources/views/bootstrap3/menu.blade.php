<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Newsletter <span class="caret"></span>
    </a>
    <ul class="dropdown-menu" role="menu">
        <a class="dropdown-item" href="{{route('laravel-cm::dashboard')}}">
            @lang('laravel-cm::crud.dashboard')
        </a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="{{ route('admin.newsletter-template.index') }}">
            @lang('laravel-cm::templates.menu_title')
        </a>
        <a class="dropdown-item" href="{{ route('laravel-cm::campaigns.index') }}">
            @lang('laravel-cm::campaigns.menu_title')
        </a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="{{ route('laravel-cm::lists.index') }}">
            @lang('laravel-cm::lists.menu_title')
        </a>
        <a class="dropdown-item" href="{{ route('laravel-cm::subscribers.index') }}">
            @lang('laravel-cm::subscribers.menu_title')
        </a>

    </ul>
</li>