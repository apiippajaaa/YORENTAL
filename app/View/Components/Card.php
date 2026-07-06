<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Card extends Component
{

    public $image;
    public $title;
    public $description;
    public $buttonText;
    public $buttonIcon;

    /**
     * Create a new component instance.
     */
    public function __construct($image, $title, $description, $buttonText = 'Pesan Sekarang', $buttonIcon = 'fa-calendar-days')
    {
        $this->image = $image;
        $this->title = $title;
        $this->description = $description;
        $this->buttonText = $buttonText;
        $this->buttonIcon = $buttonIcon;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        return view('components.card');
    }
}
