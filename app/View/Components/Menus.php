<?php

namespace App\View\Components;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Request;
use Illuminate\View\Component;

class Menus extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        $base = Request::segment(1);

        $dataLayout  = Config::get('admin.dataLayout');

        $menus = Config::get("admin.menus.$base");

        $segment = $base == 'l' ? Request::segment(2) : Request::segment(1);

        return view('components.menus', [
            'menus' => $menus ?? [],
            'dataLayout' => $dataLayout,
            'segment' => $segment
        ]);
    }

}
