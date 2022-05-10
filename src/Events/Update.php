<?php

namespace lochlite\cms\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class Update
{
    use Dispatchable, SerializesModels;

    public $currentversion;

    public function __construct($currentversion)
    {
        $this->currentversion = $currentversion;
    }
}