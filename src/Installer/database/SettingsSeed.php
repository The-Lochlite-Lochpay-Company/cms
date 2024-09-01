<?php

namespace Lochlite\cms\Installer\database;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Lochlite\cms\Models\User;
use Lochlite\cms\Models\Settings;

class SettingsSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$settingsdefault = Settings::create([
		   'domain' => request()->getHttpHost(),
		   'default' => true,
		]);
    }
}
