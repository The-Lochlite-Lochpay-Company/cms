<script setup>
import { ref } from 'vue';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import JetDialogModal from 'lochlitecms/Views/Components/Layouts/DialogModal.vue';
import JetButton from 'lochlitecms/Views/Components/Layouts/Button.vue';
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
    title: '',
    keywords: '',
    welcome: '',
    description: '',
    body: '',
});
const submit = () => {
    form.body = Base64.btoa(tinymce.activeEditor.getContent() || '<p><br><br></p>');
    form.transform(data => ({
        ...data,
    })).post(route('managerpages.store'), {
        onFinish: () => form.reset(),
    });
};
</script>

<template>
<AppLayout :menulang="menulang" :menuitems="menuitems" :avatar="avatar" :role="role" :name="name" :version="version" :breadcrumbCurrentTitle="breadcrumbCurrentTitle" :breadcrumbCurrentSection="breadcrumbCurrentSection" :title="title">
        <template #breadcrumb>
              <li class="breadcrumb-item active" aria-current="page">Create</li>
        </template>
        <JetValidationErrors class="mb-4" />

        <form @submit.prevent="submit">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                     <JetLabel for="title" value="Title" />
                     <JetInput id="title" type="text" class="form-control mt-1 block w-full rounded-0" placeholder="title" v-model="form.title" name="title" autocomplete="title" required />
                     <JetInputError for="title" class="mt-2" />
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                     <JetLabel for="keywords" value="Keywords" />
                     <JetInput id="keywords" type="text" class="form-control mt-1 block w-full rounded-0" placeholder="Keywords" v-model="form.keywords" name="keywords" autocomplete="keywords" />
                     <JetInputError for="keywords" class="mt-2" />
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                     <JetLabel for="welcome" value="Main page" />
                     <select id="welcome" class="form-select p-1 mt-1 block w-full" v-model="form.welcome" name="welcome">
					 <option value="0" selected>False</option>
					 <option value="1">True</option>
					 </select>
                     <JetInputError for="welcome" class="mt-2" />
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                     <JetLabel for="description" value="Page summary" />
                     <textarea id="description" class="form-control mt-1 block w-full rounded-0" placeholder="Write the description that will appear in search engines" v-model="form.description" name="description" autocomplete required></textarea>
                     <JetInputError for="description" class="mt-2" />
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 mb-3">
             <MylochiTinyEditor data-type="new" placeholder="Escreva aqui o conteúdo do artigo" v-model="form.body" name="body" id="mylochi-tiny"></MylochiTinyEditor>
	        </div>
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <JetButton type="submit" class="btn btn-primary" title="Publish" aria-label="Publish" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Publish</JetButton>
            </div>
        </div>
      </form>

</AppLayout>
</template>
