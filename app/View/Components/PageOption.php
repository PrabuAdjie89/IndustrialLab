<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class PageOption extends Component
{
    /**
     * Create a new component instance.
     */
    public $PageOptions = [10,20,50,100];
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.page-option');
    }
}
