<script setup>
import { ref } from 'vue';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import JetInputError from '@/Jetstream/InputError.vue';
import JetInput from '@/Jetstream/Input.vue';
import JetSelect from '@/Jetstream/Select.vue';
import JetLabel from '@/Jetstream/Label.vue';
import JetDialogModal from '@/Jetstream/DialogModal.vue';
import JetButton from '@/Jetstream/Button.vue';
import JetValidationErrors from '@/Jetstream/ValidationErrors.vue';
import AppLayout from '@/Pages/Panel/AppLayout.vue';

const props = defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    title: String,
    status: String,
    name: String,
    role: String,
    avatar: String,
    version: String,
    breadcrumbCurrentTitle: String,
    breadcrumbCurrentSection: String,
    menuitems: Object,
    seo: Object,
});
const form = useForm({
    title: props.seo.title,
    keywords: props.seo.keywords,
    author: props.seo.author,
    description: props.seo.description,
    translate: props.seo.translate,
    robots: props.seo.robots,
    google_site_verification: props.seo.google_site_verification,
    pdomain_verify: props.seo.pdomain_verify,
    ogtype: props.seo.ogtype,
    ogurl: props.seo.ogurl,
    ogtitle: props.seo.ogtitle,
    ogdescription: props.seo.ogdescription,
    ogimage: props.seo.ogimage,
    fbapp_id: props.seo.fbapp_id,
    twittercard: props.seo.twittercard,
    twitterurl: props.seo.twitterurl,
    twittertitle: props.seo.twittertitle,
    twitterdescription: props.seo.twitterdescription,
    twitterimage: props.seo.twitterimage,
    twittersite: props.seo.twittersite,
    msapplicationtilecolor: props.seo.msapplicationtilecolor,
    themecolor: props.seo.themecolor,
    favicon: props.seo.icon,
});
const submit = () => {
    form.transform(data => ({
        ...data,
    })).post(route('managerseo.store'));
};

</script>

