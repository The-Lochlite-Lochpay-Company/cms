<?php

namespace Lochlite\cms\Installer\database;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Lochlite\cms\Mail\DefaultMail;
use Lochlite\cms\Mail\TwoMail;
use Lochlite\cms\Mail\ThreeMail;
use Lochlite\cms\Mail\FourMail;
use Lochlite\cms\Mail\FiveMail;
use Lochlite\cms\Mail\SixMail;
use Lochlite\cms\Mail\SevenMail;
use Lochlite\cms\Mail\EightMail;
use Lochlite\cms\Mail\NineMail;
use Lochlite\cms\Mail\TenMail;
use Spatie\MailTemplates\Models\MailTemplate;

class EmailstemplateSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

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
