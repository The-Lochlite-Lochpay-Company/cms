<script setup>
import { ref } from 'vue';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import JetDialogModal from 'lochlitecms/Views/Components/Layouts/DialogModal.vue';
import JetActionMessage from 'lochlitecms/Views/Components/Layouts/ActionMessage.vue';
import JetButton from 'lochlitecms/Views/Components/Layouts/Button.vue';
import JetSelect from 'lochlitecms/Views/Components/Layouts/Select.vue';
import JetInput from 'lochlitecms/Views/Components/Layouts/Input.vue';
import JetInputError from 'lochlitecms/Views/Components/Layouts/InputError.vue';
import JetCheckbox from 'lochlitecms/Views/Components/Layouts/Checkbox.vue';
import JetLabel from 'lochlitecms/Views/Components/Layouts/Label.vue';
import JetValidationErrors from 'lochlitecms/Views/Components/Layouts/ValidationErrors.vue';
import AppLayout from 'lochlitecms/Views/Panel/AppLayout.vue';
import MylochiTinyEditor from  '@/Components/MylochiTinyEditor.vue';
import DOMPurify from 'dompurify';

defineProps({
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
    menulang: Object,
    menuitems: Object,
});
const form = useForm({
         domain: window.location.origin,
         menuclass: '',
         menuid: 'mainmenu',
         name: 'main-menu',
         brand: 'My Company',
         brandtype: 'text',
         button1: 'Login',
         button1id: 'buttonlogin',
         button1class: '',
         button1route: window.location.origin + '/login',
         button1status: 'active',
         button2: 'Register',
         button2id: 'buttonregister',
         button2class: '',
         button2route: window.location.origin + '/register',
         button2status: 'active',
         facebook: '',
         twitter: '',
         linkedin: '',
         pinterest: '',
         instagram: '',
         tiktok: '',
         whatsapp: '',
         youtube: '',
         search: 0,
         searchroute: window.location.origin + '/search',
         stickytop: 1,
         itemscenter: 1,
         type: 'navbar',
         default: 0,
         status: 'active',
});
const submit = () => {
    form.post(route('managermainmenu.store'));
};
</script>

