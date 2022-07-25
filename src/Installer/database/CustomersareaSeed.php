<?php

namespace Lochlite\cms\Installer\database;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Lochlite\cms\Models\User;
use Lochlite\cms\Models\Customersarea; 

class CustomersareaSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$customersareasdefault = Customersarea::create([
		   'domain' => request()->getHttpHost(),
		   'default' => true,
		]);
    }
}
