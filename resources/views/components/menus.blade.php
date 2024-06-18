<div class="topnav no-print">
    <div class="container">
        <nav class="navbar navbar-light navbar-expand-lg topnav-menu">
            <div class="collapse navbar-collapse" id="topnav-menu-content">
                <ul class="navbar-nav">
                    @if (isset($menus[0]['back']) && $menus[0]['back'])
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url()->previous() }}">
                                <i class="fas fa-arrow-left mr-2"></i>
                                <span style="vertical-align: top;">Voltar</span>
                            </a>
                        </li>
                    @elseif (Request::segment(3) != '')
                        <li class="nav-item">
                            @if (Route::has(Request::segment(2) . '.index'))
                                <a class="nav-link" href="{{ route(Request::segment(2) . '.index') }}">
                                    <i class="fas fa-arrow-left mr-2"></i>
                                    <span style="vertical-align: top;">Voltar</span>
                                </a>
                            @endif
                        </li>
                    @endif
                    @foreach ($menus as $menu)
                        @if (isset($menu['collapse']))
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle arrow-none" href="javascript:void(0)" id="topnav-apps" role="button">
                                    <i class="{{ $menu['icon'] }} mr-2"></i>{{ __trans($menu['name']) }} <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-apps">
                                    @foreach ($menu['sub-menus'] as $subMenu)
                                        <a href="{{ route($subMenu['route']) }}" class="dropdown-item">
                                            {{ $subMenu['name'] }}
                                        </a>
                                    @endforeach
                                </div>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route($menu['route']) }}">
                                    <i class="{{ $menu['icon'] }} mr-2"></i>
                                    <span style="vertical-align: top;">{{ __trans($menu['name']) }}</span>
                                </a>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </div>
        </nav>
    </div>
</div>
