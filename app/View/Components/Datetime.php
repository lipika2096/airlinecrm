<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Helpers\TimezoneHelper;

class Datetime extends Component
{
    public $datetime;
    public $format;
    public $formatted;

    /**
     * Create a new component instance.
     */
    public function __construct($datetime, $format = 'Y-m-d H:i:s')
    {
        $this->datetime = $datetime;
        $this->format = $format;
        $this->formatted = TimezoneHelper::autoFormat($datetime, $format);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        return view('components.datetime');
    }
}
