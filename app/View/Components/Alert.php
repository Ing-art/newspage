<?php

namespace App\View\Components;

use Closure;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class Alert extends Component
{
    /**
     * Create a new component instance.
     */

     // Properties
     public string $type, $message;

     //Constructor
    public function __construct(
        string $type = 'warning', // type of message
        string $message ='' // message to show
    )
    {
        //
        $this->type = $type;
        $this->message = $message;
        
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.alert');
    }
}
