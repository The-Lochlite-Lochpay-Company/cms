<?php

namespace Lochlite\cms\Installer\database;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Lochlite\cms\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use Str;

class PermissionsSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'edit system']);
        Permission::create(['name' => 'delete system']);
        Permission::create(['name' => 'publish system']);
        Permission::create(['name' => 'unpublish system']);

        Permission::create(['name' => 'edit plugins']);
        Permission::create(['name' => 'delete plugins']);
        Permission::create(['name' => 'publish plugins']);
        Permission::create(['name' => 'unpublish plugins']);

        Permission::create(['name' => 'edit user']);
        Permission::create(['name' => 'delete user']);
        Permission::create(['name' => 'publish user']);
        Permission::create(['name' => 'unpublish user']);

        Permission::create(['name' => 'edit users']);
        Permission::create(['name' => 'delete users']);
        Permission::create(['name' => 'publish users']);
        Permission::create(['name' => 'unpublish users']);

        Permission::create(['name' => 'edit comments']);
        Permission::create(['name' => 'delete comments']);
        Permission::create(['name' => 'publish comments']);
        Permission::create(['name' => 'unpublish comments']);

        Permission::create(['name' => 'edit articles']);
        Permission::create(['name' => 'delete articles']);
        Permission::create(['name' => 'publish articles']);
        Permission::create(['name' => 'unpublish articles']);

        Permission::create(['name' => 'edit pages']);
        Permission::create(['name' => 'delete pages']);
        Permission::create(['name' => 'publish pages']);
        Permission::create(['name' => 'unpublish pages']);

        Permission::create(['name' => 'edit permissions']);
        Permission::create(['name' => 'delete permissions']);
        Permission::create(['name' => 'publish permissions']);
        Permission::create(['name' => 'unpublish permissions']);

        Permission::create(['name' => 'edit contacts']);
        Permission::create(['name' => 'delete contacts']);
        Permission::create(['name' => 'publish contacts']);
        Permission::create(['name' => 'unpublish contacts']);

        Permission::create(['name' => 'edit feedbacks']);
        Permission::create(['name' => 'delete feedbacks']);
        Permission::create(['name' => 'publish feedbacks']);
        Permission::create(['name' => 'unpublish feedbacks']);

        Permission::create(['name' => 'edit emails']);
        Permission::create(['name' => 'delete emails']);
        Permission::create(['name' => 'publish emails']);
        Permission::create(['name' => 'unpublish emails']);

        Permission::create(['name' => 'edit schedulings']);
        Permission::create(['name' => 'delete schedulings']);
        Permission::create(['name' => 'publish schedulings']);
        Permission::create(['name' => 'unpublish schedulings']);

        Permission::create(['name' => 'edit fileupload']);
        Permission::create(['name' => 'delete fileupload']);
        Permission::create(['name' => 'view fileupload']);
        Permission::create(['name' => 'upload fileupload']);
        Permission::create(['name' => 'download fileupload']);

        // create roles and assign existing permissions
        $admin = Role::create(['name' => 'Admin']);
        $admin->givePermissionTo('edit system');
        $admin->givePermissionTo('publish system');
        $admin->givePermissionTo('unpublish system');
        $admin->givePermissionTo('delete system');
        $admin->givePermissionTo('edit plugins');
        $admin->givePermissionTo('publish plugins');
        $admin->givePermissionTo('unpublish plugins');
        $admin->givePermissionTo('delete plugins');
        $admin->givePermissionTo('edit users');
        $admin->givePermissionTo('publish users');
        $admin->givePermissionTo('unpublish users');
        $admin->givePermissionTo('delete users');
        $admin->givePermissionTo('edit permissions');
        $admin->givePermissionTo('publish permissions');
        $admin->givePermissionTo('unpublish permissions');
        $admin->givePermissionTo('delete permissions');
        $admin->givePermissionTo('edit fileupload');
        $admin->givePermissionTo('view fileupload');
        $admin->givePermissionTo('download fileupload');
        $admin->givePermissionTo('upload fileupload');
        $admin->givePermissionTo('delete fileupload');
        $admin->givePermissionTo('edit contacts');
        $admin->givePermissionTo('publish contacts');
        $admin->givePermissionTo('unpublish contacts');
        $admin->givePermissionTo('delete contacts');
        $admin->givePermissionTo('edit feedbacks');
        $admin->givePermissionTo('publish feedbacks');
        $admin->givePermissionTo('unpublish feedbacks');
        $admin->givePermissionTo('delete feedbacks');
        $admin->givePermissionTo('edit schedulings');
        $admin->givePermissionTo('publish schedulings');
        $admin->givePermissionTo('unpublish schedulings');
        $admin->givePermissionTo('delete schedulings');
        $admin->givePermissionTo('edit emails');
        $admin->givePermissionTo('publish emails');
        $admin->givePermissionTo('unpublish emails');
        $admin->givePermissionTo('delete emails');
        $admin->givePermissionTo('edit comments');
        $admin->givePermissionTo('publish comments');
        $admin->givePermissionTo('unpublish comments');
        $admin->givePermissionTo('delete comments');
        $admin->givePermissionTo('edit articles');
        $admin->givePermissionTo('publish articles');
        $admin->givePermissionTo('unpublish articles');
        $admin->givePermissionTo('delete articles');
        $admin->givePermissionTo('edit pages');
        $admin->givePermissionTo('publish pages');
        $admin->givePermissionTo('unpublish pages');
        $admin->givePermissionTo('delete pages');
       // create roles and assign existing permissions
        $accountmanager = Role::create(['name' => 'developer']);
        $accountmanager->givePermissionTo('edit system');
        $accountmanager->givePermissionTo('publish system');
        $accountmanager->givePermissionTo('unpublish system');
        $accountmanager->givePermissionTo('delete system');
        $accountmanager->givePermissionTo('edit plugins');
        $accountmanager->givePermissionTo('publish plugins');
        $accountmanager->givePermissionTo('unpublish plugins');
        $accountmanager->givePermissionTo('delete plugins');
        // create roles and assign existing permissions
        $accountmanager = Role::create(['name' => 'account-manager']);
        $accountmanager->givePermissionTo('edit users');
        $accountmanager->givePermissionTo('publish users');
        $accountmanager->givePermissionTo('unpublish users');
        $accountmanager->givePermissionTo('delete users');
        $accountmanager->givePermissionTo('edit permissions');
        $accountmanager->givePermissionTo('publish permissions');
        $accountmanager->givePermissionTo('unpublish permissions');
        $accountmanager->givePermissionTo('delete permissions');
        $accountmanager->givePermissionTo('edit fileupload');
        $accountmanager->givePermissionTo('view fileupload');
        $accountmanager->givePermissionTo('download fileupload');
        $accountmanager->givePermissionTo('upload fileupload');
        $accountmanager->givePermissionTo('delete fileupload');
        // create roles and assign existing permissions
        $ombudsman = Role::create(['name' => 'ombudsman']);
        $ombudsman->givePermissionTo('edit contacts');
        $ombudsman->givePermissionTo('publish contacts');
        $ombudsman->givePermissionTo('unpublish contacts');
        $ombudsman->givePermissionTo('delete contacts');
        $ombudsman->givePermissionTo('edit feedbacks');
        $ombudsman->givePermissionTo('publish feedbacks');
        $ombudsman->givePermissionTo('unpublish feedbacks');
        $ombudsman->givePermissionTo('delete feedbacks');
        $ombudsman->givePermissionTo('edit schedulings');
        $ombudsman->givePermissionTo('publish schedulings');
        $ombudsman->givePermissionTo('unpublish schedulings');
        $ombudsman->givePermissionTo('delete schedulings');
        $ombudsman->givePermissionTo('edit emails');
        $ombudsman->givePermissionTo('publish emails');
        $ombudsman->givePermissionTo('unpublish emails');
        $ombudsman->givePermissionTo('delete emails');
        $ombudsman->givePermissionTo('edit fileupload');
        $ombudsman->givePermissionTo('view fileupload');
        $ombudsman->givePermissionTo('upload fileupload');
        $ombudsman->givePermissionTo('download fileupload');
        $ombudsman->givePermissionTo('delete fileupload');
        // create roles and assign existing permissions
        $moderator = Role::create(['name' => 'moderator']);
        $moderator->givePermissionTo('edit comments');
        $moderator->givePermissionTo('publish comments');
        $moderator->givePermissionTo('unpublish comments');
        $moderator->givePermissionTo('delete comments');
        // create roles and assign existing permissions
        $writer = Role::create(['name' => 'writer']);
        $writer->givePermissionTo('edit articles');
        $writer->givePermissionTo('publish articles');
        $writer->givePermissionTo('unpublish articles');
        $writer->givePermissionTo('delete articles');
        $writer->givePermissionTo('edit pages');
        $writer->givePermissionTo('publish pages');
        $writer->givePermissionTo('unpublish pages');
        $writer->givePermissionTo('delete pages');
        $writer->givePermissionTo('edit fileupload');
        $writer->givePermissionTo('view fileupload');
        $writer->givePermissionTo('download fileupload');
        $writer->givePermissionTo('upload fileupload');
        $writer->givePermissionTo('delete fileupload');
        // create roles and assign existing permissions
        $user = Role::create(['name' => 'user']);
        $user->givePermissionTo('edit user');
        $user->givePermissionTo('publish user');
        $user->givePermissionTo('unpublish user');
        $user->givePermissionTo('delete user');
}
}
