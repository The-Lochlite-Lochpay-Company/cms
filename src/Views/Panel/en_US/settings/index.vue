<script setup>
import { ref } from 'vue';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import JetDialogModal from 'lochlitecms/Views/Components/Layouts/DialogModal.vue';
import JetButton from 'lochlitecms/Views/Components/Layouts/Button.vue';
import JetSelect from 'lochlitecms/Views/Components/Layouts/Select.vue';
import JetInput from 'lochlitecms/Views/Components/Layouts/Input.vue';
import JetInputError from 'lochlitecms/Views/Components/Layouts/InputError.vue';
import JetCheckbox from 'lochlitecms/Views/Components/Layouts/Checkbox.vue';
import JetLabel from 'lochlitecms/Views/Components/Layouts/Label.vue';
import JetValidationErrors from 'lochlitecms/Views/Components/Layouts/ValidationErrors.vue';
import AppLayout from 'lochlitecms/Views/Panel/AppLayout.vue';

const props = defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    title: String,
    status: String,
    name: String,
    role: String,
    avatar: String,
    version: String,
    domains: Object,
    settings: Object,
    breadcrumbCurrentTitle: String,
    breadcrumbCurrentSection: String,
    menulang: Object,
    menuitems: Object,
});
const formsystemsettings = useForm({
appname: props.settings.appname,
domain: props.settings.domain ?? window.location.origin,
timezone: props.settings.timezone,
language: props.settings.language,
sessiondriver: props.settings.session_driver,
sessionlifetime: props.settings.session_lifetime,
cachedriver: props.settings.cache_driver,
filesystemdisk: props.settings.filesystem_disk,
maildriver: props.settings.mail_driver,
broadcastdriver: props.settings.broadcast_driver,
debug: props.settings.debug,
running: props.settings.running,
});
const submitformsystemsettings = (event) => {
    formsystemsettings.put(route('managersettings.update', {id: event.submitter.dataset.module}));
};

const formbackupsettings = useForm({key: props.settings.backup_key, notify: props.settings.backup_notify});
const submitformbackupsettings = (event) => {
    formbackupsettings.put(route('managersettings.update', {id: event.submitter.dataset.module}));
};

const formtexteditorsettings = useForm({actived: props.settings.text_editor});
const submitformtexteditorsettings = (event) => {
    formtexteditorsettings.put(route('managersettings.update', {id: event.submitter.dataset.module}));
};

const formemailsettings = useForm({emailfromname: props.settings.mailfrom_name, emailfrom: props.settings.mailfrom_address});
const submitformemailsettings = (event) => {
    formemailsettings.put(route('managersettings.update', {id: event.submitter.dataset.module}));
};
const formsmtpsettings = useForm({smtphost: props.settings.mail_host, smtpport: props.settings.mail_port, smtpprotocol: props.settings.mail_protocol, smtpencrypt: props.settings.mail_encryption, smtpusername: props.settings.mail_username, smtppassword: props.settings.mail_password,});
const submitformsmtpsettings = (event) => {
    formsmtpsettings.put(route('managersettings.update', {id: event.submitter.dataset.module}));
};
const formmailgunsettings = useForm({mailgundomain: props.settings.mailgun_domain, mailgunsecret: props.settings.mailgun_secret, mailgunendpoint: props.settings.mailgun_endpoint, mailgunscheme: props.settings.mailgun_scheme});
const submitformmailgunsettings = (event) => {
    formmailgunsettings.put(route('managersettings.update', {id: event.submitter.dataset.module}));
};
const formmailchimpsettings = useForm({mailchimpapi: props.settings.mailchimp_api, mailchimplistid: props.settings.mailchimp_list_id});
const submitformmailchimpsettings = (event) => {
    formmailchimpsettings.put(route('managersettings.update', {id: event.submitter.dataset.module}));
};
const formgoogleanalyticssettings = useForm({analyticsviewid: props.settings.analytics_view_id});
const submitformgoogleanalyticssettings = (event) => {
    formgoogleanalyticssettings.put(route('managersettings.update', {id: event.submitter.dataset.module}));
};
const formftpsettings = useForm({ftphost: props.settings.ftp_host, ftpusername: props.settings.ftp_username, ftppassword: props.settings.ftp_password, ftpssl: props.settings.ftp_ssl, ftpport: props.settings.ftp_port, ftppassive: props.settings.ftp_passive, ftptimeout: props.settings.ftp_timeout, ftproot: props.settings.ftp_root});
const submitformftpsettings = (event) => {
    formftpsettings.put(route('managersettings.update', {id: event.submitter.dataset.module}));
};
const formsftpsettings = useForm({sftphost: props.settings.sftp_host, sftpusername: props.settings.sftp_username, sftppassword: props.settings.sftp_password, sftpprivatekey: props.settings.sftp_private_key});
const submitformsftpsettings = (event) => {
    formsftpsettings.put(route('managersettings.update', {id: event.submitter.dataset.module}));
};
const formamazonsettings = useForm({awskeyid: props.settings.aws_access_key_id, awssecretkey: props.settings.aws_secret_access_key, awsregion: props.settings.aws_default_region, awsbucket: props.settings.aws_bucket});
const submitformamazonsettings = (event) => {
    formamazonsettings.put(route('managersettings.update', {id: event.submitter.dataset.module}));
};
const formredissettings = useForm({
redisurl: props.settings.redis_url,
redishost: props.settings.redis_host,
redisport: props.settings.redis_port,
redisusername: props.settings.redis_username,
redispassword: props.settings.redis_password,
});
const submitformredissettings = (event) => {
    formredissettings.put(route('managersettings.update', {id: event.submitter.dataset.module}));
};
const formmemcachedsettings = useForm({
memcachedhost: props.settings.memcached_host,
memcachedport: props.settings.memcached_port,
memcachedusername: props.settings.memcached_username,
memcachedpassword: props.settings.memcached_password,
});
const submitformmemcachedsettings = (event) => {
    formmemcachedsettings.put(route('managersettings.update', {id: event.submitter.dataset.module}));
};
const formpushersettings = useForm({
appid: props.settings.pusher_app_id,
appkey: props.settings.pusher_app_key,
appsecret: props.settings.pusher_app_secret,
appcluster: props.settings.pusher_app_cluster,
});
const submitformpushersettings = (event) => {
    formpushersettings.put(route('managersettings.update', {id: event.submitter.dataset.module}));
};
</script>

