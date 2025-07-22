<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AppLayout extends Component
{
    public $title;
    public $description;
    public $keywords;
    public $ogImage;

    /**
     * Create a new component instance.
     */
    public function __construct(
        string $title = "",
        string $description = "",
        string $keywords = "",
        string $ogImage = ""
    ) {
        $this->title = $title;
        $this->description = $description ?: config('app.description', 'Oguri News');
        $this->keywords = $keywords ?: config('app.keywords', 'news, headline, trusted, no hoax');
        $this->ogImage = $ogImage ?: asset('images/og-default.jpg');
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.layout.app-layout');
    }
}
