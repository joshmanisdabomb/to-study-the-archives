<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Alerts extends Component
{
    /**
     * Get the view / contents that represents the component.
     *
     * @return string
     */
    public function render()
    {
        $content = '';
        if (session()->has("alert-yellow")) {
            $content .= '<div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4" role="alert">
                <p>' . session('alert-yellow') . '</p>
            </div>';
        }
        return $content;
    }
}
