<?php

namespace lochlite\cms\Listeners;

use lochlite\cms\Events\Update;

class UpdateListeners
{
    public function handle(Update $event)
    {
        $version = $event->currentversion;
    }
}