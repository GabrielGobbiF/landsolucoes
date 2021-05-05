<ul class="navbar-nav mr-auto">
    @foreach ($menus as $menu)
        <li class="nav-item">
            <a class="nav-link nav-header" id="{{ __($menu['name']) }}" href="{{ route($menu['route']) }}">{{ __($menu['name']) }}</a>
        </li>
    @endforeach
</ul>
