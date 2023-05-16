<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Layout extends Component
{
    public string $title;

    public string $lang;

    public function __construct(string $title) {
        $this->title = $title . ' - ' . config('app.name');
        $this->lang = str_replace('_', '-', app()->getLocale());
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.layout');
    }
}
