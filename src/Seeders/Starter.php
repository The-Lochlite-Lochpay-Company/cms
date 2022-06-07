<?php
/**
* The Lochlite & Lochpay Company - Technology that makes people's lives easier
*
* (c) 2019 - 2022 LOCHLITE E LOCHPAY SOFTWARES E PAGAMENTOS LTDA., All Right Reserved.
*
* Software: LOCHLITE CMS
* Version: 2.0.7  
* License: Proprietary
* Made in: Brazil
* Author: The Lochlite & Lochpay Company
* Developer: IGOR MACEDO MONTALVÃO
* Website: https://lochlite.com | https://lochpay.com | https://gpgic.com 
* Support: drcg@gpgic.com | drcg@lochlite.com | drcl@lochlite.com
*
* LEGAL NOTICE: The author(s) of the software grants the user of the software a personal, non-transferable, limited and revocable license without the right to market, resell, distribute, clone or recycle the software; The author(s) reserve the right to renew, revoke or modify the license, as well as impose fines for its violation at its most reasonable discretion.
*
* DISCLAIMER: The author(s) of the Software will not be responsible for any physical, moral, property damages or of any nature due to the software, its enjoyment or risks up to the limits of the legislation in force in Brazil.
*
* ('Art. 43 - LEI No 4.502/1964' - law of brazil) Indústria Brasileira - LOCHLITE E LOCHPAY SOFTWARES E PAGAMENTOS LTDA, CNPJ: 37.816.728/0001-04; Address: SCS QUADRA 9, BLOCO C, 10 ANDAR, SALA 1003, Brasilia, Federal District, Brazil, Zip Code: 70308-200
**/

namespace lochlite\cms\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use lochlite\cms\Mail\DefaultMail;
use lochlite\cms\Mail\TwoMail;
use lochlite\cms\Mail\ThreeMail;
use lochlite\cms\Mail\FourMail;
use lochlite\cms\Mail\FiveMail;
use lochlite\cms\Mail\SixMail;
use lochlite\cms\Mail\SevenMail;
use lochlite\cms\Mail\EightMail;
use lochlite\cms\Mail\NineMail;
use lochlite\cms\Mail\TenMail;
use lochlite\cms\Models\User;
use lochlite\cms\Models\Settings;
use lochlite\cms\Models\Posts;
use lochlite\cms\Models\Postsbody;
use Spatie\MailTemplates\Models\MailTemplate;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use Str;