<template>
<AppLayout :menulang="menulang" :menuitems="menuitems" :avatar="avatar" :role="role" :name="name" :version="version" :breadcrumbCurrentTitle="breadcrumbCurrentTitle" :breadcrumbCurrentSection="breadcrumbCurrentSection" :title="title">
        <template #breadcrumb></template>
        <JetValidationErrors class="mb-4" />

        <div class="card card-body shadow-none border border-primary rounded-0 static relative mb-5">
        <div class="fw-bold my-3">
		Advanced Settings
		</div>
        <form @submit.prevent="submitformsystemsettings">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-3">
                <div class="form-group">
                     <JetLabel for="systemappname" value="App Name" />
                     <JetInput id="systemappname" type="text" class="form-control mt-1 block w-full" placeholder="Ex: Meu site" v-model="formsystemsettings.appname" name="appname" autocomplete="appname" required />   
                     <JetInputError for="systemappname" class="mt-2" />
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-3">
                <div class="form-group">
                     <JetLabel for="systemdomain" value="Website domain" />
                     <JetSelect id="systemdomain" class="form-control mt-1 block w-full" placeholder="Ex: www.site.com" v-model="formsystemsettings.domain" name="domain" autocomplete="domain" required>
                     <option v-for="row in domains" :value="row.domain">{{row.domain}}</option>
                     </JetSelect>					 
                     <JetInputError for="systemdomain" class="mt-2" />
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-3">
                <div class="form-group">
                     <JetLabel for="systemtimezone" value="Timezone" />
                     <select id="systemtimezone" class="form-select p-1 block w-full" v-model="formsystemsettings.timezone" name="timezone" autocomplete="timezone" required>
                      <option value="America/Sao_Paulo" :selected="settings.timezone == 'America/Sao_Paulo'">America/Sao_Paulo</option>
					 </select>   
                     <JetInputError for="systemtimezone" class="mt-2" />
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-3">
                <div class="form-group">
                     <JetLabel for="systemlanguage" value="Language" />
                     <select id="systemlanguage" class="form-select p-1 block w-full" v-model="formsystemsettings.language" name="language" autocomplete="language" required>
                      <option value="pt_BR" :selected="settings.language == 'pt_BR'">pt_BR</option>
                      <option value="en_US" :selected="settings.language == 'en_US'">en_US</option>
                      <option value="es_ES" :selected="settings.language == 'es_ES'">es_ES</option>
                      <option value="ru_RU" :selected="settings.language == 'ru_RU'">ru_RU</option>
                      <option value="fr_FR" :selected="settings.language == 'fr_FR'">fr_FR</option>
                      <option value="ja_JP" :selected="settings.language == 'ja_JP'">ja_JP</option>
					 </select>   
                     <JetInputError for="systemlanguage" class="mt-2" />
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-3">
                <div class="form-group">
                     <JetLabel for="systemsessiondriver" value="Session drive" />
                     <select id="systemsessiondriver" class="form-select p-1 block w-full" v-model="formsystemsettings.sessiondriver" name="sessiondriver" autocomplete="sessiondriver" required>
                      <option value="file">File</option>
                      <option value="cookie">Cookie</option>
                      <option value="redis">Redis</option>
                      <option value="memcached">Memcached</option>
                      <option value="database" selected>Database</option>
					 </select>   
                     <JetInputError for="systemsessiondriver" class="mt-2" />
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-3">
                <div class="form-group">
                     <JetLabel for="systemsessionlifetime" value="Session validity" />
                     <JetInput id="systemsessionlifetime" type="number" class="form-control mt-1 block w-full" placeholder="Ex: 120" v-model="formsystemsettings.sessionlifetime" name="sessionlifetime" autocomplete="sessionlifetime" required />   
                     <JetInputError for="systemsessionlifetime" class="mt-2" />
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-3">
                <div class="form-group">
                     <JetLabel for="systemcachedriver" value="Cache drive" />
                     <select id="systemcachedriver" class="form-select p-1 block w-full" v-model="formsystemsettings.cachedriver" name="cachedriver" autocomplete="cachedriver" required>
                      <option value="file" selected>File</option>
                      <option value="redis">Redis</option>
                      <option value="memcached">Memcached</option>
                      <option value="database">Database</option>
					 </select>   
                     <JetInputError for="systemcachedriver" class="mt-2" />
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-3">
                <div class="form-group">
                     <JetLabel for="systemfilesystemdisk" value="Storage drive" />
                     <select id="systemfilesystemdisk" class="form-select p-1 block w-full" v-model="formsystemsettings.filesystemdisk" name="filesystemdisk" autocomplete="filesystemdisk" required>
                      <option value="s3">Amazon S3</option>
                      <option value="sftp">SFTP</option>
                      <option value="ftp">FTP</option>
                      <option value="local" selected>Local disk</option>
					 </select>   
                     <JetInputError for="systemfilesystemdisk" class="mt-2" />
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-3">
                <div class="form-group">
                     <JetLabel for="systembroadcastdriver" value="Broadcast drive" />
                     <select id="systembroadcastdriver" class="form-select p-1 block w-full" v-model="formsystemsettings.broadcastdriver" name="broadcastdriver" autocomplete="broadcastdriver" required>
                      <option value="redis">Redis</option>
                      <option value="pusher">Pusher</option>
                      <option value="log" selected>Log</option>
					 </select>   
                     <JetInputError for="systembroadcastdriver" class="mt-2" />
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-3">
                <div class="form-group">
                     <JetLabel for="systemmaildriver" value="Email drive" />
                     <select id="systemmaildriver" class="form-select p-1 block w-full" v-model="formsystemsettings.maildriver" name="maildriver" autocomplete="maildriver" required>
                      <option value="mailgun">Mailgun</option>
                      <option value="smtp" selected>SMTP</option>
					 </select>   
                     <JetInputError for="systemmaildriver" class="mt-2" />
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-3">
                <div class="form-group">
                     <JetLabel for="systemdebug" value="Debug" />
                     <select id="systemdebug" class="form-select p-1 block w-full" v-model="formsystemsettings.debug" name="debug" autocomplete="debug" required>
                      <option value="0" :selected="settings.debug == 0">Disabled</option>
                      <option value="1" :selected="settings.debug == 1">Activated</option>
					 </select>   
                     <JetInputError for="systemdebug" class="mt-2" />
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-3">
                <div class="form-group">
                     <JetLabel for="systemrunning" value="Execution mode" />
                     <select id="systemrunning" class="form-select p-1 block w-full" v-model="formsystemsettings.running" name="running" autocomplete="running" required>
                      <option value="local">Development</option>
                      <option value="production" selected>Production</option>
					 </select>   
                     <JetInputError for="systemrunning" class="mt-2" />
                </div>
            </div>
			
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <JetButton type="submit" class="btn btn-primary" title="Update" aria-label="Update" data-module="system" :class="{ 'opacity-25': formsystemsettings.processing }" :disabled="formsystemsettings.processing">Update</JetButton>
            </div>
            </div>
      </form>
            <div class="btn btn-light shadow-sm p-2 px-2 text-center align-self-center cursor-text rounded-circle text-dark absolute top-0 right-0 -translate-y-6 translate-x-6">
			<i class="menu-icon mdi mdi-server-security"></i>
            </div>
      </div>
	  
    <div class="card card-body shadow-none border border-primary rounded-0 static relative mb-5">
        <div class="fw-bold my-3">
		Backup settings
		</div>
        <form @submit.prevent="submitformbackupsettings">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                     <JetLabel for="backuppassword" value="Backup file password" />
                     <input type="password" id="backuppassword" class="form-control block w-full" v-model="formbackupsettings.key" name="key" autocomplete required>  
                     <JetInputError for="backuppassword" class="mt-2" />
                </div>
             </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                     <JetLabel for="backupnotify" value="Email for notices" />
                     <input type="email" id="backupnotify" class="form-control block w-full" v-model="formbackupsettings.notify" name="notify" autocomplete required>  
                     <JetInputError for="backupnotify" class="mt-2" />
                </div>
             </div>
		
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <JetButton type="submit" class="btn btn-primary" title="Update" aria-label="Update" data-module="backup" :class="{ 'opacity-25': formbackupsettings.processing }" :disabled="formbackupsettings.processing">Update</JetButton>
            </div>
        </div>
        </form>
            <div class="btn btn-light shadow-sm p-2 px-2 text-center align-self-center cursor-text rounded-circle text-dark absolute top-0 right-0 -translate-y-6 translate-x-6">
			<i class="menu-icon mdi mdi-server-security"></i>
            </div>
      </div>
			
    <div class="card card-body shadow-none border border-primary rounded-0 static relative mb-5">
        <div class="fw-bold my-3">
		Enable or disable the text editor
		</div>
        <form @submit.prevent="submitformtexteditorsettings">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                     <JetLabel for="activedtexteditor" value="Activated" />
                     <select id="activedtexteditor" class="form-select p-1 block w-full" v-model="formtexteditorsettings.actived" name="actived" autocomplete="actived" required>
                      <option value="1" selected>True</option>
                      <option value="0">False</option>
					 </select>   
                     <JetInputError for="activedtexteditor" class="mt-2" />
                </div>
            </div>
		
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <JetButton type="submit" class="btn btn-primary" title="Update" aria-label="Update" data-module="texteditor" :class="{ 'opacity-25': formtexteditorsettings.processing }" :disabled="formtexteditorsettings.processing">Update</JetButton>
            </div>
            </div>
      </form>
            <div class="btn btn-light shadow-sm p-2 px-2 text-center align-self-center cursor-text rounded-circle text-dark absolute top-0 right-0 -translate-y-6 translate-x-6">
			<i class="menu-icon mdi mdi-email"></i>
            </div>
      </div>
	  
    <div class="card card-body shadow-none border border-primary rounded-0 static relative mb-5">
        <div class="fw-bold my-3">
		Email settings
		</div>
        <form @submit.prevent="submitformemailsettings">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="form-group">
                     <JetLabel for="emailfromname" value="Sender's name" />
                     <JetInput id="emailfromname" type="text" class="form-control mt-1 block w-full" placeholder="Ex: John Joe" v-model="formemailsettings.emailfromname" name="emailfromname" autocomplete="emailfromname" required />   
                     <JetInputError for="emailfromname" class="mt-2" />
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="form-group">
                     <JetLabel for="emailfrom" value="Sender email" />
                     <JetInput id="emailfrom" type="email" class="form-control mt-1 block w-full" placeholder="Ex: my@mail.com" v-model="formemailsettings.emailfrom" name="emailfrom" autocomplete="emailfrom" required />   
                     <JetInputError for="emailfrom" class="mt-2" />
                </div>
            </div>
		
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <JetButton type="submit" class="btn btn-primary" title="Update" aria-label="Update" data-module="email" :class="{ 'opacity-25': formemailsettings.processing }" :disabled="formemailsettings.processing">Update</JetButton>
            </div>
            </div>
      </form>
            <div class="btn btn-light shadow-sm p-2 px-2 text-center align-self-center cursor-text rounded-circle text-dark absolute top-0 right-0 -translate-y-6 translate-x-6">
			<i class="menu-icon mdi mdi-email"></i>
            </div>
      </div>
	  
     <div class="card card-body shadow-none border border-primary rounded-0 static relative mb-5">
        <div class="fw-bold my-3">
		SMTP Settings
		</div>
        <form @submit.prevent="submitformsmtpsettings">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                     <JetLabel for="smtphost" value="SMTP mail server address" />
                     <JetInput id="smtphost" type="text" class="form-control mt-1 block w-full" placeholder="Ex: smtp.gmail.com" v-model="formsmtpsettings.smtphost" name="smtphost" autocomplete="host" required />   
                     <JetInputError for="smtphost" class="mt-2" />
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                     <JetLabel for="smtpport" value="SMTP mail server port" />
                     <JetInput id="smtpport" type="number" class="form-control mt-1 block w-full" placeholder="Ex: 587" v-model="formsmtpsettings.smtpport" name="smtpport" autocomplete="port" required />   
                     <JetInputError for="smtpport" class="mt-2" />
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                     <JetLabel for="smtpprotocol" value="SMTP mail server protocol" />
                     <select id="smtpprotocol" class="form-select p-1 block w-full" v-model="formsmtpsettings.smtpprotocol" name="smtpprotocol" autocomplete="protocol" required>
                      <option value="tls" selected>TLS</option>
                      <option value="ssl">SSL</option>
					 </select>   
                     <JetInputError for="smtpprotocol" class="mt-2" />
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                     <JetLabel for="smtpusername" value="Email" />
                     <JetInput id="smtpusername" type="email" class="form-control mt-1 block w-full" placeholder="Ex: you@gmail.com" v-model="formsmtpsettings.smtpusername" name="smtpusername" autocomplete="username" required />   
                     <JetInputError for="smtpusername" class="mt-2" />
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                     <JetLabel for="smtppassword" value="Email password" />
                     <JetInput id="smtppassword" type="password" class="form-control mt-1 block w-full" placeholder="**********" v-model="formsmtpsettings.smtppassword" name="smtppassword" autocomplete="password" required />   
                     <JetInputError for="smtppassword" class="mt-2" />
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                     <JetLabel for="smtpencrypt" value="Validate certificate" />
                     <select id="smtpencrypt" class="form-select p-1 block w-full" v-model="formsmtpsettings.smtpencrypt" name="smtpencrypt" autocomplete="encrypt" required>
                      <option value="true">True</option>
                      <option value="false" selected>False</option>
					 </select>   
                     <JetInputError for="smtpencrypt" class="mt-2" />
                </div>
            </div>
			
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <JetButton type="submit" class="btn btn-primary" title="Update" aria-label="Update" data-module="smtp" :class="{ 'opacity-25': formsmtpsettings.processing }" :disabled="formsmtpsettings.processing">Update</JetButton>
            </div>
            </div>
      </form>
            <div class="btn btn-light shadow-sm p-2 px-2 text-center align-self-center cursor-text rounded-circle text-dark absolute top-0 right-0 -translate-y-6 translate-x-6">
			<i class="menu-icon mdi mdi-email"></i>
            </div>
      </div>
	  
     <div class="card card-body shadow-none border border-primary rounded-0 static relative mb-5">
        <div class="fw-bold my-3">
		Mailgun Settings
		</div>
        <form @submit.prevent="submitformmailgunsettings">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-3">
                <div class="form-group">
                     <JetLabel for="mailgundomain" value="Mailgun Domain" />
                     <JetInput id="mailgundomain" type="text" class="form-control mt-1 block w-full" v-model="formmailgunsettings.mailgundomain" name="mailgundomain" autocomplete="mailgundomain" required />   
                     <JetInputError for="mailgundomain" class="mt-2" />
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-3">
                <div class="form-group">
                     <JetLabel for="mailgunsecret" value="Mailgun Secret" />
                     <JetInput id="mailgunsecret" type="password" class="form-control mt-1 block w-full" placeholder="***********" v-model="formmailgunsettings.mailgunsecret" name="mailgunsecret" autocomplete="mailgunsecret" required />   
                     <JetInputError for="mailgunsecret" class="mt-2" />
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-3">
                <div class="form-group">
                     <JetLabel for="mailgunscheme" value="Mailgun Scheme" />
                     <select id="mailgunscheme" class="form-select p-1 block w-full" v-model="formmailgunsettings.mailgunscheme" name="mailgunscheme" autocomplete="mailgunscheme" required>
                      <option value="https" selected>HTTPS</option>
                      <option value="http">HTTP</option>
					 </select>   
                     <JetInputError for="mailgunscheme" class="mt-2" />
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-3">
                <div class="form-group">
                     <JetLabel for="mailgunendpoint" value="Mailgun Endpoint" />
                     <JetInput id="mailgunendpoint" type="text" class="form-control mt-1 block w-full" v-model="formmailgunsettings.mailgunendpoint" name="mailgunendpoint" autocomplete="mailgunendpoint" required />   
                     <JetInputError for="mailgunendpoint" class="mt-2" />
                </div>
            </div>
			
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <JetButton type="submit" class="btn btn-primary" title="Update" aria-label="Update" data-module="mailgun" :class="{ 'opacity-25': formmailgunsettings.processing }" :disabled="formmailgunsettings.processing">Update</JetButton>
            </div>
            </div>
      </form>
            <div class="btn btn-light shadow-sm p-2 px-2 text-center align-self-center cursor-text rounded-circle text-dark absolute top-0 right-0 -translate-y-6 translate-x-6">
			<i class="menu-icon mdi mdi-email"></i>
            </div>
      </div>
 	  
     <div class="card card-body shadow-none border border-primary rounded-0 static relative mb-5">
        <div class="fw-bold my-3">
		Mailchimp Settings
		</div>
        <form @submit.prevent="submitformmailchimpsettings">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="form-group">
                     <JetLabel for="mailchimpapi" value="Mailchimp Api" />
                     <JetInput id="mailchimpapi" type="text" class="form-control mt-1 block w-full" v-model="formmailchimpsettings.mailchimpapi" name="mailchimpapi" autocomplete="mailchimpapi" required />   
                     <JetInputError for="mailchimpapi" class="mt-2" />
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="form-group">
                     <JetLabel for="mailchimplistid" value="Mailchimp List ID" />
                     <JetInput id="mailchimplistid" type="text" class="form-control mt-1 block w-full" v-model="formmailchimpsettings.mailchimplistid" name="mailchimplistid" autocomplete="mailchimplistid" required />   
                     <JetInputError for="mailchimplistid" class="mt-2" />
                </div>
            </div>
			
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <JetButton type="submit" class="btn btn-primary" title="Update" aria-label="Update" data-module="mailchimp" :class="{ 'opacity-25': formmailchimpsettings.processing }" :disabled="formmailchimpsettings.processing">Update</JetButton>
            </div>
            </div>
      </form>
            <div class="btn btn-light shadow-sm p-2 px-2 text-center align-self-center cursor-text rounded-circle text-dark absolute top-0 right-0 -translate-y-6 translate-x-6">
			<i class="menu-icon mdi mdi-email"></i>
            </div>
      </div>
 	  
     <div class="card card-body shadow-none border border-primary rounded-0 static relative mb-5">
        <div class="fw-bold my-3">
		Google Analytics Settings
		</div>
        <form @submit.prevent="submitformgoogleanalyticssettings">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                     <JetLabel for="analyticsviewid" value="Analytics View ID" />
                     <JetInput id="analyticsviewid" type="text" class="form-control mt-1 block w-full" v-model="formmailchimpsettings.analyticsviewid" name="analyticsviewid" autocomplete="analyticsviewid" required />   
                     <JetInputError for="analyticsviewid" class="mt-2" />
                </div>
            </div>
			
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <JetButton type="submit" class="btn btn-primary" title="Update" aria-label="Update" data-module="googleanalytics" :class="{ 'opacity-25': formgoogleanalyticssettings.processing }" :disabled="formgoogleanalyticssettings.processing">Update</JetButton>
            </div>
            </div>
      </form>
            <div class="btn btn-light shadow-sm p-2 px-2 text-center align-self-center cursor-text rounded-circle text-dark absolute top-0 right-0 -translate-y-6 translate-x-6">
			<i class="menu-icon mdi mdi-email"></i>
            </div>
      </div>
 
        <div class="card card-body shadow-none border border-primary rounded-0 static relative my-5">
        <div class="fw-bold my-3">
		FTP Settings
		</div>
        <form @submit.prevent="submitformftpsettings">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                     <JetLabel for="ftphost" value="FTP Host" />
                     <JetInput id="ftphost" type="text" class="form-control mt-1 block w-full" v-model="formftpsettings.ftphost" name="ftphost" autocomplete="ftphost" required />   
                     <JetInputError for="ftphost" class="mt-2" />
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                     <JetLabel for="ftpusername" value="FTP Username" />
                     <JetInput id="ftpusername" type="text" class="form-control mt-1 block w-full" v-model="formftpsettings.ftpusername" name="ftpusername" autocomplete="ftpusername" required />   
                     <JetInputError for="ftpusername" class="mt-2" />
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                     <JetLabel for="ftppassword" value="FTP Password" />
                     <JetInput id="ftppassword" type="password" class="form-control mt-1 block w-full" placeholder="***********" v-model="formftpsettings.ftppassword" name="ftppassword" autocomplete="ftppassword" required />   
                     <JetInputError for="ftppassword" class="mt-2" />
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                     <JetLabel for="ftpport" value="FTP Port" />
                     <JetInput id="ftpport" type="number" class="form-control mt-1 block w-full" v-model="formftpsettings.ftpport" name="ftpport" autocomplete="ftpport" required />   
                     <JetInputError for="ftpport" class="mt-2" />
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                     <JetLabel for="ftptimeout" value="FTP Timeout" />
                     <JetInput id="ftptimeout" type="number" class="form-control mt-1 block w-full" v-model="formftpsettings.ftptimeout" name="ftptimeout" autocomplete="ftptimeout" required />   
                     <JetInputError for="ftptimeout" class="mt-2" />
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                     <JetLabel for="ftproot" value="FTP Root Path" />
                     <JetInput id="ftproot" type="text" class="form-control mt-1 block w-full" v-model="formftpsettings.ftproot" name="ftproot" autocomplete="ftproot" required />   
                     <JetInputError for="ftproot" class="mt-2" />
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                     <JetLabel for="ftpssl" value="FTP SSL" />
                     <select id="ftpssl" class="form-select p-1 block w-full" v-model="formftpsettings.ftpssl" name="ftpssl" autocomplete="ftpssl" required>
					 <option value="0">False</option>   
					 <option value="1">True</option>   
					 </select>   
                     <JetInputError for="ftpssl" class="mt-2" />
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                     <JetLabel for="ftppassive" value="FTP Passive Mode" />
                     <select id="ftppassive" class="form-select p-1 block w-full" v-model="formftpsettings.ftppassive" name="ftppassive" autocomplete="ftppassive" required>
					 <option value="0">Disabled</option>   
					 <option value="1">Activated</option>   
					 </select>   
                     <JetInputError for="ftppassive" class="mt-2" />
                </div>
            </div>
			
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <JetButton type="submit" class="btn btn-primary" title="Update" aria-label="Update" data-module="ftp" :class="{ 'opacity-25': formftpsettings.processing }" :disabled="formftpsettings.processing">Update</JetButton>
            </div>
            </div>
      </form>
            <div class="btn btn-light shadow-sm p-2 px-2 text-center align-self-center cursor-text rounded-circle text-dark absolute top-0 right-0 -translate-y-6 translate-x-6">
			<i class="menu-icon mdi mdi-server"></i>
            </div>
      </div>
 
        <div class="card card-body shadow-none border border-primary rounded-0 static relative my-5">
        <div class="fw-bold my-3">
		SFTP Settings
		</div>
        <form @submit.prevent="submitformsftpsettings">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-3">
                <div class="form-group">
                     <JetLabel for="sftphost" value="SFTP Host" />
                     <JetInput id="sftphost" type="text" class="form-control mt-1 block w-full" v-model="formsftpsettings.sftphost" name="sftphost" autocomplete="sftphost" required />   
                     <JetInputError for="sftphost" class="mt-2" />
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-3">
                <div class="form-group">
                     <JetLabel for="sftpusername" value="SFTP Username" />
                     <JetInput id="sftpusername" type="text" class="form-control mt-1 block w-full" v-model="formsftpsettings.sftpusername" name="sftpusername" autocomplete="sftpusername" required />   
                     <JetInputError for="sftpusername" class="mt-2" />
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-3">
                <div class="form-group">
                     <JetLabel for="sftpprivatekey" value="SFTP Private Key" />
                     <JetInput id="sftpprivatekey" type="password" class="form-control mt-1 block w-full" placeholder="***********" v-model="formsftpsettings.sftpprivatekey" name="sftpprivatekey" autocomplete="sftpprivatekey" />   
                     <JetInputError for="sftpprivatekey" class="mt-2" />
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-3">
                <div class="form-group">
                     <JetLabel for="sftppassword" value="SFTP Password" />
                     <JetInput id="sftppassword" type="password" class="form-control mt-1 block w-full" placeholder="***********" v-model="formsftpsettings.sftppassword" name="sftppassword" autocomplete="sftppassword" required />   
                     <JetInputError for="sftppassword" class="mt-2" />
                </div>
            </div>
			
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <JetButton type="submit" class="btn btn-primary" title="Update" aria-label="Update" data-module="sftp" :class="{ 'opacity-25': formsftpsettings.processing }" :disabled="formsftpsettings.processing">Update</JetButton>
            </div>
            </div>
      </form>
            <div class="btn btn-light shadow-sm p-2 px-2 text-center align-self-center cursor-text rounded-circle text-dark absolute top-0 right-0 -translate-y-6 translate-x-6">
			<i class="menu-icon mdi mdi-server"></i>
            </div>
      </div>
 
        <div class="card card-body shadow-none border border-primary rounded-0 static relative my-5">
        <div class="fw-bold my-3">
		Amazon S3 Settings
		</div>
        <form @submit.prevent="submitformamazonsettings">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                     <JetLabel for="awskeyid" value="Access Key ID" />
                     <JetInput id="awskeyid" type="text" class="form-control mt-1 block w-full" v-model="formamazonsettings.awskeyid" name="awskeyid" autocomplete="awskeyid" required />   
                     <JetInputError for="awskeyid" class="mt-2" />
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                     <JetLabel for="awssecretkey" value="Secret Access Key" />
                     <JetInput id="awssecretkey" type="password" class="form-control mt-1 block w-full" v-model="formamazonsettings.awssecretkey" name="awssecretkey" autocomplete="awssecretkey" required />   
                     <JetInputError for="awssecretkey" class="mt-2" />
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                     <JetLabel for="awsregion" value="Default Region" />
                     <JetInput id="awsregion" type="text" class="form-control mt-1 block w-full" placeholder="Ex: us-east-1" v-model="formamazonsettings.awsregion" name="awsregion" autocomplete="awsregion" required />   
                     <JetInputError for="awsregion" class="mt-2" />
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                     <JetLabel for="awsbucket" value="AWS Bucket" />
                     <JetInput id="awsbucket" type="text" class="form-control mt-1 block w-full" v-model="formamazonsettings.awsbucket" name="awsbucket" autocomplete="awsbucket" required />   
                     <JetInputError for="awsbucket" class="mt-2" />
                </div>
            </div>
			
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <JetButton type="submit" class="btn btn-primary" title="Update" aria-label="Update" data-module="amazon" :class="{ 'opacity-25': formamazonsettings.processing }" :disabled="formamazonsettings.processing">Update</JetButton>
            </div>
            </div>
      </form>
            <div class="btn btn-light shadow-sm p-2 px-2 text-center align-self-center cursor-text rounded-circle text-dark absolute top-0 right-0 -translate-y-6 translate-x-6">
			<i class="menu-icon mdi mdi-server"></i>
            </div>
      </div>

	 <div class="card card-body shadow-none border border-primary rounded-0 static relative my-5">
        <div class="fw-bold my-3">
		Memcached Server Settings
		</div>
        <form @submit.prevent="submitformmemcachedsettings">
        <div class="row">
             <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                     <JetLabel for="memcachedhost" value="Memcached host" />
                     <JetInput id="memcachedhost" type="text" class="form-control mt-1 block w-full" placeholder="Ex: 127.0.0.1" v-model="formmemcachedsettings.memcachedhost" name="memcachedhost" autocomplete="memcachedhost" required />   
                     <JetInputError for="memcachedhost" class="mt-2" />
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                     <JetLabel for="memcachedport" value="Memcached port" />
                     <JetInput id="memcachedport" type="number" class="form-control mt-1 block w-full" placeholder="Ex: 11211" v-model="formmemcachedsettings.memcachedport" name="redisport" autocomplete="memcachedport" required />   
                     <JetInputError for="memcachedport" class="mt-2" />
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                     <JetLabel for="memcachedusername" value="Memcached username" />
                     <JetInput id="memcachedusername" type="text" class="form-control mt-1 block w-full" v-model="formmemcachedsettings.memcachedusername" name="memcachedusername" autocomplete="memcachedusername" required />   
                     <JetInputError for="memcachedusername" class="mt-2" />
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                     <JetLabel for="memcachedpassword" value="Memcached password" />
                     <JetInput id="memcachedpassword" type="password" class="form-control mt-1 block w-full" v-model="formmemcachedsettings.memcachedpassword" name="memcachedpassword" autocomplete="memcachedpassword" required />   
                     <JetInputError for="memcachedpassword" class="mt-2" />
                </div>
            </div>
			
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <JetButton type="submit" class="btn btn-primary" title="Update" aria-label="Update" data-module="memcached" :class="{ 'opacity-25': formmemcachedsettings.processing }" :disabled="formmemcachedsettings.processing">Update</JetButton>
            </div>
            </div>
      </form>
            <div class="btn btn-light shadow-sm p-2 px-2 text-center align-self-center cursor-text rounded-circle text-dark absolute top-0 right-0 -translate-y-6 translate-x-6">
			<i class="menu-icon mdi mdi-server"></i>
            </div>
      </div>

	 <div class="card card-body shadow-none border border-primary rounded-0 static relative my-5">
        <div class="fw-bold my-3">
		Redis Server Settings
		</div>
        <form @submit.prevent="submitformredissettings">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                     <JetLabel for="redisurl" value="Redis url" />
                     <JetInput id="redisurl" type="text" class="form-control mt-1 block w-full" placeholder="Ex: 127.0.0.1" v-model="formredissettings.redisurl" name="redisurl" autocomplete="redisurl" required />   
                     <JetInputError for="redisurl" class="mt-2" />
                </div>
            </div>
             <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                     <JetLabel for="redishost" value="Redis host" />
                     <JetInput id="redishost" type="text" class="form-control mt-1 block w-full" placeholder="Ex: 127.0.0.1" v-model="formredissettings.redishost" name="redishost" autocomplete="redishost" required />   
                     <JetInputError for="redishost" class="mt-2" />
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                     <JetLabel for="redisport" value="Redis port" />
                     <JetInput id="redisport" type="number" class="form-control mt-1 block w-full" placeholder="Ex: 6369" v-model="formredissettings.redisport" name="redisport" autocomplete="redisport" required />   
                     <JetInputError for="redisport" class="mt-2" />
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                     <JetLabel for="redisusername" value="Redis username" />
                     <JetInput id="redisusername" type="text" class="form-control mt-1 block w-full" v-model="formredissettings.redisusername" name="redisusername" autocomplete="redisusername" required />   
                     <JetInputError for="redisusername" class="mt-2" />
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                     <JetLabel for="redispassword" value="Redis password" />
                     <JetInput id="redispassword" type="password" class="form-control mt-1 block w-full" v-model="formredissettings.redispassword" name="redispassword" autocomplete="redispassword" required />   
                     <JetInputError for="redispassword" class="mt-2" />
                </div>
            </div>
			
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <JetButton type="submit" class="btn btn-primary" title="Update" aria-label="Update" data-module="redis" :class="{ 'opacity-25': formredissettings.processing }" :disabled="formredissettings.processing">Update</JetButton>
            </div>
            </div>
      </form>
            <div class="btn btn-light shadow-sm p-2 px-2 text-center align-self-center cursor-text rounded-circle text-dark absolute top-0 right-0 -translate-y-6 translate-x-6">
			<i class="menu-icon mdi mdi-server"></i>
            </div>
      </div>

	 <div class="card card-body shadow-none border border-primary rounded-0 static relative my-5">
        <div class="fw-bold my-3">
		Pusher Settings
		</div>
        <form @submit.prevent="submitformpushersettings">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-3">
                <div class="form-group">
                     <JetLabel for="pusherappid" value="App ID" />
                     <JetInput id="pusherappid" type="text" class="form-control mt-1 block w-full" v-model="formpushersettings.appid" name="appid" autocomplete="appid" required />   
                     <JetInputError for="pusherappid" class="mt-2" />
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-3">
                <div class="form-group">
                     <JetLabel for="pusherappcluster" value="App Cluster" />
                     <JetInput id="pusherappcluster" type="text" class="form-control mt-1 block w-full" v-model="formpushersettings.appcluster" name="appcluster" autocomplete="appcluster" required />   
                     <JetInputError for="pusherappcluster" class="mt-2" />
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-3">
                <div class="form-group">
                     <JetLabel for="pusherappkey" value="App Key" />
                     <JetInput id="pusherappkey" type="text" class="form-control mt-1 block w-full" v-model="formpushersettings.appkey" name="appkey" autocomplete="pusherappkey" required />   
                     <JetInputError for="pusherappkey" class="mt-2" />
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-3">
                <div class="form-group">
                     <JetLabel for="pusherappsecret" value="App Secret" />
                     <JetInput id="pusherappsecret" type="password" class="form-control mt-1 block w-full" v-model="formpushersettings.appsecret" name="appsecret" autocomplete="pusherappsecret" required />   
                     <JetInputError for="pusherappsecret" class="mt-2" />
                </div>
            </div>
			
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <JetButton type="submit" class="btn btn-primary" title="Update" aria-label="Update" data-module="pusher" :class="{ 'opacity-25': formpushersettings.processing }" :disabled="formpushersettings.processing">Update</JetButton>
            </div>
            </div>
      </form>
            <div class="btn btn-light shadow-sm p-2 px-2 text-center align-self-center cursor-text rounded-circle text-dark absolute top-0 right-0 -translate-y-6 translate-x-6">
			<i class="menu-icon mdi mdi-bell-outline"></i>
            </div>
      </div>
 
</AppLayout>
</template>
