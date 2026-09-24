<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Helpers\TimezoneHelper;
use Carbon\Carbon;

class TimezoneDisplay extends Component
{
    public $datetime;
    public $format;
    public $converted;
    public $original;

    /**
     * Create a new component instance.
     */
    public function __construct($datetime, $format = 'Y-m-d H:i:s')
    {
        $this->datetime = $datetime;
        $this->format = $format;
        
        if ($datetime) {
            if (is_string($datetime)) {
                $this->original = Carbon::parse($datetime, TimezoneHelper::getSystemTimezone());
            } else {
                $this->original = $datetime;
            }
            $this->converted = TimezoneHelper::formatInUserTimezone($this->original, $format);
        } else {
            $this->original = null;
            $this->converted = '-';
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        return view('components.timezone-display');
    }
}
