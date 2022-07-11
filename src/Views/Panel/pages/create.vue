<script setup>
import { ref } from 'vue';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import JetDialogModal from '@/Jetstream/DialogModal.vue';
import JetButton from '@/Jetstream/Button.vue';
import JetInput from '@/Jetstream/Input.vue';
import JetInputError from '@/Jetstream/InputError.vue';
import JetCheckbox from '@/Jetstream/Checkbox.vue';
import JetLabel from '@/Jetstream/Label.vue';
import JetValidationErrors from '@/Jetstream/ValidationErrors.vue';
import AppLayout from '@/Pages/Panel/AppLayout.vue';
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
<AppLayout :menuitems="menuitems" :avatar="avatar" :role="role" :name="name" :version="version" :breadcrumbCurrentTitle="breadcrumbCurrentTitle" :breadcrumbCurrentSection="breadcrumbCurrentSection" :title="title">
        <template #breadcrumb>
              <li class="breadcrumb-item active" aria-current="page">Criar</li>
        </template>
        <JetValidationErrors class="mb-4" />

        <form @submit.prevent="submit">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                     <JetLabel for="title" value="Titulo" />
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
                     <JetLabel for="welcome" value="Pagína principal" />
                     <select id="welcome" class="form-select p-1 mt-1 block w-full" v-model="form.welcome" name="welcome">
					 <option value="0" selected>Falso</option>
					 <option value="1">Verdadeiro</option>
					 </select>
                     <JetInputError for="welcome" class="mt-2" />
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                     <JetLabel for="description" value="Resumo da pagina" />
                     <textarea id="description" class="form-control mt-1 block w-full rounded-0" placeholder="Escreva a descrição que aparecerá nos buscadores" v-model="form.description" name="description" autocomplete required></textarea>
                     <JetInputError for="description" class="mt-2" />
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 mb-3">
             <MylochiTinyEditor data-type="new" placeholder="Escreva aqui o conteúdo do artigo" v-model="form.body" name="body" id="mylochi-tiny"></MylochiTinyEditor>
	        </div>
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <JetButton type="submit" class="btn btn-primary" title="Publicar" aria-label="Publicar" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Publicar</JetButton>
            </div>
        </div>
      </form>

</AppLayout>
</template>