<template>
<AppLayout :menuitems="menuitems" :avatar="avatar" :role="role" :name="name" :version="version" :breadcrumbCurrentTitle="breadcrumbCurrentTitle" :breadcrumbCurrentSection="breadcrumbCurrentSection" :title="title">
       <template #breadcrumb>
              <li class="breadcrumb-item active" aria-current="page">Configuração padrão</li>
        </template>
        <JetValidationErrors class="mb-4" />

        <form @submit.prevent="submit">
        <div class="card card-body shadow-sm mb-4">
        <div class="card-header boder-0 mb-2">Basic</div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                     <JetLabel for="title" value="Titulo" />
                     <JetInput id="title" type="text" class="form-control mt-1 block w-full" placeholder="title" v-model="form.title" name="title" autocomplete="title" required />
                     <JetInputError for="title" class="mt-2" />
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                     <JetLabel for="keywords" value="Keywords" />
                     <JetInput id="keywords" type="text" class="form-control mt-1 block w-full" placeholder="Keywords" v-model="form.keywords" name="keywords" autocomplete="keywords" required />
                     <JetInputError for="keywords" class="mt-2" />
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                     <JetLabel for="author" value="Author" />
                     <JetInput id="author" type="text" class="form-control mt-1 block w-full" placeholder="Author" v-model="form.author" name="author" autocomplete="author" required />
                     <JetInputError for="author" class="mt-2" />
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                     <JetLabel for="favicon" value="Favicon" />
                     <JetInput id="favicon" type="url" class="form-control mt-1 block w-full" placeholder="favicon" v-model="form.favicon" name="favicon" autocomplete="favicon" />
                     <JetInputError for="favicon" class="mt-2" />
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                     <JetLabel for="robots" value="Robots" />
                     <JetSelect id="robots" class="form-control mt-1 block w-full" placeholder="robots" v-model="form.robots" name="robots" autocomplete="robots">
					 <option value="index,follow">index, follow </option>
					 <option value="noindex,nofollow">noindex, nofollow </option>
					 <option value="index">index </option>
					 <option value="noindex">noindex </option>
					 <option value="follow">follow </option>
					 <option value="nofollow">nofollow </option>
					 <option value="noodp">noodp </option>
					 <option value="noarchive">noarchive </option>
					 <option value="nosnippet">nosnippet </option>
					 <option value="noimageindex">noimageindex </option>
					 <option value="index,nofollow">index, nofollow </option>
					 <option value="noindex,follow">noindex, follow </option>
					 <option value="noodp,noarchive">noodp, noarchive </option>
					 <option value="nosnippet,noimageindex">nosnippet, noimageindex </option>
					 <option value="noodp,noarchive,nosnippet,noimageindex">noodp, noarchive, nosnippet, noimageindex </option>
					 <option value="noindex,nofollow,noodp,noarchive,nosnippet,noimageindex">noindex, nofollow, noodp, noarchive, nosnippet, noimageindex </option>
					 </JetSelect>
                     <JetInputError for="robots" class="mt-2" />
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                     <JetLabel for="translate" value="Translate" />
                     <JetSelect id="translate" class="form-control mt-1 block w-full" placeholder="translate" v-model="form.translate" name="translate" autocomplete="translate">
					 <option value="translate">translate </option>
					 <option value="notranslate">notranslate </option>
					 </JetSelect>
                     <JetInputError for="translate" class="mt-2" />
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                     <JetLabel for="description" value="Description" />
                     <textarea id="description" class="form-control mt-1 block w-full" placeholder="Escreva a descrição que aparecerá nos buscadores" v-model="form.description" name="description" autocomplete required></textarea>
                     <JetInputError for="description" class="mt-2" />
                </div>
            </div>
        </div>
        </div>
		
        <div class="card card-body shadow-sm mt-4 mb-2">
        <div class="card-header boder-0 mb-2">Google</div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                     <JetLabel for="google_site_verification" value="google-site-verification" />
                     <JetInput id="google_site_verification" type="text" class="form-control mt-1 block w-full" placeholder="google_site_verification" v-model="form.google_site_verification" name="google_site_verification" autocomplete="google_site_verification" />
                     <JetInputError for="google_site_verification" class="mt-2" />
                </div>
            </div>
        </div>
        </div>
		
        <div class="card card-body shadow-sm mt-4 mb-2">
        <div class="card-header boder-0 mb-2">Pinterest</div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                     <JetLabel for="pdomain_verify" value="p:domain_verify" />
                     <JetInput id="pdomain_verify" type="text" class="form-control mt-1 block w-full" placeholder="pdomain_verify" v-model="form.pdomain_verify" name="pdomain_verify" autocomplete="pdomain_verify" />
                     <JetInputError for="pdomain_verify" class="mt-2" />
                </div>
            </div>
        </div>
        </div>
		
        <div class="card card-body shadow-sm mt-4 mb-2">
        <div class="card-header boder-0 mb-2">Twitter</div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                     <JetLabel for="twittercard" value="twitter:card" />
                     <JetSelect id="twittercard" class="form-control mt-1 block w-full" placeholder="twittercard" v-model="form.twittercard" name="twittercard" autocomplete="twittercard">
					 <option value="summary">summary</option>
					 <option value="summary_large_image">summary_large_image</option>
					 <option value="app">app</option>
					 <option value="player">player</option>
					 </JetSelect>
                     <JetInputError for="twittercard" class="mt-2" />
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-8">
                <div class="form-group">
                     <JetLabel for="twittertitle" value="twitter:title" />
                     <JetInput id="twittertitle" type="text" class="form-control mt-1 block w-full" placeholder="twittertitle" v-model="form.twittertitle" name="twittertitle" autocomplete="twittertitle" />
                     <JetInputError for="twittertitle" class="mt-2" />
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                     <JetLabel for="twitterurl" value="twitter:url" />
                     <JetInput id="twitterurl" type="url" class="form-control mt-1 block w-full" placeholder="twitterurl" v-model="form.twitterurl" name="twitterurl" autocomplete="twitterurl" />
                     <JetInputError for="twitterurl" class="mt-2" />
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                     <JetLabel for="twittersite" value="twitter:site" />
                     <JetInput id="twittersite" type="text" class="form-control mt-1 block w-full" placeholder="twittersite" v-model="form.twittersite" name="twittersite" autocomplete="twittersite" />
                     <JetInputError for="twittersite" class="mt-2" />
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                     <JetLabel for="twitterimage" value="twitter:image" />
                     <JetInput id="twitterimage" type="url" class="form-control mt-1 block w-full" placeholder="twitterimage" v-model="form.twitterimage" name="twitterimage" autocomplete="twitterimage" />
                     <JetInputError for="twitterimage" class="mt-2" />
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                     <JetLabel for="twitterdescription" value="twitter:description" />
                     <textarea id="twitterdescription" class="form-control mt-1 block w-full" placeholder="Escreva a descrição que aparecerá nos buscadores" v-model="form.twitterdescription" name="twitterdescription" autocomplete></textarea>
                     <JetInputError for="twitterdescription" class="mt-2" />
                </div>
            </div>
        </div>
        </div>
		
        <div class="card card-body shadow-sm mt-4 mb-3">
        <div class="card-header boder-0 mb-2">Facebook, Instagram, Whatsapp, Viber, Telegram and outhers</div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                     <JetLabel for="ogtype" value="og:type" />
                     <JetSelect id="ogtype" class="form-control mt-1 block w-full" placeholder="ogtype" v-model="form.ogtype" name="ogtype" autocomplete="ogtype">
					 <option value="website">website </option>
					 <option value="article">article </option>
					 <option value="book">book </option>
					 <option value="profile">profile </option>
					 <option value="video">video </option>
					 <option value="music">music </option>
					 </JetSelect>
                     <JetInputError for="ogtype" class="mt-2" />
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-8">
                <div class="form-group">
                     <JetLabel for="ogtitle" value="og:title" />
                     <JetInput id="ogtitle" type="text" class="form-control mt-1 block w-full" placeholder="ogtitle" v-model="form.ogtitle" name="ogtitle" autocomplete="ogtitle" />
                     <JetInputError for="ogtitle" class="mt-2" />
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                     <JetLabel for="ogurl" value="og:url" />
                     <JetInput id="ogurl" type="url" class="form-control mt-1 block w-full" placeholder="ogurl" v-model="form.ogurl" name="ogurl" autocomplete="ogurl" />
                     <JetInputError for="ogurl" class="mt-2" />
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                     <JetLabel for="ogimage" value="og:image" />
                     <JetInput id="ogimage" type="url" class="form-control mt-1 block w-full" placeholder="ogimage" v-model="form.ogimage" name="ogimage" autocomplete="ogimage" />
                     <JetInputError for="ogimage" class="mt-2" />
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                     <JetLabel for="fbapp_id" value="fb:app_id" />
                     <JetInput id="fbapp_id" type="text" class="form-control mt-1 block w-full" placeholder="fbapp_id" v-model="form.fbapp_id" name="fbapp_id" autocomplete="fbapp_id" />
                     <JetInputError for="fbapp_id" class="mt-2" />
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                     <JetLabel for="ogdescription" value="og:description" />
                     <textarea id="ogdescription" class="form-control mt-1 block w-full" placeholder="Escreva a descrição que aparecerá nos buscadores" v-model="form.ogdescription" name="ogdescription" autocomplete></textarea>
                     <JetInputError for="ogdescription" class="mt-2" />
                </div>
            </div>
        </div>
        </div>
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <JetButton type="submit" class="btn btn-primary" title="Atualizar" aria-label="Atualizar" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Atualizar</JetButton>
            </div>
      </form>

</AppLayout>
</template>

