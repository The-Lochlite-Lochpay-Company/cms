<?php
/**
 * The Lochlite & Lochpay Company - Technology that makes people's lives easier
 *
 * (c) 2019 - 2024 LOCHLITE E LOCHPAY SOFTWARES E PAGAMENTOS LTDA., All Right Reserved.
 *
 * Software: LOCHLITE CMS
 * Version: 2.0.13
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

namespace Lochlite\cms;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Routing\Router;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Schema;
use Symfony\Component\Finder\Finder;
use Lochlite\cms\Jobs\RegisterRouteJob;
use Lochlite\cms\Models\User;
use Lochlite\cms\Models\Notifications;
use Lochlite\cms\Models\Updates;
use Lochlite\cms\Models\Domains;
use Lochlite\cms\Models\Fileupload;
use Lochlite\cms\Models\Appendcoding;
use Lochlite\cms\Models\Pwa;
use Lochlite\cms\Models\Seo;
use Lochlite\cms\Models\Settings;
use Lochlite\cms\Models\Plugins;
use Lochlite\cms\Models\History;
use Lochlite\cms\Models\Login;
use Lochlite\cms\Models\Register;
use Lochlite\cms\Models\Emailverify;
use Lochlite\cms\Models\Recoverypassword;
use Lochlite\cms\Models\Services;
use Lochlite\cms\Models\Customersarea;
//use Jenssegers\Agent\Agent;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\SimpleExcel\SimpleExcelReader;
use Spatie\SimpleExcel\SimpleExcelWriter;
use GuzzleHttp\Client;
use Carbon\Carbon;
use Inertia\Inertia;
use Artisan;
use Storage;
use Route;
use File;

class Lochlitecms implements LochlitecmsInterface
{
    private static $instance;

    private $keypass,
        $module,
        $plugins = "\plugins",
        $basePath;

    public function __construct($keypass = null)
    {
        $this->keypass = $keypass;
        $this->basePath = app()->path();
    }

    public function start($keypass = null)
    {
        return new Lochlitecms($keypass);
    }

    public function getInstance()
    {
        if (!isset(self::$instance)) {
            return false;
        }
        return self::$instance;
    }

    public static function setStaticInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new Lochlitecms();
        }
        return self::$instance;
    }

    public function setInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new Lochlitecms();
        }
        return self::$instance;
    }

    public function setKeypass(string $keypass)
    {
        $this->keypass = $keypass;
        return $this;
    }

    private function error(
        string $module,
        string $description,
        string $solution
    ) {
        return collect([
            "success" => false,
            "module" => $module,
            "description" => $description,
            "solution" => $solution,
        ]);
    }

    private function success(string $module, string $message = null)
    {
        return collect([
            "success" => true,
            "module" => $module,
            "message" => $message,
        ]);
    }

    public function application()
    {
        return collect([
            "name" => "Lochlite CMS",
            "version" => "2.0.12",
            "madein" => "Brazil",
            "brand" => "The Lochlite & Lochpay Company",
            "manufacturer" => "Lochlite e Lochpay Softwares e Pagamentos LTDA",
            "license" => [
                "type" => "private",
                "name" => "Proprietary",
                "url" => "https://djg.gpgic.com",
            ],
            "url_product" => "https://lochlite.com/solutions/cms",
            "homepage" => "https://lochlite.com",
            "developer" => [
                "name" => "Igor Macedo Montalvão",
                "contact" => [
                    "email" => [
                        "igor.macedo@gpgic.com",
                        "igmacedo01@gmail.com",
                    ],
                ],
            ],
            "support" => [
                "to" => "drcg@gpgic.com",
                "name" => "Lochlite Technical Support",
                "homepage" => "https://drcg.gpgic.com",
            ],
        ]);
    }

    public function listModule()
    {
        return collect([
            "setInstance",
            "start",
            "setKeypass",
            "application",
            "listModule",
            "update",
            "report",
            "support",
            "artisan",
            "command",
            "config",
            "isFile",
            "isFolder",
            "existsFolder",
            "getFolder",
            "existsPluginsFolder",
            "getPluginsFolder",
        ]);
    }

    private function getRemoteComposerJSON()
    {
        try {
            $client = new Client([
                "headers" => ["Content-Type" => "application/json"],
            ]);
            $response = $client->get(
                "https://raw.githubusercontent.com/The-Lochlite-Lochpay-Company/cms/main/composer.json"
            );
            return json_decode($response->getBody());
        } catch (\Exception $e) {
            if (env("APP_DEBUG", false) == true) {
                dd($e);
            }
        }
    }

    private function getRemoteUpdate()
    {
        try {
            $client = new Client([
                "headers" => ["Content-Type" => "application/json"],
            ]);
            $response = $client->get(
                "https://api.github.com/repos/The-Lochlite-Lochpay-Company/cms/zipball"
            );
            if ($response->getStatusCode() == 200) {
                $zip = new \ZipArchive();
                File::makeDirectory(
                    base_path("/vendor/lochlite/temp"),
                    0777,
                    true,
                    true
                );
                File::put(
                    base_path("vendor/lochlite/temp/update.zip"),
                    $response->getBody()
                );
                $zip->open(base_path("vendor/lochlite/temp/update.zip"));
                $zip->extractTo(base_path("vendor/lochlite/temp"));
                $zip->close();
                File::delete(base_path("vendor/lochlite/temp/update.zip"));
                File::copyDirectory(
                    glob(base_path("vendor/lochlite/temp/*"))[0],
                    base_path("vendor/lochlite/cms")
                );
                File::deleteDirectory(base_path("vendor/lochlite/temp"));
            }
            return true;
        } catch (\Exception $e) {
            if (env("APP_DEBUG", false) == true) {
                dd($e);
            }
            session()->flash(
                "flash.banner",
                "Falha na conexão com o servidor remoto."
            );
            session()->flash("flash.bannerStyle", "danger");
            return;
        }
    }

    public function isenabledFunction($func)
    {
        return is_callable($func) &&
            false === stripos(ini_get("disable_functions"), $func);
    }

    public function update()
    {
        try {
            $version = Lochlitecms::application()->get("version");
            $remoteversion = Lochlitecms::getRemoteComposerJSON();
            if ($version == $remoteversion->version) {
                if (
                    Lochlitecms::isenabledFunction("exec") ||
                    Lochlitecms::isenabledFunction("shell_exec") ||
                    Lochlitecms::isenabledFunction("proc_open")
                ) {
                    Lochlitecms::command(
                        "cd " . base_path("/") . " && php composer.phar update"
                    );
                } else {
                    Lochlitecms::getRemoteUpdate();
                }

                //if(!is_null($this->keypass) && is_string($this->keypass)){
                //return Lochlitecms::success('update', 'Updated successfully.');
                //} else {
                //return Lochlitecms::error('update', 'Keypass is missing, you must provide it before proceeding.', 'Use "new Lochlitecms($keypass)" or if using static method, use "Lochlitecms::setKeypass($keypass)" to solve this problem.');
                //}
            }
        } catch (\Exception $e) {
            if (env("APP_DEBUG", false) == true) {
                dd($e);
            }
        }
    }

    public function report($error = null)
    {
        if (is_null($error)) {
            return Lochlitecms::error(
                "report",
                "A mandatory parameter is used, inform it before proceeding.",
                'Use "new Lochlitecms($keypass)->report("your message here")" or if using static method, use "Lochlitecms::setKeypass($keypass)->report("your message here")" to resolve this problem.'
            );
        } elseif (!is_null($this->keypass) && is_string($this->keypass)) {
            return Lochlitecms::error(
                "report",
                "Keypass is missing, you must provide it before proceeding.",
                'Use "new Lochlitecms($keypass)" or if using static method, use "Lochlitecms::setKeypass($keypass)" to solve this problem.'
            );
        } else {
            return Lochlitecms::success("report", "Reported successfully.");
        }
    }

    public function support($message = null)
    {
        if (is_null($message)) {
            return Lochlitecms::error(
                "support",
                "A mandatory parameter is used, inform it before proceeding.",
                'Use "new Lochlitecms($keypass)->support("your message here")" or if using static method use "Lochlitecms::setKeypass($keypass)->support("your message here")" to resolve this problem.'
            );
        } elseif (is_null($this->keypass) && is_string($this->keypass)) {
            return Lochlitecms::error(
                "support",
                "Keypass is missing, you must provide it before proceeding.",
                'Use "new Lochlitecms($keypass)" or if using static method, use "Lochlitecms::setKeypass($keypass)" to solve this problem.'
            );
        } else {
            return Lochlitecms::success(
                "support",
                "Support requested successfully."
            );
        }
    }

    public function install(string $domain = null)
    {
        try {
            $host = Lochlitecms::domainsDatabase(
                $domain == null ? request()->getHttpHost() : $domain
            );
            if (!$host == false && $host->status == "pre-installation") {
                $start = new \Lochlite\cms\Installer\database\Starter();
                $start->run($host->domain);
                $host->update(["status" => "active"]);
                $host->save();
                cache()->put("domains-" . $host->domain, $host, 15000);
            }
        } catch (\Exception $e) {
            if (env("APP_DEBUG", false) == true) {
                dd($e);
            }
        }
    }

    public function artisan($command)
    {
        try {
            $result = Artisan::call($command);
            return collect([
                "success" => $result == 0 ? true : false,
                "output" => Artisan::output(),
            ]);
        } catch (\Exception $e) {
            if (env("APP_DEBUG", false) == true) {
                dd($e);
            }
        }
    }

    public function command($command)
    {
        try {
            if (
                Lochlitecms::isenabledFunction("exec") &&
                Lochlitecms::isenabledFunction("escapeshellcmd")
            ) {
                $result = exec(escapeshellcmd($command), $result);
                return collect([
                    "success" => $result == null ? false : true,
                    "output" => $result,
                ]);
            } elseif (Lochlitecms::isenabledFunction("shell_exec")) {
                $result = shell_exec($command);
                return collect([
                    "success" => $result == 0 ? true : false,
                    "output" => $result,
                ]);
            } elseif (Lochlitecms::isenabledFunction("proc_open")) {
                $result = new \Symfony\Component\Process\Process([
                    "php composer.phar install --no-interaction",
                ]);
                $result->setWorkingDirectory(base_path("/"));
                $result->run();
                if ($result->isSuccessful()) {
                    return collect(["success" => true, "output" => $result]);
                } else {
                    return collect(["success" => false, "output" => $result]);
                }
            } else {
                return Lochlitecms::error(
                    "command",
                    "This server does not allow execution of shell commands, you must enable the functionality before proceeding.",
                    "Contact your hosting company or IT department and ask to enable one of the following PHP functions: exec, shell_exec or proc_open; This will solve the problem."
                );
            }
        } catch (\Exception $e) {
            if (env("APP_DEBUG", false) == true) {
                dd($e);
            }
        }
    }

    public function setDefaultHeaderResponse()
    {
        header(
            'Link: <https://fonts.gstatic.com>; rel="preconnect", <https://fonts.googleapis.com>; rel="preconnect"'
        );
        header("X-lly-visitor: " . Lochlitecms::visitorID());
        return;
    }

    private function checkVersion()
    {
        $versionpackage = Lochlitecms::setStaticInstance()
            ->application()
            ->get("version");
        $newversion = false;
        $lastversion = "";
        $toupdate = function ($versionpackage, $newversion, $lastversion) {
            try {
                if (!Updates::where("version", $versionpackage)->exists()) {
                    $current = Updates::latest()->first();
                    $newversion = true;
                    $lastversion = $current == null ? "" : $current->version;
                    $updatemodel = Updates::create([
                        "version" => $versionpackage,
                        "lastversion" => $lastversion,
                    ]);
                    $updatemodel->save();
                }
                $setversion = Updates::where(
                    "version",
                    $versionpackage
                )->first();
                cache()->put("version", $setversion);
                return (object) [
                    "status" => "success",
                    "newversion" => $newversion,
                    "lastversion" => $lastversion,
                    "version" => $setversion,
                ];
            } catch (\Exception $e) {
                return (object) [
                    "status" => "error",
                    "newversion" => $versionpackage,
                    "lastversion" => $versionpackage,
                    "version" => $versionpackage,
                ];
            }
        };
        $version = cache()->get("version");
        if (is_null($version) || $version->version !== $versionpackage) {
            cache()->forget("version");
            $result = $toupdate($versionpackage, $newversion, $lastversion);
            $newversion = $result->newversion;
            $lastversion = $result->lastversion;
            $version = $result->version;
        }
        return (object) [
            "newversion" => $newversion,
            "lastversion" => $lastversion,
            "version" => $version,
            "status" => $version->status ?? "active",
        ];
    }

    public function setChangesVersion()
    {
        $version = Lochlitecms::checkVersion();
        if ($version->status == "processing") {
        }
    }

    private function domainsDatabase($domain)
    {
        return cache()->get("domains-" . $domain, function () use ($domain) {
            if (Schema::hasTable("domains")) {
                if (Domains::where("domain", $domain)->exists()) {
                    $databasedomains = Domains::where(
                        "domain",
                        $domain
                    )->first();
                    cache()->put("domains-" . $domain, $databasedomains, 15000);
                    return $databasedomains;
                } elseif (Domains::count() == 0) {
                    $databasedomains = Domains::create([
                        "domain" => $domain,
                        "status" => "pre-installation",
                        "main" => true,
                    ]);
                    $databasedomains->save();
                    cache()->put("domains-" . $domain, $databasedomains, 15000);
                    return $databasedomains;
                } else {
                    $databasedomains = Domains::create(["domain" => $domain]);
                    $databasedomains->save();
                    cache()->put("domains-" . $domain, $databasedomains, 15000);
                    return $databasedomains;
                }
            } else {
                return false;
            }
        });
    }

    public function lang()
    {
        return Lochlitecms::config("language");
    }

    public function config(string $param = null)
    {
        return $param == null
            ? Lochlitecms::settingsDatabase()
            : Lochlitecms::settingsDatabase()->$param;
    }

    private function settingsDatabase()
    {
        return cache()->get("settings", function () {
            if (
                Schema::hasTable("settings") &&
                Settings::where("domain", request()->getHttpHost())
                    ->orWhere("default", true)
                    ->orWhere("id", 1)
                    ->exists()
            ) {
                $setting = Settings::where("domain", request()->getHttpHost())
                    ->orWhere("default", true)
                    ->orWhere("id", 1)
                    ->first();
                cache()->put("settings", $setting, 5000);
                return $setting;
            } else {
                return (object) [
                    "appname" => "App Name",
                    "language" => "pt_BR",
                    "domain" => request()->getSchemeAndHttpHost(),
                    "timezone" => "America/Sao_Paulo",
                    "debug" => (bool) env("APP_DEBUG", true),
                    "running" => env("APP_ENV", "production"),
                    "backup_key" => env("BACKUP_ARCHIVE_PASSWORD", null),
                    "backup_notify" => env("BACKUP_NOTIFY_mail", null),
                    "session_driver" => env("SESSION_DRIVER", "database"),
                    "session_lifetime" => env("SESSION_LIFETIME", 120),
                    "broadcast_driver" => env("BROADCAST_DRIVER", "null"),
                    "pusher_app_key" => "",
                    "pusher_app_secret" => "",
                    "pusher_app_id" => "",
                    "pusher_app_cluster" => "",
                    "cache_driver" => env("CACHE_DRIVER", "file"),
                    "redis_url" => "",
                    "redis_host" => "",
                    "redis_port" => "",
                    "redis_username" => "",
                    "redis_password" => "",
                ];
            }
        });
    }

    public function startConfig()
    {
        $settings = Lochlitecms::settingsDatabase();
        Config()->set("app.name", $settings->appname);
        Config()->set("app.locale", $settings->language);
        Config()->set("app.url", $settings->domain);
        Config()->set("app.timezone", $settings->timezone);
        Config()->set("app.debug", $settings->debug);
        Config()->set("app.env", $settings->running);
        Config()->set("backup.password", $settings->backup_key);
        Config()->set("backup.notifications.mail.to", $settings->backup_notify);
        Config()->set("session.driver", $settings->session_driver);
        Config()->set("session.lifetime", $settings->session_lifetime);
        Config()->set("broadcasting.default", $settings->broadcast_driver);
        Config()->set(
            "broadcasting.connections.pusher.key",
            $settings->pusher_app_key
        );
        Config()->set(
            "broadcasting.connections.pusher.secret",
            $settings->pusher_app_secret
        );
        Config()->set(
            "broadcasting.connections.pusher.app_id",
            $settings->pusher_app_id
        );
        Config()->set(
            "broadcasting.connections.options.cluster",
            $settings->pusher_app_cluster
        );
        Config()->set("cache.default", $settings->cache_driver);
        Config()->set("database.redis.default.url", $settings->redis_url);
        Config()->set("database.redis.default.host", $settings->redis_host);
        Config()->set("database.redis.default.port", $settings->redis_port);
        Config()->set(
            "database.redis.default.username",
            $settings->redis_username
        );
        Config()->set(
            "database.redis.default.password",
            $settings->redis_password
        );
        Config()->set("database.redis.cache.url", $settings->redis_url);
        Config()->set("database.redis.cache.host", $settings->redis_host);
        Config()->set("database.redis.cache.port", $settings->redis_port);
        Config()->set(
            "database.redis.cache.username",
            $settings->redis_username
        );
        Config()->set(
            "database.redis.cache.password",
            $settings->redis_password
        );
        Config()->set(
            "mail.default",
            $settings->mail_driver ?? env("MAIL_MAILER", "smtp")
        );
        Config()->set("mail.from.name", $settings->mailfrom_name ?? "");
        Config()->set("mail.from.address", $settings->mailfrom_address ?? "");
        Config()->set(
            "mail.mailers.smtp.host",
            $settings->mail_host ?? "127.0.0.1"
        );
        Config()->set(
            "mail.mailers.smtp.local_domain",
            $settings->mail_host ?? "127.0.0.1"
        );
        Config()->set("mail.mailers.smtp.port", $settings->mail_port ?? 587);
        Config()->set(
            "mail.mailers.smtp.username",
            $settings->mail_username ?? ""
        );
        Config()->set(
            "mail.mailers.smtp.password",
            $settings->mail_password ?? ""
        );
        Config()->set(
            "mail.mailers.smtp.encryption",
            $settings->mail_protocol ?? "ssl"
        );
        Config()->set(
            "mail.mailers.smtp.verify_peer",
            $settings->mail_encryption ?? true
        );
        Config()->set(
            "services.mailgun.domain",
            $settings->mailgun_domain ?? ""
        );
        Config()->set(
            "services.mailgun.secret",
            $settings->mailgun_secret ?? ""
        );
        Config()->set(
            "services.mailgun.endpoint",
            $settings->mailgun_endpoint ?? ""
        );
        Config()->set(
            "services.mailgun.scheme",
            $settings->mailgun_scheme ?? ""
        );
        Config()->set(
            "filesystems.default",
            $settings->filesystem_disk ?? env("FILESYSTEM_DISK", "local")
        );
        Config()->set(
            "filesystems.disks.sftp.host",
            $settings->sftp_host ?? ""
        );
        Config()->set(
            "filesystems.disks.sftp.username",
            $settings->sftp_username ?? ""
        );
        Config()->set(
            "filesystems.disks.sftp.password",
            $settings->sftp_password ?? ""
        );
        Config()->set(
            "filesystems.disks.sftp.privateKey",
            $settings->sftp_private_key ?? ""
        );
        Config()->set("filesystems.disks.ftp.host", $settings->ftp_host ?? "");
        Config()->set(
            "filesystems.disks.ftp.username",
            $settings->ftp_username ?? ""
        );
        Config()->set(
            "filesystems.disks.ftp.password",
            $settings->ftp_password ?? ""
        );
        Config()->set("filesystems.disks.ftp.port", $settings->ftp_port ?? "");
        Config()->set("filesystems.disks.ftp.ssl", $settings->ftp_ssl ?? "");
        Config()->set(
            "filesystems.disks.ftp.passive",
            $settings->ftp_passive ?? ""
        );
        Config()->set(
            "filesystems.disks.ftp.timeout",
            $settings->ftp_timeout ?? ""
        );
        Config()->set("filesystems.disks.ftp.root", $settings->ftp_root ?? "");
        Config()->set(
            "filesystems.disks.s3.key",
            $settings->aws_access_key_id ?? ""
        );
        Config()->set(
            "filesystems.disks.s3.secret",
            $settings->aws_secret_access_key ?? ""
        );
        Config()->set(
            "filesystems.disks.s3.region",
            $settings->aws_default_region ?? ""
        );
        Config()->set(
            "filesystems.disks.s3.bucket",
            $settings->aws_bucket ?? ""
        );
        Config()->set(
            "filesystems.disks.s3.use_path_style_endpoint",
            $settings->aws_use_path_style_endpoint ?? ""
        );
        Config()->set("analytics.view_id", $settings->analytics_view_id ?? "");
        Config()->set("newsletter.apiKey", $settings->mailchimp_api ?? "");
        Config()->set(
            "newsletter.lists.subscribers.id",
            $settings->mailchimp_list_id ?? ""
        );
        return $this;
    }

    public function setConfig(string $module, Request $request)
    {
        try {
            $setting = Settings::where("default", true)
                ->orWhere("id", 1)
                ->first();
            if ($module == "lang") {
                $setting->update(["language" => $request->get("language")]);
                session()->flash(
                    "flash.banner",
                    "O idioma foi atualizado com sucesso."
                );
                session()->flash("flash.bannerStyle", "success");
            } elseif ($module == "system") {
                $setting->update([
                    "appname" => $request->get("appname"),
                    "domain" => $request->get("domain"),
                    "timezone" => $request->get("timezone"),
                    "language" => $request->get("language"),
                    "mail_driver" => $request->get("maildriver"),
                    "broadcast_driver" => $request->get("broadcastdriver"),
                    "session_driver" => $request->get("sessiondriver"),
                    "session_lifetime" => $request->get("sessionlifetime"),
                    "filesystem_disk" => $request->get("filesystemdisk"),
                    "cache_driver" => $request->get("cachedriver"),
                    "debug" => $request->get("debug"),
                    "running" => $request->get("running"),
                ]);
                session()->flash(
                    "flash.banner",
                    "Configurações do sistema atualizadas com sucesso."
                );
                session()->flash("flash.bannerStyle", "success");
            } elseif ($module == "backup") {
                $setting->update([
                    "backup_key" => $request->get("key"),
                    "backup_notify" => $request->get("notify"),
                ]);
                session()->flash(
                    "flash.banner",
                    "As configurações de backup foram atualizadas com sucesso."
                );
                session()->flash("flash.bannerStyle", "success");
            } elseif ($module == "texteditor") {
                $setting->update([
                    "text_editor" => $request->get("actived"),
                ]);
                session()->flash(
                    "flash.banner",
                    "As configurações do editor de texto foram atualizadas com sucesso."
                );
                session()->flash("flash.bannerStyle", "success");
            } elseif ($module == "email") {
                $setting->update([
                    "mailfrom_name" => $request->get("emailfromname"),
                    "mailfrom_address" => $request->get("emailfrom"),
                ]);
                session()->flash(
                    "flash.banner",
                    "Configurações de email atualizadas com sucesso."
                );
                session()->flash("flash.bannerStyle", "success");
            } elseif ($module == "mailgun") {
                $setting->update([
                    "mailgun_domain" => $request->get("mailgundomain"),
                    "mailgun_secret" => $request->get("mailgunsecret"),
                    "mailgun_endpoint" => $request->get("mailgunendpoint"),
                    "mailgun_scheme" => $request->get("mailgunscheme"),
                ]);
                session()->flash(
                    "flash.banner",
                    "Configurações de Mailgun atualizadas com sucesso."
                );
                session()->flash("flash.bannerStyle", "success");
            } elseif ($module == "smtp") {
                $setting->update([
                    "mail_host" => $request->get("smtphost"),
                    "mail_port" => $request->get("smtpport"),
                    "mail_protocol" => $request->get("smtpprotocol"),
                    "mail_encryption" => $request->get("smtpencrypt"),
                    "mail_username" => $request->get("smtpusername"),
                    "mail_password" => $request->get("smtppassword"),
                ]);
                session()->flash(
                    "flash.banner",
                    "Configurações de SMTP atualizadas com sucesso."
                );
                session()->flash("flash.bannerStyle", "success");
            } elseif ($module == "mailchimp") {
                $setting->update([
                    "mailchimp_api" => $request->get("mailchimpapi"),
                    "mailchimp_list_id" => $request->get("mailchimplistid"),
                ]);
                session()->flash(
                    "flash.banner",
                    "Configurações de Mailchimp atualizadas com sucesso."
                );
                session()->flash("flash.bannerStyle", "success");
            } elseif ($module == "googleanalytics") {
                $setting->update([
                    "analytics_view_id" => $request->get("analyticsviewid"),
                ]);
                session()->flash(
                    "flash.banner",
                    "Configurações do Google Analytics atualizadas com sucesso."
                );
                session()->flash("flash.bannerStyle", "success");
            } elseif ($module == "ftp") {
                $setting->update([
                    "ftp_host" => $request->get("ftphost"),
                    "ftp_username" => $request->get("ftpusername"),
                    "ftp_password" => $request->get("ftppassword"),
                    "ftp_port" => $request->get("ftpport"),
                    "ftp_ssl" => $request->get("ftpssl"),
                    "ftp_passive" => $request->get("ftppassive"),
                    "ftp_timeout" => $request->get("ftptimeout"),
                    "ftp_root" => $request->get("ftproot"),
                ]);
                session()->flash(
                    "flash.banner",
                    "Configurações do FTP atualizadas com sucesso."
                );
                session()->flash("flash.bannerStyle", "success");
            } elseif ($module == "sftp") {
                $setting->update([
                    "sftp_host" => $request->get("sftphost"),
                    "sftp_username" => $request->get("sftpusername"),
                    "sftp_password" => $request->get("sftppassword"),
                    "sftp_private_key" => $request->get("sftpprivatekey"),
                ]);
                session()->flash(
                    "flash.banner",
                    "Configurações do SFTP atualizadas com sucesso."
                );
                session()->flash("flash.bannerStyle", "success");
            } elseif ($module == "amazon") {
                $setting->update([
                    "aws_access_key_id" => $request->get("awskeyid"),
                    "aws_secret_access_key" => $request->get("awssecretkey"),
                    "aws_default_region" => $request->get("awsregion"),
                    "aws_bucket" => $request->get("awsbucket"),
                ]);
                session()->flash(
                    "flash.banner",
                    "Configurações do Amazon S3 atualizadas com sucesso."
                );
                session()->flash("flash.bannerStyle", "success");
            } elseif ($module == "memcached") {
                $setting->update([
                    "memcached_host" => $request->get("memcachedhost"),
                    "memcached_port" => $request->get("memcachedport"),
                    "memcached_username" => $request->get("memcachedusername"),
                    "memcached_password" => $request->get("memcachedpassword"),
                ]);
                session()->flash(
                    "flash.banner",
                    "Configurações do Memcached Server atualizadas com sucesso."
                );
                session()->flash("flash.bannerStyle", "success");
            } elseif ($module == "redis") {
                $setting->update([
                    "redis_url" => $request->get("redisurl"),
                    "redis_host" => $request->get("redishost"),
                    "redis_port" => $request->get("redisport"),
                    "redis_username" => $request->get("redisusername"),
                    "redis_password" => $request->get("redispassword"),
                ]);
                session()->flash(
                    "flash.banner",
                    "Configurações do Redis Server atualizadas com sucesso."
                );
                session()->flash("flash.bannerStyle", "success");
            } elseif ($module == "pusher") {
                $setting->update([
                    "pusher_app_id" => $request->get("appid"),
                    "pusher_app_key" => $request->get("appkey"),
                    "pusher_app_secret" => $request->get("appsecret"),
                    "pusher_app_cluster" => $request->get("appcluster"),
                ]);
                session()->flash(
                    "flash.banner",
                    "Configurações do Pusher atualizadas com sucesso."
                );
                session()->flash("flash.bannerStyle", "success");
            } else {
                session()->flash(
                    "flash.banner",
                    "O Módulo: " .
                        $module .
                        " é invalido para o conjunto de configurações disponiveis atualmente."
                );
                session()->flash("flash.bannerStyle", "danger");
                return redirect()
                    ->back()
                    ->with("error", "Module not found.");
            }
            $setting->save();
            $clearcache = Artisan::call("cache:clear");
            $clearconfig = Artisan::call("config:clear");
            cache()->forget("settings");
            return redirect()
                ->back()
                ->with("success", "Settings updated successfully");
        } catch (\Exception $e) {
            session()->flash(
                "flash.banner",
                "Falha ao atualizar as configurações de: " . $module
            );
            session()->flash("flash.bannerStyle", "danger");
            return redirect()
                ->back()
                ->with("error", "Failed to update settings");
        }
    }

    public function import(string $path, string $extension = "xlsx")
    {
        try {
            $import = SimpleExcelReader::create($path, $extension)->getRows();
            return $import;
        } catch (\Exception $e) {
            session()->flash(
                "flash.banner",
                "There was an error importing the file, please try again or consult the support service."
            );
            session()->flash("flash.bannerStyle", "danger");
            return redirect()->back();
        }
    }

    public function export(
        string $path,
        array $data,
        string $extension = "xlsx"
    ) {
        try {
            $export = SimpleExcelWriter::create($path, $extension)->addRows(
                $data
            );
            return $export;
        } catch (\Exception $e) {
            dd($e);
            session()->flash(
                "flash.banner",
                "There was an error exporting the file, please try again or consult the support service."
            );
            session()->flash("flash.bannerStyle", "danger");
            return redirect()->back();
        }
    }

    public function exportDownload(
        string $name,
        array $data,
        string $extension = "xlsx"
    ) {
        try {
            $export = SimpleExcelWriter::streamDownload($name, $extension)
                ->addRows($data)
                ->toBrowser();
            return $export;
        } catch (\Exception $e) {
            dd($e);
            session()->flash(
                "flash.banner",
                "There was an error exporting the file, please try again or consult the support service."
            );
            session()->flash("flash.bannerStyle", "danger");
            return redirect()->back();
        }
    }

    public function optimize(string $command)
    {
        try {
            if ($command == "cache") {
                $operation = Lochlitecms::artisan("cache:clear");
                session()->flash(
                    "flash.banner",
                    "O cache do CMS foi excluido com sucesso."
                );
                session()->flash("flash.bannerStyle", "success");
            } elseif ($command == "config") {
                $operation = Lochlitecms::artisan("config:clear");
                session()->flash(
                    "flash.banner",
                    "O cache de configurações foi excluido com sucesso."
                );
                session()->flash("flash.bannerStyle", "success");
            } elseif ($command == "view") {
                $operation = Lochlitecms::artisan("view:clear");
                session()->flash(
                    "flash.banner",
                    "O cache de renderização foi excluido com sucesso."
                );
                session()->flash("flash.bannerStyle", "success");
            } elseif ($command == "route") {
                $operation = Lochlitecms::artisan("route:clear");
                session()->flash(
                    "flash.banner",
                    "O cache de rotas foi excludo com sucesso"
                );
                session()->flash("flash.bannerStyle", "success");
            } elseif ($command == "cleanall") {
                $operation = Lochlitecms::artisan("optimize:clear");
                session()->flash(
                    "flash.banner",
                    "O cache do site foi excludo com sucesso"
                );
                session()->flash("flash.bannerStyle", "success");
            } elseif ($command == "optimize") {
                $operation = Lochlitecms::artisan("optimize");
                session()->flash(
                    "flash.banner",
                    "O site foi otimizado com sucesso"
                );
                session()->flash("flash.bannerStyle", "success");
            } else {
                session()->flash(
                    "flash.banner",
                    "O Módulo: " .
                        $command .
                        " é invalido para o conjunto de configurações disponiveis atualmente."
                );
                session()->flash("flash.bannerStyle", "danger");
                return redirect()
                    ->route("managersettings.cleandata")
                    ->with("error", "Module not found.");
            }

            if ($operation->get("success")) {
                return redirect()
                    ->route("managersettings.cleandata")
                    ->with("success", "Settings updated successfully");
            } else {
                session()->flash(
                    "flash.banner",
                    "O modulo: " .
                        $command .
                        " retornou a seguinte mensagem: " .
                        $operation->get("output")
                );
                session()->flash("flash.bannerStyle", "danger");
                return redirect()
                    ->route("managersettings.cleandata")
                    ->with("error", "Settings updated failed");
            }
        } catch (\Exception $e) {
            session()->flash(
                "flash.banner",
                "Ocorreu uma falha ao lidar com o modulo: " . $command
            );
            session()->flash("flash.bannerStyle", "danger");
            return redirect()
                ->back()
                ->with("error", "Failed to update settings");
        }
    }

    public function newPermissions(array $data)
    {
        foreach ($data as $item) {
            if ($item["type"] == "permission") {
                if (
                    Role::where("name", $item["role"])->exists() &&
                    !Permission::where("name", $item["name"])->exists()
                ) {
                    $role = Role::where("name", $item["role"])->first();
                    Permission::create(["name" => $item["name"]]);
                    $role->givePermissionTo($item["name"]);
                    app()[
                        \Spatie\Permission\PermissionRegistrar::class
                    ]->forgetCachedPermissions();
                }
            } elseif ($item["type"] == "role") {
                if (!Role::where("name", $item["name"])->exists()) {
                    Role::create(["name" => $item["name"]]);
                    app()[
                        \Spatie\Permission\PermissionRegistrar::class
                    ]->forgetCachedPermissions();
                }
            } else {
            }
        }
    }

    private function servicesDatabase(string $query = null)
    {
        try {
            if (is_null($query)) {
                return cache()->get("services", function () use ($query) {
                    if (Schema::hasTable("services")) {
                        $services = Services::all();
                        cache()->put("services", $services, 5000);
                        return $services;
                    } else {
                        return (object) [];
                    }
                });
            } else {
                return cache()->get("services-" . $query, function () use (
                    $query
                ) {
                    if (
                        Schema::hasTable("services") &&
                        Services::where("name", $query)
                            ->orWhere("id", $query)
                            ->exists()
                    ) {
                        $services = Services::where("default", true)
                            ->orWhere("id", 1)
                            ->first();
                        cache()->put("services-" . $query, $services, 5000);
                        return $services;
                    } else {
                        return (object) [
                            "domain" => "",
                            "name" => "",
                            "host" => "",
                            "callback" => "",
                            "query" => "",
                            "type" => "post",
                            "data" => "json",
                            "apis" => (object) ["original" => [], "api" => []],
                            "status" => "disabled",
                        ];
                    }
                });
            }
        } catch (\Exception $e) {
            return (object) [
                "domain" => "",
                "name" => "",
                "host" => "",
                "callback" => "",
                "query" => "",
                "type" => "post",
                "data" => "json",
                "apis" => (object) ["original" => [], "api" => []],
                "status" => "disabled",
            ];
        }
    }

    public function setServices()
    {
        try {
            $database = Lochlitecms::servicesDatabase();
            foreach ($database as $row) {
                config()->set(
                    "services." . $row->name,
                    Lochlitecms::serviceData($row)
                );
            }
        } catch (\Exception $e) {
        }
    }

    public function serviceData(Services $service)
    {
        return $service->api["api"];
    }

    public function render(
        string $view = "Welcome",
        array $data = [],
        string $layout = "lochlitecms::admin"
    ) {
        return Inertia::render($view, $data)->rootview($layout);
    }

    public function renderAuth(
        string $view = "Welcome",
        array $data = [],
        string $layout = "lochlitecms::admin"
    ) {
        if (Auth()->check() || Auth()->check()) {
            $user = Auth()->User();
            $mynotifications = Notifications::where(
                "user_id",
                $user->id
            )->paginate();
            return Inertia::render(
                $view,
                array_merge(
                    [
                        "mynotifications" => $mynotifications,
                        "lang" => Lochlitecms::lang(),
                        "name" => $user->name,
                        "last_name" => $user->last_name,
                        "email" => $user->email,
                        "avatar" => $user->avatar,
                        "wallpaper" => $user->wallpaper,
                    ],
                    $data
                )
            )->rootview($layout);
        } else {
            session()->flash(
                "flash.banner",
                "Você precisa fazer login ou registrar-se antes de continuar."
            );
            session()->flash("flash.bannerStyle", "danger");
            return redirect()->route("login");
        }
    }

    public function renderPanelCMS(string $view = "Welcome", array $data = [])
    {
        if (Auth()->check() || Auth()->check()) {//dd(Auth()->User()->assignRole(\Spatie\Permission\Models\Role::where('name', 'user')->first()));

            return Inertia::render(
                "Panel/" . Lochlitecms::lang() . "/" . $view,
                array_merge(
                    [
                        "lang" => Lochlitecms::lang(),
                        "menuitems" => Lochlitecms::generateSidebar(),
                        "menulang" => Lochlitecms::generateMenuLang(),
                        "version" => Lochlitecms::application()->get("version"),
                    ],
                    $data
                )
            )->rootview("lochlitecms::admin");
        } else {
            session()->flash(
                "flash.banner",
                "Você precisa fazer login ou registrar-se antes de continuar."
            );
            session()->flash("flash.bannerStyle", "danger");
            return redirect()->route("login");
        }
    }

    public function visitorID()
    {
        if (!session()->has("visitor")) {
            $random = Str::random(32);
            $time = now();
            $visitor = Lochlitecms::visitor();
            $ip = $visitor->ip;
            $city = $visitor->city;
            $id = sha1($ip . $random . $time);
            session()->put(
                "visitor",
                (object) ["id" => $id, "city" => $city, "ip" => $ip]
            );
        }
        return session()->get("visitor")->id;
    }

    public function visitor(string $ip = null, string $param = null)
    {
        try {
            Config()->set("cache.default", "array");
            $geo = $ip == null ? GeoIP()->getLocation() : GeoIP($ip);
            Config()->set("cache.default", Lochlitecms::config("cache_driver"));
            return $param == null ? $geo : $geo->$param;
        } catch (\Exception $e) {
            return (object) [
                "ip" => "127.0.0.0",
                "iso_code" => "US",
                "country" => "United States",
                "city" => "New Haven",
                "state" => "CT",
                "state_name" => "Connecticut",
                "postal_code" => "06510",
                "lat" => 41.31,
                "lon" => -72.92,
                "timezone" => "America/New_York",
                "continent" => "NA",
                "default" => true,
                "currency" => "USD",
            ];
        }
    }

    public function userAgent()
    {
       // $agent = new Agent();
        //return $agent;
    }

    public function getHistory(int $id)
    {
        $history = History::where("userid", $id)->paginate();
        return $history;
    }

    public function setHistory(
        string $action,
        string $description,
        $authuser = null
    ) {
        $visitor = Lochlitecms::visitor();
        $visitorid = Lochlitecms::visitorID();
        //$agent = Lochlitecms::userAgent();
        $user =
            $authuser !== null
                ? $authuser
                : (Auth()->check() == true
                    ? Auth()->User()
                    : null);
        History::create([
            "domain" => request()->getHttpHost(),
            "action" => $action,
            "description" => $description,
            "visitorid" => $visitorid,
            "userid" => $user !== null ? $user->id : "",
            "username" => $user !== null ? $user->name : "",
            "url" => url()->current(),
            "urlprevious" => url()->previous(),
            "ip" => $visitor->ip,
            "city" => $visitor->city,
            "state" => $visitor->state,
            "country" => $visitor->country,
            "latitude" => $visitor->lat,
            "longitude" => $visitor->lon,
            "zipcode" => $visitor->postal_code,
        ]);
        return true;
    }

    private static function loginDatabase(string $param = null)
    {
        if (
            !Login::where("default", true)
                ->orWhere("id", 1)
                ->exists()
        ) {
            Login::create(["default" => true]);
        }
        $login = Login::where("default", true)
            ->orWhere("id", 1)
            ->first();
        return $login;
    }

    private static function registerDatabase(string $param = null)
    {
        if (
            !Register::where("default", true)
                ->orWhere("id", 1)
                ->exists()
        ) {
            Register::create(["default" => true]);
        }
        $register = Register::where("default", true)
            ->orWhere("id", 1)
            ->first();
        return $register;
    }

    private static function recoverypasswordDatabase(string $param = null)
    {
        if (
            !Recoverypassword::where("default", true)
                ->orWhere("id", 1)
                ->exists()
        ) {
            Recoverypassword::create(["default" => true]);
        }
        $recoverypassword = Recoverypassword::where("default", true)
            ->orWhere("id", 1)
            ->first();
        return $recoverypassword;
    }

    private static function emailverifyDatabase(string $param = null)
    {
        if (
            !Emailverify::where("default", true)
                ->orWhere("id", 1)
                ->exists()
        ) {
            Emailverify::create(["default" => true]);
        }
        $emailverify = Emailverify::where("default", true)
            ->orWhere("id", 1)
            ->first();
        return $emailverify;
    }

    public static function login()
    {
        $login = Lochlitecms::loginDatabase();
        return \Lochlite\cms\Facades\Lochlitecms::render(
            "Auth/" . Lochlitecms::setStaticInstance()->lang() . "/login",
            [
                "canResetPassword" => Route::has("password.request.index"),
                "status" => session("status"),
                "title" => $login->title,
                "description" => $login->description,
                "login" => $login,
            ],
            "lochlitecms::tailwind"
        );
    }

    public static function forgotpassword()
    {
        $recoverypassword = Lochlitecms::recoverypasswordDatabase();
        return \Lochlite\cms\Facades\Lochlitecms::render(
            "Auth/" .
                Lochlitecms::setStaticInstance()->lang() .
                "/forgotpassword",
            [
                "status" => session("status"),
                "title" => $recoverypassword->title,
                "description" => $recoverypassword->description,
                "recoverypassword" => $recoverypassword,
            ],
            "lochlitecms::tailwind"
        );
    }

    public static function resetpassword(Request $request)
    {
        $token = $request->route("token");
        $email = $request->query("email");
        $login = Lochlitecms::loginDatabase();
        return \Lochlite\cms\Facades\Lochlitecms::render(
            "Auth/" .
                Lochlitecms::setStaticInstance()->lang() .
                "/resetpassword",
            [
                "status" => session("status"),
                "title" => "Forgot Password",
                "description" => $login->description,
                "email" => $email,
                "token" => $token,
                "login" => $login,
            ],
            "lochlitecms::tailwind"
        );
    }

    public static function register()
    {
        $register = Lochlitecms::registerDatabase();
        return \Lochlite\cms\Facades\Lochlitecms::render(
            "Auth/" . Lochlitecms::setStaticInstance()->lang() . "/register",
            [
                "status" => session("status"),
                "title" => $register->title,
                "description" => $register->description,
                "register" => $register,
            ],
            "lochlitecms::tailwind"
        );
    }

    public static function emailverified()
    {
        $emailverify = Lochlitecms::emailverifyDatabase();
        return \Lochlite\cms\Facades\Lochlitecms::render(
            "Auth/" .
                Lochlitecms::setStaticInstance()->lang() .
                "/emailverified",
            [
                "status" => session("status"),
                "title" => $emailverify->title,
                "description" => $emailverify->description,
                "emailverify" => $emailverify,
            ],
            "lochlitecms::tailwind"
        );
    }

    public static function confirmpassword()
    {
        $login = Lochlitecms::loginDatabase();
        return \Lochlite\cms\Facades\Lochlitecms::render(
            "Auth/" .
                Lochlitecms::setStaticInstance()->lang() .
                "/confirmpassword",
            [
                "title" => $login->title,
                "description" => $login->description,
                "login" => $login,
            ],
            "lochlitecms::tailwind"
        );
    }

    public function isFile($path)
    {
        return File::isFile($path);
    }

    public function isFolder($path)
    {
        return File::isDirectory($path);
    }

    public function existsFolder($path)
    {
        try {
            if (File::exists($path) && Lochlitecms::isFolder($path) === true) {
                return true;
            } else {
                return false;
            }
        } catch (\Exception $e) {
            if (env("APP_DEBUG", false) == true) {
                dd($e);
            }
        }
    }

    public function getFolder($path, $param = "")
    {
        try {
            if (Lochlitecms::existsFolder($path)) {
                $provider = File::glob($path . "\*" . $param);
                return File::file($provider[0])->dirname();
            } else {
                return Lochlitecms::existsFolder($path);
            }
        } catch (\Exception $e) {
            if (env("APP_DEBUG", false) == true) {
                dd($e);
            }
        }
    }

    public function FilesistemPlugin()
    {
        try {
            return Storage::disk("plugins");
        } catch (\Exception $e) {
            if (env("APP_DEBUG", false) == true) {
                dd($e);
            }
        }
    }

    public function existsPluginsFolder()
    {
        try {
            return Lochlitecms::existsFolder(base_path("plugins"));
        } catch (\Exception $e) {
            if (env("APP_DEBUG", false) == true) {
                dd($e);
            }
        }
    }

    public function getPluginsFolder()
    {
        try {
            if (Lochlitecms::existsPluginsFolder()) {
                return Lochlitecms::FilesistemPlugin();
            } else {
                return Lochlitecms::existsPluginsFolder();
            }
        } catch (\Exception $e) {
            if (env("APP_DEBUG", false) == true) {
                dd($e);
            }
        }
    }

    private function processingNewPlugins()
    {
        try {
            $newplugin = false;
            $registeredplugins = 0;
            $failed = 0;
            $total = 0;
            $folders = File::directories(base_path("plugins"));
            foreach ($folders as $item) {
                if (!Plugins::where("path", $item)->exists()) {
                    //Returns the absolute path of the first service provider it finds
                    $path = collect(
                        glob($item . DIRECTORY_SEPARATOR . "manifest.json")
                    )->first();
                    if (!is_null($path)) {
                        $content = collect(
                            json_decode(
                                Storage::disk("plugins")->get(
                                    substr(
                                        $item,
                                        strpos(
                                            $item,
                                            "plugins" . DIRECTORY_SEPARATOR
                                        ) + 8
                                    ) .
                                        DIRECTORY_SEPARATOR .
                                        "manifest.json"
                                ),
                                true
                            )
                        );
                        Plugins::create([
                            "path" => $item,
                            "namespace" => $content->get("namespace"),
                            "provider" => $content->get("provider"),
                            "version" => $content->get("version"),
                            "logo" => $content->get("logo"),
                            "screenshots" => $content->get("screenshots"),
                            "homepage" => $content->get("homepage"),
                            "authors" => $content->get("authors"),
                            "name" => $content->get("name"),
                            "description" => $content->get("description"),
                            "keywords" => $content->get("keywords"),
                            "license" => $content->get("license"),
                            "update" => $content->get("update"),
                            "keysecret" => $content->get("keysecret"),
                        ]);
                        $newplugin = true;
                    } else {
                        $failed++;
                    }
                    $total++;
                }
            }
            return collect([
                "newplugin" => $newplugin,
                "added" => $registeredplugins,
                "failed" => $failed,
                "total" => $total,
            ]);
        } catch (\Exception $e) {
            if (env("APP_DEBUG", false) == true) {
                dd($e);
            }
        }
    }

    public function listPlugins(bool $paginate = false)
    {
        try {
            Lochlitecms::processingNewPlugins();
            if ($paginate) {
                $plugins = Plugins::paginate();
            } else {
                $plugins = Plugins::all();
            }
            return $plugins;
        } catch (\Exception $e) {
            if (env("APP_DEBUG", false) == true) {
                dd($e);
            }
        }
    }

    private function searchPluginProvider($item)
    {
        try {
            //Returns the absolute path of the first service provider it finds
            $str = collect(glob($item . "\\Providers\\*Provider.php"))->first();
            //Proceed with registration if the plugin has a service provider, otherwise continue the loop
            if (!is_null($str)) {
                //Prepare the class name and namespace to be used
                $filter = pathinfo($str);
                $path = $filter["dirname"] . "\\" . $filter["filename"];
                $newclass = str_replace(".php", "", strstr($str, "\plugins"));
                return $newclass;
            }
            return false;
        } catch (\Exception $e) {
            if (env("APP_DEBUG", false) == true) {
                dd($e);
            }
        }
    }

    public function installPlugin(string $name, callable $installed)
    {
        try {
            $plugin = Plugins::where("name", $name);
            if (
                $plugin->exists() &&
                $plugin->first()->status == "pre-installation"
            ) {
                try {
                    $installed($plugin->first());
                    $plugin->first()->update(["status" => "installed"]);
                } catch (\Exception $e) {
                    dd($e);
                    $plugin->first()->update(["status" => "fail-installed"]);
                }
            }
        } catch (\Exception $e) {
            if (env("APP_DEBUG", false) == true) {
                dd($e);
            }
        }
    }

    public function reinstallationPlugin(
        string $name,
        string $version,
        callable $installed
    ) {
        try {
            $plugin = Plugins::where("name", $name);
            if ($plugin->exists() && $plugin->first()->version == $version) {
                try {
                    $installed($plugin->first());
                    $plugin->first()->update(["status" => "installed"]);
                } catch (\Exception $e) {
                    $plugin->first()->update(["status" => "fail-installed"]);
                }
            }
        } catch (\Exception $e) {
            if (env("APP_DEBUG", false) == true) {
                dd($e);
            }
        }
    }

    public function startPlugins($app)
    {
        try {
            /**
             * For information on 'spl_autoload_register' see: https://www.php.net/manual/en/function.spl-autoload-register.php
             * For information on 'glob()' see: https://www.php.net/manual/en/function.glob.php
             * For information on 'app()' see: https://laravel.com/docs/9.x/helpers#method-app
             * base_path() returns the path of the plugins folder, something like: 'D:\www\laravel\plguins'
             * $name returns the namespace of the plugin's service provider, something like: '\plugins\plugin-name\Providers\PluginNameServiceProvider'
             * 'File::' is an abbreviation for the facade 'Illuminate\support\facades\File'
             **/
            if (Lochlitecms::existsPluginsFolder()) {
                //Import file if class not found
                spl_autoload_register(function ($name) {
                    //Check if the file exists before importing it
                    if (File::exists(base_path($name) . ".php")) {
                        include base_path($name) . ".php";
                    }
                });
                $plugins = Lochlitecms::listPlugins();
                //Iterates over a set of subfolders and accesses each one of them looking for a file with 'Provider.php' in the name
                foreach ($plugins as $item) {
                    try {
                        $newclass = $item->provider;
                        if (!is_null($newclass)) {
                            //Register the plugin provider
                            app()->register(new $newclass(app()));
                            if ($item->status == "processing") {
                                $item->update(["status" => "pre-installation"]);
                                $item->save();
                            }
                        } elseif (
                            $alternative = Lochlitecms::searchPluginProvider(
                                $item->path
                            )
                        ) {
                            //Register the plugin provider
                            app()->register(new $alternative(app()));
                            if ($item->status == "processing") {
                                $item->update(["status" => "pre-installation"]);
                                $item->save();
                            }
                        }
                    } catch (\Exception $e) {
                        $item->update(["status" => "failed"]);
                        $item->update(["failedmessage" => $e->getMessage()]);
                        $item->save();
                    }
                }
            }
        } catch (\Exception $e) {
            if (env("APP_DEBUG", false) == true) {
                dd($e);
            }
        }
    }

    public static function upload(
        Request $request,
        string $input = "file",
        string $disk = "uploads",
        string $folder = "uploads"
    ) {
        try {
            $currentfile = $request->file($input ?? "file");
            $path = Storage::disk($disk ?? "uploads")->putFile(
                $folder ?? "uploads",
                $currentfile
            );
            $url = Storage::disk($disk ?? "uploads")->url($path);
            $size = Storage::disk($disk ?? "uploads")->size($path);
            $name = $currentfile->getClientOriginalName();
            $type = $currentfile->getClientMimeType();
            $typesystem = $currentfile->getMimeType();

            return collect([
                "success" => true,
                "path" => $path,
                "url" => $url,
                "size" => $size,
                "name" => $name,
                "type" => $type,
                "typesystem" => $typesystem,
            ]);
        } catch (\Exception $e) {
            if (env("APP_DEBUG", false) == true) {
                dd($e);
            }
            return collect(["success" => false, "error" => $e->getMessage()]);
        }
    }

    public static function deleteUpload(string $path, string $disk = "uploads")
    {
        try {
            if (Storage::disk($disk ?? "uploads")->exists($path)) {
                $result = Storage::disk($disk ?? "uploads")->delete($path);
                return collect([
                    "success" => true,
                    "exists" => true,
                    "result" => $result,
                ]);
            } else {
                return collect(["success" => true, "exists" => false]);
            }
        } catch (\Exception $e) {
            if (env("APP_DEBUG", false) == true) {
                dd($e);
            }
            return collect(["success" => false, "error" => $e->getMessage()]);
        }
    }

    public static function setAvatar(Request $request)
    {
        try {
            if (Auth()->check()) {
                $user = Auth()->User();
                if (
                    !empty($user->profile_photo_path) &&
                    Storage::disk("uploads")->exists($user->profile_photo_path)
                ) {
                    Storage::disk("uploads")->delete($user->profile_photo_path);
                }
                if (
                    !empty($user->profile_photo_path) &&
                    Fileupload::where("id", $user->id)
                        ->where("path", $user->profile_photo_path)
                        ->exists()
                ) {
                    $removeavatar = Fileupload::where("id", $user->id)
                        ->where("path", $user->profile_photo_path)
                        ->first();
                    $removeavatar->delete();
                }

                $currentfile = $request->file("file");
                $path = Storage::disk("uploads")->putFile(
                    "avatars",
                    $currentfile
                );
                $url = Storage::disk("uploads")->url($path);
                $size = Storage::disk("uploads")->size($path);
                $name = $currentfile->getClientOriginalName();
                $type = $currentfile->getClientMimeType();
                $typesystem = $currentfile->getMimeType();

                $saveupload = Fileupload::create([
                    "user_id" => Auth()->User()->id,
                    "user_name" => Auth()->User()->name,
                    "visitor" => $request->ip(),
                    "filename" => $name,
                    "size" => $size,
                    "url" => $url,
                    "path" => $path,
                    "mimetype" => $type,
                    "status" => "success",
                ]);

                $user->update([
                    "avatar" =>
                        "/filing/" .
                        now()
                            ->parse($saveupload->created_at)
                            ->toDateString() .
                        "?url=" .
                        ($url ?? $user->avatar),
                    "profile_photo_path" => $path ?? $user->profile_photo_path,
                ]);

                return true;
            } else {
                return false;
            }
        } catch (\Exception $e) {
            if (env("APP_DEBUG", false) == true) {
                dd($e);
            }
            return $e->getMessage();
        }
    }

    public static function deleteAvatar()
    {
        try {
            if (Auth()->check()) {
                $user = Auth()->User();
                if (
                    !empty($user->profile_photo_path) &&
                    Storage::disk("uploads")->exists($user->profile_photo_path)
                ) {
                    Storage::disk("uploads")->delete($user->profile_photo_path);
                }
                if (
                    !empty($user->profile_photo_path) &&
                    Fileupload::where("id", $user->id)
                        ->where("path", $user->profile_photo_path)
                        ->exists()
                ) {
                    $removeavatar = Fileupload::where("id", $user->id)
                        ->where("path", $user->profile_photo_path)
                        ->first();
                    $removeavatar->delete();
                }
                $user->update(["avatar" => "", "profile_photo_path" => ""]);
                return true;
            } else {
                return false;
            }
        } catch (\Exception $e) {
            if (env("APP_DEBUG", false) == true) {
                dd($e);
            }
            return false;
        }
    }

    public static function cmsFetchPublicDisk()
    {
        try {
            config()->set("filesystems.disks", [
                "cmsFetchPublicDisk" => [
                    "driver" => "local",
                    "root" => base_path("vendor/lochlite/cms/src/Disk/public/"),
                    "throw" => false,
                ],
            ]);
            return Storage::disk("cmsFetchPublicDisk");
        } catch (\Exception $e) {
            if (env("APP_DEBUG", false) == true) {
                dd($e);
            }
        }
    }

    public static function cmsDisk()
    {
        try {
            config()->set("filesystems.disks", [
                "lochlitecms" => [
                    "driver" => "local",
                    "root" => base_path("lochlite\cms"),
                    "throw" => false,
                ],
            ]);
            return Storage::disk("lochlitecms");
        } catch (\Exception $e) {
            if (env("APP_DEBUG", false) == true) {
                dd($e);
            }
        }
    }

    public function getRoutes()
    {
        try {
            $routes = cache()->get("routes", function () {
                if (Schema::hasTable("routes")) {
                    $database = \Lochlite\cms\Models\Routes::all();
                    cache()->put("routes", $database, 1000);
                    return $database;
                } else {
                    return [];
                }
            });

            foreach ($routes as $item) {
                if ($item->controller == null) {
                    dd($item);
                }
                if ($item->type == "resource") {
                    app()->router->resource($item->url, $item->controller, [
                        "middleware" => $item->middleware ?? ["web"],
                        "names" => $item->name ?? null,
                        "only" => $item->only ?? null,
                        "except" => $item->except ?? null,
                    ]);
                } elseif ($item->type == "get") {
                    app()
                        ->router->get($item->url, [
                            $item->controller,
                            $item->action ?? "index",
                        ])
                        ->middleware($item->middleware ?? ["web"])
                        ->name($item->name ?? null);
                } elseif ($item->type == "post") {
                    app()
                        ->router->post($item->url, [
                            $item->controller,
                            $item->action ?? "index",
                        ])
                        ->middleware($item->middleware ?? ["web"])
                        ->name($item->name ?? null);
                } else {
                    app()
                        ->router->match($item->type, $item->url, [
                            $item->controller,
                            $item->action ?? "index",
                        ])
                        ->middleware($item->middleware ?? ["web"])
                        ->name($item->name ?? null);
                }
            }
            return;
        } catch (\Exception $e) {
            if (env("APP_DEBUG", false) == true) {
                dd($e);
            }
        }
    }

    public static function addRoutes(array $array)
    {
        try {
            RegisterRouteJob::dispatch($array);
        } catch (\Exception $e) {
            if (env("APP_DEBUG", false) == true) {
                dd($e);
            }
        }
    }

    public static function defaultRoutes()
    {
        try {
            lochlitecms::addRoutes([
                [
                    "system" => true,
                    "type" => "resource",
                    "url" => "/register",
                    "controller" =>
                        \Lochlite\cms\Controllers\Auth\RegisterAuthController::class,
                    "middleware" => ["web", "guest"],
                    "name" => "register",
                ],
                [
                    "system" => true,
                    "type" => "resource",
                    "url" => "/login",
                    "controller" =>
                        \Lochlite\cms\Controllers\Auth\LoginAuthController::class,
                    "middleware" => ["web", "guest"],
                    "name" => "login",
                ],
                [
                    "system" => true,
                    "type" => "get",
                    "url" => "/oauth/google",
                    "action" => "google",
                    "controller" =>
                        \Lochlite\cms\Controllers\Auth\LoginAuthController::class,
                    "middleware" => ["web", "guest"],
                    "name" => "oauth.google",
                ],
                [
                    "system" => true,
                    "type" => "get",
                    "url" => "/oauth/facebook",
                    "action" => "facebook",
                    "controller" =>
                        \Lochlite\cms\Controllers\Auth\LoginAuthController::class,
                    "middleware" => ["web", "guest"],
                    "name" => "oauth.facebook",
                ],
                [
                    "system" => true,
                    "type" => "get",
                    "url" => "/oauth/twitter",
                    "action" => "twitter",
                    "controller" =>
                        \Lochlite\cms\Controllers\Auth\LoginAuthController::class,
                    "middleware" => ["web", "guest"],
                    "name" => "oauth.twitter",
                ],
                [
                    "system" => true,
                    "type" => "get",
                    "url" => "/oauth/gameloch",
                    "action" => "gameloch",
                    "controller" =>
                        \Lochlite\cms\Controllers\Auth\LoginAuthController::class,
                    "middleware" => ["web", "guest"],
                    "name" => "oauth.gameloch",
                ],
                [
                    "system" => true,
                    "type" => "get",
                    "url" => "/oauth/google/callback",
                    "action" => "googlecallback",
                    "controller" =>
                        \Lochlite\cms\Controllers\Auth\LoginAuthController::class,
                    "middleware" => ["web", "guest"],
                    "name" => "oauth.googlecallback",
                ],
                [
                    "system" => true,
                    "type" => "get",
                    "url" => "/oauth/facebook/callback",
                    "action" => "facebookcallback",
                    "controller" =>
                        \Lochlite\cms\Controllers\Auth\LoginAuthController::class,
                    "middleware" => ["web", "guest"],
                    "name" => "oauth.facebookcallback",
                ],
                [
                    "system" => true,
                    "type" => "get",
                    "url" => "/oauth/twitter/callback",
                    "action" => "twittercallback",
                    "controller" =>
                        \Lochlite\cms\Controllers\Auth\LoginAuthController::class,
                    "middleware" => ["web", "guest"],
                    "name" => "oauth.twittercallback",
                ],
                [
                    "system" => true,
                    "type" => "get",
                    "url" => "/oauth/gameloch/callback",
                    "action" => "gamelochcallback",
                    "controller" =>
                        \Lochlite\cms\Controllers\Auth\LoginAuthController::class,
                    "middleware" => ["web", "guest"],
                    "name" => "oauth.gamelochcallback",
                ],
                [
                    "system" => true,
                    "type" => "resource",
                    "url" => "/forgot-password",
                    "controller" =>
                        \Lochlite\cms\Controllers\Auth\ForgotPasswordAuthController::class,
                    "middleware" => ["web", "guest"],
                    "name" => "password.request",
                    "except" => ["create"],
                ],
                [
                    "system" => true,
                    "type" => "get",
                    "url" => "/confirm-password",
                    "action" => "show",
                    "controller" =>
                        \Lochlite\cms\Controllers\Auth\ConfirmablePasswordController::class,
                    "middleware" => ["web", "auth"],
                    "name" => "password.confirm",
                ],
                [
                    "system" => true,
                    "type" => "post",
                    "url" => "/confirm-password/store",
                    "action" => "store",
                    "controller" =>
                        \Lochlite\cms\Controllers\Auth\ConfirmablePasswordController::class,
                    "middleware" => ["web", "auth"],
                    "name" => "password.confirm.store",
                ],
                [
                    "system" => true,
                    "type" => "get",
                    "url" => "/reset-password/{token}",
                    "action" => "create",
                    "controller" =>
                        \Lochlite\cms\Controllers\Auth\ForgotPasswordAuthController::class,
                    "middleware" => ["web", "guest"],
                    "name" => "password.reset",
                ],
                [
                    "system" => true,
                    "type" => "post",
                    "url" => "/verify-email/update",
                    "action" => "changeemail",
                    "controller" =>
                        \Lochlite\cms\Controllers\Auth\VerifyEmailController::class,
                    "middleware" => ["web", "auth"],
                    "name" => "verification.changeemail",
                ],
                [
                    "system" => true,
                    "type" => "get",
                    "url" => "/verify-email",
                    "action" => "__invoke",
                    "controller" =>
                        \Lochlite\cms\Controllers\Auth\EmailVerificationPromptController::class,
                    "middleware" => ["web", "auth"],
                    "name" => "verification.notice",
                ],
                [
                    "system" => true,
                    "type" => "get",
                    "url" => "/verify-email/{id}/{hash}",
                    "action" => "__invoke",
                    "controller" =>
                        \Lochlite\cms\Controllers\Auth\VerifyEmailController::class,
                    "middleware" => ["web", "auth", "signed", "throttle:6,1"],
                    "name" => "verification.verify",
                ],
                [
                    "system" => true,
                    "type" => "post",
                    "url" => "/email/verification-notification",
                    "action" => "store",
                    "controller" =>
                        \Lochlite\cms\Controllers\Auth\EmailVerificationNotificationController::class,
                    "middleware" => ["web", "auth", "throttle:6,1"],
                    "name" => "verification.send",
                ],
                [
                    "system" => true,
                    "type" => "post",
                    "url" => "/logout",
                    "action" => "destroy",
                    "controller" =>
                        \Lochlite\cms\Controllers\Auth\LoginAuthController::class,
                    "middleware" => ["web", "auth"],
                    "name" => "logout",
                ],
                [
                    "system" => true,
                    "type" => "resource",
                    "url" => "/blog",
                    "controller" =>
                        \Lochlite\cms\Controllers\WelcomeBlogController::class,
                    "middleware" => ["web"],
                    "name" => "blog",
                ],
                [
                    "system" => true,
                    "type" => "get",
                    "url" => "/page/{id}",
                    "action" => "index",
                    "controller" =>
                        \Lochlite\cms\Controllers\WelcomePagesController::class,
                    "middleware" => ["web"],
                    "name" => "page.index",
                ],
                [
                    "system" => true,
                    "type" => "resource",
                    "url" => "/dashboard",
                    "controller" =>
                        \Lochlite\cms\Controllers\HomeController::class,
                    "middleware" => ["web", "auth"],
                    "name" => "dashboard",
                    "except" => ["show", "create", "edit"],
                ],
                [
                    "system" => true,
                    "type" => "get",
                    "url" => "/profile",
                    "action" => "profile",
                    "controller" =>
                        \Lochlite\cms\Controllers\HomeController::class,
                    "middleware" => ["web", "auth"],
                    "name" => "dashboard.profile",
                ],
                [
                    "system" => true,
                    "type" => "get",
                    "url" => "/profile/edit",
                    "action" => "editprofile",
                    "controller" =>
                        \Lochlite\cms\Controllers\HomeController::class,
                    "middleware" => ["web", "auth"],
                    "name" => "dashboard.editprofile",
                ],
                [
                    "system" => true,
                    "type" => "get",
                    "url" => "/comments",
                    "action" => "comments",
                    "controller" =>
                        \Lochlite\cms\Controllers\HomeController::class,
                    "middleware" => ["web", "auth"],
                    "name" => "dashboard.comments",
                ],
                [
                    "system" => true,
                    "type" => "get",
                    "url" => "/shopping",
                    "action" => "shopping",
                    "controller" =>
                        \Lochlite\cms\Controllers\HomeController::class,
                    "middleware" => ["web", "auth"],
                    "name" => "dashboard.shopping",
                ],
                [
                    "system" => true,
                    "type" => "get",
                    "url" => "/notifications",
                    "action" => "notifications",
                    "controller" =>
                        \Lochlite\cms\Controllers\HomeController::class,
                    "middleware" => ["web", "auth"],
                    "name" => "dashboard.notifications",
                ],
                [
                    "system" => true,
                    "type" => "get",
                    "url" => "/history",
                    "action" => "history",
                    "controller" =>
                        \Lochlite\cms\Controllers\HomeController::class,
                    "middleware" => ["web", "auth"],
                    "name" => "dashboard.history",
                ],

                [
                    "system" => true,
                    "type" => "resource",
                    "url" => "/manager/dashboard",
                    "controller" =>
                        \Lochlite\cms\Controllers\Admin\AdminController::class,
                    "middleware" => ["web", "auth"],
                    "name" => "managerdashboard",
                ],
                [
                    "system" => true,
                    "type" => "resource",
                    "url" => "/manager/domains",
                    "controller" =>
                        \Lochlite\cms\Controllers\Admin\DomainsController::class,
                    "middleware" => ["web", "auth"],
                    "name" => "managerdomains",
                ],
                [
                    "system" => true,
                    "type" => "resource",
                    "url" => "/manager/pages",
                    "controller" =>
                        \Lochlite\cms\Controllers\Admin\PagesController::class,
                    "middleware" => ["web", "auth"],
                    "name" => "managerpages",
                ],
                [
                    "system" => true,
                    "type" => "resource",
                    "url" => "/manager/posts",
                    "controller" =>
                        \Lochlite\cms\Controllers\Admin\PostsController::class,
                    "middleware" => ["web", "auth"],
                    "name" => "managerposts",
                ],
                [
                    "system" => true,
                    "type" => "resource",
                    "url" => "/manager/pwa",
                    "controller" =>
                        \Lochlite\cms\Controllers\Admin\PwaController::class,
                    "middleware" => ["web", "auth"],
                    "name" => "managerpwa",
                ],
                [
                    "system" => true,
                    "type" => "resource",
                    "url" => "/manager/seo",
                    "controller" =>
                        \Lochlite\cms\Controllers\Admin\SeoController::class,
                    "middleware" => ["web", "auth"],
                    "name" => "managerseo",
                ],
                [
                    "system" => true,
                    "type" => "resource",
                    "url" => "/manager/appendcoding",
                    "controller" =>
                        \Lochlite\cms\Controllers\Admin\AppendcodingController::class,
                    "middleware" => ["web", "auth"],
                    "name" => "managerappendcoding",
                ],
                [
                    "system" => true,
                    "type" => "resource",
                    "url" => "/manager/customersarea",
                    "controller" =>
                        \Lochlite\cms\Controllers\Admin\CustomersareaController::class,
                    "middleware" => ["web", "auth"],
                    "name" => "managercustomersarea",
                ],
                [
                    "system" => true,
                    "type" => "resource",
                    "url" => "/manager/mainmenu",
                    "controller" =>
                        \Lochlite\cms\Controllers\Admin\MainmenuController::class,
                    "middleware" => ["web", "auth"],
                    "name" => "managermainmenu",
                ],
                [
                    "system" => true,
                    "type" => "resource",
                    "url" => "/manager/mainmenuitem",
                    "controller" =>
                        \Lochlite\cms\Controllers\Admin\MainmenuitemController::class,
                    "middleware" => ["web", "auth"],
                    "name" => "managermainmenuitem",
                ],
                [
                    "system" => true,
                    "type" => "resource",
                    "url" => "/manager/login",
                    "controller" =>
                        \Lochlite\cms\Controllers\Admin\LoginController::class,
                    "middleware" => ["web", "auth"],
                    "name" => "managerlogin",
                ],
                [
                    "system" => true,
                    "type" => "resource",
                    "url" => "/manager/register",
                    "controller" =>
                        \Lochlite\cms\Controllers\Admin\RegisterController::class,
                    "middleware" => ["web", "auth"],
                    "name" => "managerregister",
                ],
                [
                    "system" => true,
                    "type" => "resource",
                    "url" => "/manager/recoverypassword",
                    "controller" =>
                        \Lochlite\cms\Controllers\Admin\RecoverypasswordController::class,
                    "middleware" => ["web", "auth"],
                    "name" => "managerrecoverypassword",
                ],
                [
                    "system" => true,
                    "type" => "get",
                    "url" => "/manager/test/emailverify/reverse",
                    "action" => "reverseresettestsend",
                    "controller" =>
                        \Lochlite\cms\Controllers\Admin\EmailverifyController::class,
                    "middleware" => ["web", "auth"],
                    "name" => "manageremailverify.reversetest",
                ],
                [
                    "system" => true,
                    "type" => "get",
                    "url" => "/manager/test/emailverify/start",
                    "action" => "resettestsend",
                    "controller" =>
                        \Lochlite\cms\Controllers\Admin\EmailverifyController::class,
                    "middleware" => ["web", "auth"],
                    "name" => "manageremailverify.resettest",
                ],
                [
                    "system" => true,
                    "type" => "get",
                    "url" => "/manager/test/emailverify",
                    "action" => "testsend",
                    "controller" =>
                        \Lochlite\cms\Controllers\Admin\EmailverifyController::class,
                    "middleware" => ["web", "auth", "verified"],
                    "name" => "manageremailverify.test",
                ],
                [
                    "system" => true,
                    "type" => "resource",
                    "url" => "/manager/emailverify",
                    "controller" =>
                        \Lochlite\cms\Controllers\Admin\EmailverifyController::class,
                    "middleware" => ["web", "auth"],
                    "name" => "manageremailverify",
                ],
                [
                    "system" => true,
                    "type" => "resource",
                    "url" => "/manager/notifications",
                    "controller" =>
                        \Lochlite\cms\Controllers\Admin\NotificationsController::class,
                    "middleware" => ["web", "auth"],
                    "name" => "managernotifications",
                ],
                [
                    "system" => true,
                    "type" => "resource",
                    "url" => "/manager/search",
                    "controller" =>
                        \Lochlite\cms\Controllers\Admin\SearchController::class,
                    "middleware" => ["web", "auth"],
                    "name" => "managersearch",
                ],
                [
                    "system" => true,
                    "type" => "resource",
                    "url" => "/manager/roles",
                    "controller" =>
                        \Lochlite\cms\Controllers\Admin\PermissionsController::class,
                    "middleware" => ["web", "auth", "password.confirm"],
                    "name" => "managerroles",
                ],
                [
                    "system" => true,
                    "type" => "resource",
                    "url" => "/manager/users",
                    "controller" =>
                        \Lochlite\cms\Controllers\Admin\UsersController::class,
                    "middleware" => ["web", "auth", "password.confirm"],
                    "name" => "managerusers",
                ],
                [
                    "system" => true,
                    "type" => "post",
                    "url" => "/manager/comments/setapproved/{id}",
                    "action" => "moderatesetapproved",
                    "controller" =>
                        \Lochlite\cms\Controllers\Admin\CommentsController::class,
                    "middleware" => ["web", "auth"],
                    "name" => "managercomments.setapproved",
                ],
                [
                    "system" => true,
                    "type" => "get",
                    "url" => "/manager/comments/moderate",
                    "action" => "moderate",
                    "controller" =>
                        \Lochlite\cms\Controllers\Admin\CommentsController::class,
                    "middleware" => ["web", "auth"],
                    "name" => "managercomments.moderate",
                ],
                [
                    "system" => true,
                    "type" => "resource",
                    "url" => "/manager/comments",
                    "controller" =>
                        \Lochlite\cms\Controllers\Admin\CommentsController::class,
                    "middleware" => ["web", "auth"],
                    "name" => "managercomments",
                ],
                [
                    "system" => true,
                    "type" => "resource",
                    "url" => "/manager/contacts",
                    "controller" =>
                        \Lochlite\cms\Controllers\Admin\ContactsController::class,
                    "middleware" => ["web", "auth"],
                    "name" => "managercontacts",
                ],
                [
                    "system" => true,
                    "type" => "resource",
                    "url" => "/manager/feedbacks",
                    "controller" =>
                        \Lochlite\cms\Controllers\Admin\FeedbacksController::class,
                    "middleware" => ["web", "auth"],
                    "name" => "managerfeedbacks",
                ],
                [
                    "system" => true,
                    "type" => "resource",
                    "url" => "/manager/feedback-responses",
                    "controller" =>
                        \Lochlite\cms\Controllers\Admin\FeedbackresponsesController::class,
                    "middleware" => ["web", "auth"],
                    "name" => "managerfeedback-responses",
                ],
                [
                    "system" => true,
                    "type" => "resource",
                    "url" => "/manager/scheduling",
                    "controller" =>
                        \Lochlite\cms\Controllers\Admin\SchedulingController::class,
                    "middleware" => ["web", "auth"],
                    "name" => "managerscheduling",
                ],
                [
                    "system" => true,
                    "type" => "resource",
                    "url" => "/manager/storange",
                    "controller" =>
                        \Lochlite\cms\Controllers\Admin\StorangeController::class,
                    "middleware" => ["web", "auth"],
                    "name" => "managerstorange",
                ],
                [
                    "system" => true,
                    "type" => "get",
                    "url" => "/manager/storange/download/{id}",
                    "action" => "download",
                    "controller" =>
                        \Lochlite\cms\Controllers\Admin\StorangeController::class,
                    "middleware" => ["web", "auth"],
                    "name" => "managerstorange.download",
                ],
                [
                    "system" => true,
                    "type" => "resource",
                    "url" => "/manager/emails",
                    "controller" =>
                        \Lochlite\cms\Controllers\Admin\EmailsController::class,
                    "middleware" => ["web", "auth"],
                    "name" => "manageremails",
                ],
                [
                    "system" => true,
                    "type" => "resource",
                    "url" => "/manager/emailsmodel",
                    "controller" =>
                        \Lochlite\cms\Controllers\Admin\EmailsmodelController::class,
                    "middleware" => ["web", "auth"],
                    "name" => "manageremailsmodel",
                ],
                [
                    "system" => true,
                    "type" => "resource",
                    "url" => "/manager/plugins",
                    "controller" =>
                        \Lochlite\cms\Controllers\Admin\PluginsController::class,
                    "middleware" => ["web", "auth", "password.confirm"],
                    "name" => "managerplugins",
                ],
                [
                    "system" => true,
                    "type" => "resource",
                    "url" => "/manager/services",
                    "controller" =>
                        \Lochlite\cms\Controllers\Admin\ServicesController::class,
                    "middleware" => ["web", "auth", "password.confirm"],
                    "name" => "managerservices",
                ],
                [
                    "system" => true,
                    "type" => "resource",
                    "url" => "/manager/system",
                    "controller" =>
                        \Lochlite\cms\Controllers\Admin\SystemController::class,
                    "middleware" => ["web", "auth"],
                    "name" => "managersystem",
                ],
                [
                    "system" => true,
                    "type" => "resource",
                    "url" => "/manager/updates",
                    "controller" =>
                        \Lochlite\cms\Controllers\Admin\UpdateController::class,
                    "middleware" => ["web", "auth", "password.confirm"],
                    "name" => "managerupdates",
                ],
                [
                    "system" => true,
                    "type" => "resource",
                    "url" => "/manager/routes",
                    "controller" =>
                        \Lochlite\cms\Controllers\Admin\RoutesController::class,
                    "middleware" => ["web", "auth", "password.confirm"],
                    "name" => "managerroutes",
                ],
                [
                    "system" => true,
                    "type" => "get",
                    "url" => "/manager/resetroutes",
                    "action" => "resetroutes",
                    "controller" =>
                        \Lochlite\cms\Controllers\Admin\RoutesController::class,
                    "middleware" => ["web", "auth", "password.confirm"],
                    "name" => "managerroutes.reset",
                ],
                [
                    "system" => true,
                    "type" => "resource",
                    "url" => "/manager/settings",
                    "controller" =>
                        \Lochlite\cms\Controllers\Admin\SettingsController::class,
                    "middleware" => ["web", "auth", "password.confirm"],
                    "name" => "managersettings",
                    "only" => ["index", "store", "update"],
                ],
                [
                    "system" => true,
                    "type" => "get",
                    "url" => "/manager/settings/cleandata",
                    "action" => "cleandata",
                    "controller" =>
                        \Lochlite\cms\Controllers\Admin\SettingsController::class,
                    "middleware" => ["web", "auth", "password.confirm"],
                    "name" => "managersettings.cleandata",
                ],

                [
                    "system" => true,
                    "type" => "get",
                    "url" => "/filing/{date}",
                    "action" => "filefiling",
                    "controller" =>
                        \Lochlite\cms\Controllers\WelcomeController::class,
                    "middleware" => ["web"],
                    "name" => "filefiling",
                ],
                [
                    "system" => true,
                    "type" => "get",
                    "url" => "/download/{id}",
                    "action" => "download",
                    "controller" =>
                        \Lochlite\cms\Controllers\WelcomeController::class,
                    "middleware" => ["web"],
                    "name" => "download",
                ],
                [
                    "system" => true,
                    "type" => "get",
                    "url" => "/contact",
                    "action" => "contact",
                    "controller" =>
                        \Lochlite\cms\Controllers\WelcomeController::class,
                    "middleware" => ["web"],
                    "name" => "contact",
                ],
                [
                    "system" => true,
                    "type" => "post",
                    "url" => "/sendcontact",
                    "action" => "sendcontact",
                    "controller" =>
                        \Lochlite\cms\Controllers\WelcomeController::class,
                    "middleware" => ["web"],
                    "name" => "sendcontact",
                ],
                [
                    "system" => true,
                    "type" => "get",
                    "url" => "/feedback",
                    "action" => "feedback",
                    "controller" =>
                        \Lochlite\cms\Controllers\WelcomeController::class,
                    "middleware" => ["web"],
                    "name" => "feedback",
                ],
                [
                    "system" => true,
                    "type" => "post",
                    "url" => "/sendfeedback",
                    "action" => "sendfeedback",
                    "controller" =>
                        \Lochlite\cms\Controllers\WelcomeController::class,
                    "middleware" => ["web"],
                    "name" => "sendfeedback",
                ],
                [
                    "system" => true,
                    "type" => "post",
                    "url" => "/sendfeedback",
                    "action" => "sendfeedback",
                    "controller" =>
                        \Lochlite\cms\Controllers\WelcomeController::class,
                    "middleware" => ["web"],
                    "name" => "sendfeedback",
                ],
                [
                    "system" => true,
                    "type" => "post",
                    "url" => "/sendcomment/{id}",
                    "action" => "sendcomment",
                    "controller" =>
                        \Lochlite\cms\Controllers\WelcomeBlogController::class,
                    "middleware" => ["web"],
                    "name" => "sendcomment",
                ],
                [
                    "system" => true,
                    "type" => "post",
                    "url" => "/sendvotes/{id}",
                    "action" => "sendvotes",
                    "controller" =>
                        \Lochlite\cms\Controllers\WelcomeBlogController::class,
                    "middleware" => ["web"],
                    "name" => "sendvotes",
                ],
                [
                    "system" => true,
                    "type" => "post",
                    "url" => "/newsletter/subscript",
                    "action" => "subscriptnewsletter",
                    "controller" =>
                        \Lochlite\cms\Controllers\WelcomeController::class,
                    "middleware" => ["web"],
                    "name" => "subscriptnewsletter",
                ],
                [
                    "system" => true,
                    "type" => "get",
                    "url" => "/newsletter/unsubscribe/{email}",
                    "action" => "unsubscribenewsletter",
                    "controller" =>
                        \Lochlite\cms\Controllers\WelcomeController::class,
                    "middleware" => ["web"],
                    "name" => "unsubscribenewsletter",
                ],
                [
                    "system" => true,
                    "type" => "get",
                    "url" => "/manifest.webmanifest",
                    "action" => "pwa",
                    "controller" =>
                        \Lochlite\cms\Controllers\WelcomeController::class,
                    "middleware" => ["web"],
                    "name" => "pwa",
                ],
                [
                    "system" => true,
                    "type" => "get",
                    "url" => "/application/{path}",
                    "action" => "application",
                    "controller" =>
                        \Lochlite\cms\Controllers\WelcomeController::class,
                    "middleware" => ["web"],
                    "name" => "application",
                ],
                [
                    "system" => true,
                    "type" => "get",
                    "url" => "/",
                    "action" => "index",
                    "controller" =>
                        \Lochlite\cms\Controllers\WelcomeController::class,
                    "middleware" => ["web"],
                    "name" => "index.index",
                ],
            ]);
        } catch (\Exception $e) {
            if (env("APP_DEBUG", false) == true) {
                dd($e);
            }
        }
    }

    public static function pwa(string $param = null)
    {
        try {
            $manifest = cache()->get("pwa", function () {
                if (\Schema::hasTable("pwas")) {
                    if (
                        !Pwa::where("default", true)
                            ->orWhere("id", 1)
                            ->exists()
                    ) {
                        Pwa::create([
                            "default" => true,
                            "icons" => [
                                [
                                    "src" =>
                                        request()->getSchemeAndHttpHost() .
                                        "/application/12x12.png",
                                    "type" => "image/png",
                                    "sizes" => "12x12",
                                ],
                                [
                                    "src" =>
                                        request()->getSchemeAndHttpHost() .
                                        "/application/24x24.png",
                                    "type" => "image/png",
                                    "sizes" => "24x24",
                                ],
                                [
                                    "src" =>
                                        request()->getSchemeAndHttpHost() .
                                        "/application/32x32.png",
                                    "type" => "image/png",
                                    "sizes" => "32x32",
                                ],
                                [
                                    "src" =>
                                        request()->getSchemeAndHttpHost() .
                                        "/application/48x48.png",
                                    "type" => "image/png",
                                    "sizes" => "48x48",
                                ],
                                [
                                    "src" =>
                                        request()->getSchemeAndHttpHost() .
                                        "/application/56x56.png",
                                    "type" => "image/png",
                                    "sizes" => "56x56",
                                ],
                                [
                                    "src" =>
                                        request()->getSchemeAndHttpHost() .
                                        "/application/72x72.png",
                                    "type" => "image/png",
                                    "sizes" => "72x72",
                                ],
                                [
                                    "src" =>
                                        request()->getSchemeAndHttpHost() .
                                        "/application/96x96.png",
                                    "type" => "image/png",
                                    "sizes" => "96x96",
                                ],
                                [
                                    "src" =>
                                        request()->getSchemeAndHttpHost() .
                                        "/application/144x144.png",
                                    "type" => "image/png",
                                    "sizes" => "144x144",
                                ],
                                [
                                    "src" =>
                                        request()->getSchemeAndHttpHost() .
                                        "/application/168x168.png",
                                    "type" => "image/png",
                                    "sizes" => "168x168",
                                ],
                                [
                                    "src" =>
                                        request()->getSchemeAndHttpHost() .
                                        "/application/192x192.png",
                                    "type" => "image/png",
                                    "sizes" => "192x192",
                                ],
                            ],
                        ]);
                    }
                    $pwa = Pwa::where("default", true)
                        ->orWhere("id", 1)
                        ->first();
                    cache()->put("pwa", $pwa, 5000);
                    return $pwa;
                } else {
                    $manifest = (object) [
                        "name" => "Lochlite CMS",
                        "background_color" => "#000000",
                        "description" =>
                            "Another app generated with Lochlite CMS",
                        "dir" => "ltr",
                        "display" => "standalone",
                        "orientation" => "any",
                        "scope" => "/",
                        "short_name" => "Appname",
                        "start_url" => "/",
                        "theme_color" => "#cc8899",
                        "msapplicationtilecolor" => "#cc8899",
                        "content_security_policy" => [],
                        "icons" => [
                            [
                                "src" =>
                                    request()->getSchemeAndHttpHost() .
                                    "/application/12x12.png",
                                "type" => "image/png",
                                "sizes" => "12x12",
                            ],
                            [
                                "src" =>
                                    request()->getSchemeAndHttpHost() .
                                    "/application/24x24.png",
                                "type" => "image/png",
                                "sizes" => "24x24",
                            ],
                            [
                                "src" =>
                                    request()->getSchemeAndHttpHost() .
                                    "/application/32x32.png",
                                "type" => "image/png",
                                "sizes" => "32x32",
                            ],
                            [
                                "src" =>
                                    request()->getSchemeAndHttpHost() .
                                    "/application/48x48.png",
                                "type" => "image/png",
                                "sizes" => "48x48",
                            ],
                            [
                                "src" =>
                                    request()->getSchemeAndHttpHost() .
                                    "/application/56x56.png",
                                "type" => "image/png",
                                "sizes" => "56x56",
                            ],
                            [
                                "src" =>
                                    request()->getSchemeAndHttpHost() .
                                    "/application/72x72.png",
                                "type" => "image/png",
                                "sizes" => "72x72",
                            ],
                            [
                                "src" =>
                                    request()->getSchemeAndHttpHost() .
                                    "/application/96x96.png",
                                "type" => "image/png",
                                "sizes" => "96x96",
                            ],
                            [
                                "src" =>
                                    request()->getSchemeAndHttpHost() .
                                    "/application/144x144.png",
                                "type" => "image/png",
                                "sizes" => "144x144",
                            ],
                            [
                                "src" =>
                                    request()->getSchemeAndHttpHost() .
                                    "/application/168x168.png",
                                "type" => "image/png",
                                "sizes" => "168x168",
                            ],
                            [
                                "src" =>
                                    request()->getSchemeAndHttpHost() .
                                    "/application/192x192.png",
                                "type" => "image/png",
                                "sizes" => "192x192",
                            ],
                        ],
                    ];
                }
            });
            return $param == null ? $manifest : $manifest->$param;
        } catch (\Exception $e) {
            if (env("APP_DEBUG", false) == true) {
                dd($e);
            }
        }
    }

    public static function pwaManifest()
    {
        try {
            return response()->json(
                Lochlitecms::pwa()->setHidden([
                    "id",
                    "default",
                    "domain",
                    "created_at",
                    "updated_at",
                ])
            );
        } catch (\Exception $e) {
            if (env("APP_DEBUG", false) == true) {
                dd($e);
            }
        }
    }

    public static function seo(string $param = null)
    {
        try {
            return cache()->get("seo", function () {
                if (\Schema::hasTable("seos")) {
                    if (
                        !Seo::where("default", true)
                            ->orWhere("id", 1)
                            ->exists()
                    ) {
                        Seo::create(["default" => true]);
                    }
                    $seo = Seo::where("default", true)
                        ->orWhere("id", 1)
                        ->first();
                    cache()->put("seo", $seo, 5000);
                    return $seo;
                    $filter = str_replace(":", "", $param);
                    return $param == null ? $opt : $opt->$filter;
                } else {
                    $opt = (object) [
                        "title" => "Sem titulo",
                        "description" => "Sem descrição",
                        "author" => "Sem author",
                        "keywords" => "homepage, company, business",
                        "google_site_verification" => "",
                        "p:domain_verify" => "",
                        "og:type" => "website",
                        "og:url" => url()->current(),
                        "og:title" => "Sem titulo",
                        "og:description" => "Sem descrição",
                        "og:image" => "Sem descrição",
                        "fb:app_id" => "",
                        "twitter:card" => "summary_large_image",
                        "twitter:url" => url()->current(),
                        "twitter:title" => "Sem titulo",
                        "twitter:description" => "Sem descrição",
                        "twitter:image" => "",
                        "twitter:site" => "",
                        "icon" => "",
                    ];
                    return $param == null ? $opt : $opt->$param;
                }
            });
        } catch (\Exception $e) {
            if (env("APP_DEBUG", false) == true) {
                dd($e);
            }
        }
    }

    private static function appendCodingRender($list)
    {
        try {
            foreach ($list as $item) {
                echo $item;
            }
        } catch (\Exception $e) {
            if (env("APP_DEBUG", false) == true) {
                dd($e);
            }
        }
    }

    public static function appendCoding(
        string $position = "head",
        string $status = "active"
    ) {
        try {
            $list = Appendcoding::where("position", $position)
                ->where("status", $status)
                ->pluck("body");
            return Lochlitecms::appendCodingRender($list);
        } catch (\Exception $e) {
            if (env("APP_DEBUG", false) == true) {
                dd($e);
            }
        }
    }

    public static function generateStylesheet(array $array)
    {
        try {
            foreach ($array as $item) {
                try {
                    echo '<link rel="stylesheet" href="' .
                        ($item["href"] ?? "") .
                        '" />';
                } catch (\Exception $e) {
                }
                if (env("APP_DEBUG", false) == true) {
                    dd($e);
                }
            }
        } catch (\Exception $e) {
            if (env("APP_DEBUG", false) == true) {
                dd($e);
            }
        }
    }

    public static function generateScript(array $array)
    {
        try {
            foreach ($array as $item) {
                try {
                    echo '<script defer src="' .
                        ($item["src"] ?? "") .
                        '"></script>';
                } catch (\Exception $e) {
                }
                if (env("APP_DEBUG", false) == true) {
                    dd($e);
                }
            }
        } catch (\Exception $e) {
            if (env("APP_DEBUG", false) == true) {
                dd($e);
            }
        }
    }

    public function generateMenuLang()
    {
        try {
            return collect([
                "current" => Lochlitecms::lang(),
                "items" => [
                    [
                        "active" =>
                            Lochlitecms::lang() == "pt_BR" ? "true" : "false",
                        "name" => "Portuguese",
                        "code" => "pt_BR",
                    ],
                    [
                        "active" =>
                            Lochlitecms::lang() == "en_US" ? "true" : "false",
                        "name" => "English",
                        "code" => "en_US",
                    ],
                ],
            ]);
        } catch (\Exception $e) {
            if (env("APP_DEBUG", false) == true) {
                dd($e);
            }
        }
    }
    public function generateSidebar()
    {
        try {
            if (Lochlitecms::lang() == "en_US") {
                return collect([
                    [
                        "dropdown" => true,
                        "active" =>
                            request()->getSchemeAndHttpHost() .
                                "/" .
                                Route::current()->uri() ==
                                route("index.index") ||
                            request()->getSchemeAndHttpHost() .
                                "/" .
                                Route::current()->uri() ==
                                route("managerdashboard.index") ||
                            request()->getSchemeAndHttpHost() .
                                "/" .
                                Route::current()->uri() ==
                                route("managerdomains.index") ||
                            request()->getSchemeAndHttpHost() .
                                "/" .
                                Route::current()->uri() ==
                                route("managerdomains.create"),
                        "id" => "dashboard",
                        "url" => "#dashboard",
                        "icon" => "menu-icon mdi mdi-television",
                        "name" => "Panel & Domains",
                        "subitems" => [
                            [
                                "url" => route("managerdashboard.index"),
                                "name" => "Main panel",
                            ],
                            [
                                "url" => route("managerdomains.index"),
                                "name" => "Manage domains",
                            ],
                        ],
                    ],
                    [
                        "dropdown" => true,
                        "active" =>
                            request()->getSchemeAndHttpHost() .
                                "/" .
                                Route::current()->uri() ==
                                route("managerposts.create") ||
                            request()->getSchemeAndHttpHost() .
                                "/" .
                                Route::current()->uri() ==
                                route("managerposts.index") ||
                            request()->getSchemeAndHttpHost() .
                                "/" .
                                Route::current()->uri() ==
                                route("managerpages.create") ||
                            request()->getSchemeAndHttpHost() .
                                "/" .
                                Route::current()->uri() ==
                                route("managerpages.index"),
                        "id" => "pages",
                        "url" => "#pages",
                        "icon" => "menu-icon mdi mdi-newspaper",
                        "name" => "Pages & Articles",
                        "subitems" => [
                            [
                                "url" => route("managerposts.create"),
                                "name" => "Create article",
                            ],
                            [
                                "url" => route("managerpages.create"),
                                "name" => "Create page",
                            ],
                            [
                                "url" => route("managerlogin.create"),
                                "name" => "Create login page",
                            ],
                            [
                                "url" => route("managerregister.create"),
                                "name" => "Create registration page",
                            ],
                            [
                                "url" => route("managerpages.index"),
                                "name" => "All pages",
                            ],
                            [
                                "url" => route("managerposts.index"),
                                "name" => "All posts",
                            ],
                            [
                                "url" => route("managerseo.index"),
                                "name" => "SEO Settings",
                            ],
                            [
                                "url" => route("managerpwa.index"),
                                "name" => "PWA Settings",
                            ],
                        ],
                    ],
                    [
                        "dropdown" => true,
                        "active" =>
                            request()->getSchemeAndHttpHost() .
                                "/" .
                                Route::current()->uri() ==
                                route("managercomments.moderate") ||
                            request()->getSchemeAndHttpHost() .
                                "/" .
                                Route::current()->uri() ==
                                route("managercomments.index"),
                        "id" => "appearance",
                        "url" => "#appearance",
                        "icon" => "menu-icon mdi mdi-palette",
                        "name" => "Appearance",
                        "subitems" => [
                            [
                                "url" => route("managerappendcoding.index"),
                                "name" => "Add code",
                            ],
                            [
                                "url" => route("managerlogin.index"),
                                "name" => "Login page",
                            ],
                            [
                                "url" => route("managerregister.index"),
                                "name" => "Registration page",
                            ],
                            [
                                "url" => route("managerrecoverypassword.index"),
                                "name" => "Password recovery",
                            ],
                            [
                                "url" => route("manageremailverify.index"),
                                "name" => "Email verification",
                            ],
                            [
                                "url" => route("managercustomersarea.index"),
                                "name" => "Customer's area",
                            ],
                            [
                                "url" => route("managermainmenu.index"),
                                "name" => "Main menu",
                            ],
                        ],
                    ],
                    [
                        "dropdown" => true,
                        "active" =>
                            request()->getSchemeAndHttpHost() .
                                "/" .
                                Route::current()->uri() ==
                                route("managercomments.moderate") ||
                            request()->getSchemeAndHttpHost() .
                                "/" .
                                Route::current()->uri() ==
                                route("managercomments.index"),
                        "id" => "comment",
                        "url" => "#comment",
                        "icon" => "menu-icon mdi mdi-message-text",
                        "name" => "Comments",
                        "subitems" => [
                            [
                                "url" => route("managercomments.moderate"),
                                "name" => "Approve comments",
                            ],
                            [
                                "url" => route("managercomments.index"),
                                "name" => "All comments",
                            ],
                        ],
                    ],
                    [
                        "dropdown" => true,
                        "active" =>
                            request()->getSchemeAndHttpHost() .
                                "/" .
                                Route::current()->uri() ==
                                route("managerplugins.index") ||
                            request()->getSchemeAndHttpHost() .
                                "/" .
                                Route::current()->uri() ==
                                route("managerplugins.create"),
                        "id" => "plugins",
                        "url" => "#plugins",
                        "icon" => "menu-icon mdi mdi-apps",
                        "name" => "Plugins & Services",
                        "subitems" => [
                            [
                                "url" => route("managerplugins.index"),
                                "name" => "Manage plugins",
                            ],
                            [
                                "url" => route("managerservices.index"),
                                "name" => "Manage services",
                            ],
                        ],
                    ],
                    [
                        "dropdown" => true,
                        "active" =>
                            request()->getSchemeAndHttpHost() .
                                "/" .
                                Route::current()->uri() ==
                                route("managersettings.index") ||
                            request()->getSchemeAndHttpHost() .
                                "/" .
                                Route::current()->uri() ==
                                route("managersettings.cleandata") ||
                            request()->getSchemeAndHttpHost() .
                                "/" .
                                Route::current()->uri() ==
                                route("managersystem.index"),
                        "id" => "manager",
                        "url" => "#manager",
                        "icon" => "menu-icon mdi mdi-security",
                        "name" => "Website administration",
                        "subitems" => [
                            [
                                "url" => route("managerroutes.index"),
                                "name" => "Manage routes",
                            ],
                            [
                                "url" => route("managersettings.index"),
                                "name" => "System Settings",
                            ],
                            [
                                "url" => route("managersettings.cleandata"),
                                "name" => "Stored data",
                            ],
                            [
                                "url" => route("managersystem.index"),
                                "name" => "System Information",
                            ],
                            [
                                "url" => route("managerupdates.index"),
                                "name" => "Update center",
                            ],
                        ],
                    ],
                    [
                        "dropdown" => true,
                        "active" =>
                            request()->getSchemeAndHttpHost() .
                                "/" .
                                Route::current()->uri() ==
                                route("managerstorange.index") ||
                            request()->getSchemeAndHttpHost() .
                                "/" .
                                Route::current()->uri() ==
                                route("managerstorange.create"),
                        "id" => "storage",
                        "url" => "#storage",
                        "icon" => "menu-icon mdi mdi-database",
                        "name" => "Storage",
                        "subitems" => [
                            [
                                "url" => route("managerstorange.index"),
                                "name" => "All files",
                            ],
                            [
                                "url" => route("managerstorange.create"),
                                "name" => "Upload",
                            ],
                        ],
                    ],
                    [
                        "dropdown" => true,
                        "active" =>
                            request()->getSchemeAndHttpHost() .
                                "/" .
                                Route::current()->uri() ==
                                route("manageremails.index") ||
                            request()->getSchemeAndHttpHost() .
                                "/" .
                                Route::current()->uri() ==
                                route("manageremailsmodel.index") ||
                            request()->getSchemeAndHttpHost() .
                                "/" .
                                Route::current()->uri() ==
                                route("manageremails.create"),
                        "id" => "email",
                        "url" => "#email",
                        "icon" => "menu-icon mdi mdi-email",
                        "name" => "Email",
                        "subitems" => [
                            [
                                "url" => route("manageremails.index"),
                                "name" => "All emails",
                            ],
                            [
                                "url" => route("manageremailsmodel.index"),
                                "name" => "Email Templates",
                            ],
                            [
                                "url" => route("manageremails.create"),
                                "name" => "New email",
                            ],
                        ],
                    ],
                    [
                        "dropdown" => true,
                        "active" =>
                            request()->getSchemeAndHttpHost() .
                                "/" .
                                Route::current()->uri() ==
                                route("managerusers.index") ||
                            request()->getSchemeAndHttpHost() .
                                "/" .
                                Route::current()->uri() ==
                                route("managerroles.index") ||
                            request()->getSchemeAndHttpHost() .
                                "/" .
                                Route::current()->uri() ==
                                route("managerroles.create") ||
                            request()->getSchemeAndHttpHost() .
                                "/" .
                                Route::current()->uri() ==
                                route("managerusers.create"),
                        "id" => "users",
                        "url" => "#users",
                        "icon" => "menu-icon mdi mdi-account-multiple",
                        "name" => "User management",
                        "subitems" => [
                            [
                                "url" => route("managerusers.index"),
                                "name" => "All users",
                            ],
                            [
                                "url" => route("managerroles.index"),
                                "name" => "Permissions Management",
                            ],
                            [
                                "url" => route("managerroles.create"),
                                "name" => "New user type",
                            ],
                            [
                                "url" => route("managerusers.create"),
                                "name" => "Register user",
                            ],
                        ],
                    ],
                    [
                        "dropdown" => true,
                        "active" =>
                            request()->getSchemeAndHttpHost() .
                                "/" .
                                Route::current()->uri() ==
                            route("managerusers.index"),
                        "id" => "support",
                        "url" => "#support",
                        "icon" => "menu-icon mdi mdi-help-circle",
                        "name" => "Support",
                        "subitems" => [
                            [
                                "url" => "https://lochlite.com/",
                                "name" => "Usage manual",
                            ],
                            [
                                "url" => "https://lochlite.com/",
                                "name" => "Report a bug",
                            ],
                            [
                                "url" => "https://lochlite.com/",
                                "name" => "Request support",
                            ],
                        ],
                    ],
                ]);
            } elseif (Lochlitecms::lang() == "pt_BR") {
                return collect([
                    [
                        "dropdown" => true,
                        "active" =>
                            request()->getSchemeAndHttpHost() .
                                "/" .
                                Route::current()->uri() ==
                                route("index.index") ||
                            request()->getSchemeAndHttpHost() .
                                "/" .
                                Route::current()->uri() ==
                                route("managerdashboard.index") ||
                            request()->getSchemeAndHttpHost() .
                                "/" .
                                Route::current()->uri() ==
                                route("managerdomains.index") ||
                            request()->getSchemeAndHttpHost() .
                                "/" .
                                Route::current()->uri() ==
                                route("managerdomains.create"),
                        "id" => "dashboard",
                        "url" => "#dashboard",
                        "icon" => "menu-icon mdi mdi-television",
                        "name" => "Painel & Dominios",
                        "subitems" => [
                            [
                                "url" => route("managerdashboard.index"),
                                "name" => "Painel principal",
                            ],
                            [
                                "url" => route("managerdomains.index"),
                                "name" => "Gerenciar dominios",
                            ],
                        ],
                    ],
                    [
                        "dropdown" => true,
                        "active" =>
                            request()->getSchemeAndHttpHost() .
                                "/" .
                                Route::current()->uri() ==
                                route("managerposts.create") ||
                            request()->getSchemeAndHttpHost() .
                                "/" .
                                Route::current()->uri() ==
                                route("managerposts.index") ||
                            request()->getSchemeAndHttpHost() .
                                "/" .
                                Route::current()->uri() ==
                                route("managerpages.create") ||
                            request()->getSchemeAndHttpHost() .
                                "/" .
                                Route::current()->uri() ==
                                route("managerpages.index"),
                        "id" => "pages",
                        "url" => "#pages",
                        "icon" => "menu-icon mdi mdi-newspaper",
                        "name" => "Páginas & Artigos",
                        "subitems" => [
                            [
                                "url" => route("managerposts.create"),
                                "name" => "Criar artigo",
                            ],
                            [
                                "url" => route("managerpages.create"),
                                "name" => "Criar página",
                            ],
                            [
                                "url" => route("managerlogin.create"),
                                "name" => "Criar página de login",
                            ],
                            [
                                "url" => route("managerregister.create"),
                                "name" => "Criar página de registro",
                            ],
                            [
                                "url" => route("managerpages.index"),
                                "name" => "Todas as páginas",
                            ],
                            [
                                "url" => route("managerposts.index"),
                                "name" => "Todos os artigos",
                            ],
                            [
                                "url" => route("managerseo.index"),
                                "name" => "Configurações de SEO",
                            ],
                            [
                                "url" => route("managerpwa.index"),
                                "name" => "Configurações de PWA",
                            ],
                        ],
                    ],
                    [
                        "dropdown" => true,
                        "active" =>
                            request()->getSchemeAndHttpHost() .
                                "/" .
                                Route::current()->uri() ==
                                route("managercomments.moderate") ||
                            request()->getSchemeAndHttpHost() .
                                "/" .
                                Route::current()->uri() ==
                                route("managercomments.index"),
                        "id" => "appearance",
                        "url" => "#appearance",
                        "icon" => "menu-icon mdi mdi-palette",
                        "name" => "Aparência",
                        "subitems" => [
                            [
                                "url" => route("managerappendcoding.index"),
                                "name" => "Adicionar codigo",
                            ],
                            [
                                "url" => route("managerlogin.index"),
                                "name" => "Página de login",
                            ],
                            [
                                "url" => route("managerregister.index"),
                                "name" => "Página de registro",
                            ],
                            [
                                "url" => route("managerrecoverypassword.index"),
                                "name" => "Recuperação de senha",
                            ],
                            [
                                "url" => route("manageremailverify.index"),
                                "name" => "Verificação de email",
                            ],
                            [
                                "url" => route("managercustomersarea.index"),
                                "name" => "Área do cliente",
                            ],
                            [
                                "url" => route("managermainmenu.index"),
                                "name" => "Menu principal",
                            ],
                        ],
                    ],
                    [
                        "dropdown" => true,
                        "active" =>
                            request()->getSchemeAndHttpHost() .
                                "/" .
                                Route::current()->uri() ==
                                route("managercomments.moderate") ||
                            request()->getSchemeAndHttpHost() .
                                "/" .
                                Route::current()->uri() ==
                                route("managercomments.index"),
                        "id" => "comment",
                        "url" => "#comment",
                        "icon" => "menu-icon mdi mdi-message-text",
                        "name" => "Comentários",
                        "subitems" => [
                            [
                                "url" => route("managercomments.moderate"),
                                "name" => "Aprovar comentários",
                            ],
                            [
                                "url" => route("managercomments.index"),
                                "name" => "Todos os comentários",
                            ],
                        ],
                    ],
                    [
                        "dropdown" => true,
                        "active" =>
                            request()->getSchemeAndHttpHost() .
                                "/" .
                                Route::current()->uri() ==
                                route("managerplugins.index") ||
                            request()->getSchemeAndHttpHost() .
                                "/" .
                                Route::current()->uri() ==
                                route("managerplugins.create"),
                        "id" => "plugins",
                        "url" => "#plugins",
                        "icon" => "menu-icon mdi mdi-apps",
                        "name" => "Plugins & Serviços",
                        "subitems" => [
                            [
                                "url" => route("managerplugins.index"),
                                "name" => "Gerenciar plugins",
                            ],
                            [
                                "url" => route("managerservices.index"),
                                "name" => "Gerenciar serviços",
                            ],
                        ],
                    ],
                    [
                        "dropdown" => true,
                        "active" =>
                            request()->getSchemeAndHttpHost() .
                                "/" .
                                Route::current()->uri() ==
                                route("managersettings.index") ||
                            request()->getSchemeAndHttpHost() .
                                "/" .
                                Route::current()->uri() ==
                                route("managersettings.cleandata") ||
                            request()->getSchemeAndHttpHost() .
                                "/" .
                                Route::current()->uri() ==
                                route("managersystem.index"),
                        "id" => "manager",
                        "url" => "#manager",
                        "icon" => "menu-icon mdi mdi-security",
                        "name" => "Administração do site",
                        "subitems" => [
                            [
                                "url" => route("managerroutes.index"),
                                "name" => "Gerenciar rotas",
                            ],
                            [
                                "url" => route("managersettings.index"),
                                "name" => "Configurações do sistema",
                            ],
                            [
                                "url" => route("managersettings.cleandata"),
                                "name" => "Dados armazenados",
                            ],
                            [
                                "url" => route("managersystem.index"),
                                "name" => "Informações do sistema",
                            ],
                            [
                                "url" => route("managerupdates.index"),
                                "name" => "Central de atualizações",
                            ],
                        ],
                    ],
                    [
                        "dropdown" => true,
                        "active" =>
                            request()->getSchemeAndHttpHost() .
                                "/" .
                                Route::current()->uri() ==
                                route("managerstorange.index") ||
                            request()->getSchemeAndHttpHost() .
                                "/" .
                                Route::current()->uri() ==
                                route("managerstorange.create"),
                        "id" => "storage",
                        "url" => "#storage",
                        "icon" => "menu-icon mdi mdi-database",
                        "name" => "Amazenamento",
                        "subitems" => [
                            [
                                "url" => route("managerstorange.index"),
                                "name" => "Todos os arquivos",
                            ],
                            [
                                "url" => route("managerstorange.create"),
                                "name" => "Fazer upload",
                            ],
                        ],
                    ],
                    [
                        "dropdown" => true,
                        "active" =>
                            request()->getSchemeAndHttpHost() .
                                "/" .
                                Route::current()->uri() ==
                                route("manageremails.index") ||
                            request()->getSchemeAndHttpHost() .
                                "/" .
                                Route::current()->uri() ==
                                route("manageremailsmodel.index") ||
                            request()->getSchemeAndHttpHost() .
                                "/" .
                                Route::current()->uri() ==
                                route("manageremails.create"),
                        "id" => "email",
                        "url" => "#email",
                        "icon" => "menu-icon mdi mdi-email",
                        "name" => "Email",
                        "subitems" => [
                            [
                                "url" => route("manageremails.index"),
                                "name" => "Todos os emails",
                            ],
                            [
                                "url" => route("manageremailsmodel.index"),
                                "name" => "Modelos de email",
                            ],
                            [
                                "url" => route("manageremails.create"),
                                "name" => "Novo email",
                            ],
                        ],
                    ],
                    [
                        "dropdown" => true,
                        "active" =>
                            request()->getSchemeAndHttpHost() .
                                "/" .
                                Route::current()->uri() ==
                                route("managerusers.index") ||
                            request()->getSchemeAndHttpHost() .
                                "/" .
                                Route::current()->uri() ==
                                route("managerroles.index") ||
                            request()->getSchemeAndHttpHost() .
                                "/" .
                                Route::current()->uri() ==
                                route("managerroles.create") ||
                            request()->getSchemeAndHttpHost() .
                                "/" .
                                Route::current()->uri() ==
                                route("managerusers.create"),
                        "id" => "users",
                        "url" => "#users",
                        "icon" => "menu-icon mdi mdi-account-multiple",
                        "name" => "Gestão de usuários",
                        "subitems" => [
                            [
                                "url" => route("managerusers.index"),
                                "name" => "Todos os usuários",
                            ],
                            [
                                "url" => route("managerroles.index"),
                                "name" => "Gestão De Permissões",
                            ],
                            [
                                "url" => route("managerroles.create"),
                                "name" => "Novo tipo de usuário",
                            ],
                            [
                                "url" => route("managerusers.create"),
                                "name" => "Cadastrar usuário",
                            ],
                        ],
                    ],
                    [
                        "dropdown" => true,
                        "active" =>
                            request()->getSchemeAndHttpHost() .
                                "/" .
                                Route::current()->uri() ==
                            route("managerusers.index"),
                        "id" => "support",
                        "url" => "#support",
                        "icon" => "menu-icon mdi mdi-help-circle",
                        "name" => "Suporte",
                        "subitems" => [
                            [
                                "url" => "https://lochlite.com/",
                                "name" => "Manual de uso",
                            ],
                            [
                                "url" => "https://lochlite.com/",
                                "name" => "Reportar um erro",
                            ],
                            [
                                "url" => "https://lochlite.com/",
                                "name" => "Solicitar suporte",
                            ],
                        ],
                    ],
                ]);
            }
        } catch (\Exception $e) {
            if (env("APP_DEBUG", false) == true) {
                dd($e);
            }
        }
    }
}
