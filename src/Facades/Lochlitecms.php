<?php

namespace lochlite\cms\Facades;

use Illuminate\Support\Facades\Facade;

class Lochlitecms extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'lochlitecms';
    }
}
