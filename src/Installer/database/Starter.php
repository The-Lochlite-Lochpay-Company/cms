<?php

namespace Lochlite\cms\Installer\database;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Lochlite\cms\Installer\database\ServicesSeed;
use Lochlite\cms\Installer\database\CustomersareaSeed;
use Lochlite\cms\Installer\database\PostsSeed;
use Lochlite\cms\Installer\database\EmailstemplateSeed;
use Lochlite\cms\Installer\database\UsersSeed;
use Lochlite\cms\Installer\database\SettingsSeed;
use Lochlite\cms\Installer\database\PermissionsSeed;
use Str;

class Starter extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(String $domain)
    {
        try{
			$setting = new SettingsSeed();
			$setting->run();
		} catch(\Exception $e){}
		
        try{
			$permission = new PermissionsSeed();
			$permission->run();
		} catch(\Exception $e){}
		
        try{
			$user = new UsersSeed();
			$user->run();
		} catch(\Exception $e){}
		
		
        try{
			$emailtemplate = new EmailstemplateSeed();
			$emailtemplate->run();
		} catch(\Exception $e){}
		
        try{
			$posts = new PostsSeed();
			$posts->run();
		} catch(\Exception $e){}
		
        try{
			$customer = new CustomersareaSeed();
			$customer->run();
		} catch(\Exception $e){}
		
        try{
			$services = new ServicesSeed();
			$services->run();
		} catch(\Exception $e){}
		

}
}
