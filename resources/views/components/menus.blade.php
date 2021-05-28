@if ($dataLayout == 'vertical')
    <div class="vertical-menu">
        <div data-simplebar class="h-100">
            <div id="sidebar-menu">
                <ul class="metismenu list-unstyled" id="side-menu">
                    <li class="menu-title">Menu</li>
                    @foreach ($menus as $menu)
                        <li>
                            <a class="waves-effect" href="{{ route($menu['route']) }}">
                                <i class="{{ $menu['icon'] }} mr-2"></i>
                                <span>{{ __($menu['name']) }}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@else
    <div class="topnav">
        <div class="container-fluid">
            <nav class="navbar navbar-light navbar-expand-lg topnav-menu">
                <div class="collapse navbar-collapse" id="topnav-menu-content">
                    <ul class="navbar-nav">
                        @if (isset($menus['back']) && $menus['back'])
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url()->previous() }}">
                                    <i class="ri-arrow-left-line mr-2"></i> Voltar
                                </a>
                            </li>
                        @elseif (Request::segment(3) != '')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route(Request::segment(2) . '.index') }}">
                                    <i class="ri-arrow-left-line mr-2"></i> Voltar
                                </a>
                            </li>
                        @endif
                        @foreach ($menus as $menu)
                            @if ($menu != 'back')
                                <li class="nav-item {{ isset($menu['atc']) && $segment == $menu['atc'] ? 'active' : '' }}">
                                    <a class="nav-link {{ isset($menu['atc']) && $segment == $menu['atc'] ? 'active' : '' }}" href="{{ route($menu['route']) }}">
                                        <i class="{{ $menu['icon'] }} mr-2"></i> {{ __($menu['name']) }}
                                    </a>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            </nav>
        </div>
    </div>
@endif
