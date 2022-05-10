<?php

namespace lochlite\cms\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use lochlite\cms\Events\Update;

class UpdateJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $currentversion;

    public function __construct($currentversion)
    {
        $this->currentversion = $currentversion;
    }

    public function handle()
    {
        return event(new Update($this->currentversion));
    }
	
}
