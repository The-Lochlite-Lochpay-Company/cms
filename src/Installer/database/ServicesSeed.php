<?php

namespace Lochlite\cms\Installer\database;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Lochlite\cms\Models\User;
use Lochlite\cms\Models\Services;

class ServicesSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$servicesgoogle = Services::create([
		   'domain' => request()->getHttpHost(),
		   'name' => 'google',
		   'api' => array('original' => [
		   ['key' => 'client_id', 'value' => ''],
		   ['key' => 'client_secret', 'value' => ''],
		   ['key' => 'redirect', 'value' => request()->getSchemeAndHttpHost() .'/oauth/google/callback'],
		   ],
		   'api' => ['client_id' => '', 'client_secret' => '', 'redirect' => request()->getSchemeAndHttpHost() .'/oauth/google/callback']),
		]);
		$servicestwitter = Services::create([
		   'domain' => request()->getHttpHost(),
		   'name' => 'twitter',
		   'api' => array('original' => [
		   ['key' => 'client_id', 'value' => ''],
		   ['key' => 'client_secret', 'value' => ''],
		   ['key' => 'redirect', 'value' => request()->getSchemeAndHttpHost() .'/oauth/twitter/callback'],
		   ],
		   'api' => ['client_id' => '', 'client_secret' => '', 'redirect' => request()->getSchemeAndHttpHost() .'/oauth/twitter/callback']),
		]);
		$servicesfacebook = Services::create([
		   'domain' => request()->getHttpHost(),
		   'name' => 'facebook',
		   'api' => array('original' => [
		   ['key' => 'client_id', 'value' => ''],
		   ['key' => 'client_secret', 'value' => ''],
		   ['key' => 'redirect', 'value' => request()->getSchemeAndHttpHost() .'/oauth/facebook/callback'],
		   ],
		   'api' => ['client_id' => '', 'client_secret' => '', 'redirect' => request()->getSchemeAndHttpHost() .'/oauth/facebook/callback']),
		]);
    }
}