<template>
<AppLayout :menulang="menulang" :menuitems="menuitems" :avatar="avatar" :role="role" :name="name" :version="version" :breadcrumbCurrentTitle="breadcrumbCurrentTitle" :breadcrumbCurrentSection="breadcrumbCurrentSection" :title="title">
        <template #breadcrumb>
              <li class="breadcrumb-item active" aria-current="page">Criar menu</li>
        </template>
        <JetValidationErrors class="mb-4" />

        <form @submit.prevent="submit">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                     <JetLabel for="domain" value="Domain" />
                     <JetInput id="domain" type="text" class="form-control mt-1 block w-full" placeholder="https://domain.com" v-model="form.domain" name="domain" autocomplete="domain" required />
                     <JetInputError for="domain" class="mt-2" />
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                     <JetLabel for="default" value="Default" />
                     <JetSelect id="default" class="form-control mt-1 block w-full" placeholder="default" v-model="form.default" name="default" autocomplete="default" required>
					 <option value="0">False</option>
					 <option value="1">True</option>
					 </JetSelect>
                     <JetInputError for="default" class="mt-2" />
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                     <JetLabel for="status" value="Status" />
                     <JetSelect id="status" class="form-control mt-1 block w-full" placeholder="status" v-model="form.status" name="status" autocomplete="status" required>
					 <option value="active">Active</option>
					 <option value="disable">Disable</option>
					 </JetSelect>
                     <JetInputError for="status" class="mt-2" />
                </div>
            </div>			
            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                     <JetLabel for="name" value="Name" />
                     <JetInput id="name" type="text" class="form-control mt-1 block w-full" placeholder="name" v-model="form.name" name="name" autocomplete="name" required />
                     <JetInputError for="name" class="mt-2" />
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                     <JetLabel for="brand" value="Brand" />
                     <JetInput id="brand" type="text" class="form-control mt-1 block w-full" placeholder="brand" v-model="form.brand" name="brand" autocomplete="brand" required />
                     <JetInputError for="brand" class="mt-2" />
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                     <JetLabel for="brandtype" value="Brand Type" />
                     <JetSelect id="brandtype" class="form-control mt-1 block w-full" placeholder="brandtype" v-model="form.brandtype" name="brandtype" autocomplete="brandtype" required>
					 <option value="text">text</option>
					 <option value="image">Image</option>
					 </JetSelect>
                     <JetInputError for="brandtype" class="mt-2" />
                </div>
            </div>
			<div class="col-xs-12 col-sm-12 col-md-12 py-2 card card-body fw-bold font-bold text-dark bg-light w-full w-100 my-5">
			Buttons
			</div>
            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                     <JetLabel for="button1" value="Button 1 Text" />
                     <JetInput id="button1" type="text" class="form-control mt-1 block w-full" placeholder="Login" v-model="form.button1" name="button1" autocomplete="button1" />
                     <JetInputError for="button1" class="mt-2" />
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                     <JetLabel for="button1id" value="Button 1 ID" />
                     <JetInput id="button1id" type="text" class="form-control mt-1 block w-full" placeholder="button1id" v-model="form.button1id" name="button1id" autocomplete="button1id" />
                     <JetInputError for="button1id" class="mt-2" />
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                     <JetLabel for="button1class" value="Button 1 Class" />
                     <JetInput id="button1class" type="text" class="form-control mt-1 block w-full" placeholder="button1class" v-model="form.button1class" name="button1class" autocomplete="button1class" />
                     <JetInputError for="button1class" class="mt-2" />
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                     <JetLabel for="button1route" value="Button 1 Link" />
                     <JetInput id="button1route" type="url" class="form-control mt-1 block w-full" placeholder="https://domain.com" v-model="form.button1route" name="button1route" autocomplete="button1route" />
                     <JetInputError for="button1route" class="mt-2" />
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                     <JetLabel for="button1status" value="Button 1 Status" />
                     <JetSelect id="button1status" class="form-control mt-1 block w-full" placeholder="button1status" v-model="form.button1status" name="button1status" autocomplete="button1status">
					 <option value="active">Active</option>
					 <option value="disable">Disable</option>
					 </JetSelect>
                     <JetInputError for="button1status" class="mt-2" />
                </div>
            </div>			
            <div class="col-xs-12 col-sm-12 col-md-4"></div>
            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                     <JetLabel for="button2" value="Button 2 Text" />
                     <JetInput id="button2" type="text" class="form-control mt-1 block w-full" placeholder="Register" v-model="form.button2" name="button2" autocomplete="button2" />
                     <JetInputError for="button2" class="mt-2" />
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                     <JetLabel for="button2id" value="Button 2 ID" />
                     <JetInput id="button2id" type="text" class="form-control mt-1 block w-full" placeholder="button2id" v-model="form.button2id" name="button2id" autocomplete="button2id" />
                     <JetInputError for="button2id" class="mt-2" />
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                     <JetLabel for="button2class" value="Button 2 Class" />
                     <JetInput id="button2class" type="text" class="form-control mt-1 block w-full" placeholder="button2class" v-model="form.button2class" name="button2class" autocomplete="button2class" />
                     <JetInputError for="button2class" class="mt-2" />
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                     <JetLabel for="button2route" value="Button 2 Link" />
                     <JetInput id="button2route" type="url" class="form-control mt-1 block w-full" placeholder="https://domain.com" v-model="form.button2route" name="button2route" autocomplete="button2route" />
                     <JetInputError for="button2route" class="mt-2" />
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                     <JetLabel for="button2status" value="Button 2 Status" />
                     <JetSelect id="button2status" class="form-control mt-1 block w-full" placeholder="button2status" v-model="form.button2status" name="button2status" autocomplete="button2status">
					 <option value="active">Active</option>
					 <option value="disable">Disable</option>
					 </JetSelect>
                     <JetInputError for="button2status" class="mt-2" />
                </div>
            </div>			
			<div class="col-xs-12 col-sm-12 col-md-12 py-2 card card-body fw-bold font-bold text-dark bg-light w-full w-100 my-5">
			Social Network
			</div>
            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                     <JetLabel for="facebook" value="Facebook" />
                     <JetInput id="facebook" type="text" class="form-control mt-1 block w-full" placeholder="https://facebook.com" v-model="form.facebook" name="facebook" autocomplete="facebook" />
                     <JetInputError for="facebook" class="mt-2" />
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                     <JetLabel for="twitter" value="Twitter" />
                     <JetInput id="twitter" type="text" class="form-control mt-1 block w-full" placeholder="https://twitter.com" v-model="form.twitter" name="twitter" autocomplete="twitter" />
                     <JetInputError for="twitter" class="mt-2" />
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                     <JetLabel for="linkedin" value="Linkedin" />
                     <JetInput id="linkedin" type="text" class="form-control mt-1 block w-full" placeholder="https://linkedin.com" v-model="form.linkedin" name="linkedin" autocomplete="linkedin" />
                     <JetInputError for="linkedin" class="mt-2" />
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                     <JetLabel for="pinterest" value="Pinterest" />
                     <JetInput id="pinterest" type="text" class="form-control mt-1 block w-full" placeholder="https://pinterest.com" v-model="form.pinterest" name="pinterest" autocomplete="pinterest" />
                     <JetInputError for="pinterest" class="mt-2" />
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                     <JetLabel for="instagram" value="Instagram" />
                     <JetInput id="instagram" type="text" class="form-control mt-1 block w-full" placeholder="https://instagram.com" v-model="form.instagram" name="instagram" autocomplete="instagram" />
                     <JetInputError for="instagram" class="mt-2" />
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                     <JetLabel for="tiktok" value="Tiktok" />
                     <JetInput id="tiktok" type="text" class="form-control mt-1 block w-full" placeholder="https://tiktok.com" v-model="form.tiktok" name="tiktok" autocomplete="tiktok" />
                     <JetInputError for="tiktok" class="mt-2" />
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                     <JetLabel for="whatsapp" value="Whatsapp" />
                     <JetInput id="whatsapp" type="text" class="form-control mt-1 block w-full" placeholder="https://whatsapp.com" v-model="form.whatsapp" name="whatsapp" autocomplete="whatsapp" />
                     <JetInputError for="whatsapp" class="mt-2" />
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                     <JetLabel for="youtube" value="Youtube" />
                     <JetInput id="youtube" type="text" class="form-control mt-1 block w-full" placeholder="https://youtube.com" v-model="form.youtube" name="youtube" autocomplete="youtube" />
                     <JetInputError for="youtube" class="mt-2" />
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4"></div>
			<div class="col-xs-12 col-sm-12 col-md-12 py-2 card card-body fw-bold font-bold text-dark bg-light w-full w-100 my-5">
			Advanced options
			</div>
            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                     <JetLabel for="search" value="Search" />
                     <JetSelect id="search" class="form-control mt-1 block w-full" placeholder="search" v-model="form.search" name="search" autocomplete="search" required>
					 <option value="0">False</option>
					 <option value="1">True</option>
					 </JetSelect>
                     <JetInputError for="search" class="mt-2" />
                </div>
            </div>			
            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                     <JetLabel for="searchroute" value="Search URL Callback" />
                     <JetInput id="searchroute" type="url" class="form-control mt-1 block w-full" placeholder="https://domain.com/search" v-model="form.searchroute" name="searchroute" autocomplete="searchroute" required />
                     <JetInputError for="searchroute" class="mt-2" />
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                     <JetLabel for="menuclass" value="Menu Class" />
                     <JetInput id="menuclass" type="text" class="form-control mt-1 block w-full" placeholder="menuclass" v-model="form.menuclass" name="menuclass" autocomplete="menuclass" required />
                     <JetInputError for="menuclass" class="mt-2" />
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                     <JetLabel for="menuid" value="Menu ID" />
                     <JetInput id="menuid" type="text" class="form-control mt-1 block w-full" placeholder="menuid" v-model="form.menuid" name="menuid" autocomplete="menuid" required />
                     <JetInputError for="menuid" class="mt-2" />
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                     <JetLabel for="type" value="Type" />
                     <JetSelect id="type" class="form-control mt-1 block w-full" placeholder="type" v-model="form.type" name="type" autocomplete="type" required>
					 <option value="navbar">Navbar</option>
					 </JetSelect>
                     <JetInputError for="type" class="mt-2" />
                </div>
            </div>			
            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                     <JetLabel for="stickytop" value="Sticky Top" />
                     <JetSelect id="stickytop" class="form-control mt-1 block w-full" placeholder="stickytop" v-model="form.stickytop" name="stickytop" autocomplete="stickytop" required>
					 <option value="0">False</option>
					 <option value="1">True</option>
					 </JetSelect>
                     <JetInputError for="stickytop" class="mt-2" />
                </div>
            </div>			
			
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <JetButton type="submit" class="btn btn-primary" title="Adicionar" aria-label="Adicionar" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Adicionar</JetButton>
            </div>
        </div>
      </form>

</AppLayout>
</template>