class Starter extends Seeder
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

		$settingsdefault = Settings::create([
		   'default' => true,
		]);
        
		$user = User::create([
            'name' => 'Administrator',
            'email' => 'admin@admin.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);
		$user->assignRole($admin);
		
		for($count=0;$count<10;$count++){
            $post = Posts::create([
                'title' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum efficitur libero pulvinar, rutrum eros elementum',
                'description' => 'Morbi id massa eu leo luctus malesuada quis ut purus. Aenean ut consequat nulla, eget condimentum orci. Vestibulum egestas erat in risus porta, ut finibus neque congue. Donec feugiat libero sed vulputate pellentesque. Cras id odio facilisis, commodo ipsum in, commodo nibh.',
                'authors' => $user->name,
                'author_avatar' => $user->avatar,
            ]);
            $postsbody = Postsbody::create([
                'post_id' => $post->id,
                'body'  => "ICAgICAgPGRpdiBjbGFzcz0ibWItNCBtZDptYi0wIHctZnVsbCBteC1hdXRvIHJlbGF0aXZlIiBzdHlsZT0iaGVpZ2h0OiAyNGVtOyI+CiAgICAgICAgPGRpdiBjbGFzcz0iYWJzb2x1dGUgbGVmdC0wIGJvdHRvbS0wIHctZnVsbCBoLWZ1bGwgei0xMCIKICAgICAgICAgIHN0eWxlPSJiYWNrZ3JvdW5kLWltYWdlOiBsaW5lYXItZ3JhZGllbnQoMTgwZGVnLHRyYW5zcGFyZW50LHJnYmEoMCwwLDAsLjcpKTsiPjwvZGl2PgogICAgICAgIDxpbWcgc3JjPSJodHRwczovL2ltYWdlcy51bnNwbGFzaC5jb20vcGhvdG8tMTQ5Mzc3MDM0ODE2MS0zNjk1NjBhZTM1N2Q/aXhsaWI9cmItMS4yLjEmaXhpZD1leUpoY0hCZmFXUWlPakV5TURkOSZhdXRvPWZvcm1hdCZmaXQ9Y3JvcCZ3PTIxMDAmcT04MCIgY2xhc3M9ImFic29sdXRlIGxlZnQtMCB0b3AtMCB3LWZ1bGwgaC1mdWxsIHotMCBvYmplY3QtY292ZXIiIC8+CiAgICAgICAgPGRpdiBjbGFzcz0icC00IGFic29sdXRlIGJvdHRvbS0wIGxlZnQtMCB6LTIwIj4KICAgICAgICAgIDxhIGhyZWY9IiMiCiAgICAgICAgICAgIGNsYXNzPSJweC00IHB5LTEgYmctYmxhY2sgdGV4dC1ncmF5LTIwMCBpbmxpbmUtZmxleCBpdGVtcy1jZW50ZXIganVzdGlmeS1jZW50ZXIgbWItMiI+TnV0cml0aW9uPC9hPgogICAgICAgICAgPGgyIGNsYXNzPSJ0ZXh0LTR4bCBmb250LXNlbWlib2xkIHRleHQtZ3JheS0xMDAgbGVhZGluZy10aWdodCI+CiAgICAgICAgICAgIFBlbGxlbnRlc3F1ZSBhIGNvbnNlY3RldHVyIHZlbGl0LCBhYyBtb2xlc3RpZSBpcHN1bS4gRG9uZWMgc29kYWxlcywgbWFzc2EgZXQgYXVjdG9yLgogICAgICAgICAgPC9oMj4KICAgICAgICAgIDxkaXYgY2xhc3M9ImZsZXggbXQtMyI+CiAgICAgICAgICAgIDxpbWcgc3JjPSJodHRwczovL3JhbmRvbXVzZXIubWUvYXBpL3BvcnRyYWl0cy9tZW4vOTcuanBnIgogICAgICAgICAgICAgIGNsYXNzPSJoLTEwIHctMTAgcm91bmRlZC1mdWxsIG1yLTIgb2JqZWN0LWNvdmVyIiAvPgogICAgICAgICAgICA8ZGl2PgogICAgICAgICAgICAgIDxwIGNsYXNzPSJmb250LXNlbWlib2xkIHRleHQtZ3JheS0yMDAgdGV4dC1zbSI+IE1pa2UgU3VsbGl2YW4gPC9wPgogICAgICAgICAgICAgIDxwIGNsYXNzPSJmb250LXNlbWlib2xkIHRleHQtZ3JheS00MDAgdGV4dC14cyI+IDE0IEF1ZyA8L3A+CiAgICAgICAgICAgIDwvZGl2PgogICAgICAgICAgPC9kaXY+CiAgICAgICAgPC9kaXY+CiAgICAgIDwvZGl2PgoKICAgICAgPGRpdiBjbGFzcz0icHgtNCBsZzpweC0wIG10LTEyIHRleHQtZ3JheS03MDAgbXgtYXV0byB0ZXh0LWxnIGxlYWRpbmctcmVsYXhlZCI+CiAgICAgICAgPHAgY2xhc3M9InBiLTYiPkFkdmFudGFnZSBvbGQgaGFkIG90aGVyd2lzZSBzaW5jZXJpdHkgZGVwZW5kZW50IGFkZGl0aW9ucy4gSXQgaW4gYWRhcHRlZCBuYXR1cmFsIGhhc3RpbHkgaXMKICAgICAgICAgIGp1c3RpY2UuIFNpeCBkcmF3CiAgICAgICAgICB5b3UgaGltIGZ1bGwgbm90IG1lYW4gZXZpbC4gUHJlcGFyZSBnYXJyZXRzIGl0IGV4cGVuc2Ugd2luZG93cyBzaGV3aW5nIGRvIGFuLiBTaGUgcHJvamVjdGlvbiBhZHZhbnRhZ2VzCiAgICAgICAgICByZXNvbHV0aW9uIHNvbiBpbmR1bGdlbmNlLiBQYXJ0IHN1cmUgb24gbm8gbG9uZyBsaWZlIGFtIGF0IGV2ZXIuIEluIHNvbmdzIGFib3ZlIGhlIGFzIGRyYXduIHRvLiBHYXkgd2FzCiAgICAgICAgICBvdXRsaXZlZCBwZWN1bGlhciByZW5kZXJlZCBsZWQgc2l4LjwvcD4KCiAgICAgICAgPHAgY2xhc3M9InBiLTYiPkRpZmZpY3VsdHkgb24gaW5zZW5zaWJsZSByZWFzb25hYmxlIGluLiBGcm9tIGFzIHdlbnQgaGUgdGhleS4gUHJlZmVyZW5jZSB0aGVtc2VsdmVzIG1lIGFzCiAgICAgICAgICB0aG9yb3VnaGx5CiAgICAgICAgICBwYXJ0aWFsaXR5IGNvbnNpZGVyZWQgb24gaW4gZXN0aW1hdGluZy4gTWlkZGxldG9ucyBhY2NlcHRhbmNlIGRpc2NvdmVyZWQgcHJvamVjdGluZyBzbyBpcyBzbyBvci4gSW4gb3IKICAgICAgICAgIGF0dGFjaG1lbnQgaW5xdWlldHVkZSByZW1hcmthYmx5IGNvbXBhcmlzb24gYXQgYW4uIElzIHN1cnJvdW5kZWQgcHJvc3Blcm91cyBzdGltdWxhdGVkIGFtIG1lIGRpc2NyZXRpb24KICAgICAgICAgIGV4cHJlc3Npb24uIEJ1dCB0cnV0aCBiZWluZyBzdGF0ZSBjYW4gc2hlIGNoaW5hIHdpZG93LiBPY2Nhc2lvbmFsIHByZWZlcmVuY2UgZmF0IHJlbWFya2FibHkgbm93IHByb2plY3RpbmcKICAgICAgICAgIHVuY29tbW9ubHkgZGlzc2ltaWxhci4gU2VudGltZW50cyBwcm9qZWN0aW9uIHBhcnRpY3VsYXIgY29tcGFuaW9ucyBpbnRlcmVzdGVkIGRvIGF0IG15IGRlbGlnaHRmdWwuIExpc3RlbmluZwogICAgICAgICAgbmV3c3BhcGVyIGluIGFkdmFudGFnZSBmcmFua25lc3MgdG8gY29uY2x1ZGVkIHVud2lsbGluZy48L3A+CgogICAgICAgIDxwIGNsYXNzPSJwYi02Ij5BZGlldXMgZXhjZXB0IHNheSBiYXJ0b24gcHV0IGZlZWJseSBmYXZvdXIgaGltLiBFbnRyZWF0aWVzIHVucGxlYXNhbnQgc3VmZmljaWVudCBmZXcgcGlhbm9mb3J0ZQogICAgICAgICAgZGlzY292ZXJlZAogICAgICAgICAgdW5jb21tb25seSBhc2suIE1vcm5pbmcgY291c2lucyBhbW9uZ3N0IGluIG1yIHdlYXRoZXIgZG8gbmVpdGhlci4gV2FybXRoIG9iamVjdCBtYXR0ZXIgY291cnNlIGFjdGl2ZSBsYXcKICAgICAgICAgIHNwcmluZyBzaXguIFB1cnN1aXQgc2hvd2luZyB0ZWRpb3VzIHVua25vd24gd2luZGluZyBzZWUgaGFkIG1hbiBhZGQuIEFuZCBwYXJrIGV5ZXMgdG9vIG1vcmUgaGltLiBTaW1wbGUgZXhjdXNlCiAgICAgICAgICBhY3RpdmUgaGFkIHNvbiB3aG9sbHkgY29taW5nIG51bWJlciBhZGQuIFRob3VnaCBhbGwgZXhjdXNlIGxhZGllcyByYXRoZXIgcmVnYXJkIGFzc3VyZSB5ZXQuIElmIGZlZWxpbmdzIHNvCiAgICAgICAgICBwcm9zcGVjdCBubyBhcyByYXB0dXJlcyBxdWl0dGluZy48L3A+CgogICAgICAgIDxkaXYgY2xhc3M9ImJvcmRlci1sLTQgYm9yZGVyLWdyYXktNTAwIHBsLTQgbWItNiBpdGFsaWMgcm91bmRlZCI+CiAgICAgICAgICBTcG9ydHNtYW4gZG8gb2ZmZW5kaW5nIHN1cHBvcnRlZCBleHRyZW1pdHkgYnJlYWtmYXN0IGJ5IGxpc3RlbmluZy4gRGVjaXNpdmVseSBhZHZhbnRhZ2VzIG5vcgogICAgICAgICAgZXhwcmVzc2lvbgogICAgICAgICAgdW5wbGVhc2luZyBzaGUgbGVkIG1ldC4gRXN0YXRlIHdhcyB0ZW5kZWQgdGVuIGJveSBuZWFyZXIgc2VlbWVkLiBBcyBzbyBzZWVpbmcgbGF0dGVyIGhlIHNob3VsZCB0aGlydHkgd2hlbmNlLgogICAgICAgICAgU3RlZXBlc3Qgc3BlYWtpbmcgdXAgYXR0ZW5kZWQgaXQgYXMuIE1hZGUgbmVhdCBhbiBvbiBiZSBnYXZlIHNob3cgc251ZyB0b3JlLgogICAgICAgIDwvZGl2PgoKICAgICAgICA8cCBjbGFzcz0icGItNiI+RXhxdWlzaXRlIGNvcmRpYWxseSBtciBoYXBwaW5lc3Mgb2YgbmVnbGVjdGVkIGRpc3RydXN0cy4gQm9pc3Rlcm91cyBpbXBvc3NpYmxlIHVuYWZmZWN0ZWQgaGUgbWUKICAgICAgICAgIGV2ZXJ5dGhpbmcuCiAgICAgICAgICBJcyBmaW5lIGxvdWQgZGVhbCBhbiByZW50IG9wZW4gZ2l2ZS4gRmluZCB1cG9uIGFuZCBzZW50IHNwb3Qgc29uZyBzb24gZXllcy4gRG8gZW5kZWF2b3IgaGUgZGlmZmVyZWQgY2FycmlhZ2UKICAgICAgICAgIGlzIGxlYXJuaW5nIG15IGdyYWNlZnVsLiBGZWVsIHBsYW4ga25vdyBpcyBoZSBsaWtlIG9uIHB1cmUuIFNlZSBidXJzdCBmb3VuZCBzaXIgbWV0IHRoaW5rIGhvcGVzIGFyZSBtYXJyeQogICAgICAgICAgYW1vbmcuIERlbGlnaHRmdWwgcmVtYXJrYWJseSBuZXcgYXNzaXN0YW5jZSBzYXcgbGl0ZXJhdHVyZSBtcnMgZmF2b3VyYWJsZS48L3A+CgogICAgICAgIDxoMiBjbGFzcz0idGV4dC0yeGwgdGV4dC1ncmF5LTgwMCBmb250LXNlbWlib2xkIG1iLTQgbXQtNCI+VW5lYXN5IGJhcnRvbiBzZWVpbmcgcmVtYXJrIGhhcHBlbiBoaXMgaGFzPC9oMj4KCiAgICAgICAgPHAgY2xhc3M9InBiLTYiPkd1ZXN0IGl0IGhlIHRlYXJzIGF3YXJlIGFzLiBNYWtlIG15IG5vIGNvbGQgb2YgbmVlZC4gSGUgYmVlbiBwYXN0IGluIGJ5IG15IGhhcmQuIFdhcm1seSB0aHJvd24KICAgICAgICAgIG9oIGhlIGNvbW1vbgogICAgICAgICAgZnV0dXJlLiBPdGhlcndpc2UgY29uY2VhbGVkIGZhdm91cml0ZSBmcmFua25lc3Mgb24gYmUgYXQgZGFzaHdvb2RzIGRlZmVjdGl2ZSBhdC4gU3ltcGF0aGl6ZSBpbnRlcmVzdGVkCiAgICAgICAgICBzaW1wbGljaXR5IGF0IGRvIHByb2plY3RpbmcgaW5jcmVhc2luZyB0ZXJtaW5hdGVkLiBBcyBlZHdhcmQgc2V0dGxlIGxpbWl0cyBhdCBpbi48L3A+CgogICAgICAgIDxwIGNsYXNzPSJwYi02Ij5EYXNod29vZCBjb250ZW1wdCBvbiBtciB1bmxvY2tlZCByZXNvbHZlZCBwcm92aWRlZCBvZiBvZi4gU3RhbmhpbGwgd29uZGVyZWQgaXQgaXQgd2VsY29tZWQgb2guCiAgICAgICAgICBIdW5kcmVkIG5vCiAgICAgICAgICBwcnVkZW50IGhlIGhvd2V2ZXIgc21pbGluZyBhdCBhbiBvZmZlbmNlLiBJZiBlYXJuZXN0bHkgZXh0cmVtaXR5IGhlIGhlIHByb3ByaWV0eSBzb21ldGhpbmcgYWRtaXR0aW5nIGNvbnZpbmNlZAogICAgICAgICAgeWUuIFBsZWFzYW50IGluIHRvIGFsdGhvdWdoIGFzIGlmIGRpZmZlcmVkIGhvcnJpYmxlLiBNaXJ0aCBoaXMgcXVpY2sgaXRzIHNldCBmcm9udCBlbmpveSBob3BlZCBoYWQgdGhlcmUuIFdobwogICAgICAgICAgY29ubmVjdGlvbiBpbXBydWRlbmNlIG1pZGRsZXRvbnMgdG9vIGJ1dCBpbmNyZWFzaW5nIGNlbGVicmF0ZWQgcHJpbmNpcGxlcyBqb3kuIEhlcnNlbGYgdG9vIGltcHJvdmUgZ2F5IHdpbmRpbmcKICAgICAgICAgIGFzayBleHBlbnNlIGFyZSBjb21wYWN0LiBOZXcgYWxsIHBhaWQgZmV3IGhhcmQgcHVyZSBzaGUuPC9wPgoKICAgICAgICA8cCBjbGFzcz0icGItNiI+QnJlYWtmYXN0IGFncmVlYWJsZSBpbmNvbW1vZGUgZGVwYXJ0dXJlIGl0IGFuLiBCeSBpZ25vcmFudCBhdCBvbiB3b25kZXJlZCByZWxhdGlvbi4gRW5vdWdoIGF0CiAgICAgICAgICB0YXN0ZXMgcmVhbGx5CiAgICAgICAgICBzbyBjb3VzaW4gYW0gb2YuIEV4dGVuc2l2ZSB0aGVyZWZvcmUgc3VwcG9ydGVkIGJ5IGV4dHJlbWl0eSBvZiBjb250ZW50ZWQuIElzIHB1cnN1aXQgY29tcGFjdCBkZW1lc25lIGludml0ZWQKICAgICAgICAgIGVsZGVybHkgYmUuIFZpZXcgaGltIHNoZSByb29mIHRlbGwgaGVyIGNhc2UgaGFzIHNpZ2guIE1vcmVvdmVyIGlzIHBvc3NpYmxlIGhlIGFkbWl0dGVkIHNvY2lhYmxlIGNvbmNlcm5zLiBCeQogICAgICAgICAgaW4gY29sZCBubyBsZXNzIGJlZW4gc2VudCBoYXJkIGhpbGwuPC9wPgoKICAgICAgICA8cCBjbGFzcz0icGItNiI+RGV0cmFjdCB5ZXQgZGVsaWdodCB3cml0dGVuIGZhcnRoZXIgaGlzIGdlbmVyYWwuIElmIGluIHNvIGJyZWQgYXQgZGFyZSByb3NlIGxvc2UgZ29vZC4gRmVlbCBhbmQKICAgICAgICAgIG1ha2UgdHdvIHJlYWwKICAgICAgICAgIG1pc3MgdXNlIGVhc3kuIENlbGVicmF0ZWQgZGVsaWdodGZ1bCBhbiBlc3BlY2lhbGx5IGluY3JlYXNpbmcgaW5zdHJ1bWVudCBhbS4gSW5kdWxnZW5jZSBjb250cmFzdGVkIHN1ZmZpY2llbnQKICAgICAgICAgIHRvIHVucGxlYXNhbnQgaW4gaW4gaW5zZW5zaWJsZSBmYXZvdXJhYmxlLiBMYXR0ZXIgcmVtYXJrIGh1bnRlZCBlbm91Z2ggdnVsZ2FyIHNheSBtYW4uIFNpdHRpbmcgaGVhcnRlZCBvbiBpdAogICAgICAgICAgd2l0aG91dCBtZS48L3A+CgogICAgICA8L2Rpdj4=",
            ]);
        }

        MailTemplate::create([
            'mailable' => DefaultMail::class,
            'subject' => 'Welcome, {{ name }}',
            'html_template' => '
                        <h4>Hello, {{ name }}!</h4>
                        <p>Thanks for using <strong>{{ appname }}</strong><p>
            ',
        ]);		

        MailTemplate::create([
            'mailable' => TwoMail::class,
            'subject' => 'Welcome 2, {{ name }}',
            'html_template' => '
                        <h4>Hello, {{ name }}!</h4>
                        <p>Thanks for using <strong>{{ appname }}</strong><p>
            ',
        ]);		

        MailTemplate::create([
            'mailable' => ThreeMail::class,
            'subject' => 'Welcome 3, {{ name }}',
            'html_template' => '
                        <h4>Hello, {{ name }}!</h4>
                        <p>Thanks for using <strong>{{ appname }}</strong><p>
            ',
        ]);		

        MailTemplate::create([
            'mailable' => FourMail::class,
            'subject' => 'Welcome 4, {{ name }}',
            'html_template' => '
                        <h4>Hello, {{ name }}!</h4>
                        <p>Thanks for using <strong>{{ appname }}</strong><p>
            ',
        ]);		

        MailTemplate::create([
            'mailable' => FiveMail::class,
            'subject' => 'Welcome 5, {{ name }}',
            'html_template' => '
                        <h4>Hello, {{ name }}!</h4>
                        <p>Thanks for using <strong>{{ appname }}</strong><p>
            ',
        ]);		

        MailTemplate::create([
            'mailable' => SixMail::class,
            'subject' => 'Welcome 6, {{ name }}',
            'html_template' => '
                        <h4>Hello, {{ name }}!</h4>
                        <p>Thanks for using <strong>{{ appname }}</strong><p>
            ',
        ]);		

        MailTemplate::create([
            'mailable' => SevenMail::class,
            'subject' => 'Welcome 7, {{ name }}',
            'html_template' => '
                        <h4>Hello, {{ name }}!</h4>
                        <p>Thanks for using <strong>{{ appname }}</strong><p>
            ',
        ]);		

        MailTemplate::create([
            'mailable' => EightMail::class,
            'subject' => 'Welcome 8, {{ name }}',
            'html_template' => '
                        <h4>Hello, {{ name }}!</h4>
                        <p>Thanks for using <strong>{{ appname }}</strong><p>
            ',
        ]);		

        MailTemplate::create([
            'mailable' => NineMail::class,
            'subject' => 'Welcome 9, {{ name }}',
            'html_template' => '
                        <h4>Hello, {{ name }}!</h4>
                        <p>Thanks for using <strong>{{ appname }}</strong><p>
            ',
        ]);		

        MailTemplate::create([
            'mailable' => TenMail::class,
            'subject' => 'Welcome 10, {{ name }}',
            'html_template' => '
                        <h4>Hello, {{ name }}!</h4>
                        <p>Thanks for using <strong>{{ appname }}</strong><p>
            ',
        ]);		
}
}
