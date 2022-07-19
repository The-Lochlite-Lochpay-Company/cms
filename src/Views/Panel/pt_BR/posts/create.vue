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
    image: '',
    description: '',
    body: '',
});
const submit = () => {
    form.body = Base64.encode(DOMPurify.sanitize(tinymce.activeEditor.getContent() || '<p><br><br></p>'));
    form.transform(data => ({
        ...data,
    })).post(route('managerposts.store'), {
        onFinish: () => form.reset(),
    });
};
</script>

<template>
<AppLayout :menulang="menulang" :menuitems="menuitems" :avatar="avatar" :role="role" :name="name" :version="version" :breadcrumbCurrentTitle="breadcrumbCurrentTitle" :breadcrumbCurrentSection="breadcrumbCurrentSection" :title="title">
        <template #breadcrumb>
              <li class="breadcrumb-item active" aria-current="page">Criar</li>
        </template>
        <JetValidationErrors class="mb-4" />

        <form @submit.prevent="submit">
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
                     <JetLabel for="imagecap" value="Imagem de capa" />
                     <JetInput id="imagecap" type="url" class="form-control mt-1 block w-full" placeholder="htpps://exemple.com/image.png" v-model="form.image" name="image" autocomplete="imagecap" />
                     <JetInputError for="imagecap" class="mt-2" />
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                     <JetLabel for="description" value="Resumo do artigo" />
                     <textarea id="description" class="form-control mt-1 block w-full" placeholder="Escreva a descrição que aparecerá nos buscadores" v-model="form.description" name="description" autocomplete required></textarea>
                     <JetInputError for="description" class="mt-2" />
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 mb-3">
             <MylochiTinyEditor data-type="new" placeholder="Escreva aqui o conteúdo do artigo" v-model="form.body" name="body" id="mylochi-tiny"></MylochiTinyEditor>
	        </div>
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <JetButton type="submit" class="btn btn-primary" title="Cadastrar" aria-label="Cadastrar" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Cadastrar</JetButton>
            </div>
        </div>
      </form>

</AppLayout>
</template>
