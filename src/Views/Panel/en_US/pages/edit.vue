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
import MylochiTinyEditor from  'lochlitecms/Views/Components/MylochiTinyEditor.vue';
import DOMPurify from 'dompurify';

const props = defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    title: String,
    status: String,
    name: String,
    role: String,
    avatar: String,
    version: String,
    page: Object,
    pagebody: Object,
    breadcrumbCurrentSection: String,
    breadcrumbCurrentTitle: String,
    menulang: Object,
    menuitems: Object,
});
const form = useForm({
    title: props.page.title,
    keywords: props.page.keywords,
    welcome: props.page.welcome,
    description: props.page.description,
    body: props.pagebody.body,
});
const submit = (event) => {
    form.body = Base64.encode(DOMPurify.sanitize(tinymce.activeEditor.getContent() || '<p><br><br></p>'));
    form.transform(data => ({
        ...data,
    })).put(route('managerpages.update', {id: event.submitter.dataset.page}), {
        onFinish: () => form.reset(),
    });
};
</script>

<template>
<AppLayout :menulang="menulang" :menuitems="menuitems" :avatar="avatar" :role="role" :name="name" :version="version" :breadcrumbCurrentTitle="breadcrumbCurrentTitle" :breadcrumbCurrentSection="breadcrumbCurrentSection" :title="title">
        <template #breadcrumb>
              <li class="breadcrumb-item active" aria-current="page">Editing</li>
        </template>
        <JetValidationErrors class="mb-4" />
        <form @submit.prevent="submit">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                     <JetLabel for="title" value="Title" />
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
                     <JetLabel for="welcome" value="Main page" />
                     <select id="welcome" class="form-select p-1 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm w-full" v-model="form.welcome" name="welcome">
					 <option value="0" :selected="page.welcome == 0">False</option>
					 <option value="1" :selected="page.welcome == 1">True</option>
					 </select>
                     <JetInputError for="welcome" class="mt-2" />
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                     <JetLabel for="description" value="Page summary" />
                     <textarea id="description" class="form-control mt-1 block w-full" placeholder="Escreva a descrição que aparecerá nos buscadores" v-model="form.description" name="description" autocomplete></textarea>
                     <JetInputError for="description" class="mt-2" />
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 mb-3 rowcolumneditor">
             <MylochiTinyEditor data-type="edit" placeholder="Escreva aqui o conteúdo da pagina" v-model="form.body" name="body" id="mylochi-tiny" :data-body="pagebody.body"></MylochiTinyEditor>
	        </div>
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <JetButton type="submit" class="btn btn-primary" title="Publish" aria-label="Publish" :data-page="page.id" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Publish</JetButton>
            </div>
        </div>
      </form>

</AppLayout>
</template>
