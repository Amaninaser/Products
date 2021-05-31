<?php

namespace App\View\Components;

use Illuminate\View\Component;

class DashboardLayout extends Component
{
    public $pageTitle;
    public $subtitle;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($title = '', $subtitle = '')
    {
        $this->pageTitle = $title;
        $this->subtitle = $subtitle;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('layouts.dashboard');
    }
}
