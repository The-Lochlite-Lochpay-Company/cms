<script setup>
import { ref } from 'vue';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import JetDialogModal from 'lochlitecms/Views/Components/Layouts/DialogModal.vue';
import JetActionMessage from 'lochlitecms/Views/Components/Layouts/ActionMessage.vue';
import JetButton from 'lochlitecms/Views/Components/Layouts/Button.vue';
import JetInput from 'lochlitecms/Views/Components/Layouts/Input.vue';
import JetInputError from 'lochlitecms/Views/Components/Layouts/InputError.vue';
import JetCheckbox from 'lochlitecms/Views/Components/Layouts/Checkbox.vue';
import JetLabel from 'lochlitecms/Views/Components/Layouts/Label.vue';
import JetSelect from 'lochlitecms/Views/Components/Layouts/Select.vue';
import JetValidationErrors from 'lochlitecms/Views/Components/Layouts/ValidationErrors.vue';
import AppLayout from 'lochlitecms/Views/Panel/AppLayout.vue';
import MylochiTinyEditor from  'lochlitecms/Views/Components/MylochiTinyEditor.vue';
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
    default: 0,
    logo: window.location.origin + '/application/72x72.png',
    image: 'https://source.unsplash.com/user/erondu/1600x900',
    imagevisible: 1,
    emphasis: 'Forgot your password? No problem.',
    instruction: 'Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.',
    title: 'Forgot Password',
    description: 'Forgot your password? No problem.',
    logintext: 'Did you remember your password?',
    buttontext: 'EMAIL PASSWORD RESET LINK',
    buttoncolor: 'bg-blue-600',
    buttontextcolor: 'text-white',
});
const submit = () => {
    form.post(route('managerrecoverypassword.store'));
};
</script>

<template>
<AppLayout :menulang="menulang" :menuitems="menuitems" :avatar="avatar" :role="role" :name="name" :version="version" :breadcrumbCurrentTitle="breadcrumbCurrentTitle" :breadcrumbCurrentSection="breadcrumbCurrentSection" :title="title">
        <template #breadcrumb>
              <li class="breadcrumb-item active" aria-current="page">Nova página de recuperação de senha</li>
        </template>
        <JetValidationErrors class="mb-4" />

        <form @submit.prevent="submit">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="form-group">
                     <JetLabel for="domain" value="Domain" />
                     <JetInput id="domain" type="text" class="form-control mt-1 block w-full" placeholder="https://domain.com" v-model="form.domain" name="domain" autocomplete="domain" autofocus required />
                     <JetInputError for="domain" class="mt-2" />
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="form-group">
                     <JetLabel for="default" value="Default" />
                     <JetSelect id="default" class="form-control mt-1 block w-full" placeholder="Default" v-model="form.default" name="default" autocomplete required>
					 <option value="0">False</option>
					 <option value="1">True</option>
					 </JetSelect>
                     <JetInputError for="default" class="mt-2" />
                </div>
            </div>
            <div class="col-12 card border-0 shadow-none">
            <div class="card-header">SEO</div>
            <div class="card-body">
            <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="form-group">
                     <JetLabel for="title" value="Title" />
                     <JetInput id="title" type="text" class="form-control mt-1 block w-full" placeholder="Title" v-model="form.title" name="title" autocomplete="title" />
                     <JetInputError for="title" class="mt-2" />
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="form-group">
                     <JetLabel for="description" value="Description" />
                     <input id="description" class="form-control mt-1 block w-full" placeholder="Escreva a descrição que aparecerá nos buscadores" v-model="form.description" name="description" autocomplete required>
                     <JetInputError for="description" class="mt-2" />
                </div>
            </div>
            </div>
            </div>
            </div>
            <div class="col-12 card border-0 shadow-none">
            <div class="card-header">Image</div>
            <div class="card-body">
            <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="form-group">
                     <JetLabel for="image" value="Image URL" />
                     <JetInput id="image" type="url" class="form-control mt-1 block w-full" placeholder="https://exemple.com/image.png" v-model="form.image" name="image" autocomplete="image" required />
                     <JetInputError for="image" class="mt-2" />
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="form-group">
                     <JetLabel for="imagevisible" value="Image visible" />
                     <JetSelect id="imagevisible" class="form-control mt-1 block w-full" placeholder="imagevisible" v-model="form.imagevisible" name="imagevisible" autocomplete required>
					 <option value="0">False</option>
					 <option value="1">True</option>
					 </JetSelect>
                     <JetInputError for="imagevisible" class="mt-2" />
                </div>
            </div>
            </div>
            </div>
            </div>
            <div class="col-12 card border-0 shadow-none">
            <div class="card-header">Details</div>
            <div class="card-body">
            <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                     <JetLabel for="logo" value="Logo" />
                     <JetInput id="logo" type="url" class="form-control mt-1 block w-full" placeholder="https://exemple.com/image.png" v-model="form.logo" name="logo" autocomplete="logo" required />
                     <JetInputError for="logo" class="mt-2" />
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                     <JetLabel for="emphasis" value="Emphasis" />
                     <JetInput id="emphasis" type="text" class="form-control mt-1 block w-full" placeholder="Emphasis" v-model="form.emphasis" name="emphasis" autocomplete="emphasis" required />
                     <JetInputError for="emphasis" class="mt-2" />
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                     <JetLabel for="instruction" value="instruction" />
                     <JetInput id="instruction" type="text" class="form-control mt-1 block w-full" placeholder="instruction" v-model="form.instruction" name="instruction" autocomplete="instruction" required />
                     <JetInputError for="instruction" class="mt-2" />
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                     <JetLabel for="logintext" value="Login text" />
                     <input id="logintext" class="form-control mt-1 block w-full" placeholder="Login text" v-model="form.logintext" name="logintext" autocomplete required>
                     <JetInputError for="logintext" class="mt-2" />
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                     <JetLabel for="buttontext" value="Button text" />
                     <input id="buttontext" class="form-control mt-1 block w-full" placeholder="Button text" v-model="form.buttontext" name="buttontext" autocomplete required>
                     <JetInputError for="buttontext" class="mt-2" />
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                     <JetLabel for="buttoncolor" value="Button color" />
                     <JetSelect id="buttoncolor" class="form-control mt-1 block w-full" placeholder="Button color" v-model="form.buttoncolor" name="buttoncolor" autocomplete required>
					 <option value="bg-blue-600">Default</option>
					 <option value="btn-primary">Blue</option>
					 <option value="btn-info">Light blue</option>
					 <option value="btn-light">Light</option>
					 <option value="btn-danger">Red</option>
					 <option value="btn-warning">Yellow</option>
					 <option value="btn-dark">Black</option>
					 </JetSelect>
                     <JetInputError for="buttoncolor" class="mt-2" />
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                     <JetLabel for="buttontextcolor" value="Button Text Color" />
                     <JetSelect id="buttontextcolor" class="form-control mt-1 block w-full" placeholder="Button text color" v-model="form.buttontextcolor" name="buttontextcolor" autocomplete required>
					 <option value="text-white">White</option>
					 <option value="text-primary">Blue</option>
					 <option value="text-info">Light blue</option>
					 <option value="text-light">Light</option>
					 <option value="text-danger">Red</option>
					 <option value="text-warning">Yellow</option>
					 <option value="text-dark">Black</option>
					 </JetSelect>
                     <JetInputError for="buttoncolor" class="mt-2" />
                </div>
            </div>
            </div>
            </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <JetButton type="submit" class="btn btn-primary" title="Adicionar" aria-label="Adicionar" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Adicionar</JetButton>
            </div>
        </div>
      </form>

</AppLayout>
</template>
