
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
                        @foreach ($menus as $menu)
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route($menu['route']) }}">
                                    <i class="{{ $menu['icon'] }} mr-2"></i> {{ __($menu['name']) }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </nav>
        </div> 
    </div>
@endif
