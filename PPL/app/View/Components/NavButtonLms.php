<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class NavButtonLms extends Component
{
    public $route;
    public $id;
    public $label;

    /**
     * Create a new component instance.
     */
    public function __construct($route, $id = null, $label = 'Forum')
    {
        $this->route = $route;
        $this->id = $id;
        $this->label = $label;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|string|Closure
    {
        return view('components.nav-button-lms');
    }
}
