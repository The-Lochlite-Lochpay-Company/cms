<script setup>
import { onMounted, ref, reactive } from 'vue';
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
import tagify from '@yaireo/tagify'
import Tags from '@yaireo/tagify/dist/tagify.vue'
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
    models: Object,
    breadcrumbCurrentTitle: String,
    breadcrumbCurrentSection: String,
    menulang: Object,
    menuitems: Object,
});
let emaillists;
const form = useForm({
    emails: emaillists,
    model: '',
});
const submit = () => {
    form.emails = emaillists;
    form.transform(data => ({
        ...data,
    })).post(route('manageremails.store'));
};
function onChange(e){
  emaillists = e.target.value;
}
</script>


<template>
<AppLayout :menulang="menulang" :menuitems="menuitems" :avatar="avatar" :role="role" :name="name" :version="version" :breadcrumbCurrentTitle="breadcrumbCurrentTitle" :breadcrumbCurrentSection="breadcrumbCurrentSection" :title="title">
        <template #breadcrumb>
              <li class="breadcrumb-item active" aria-current="page">Enviar novo email</li>
        </template>
        <JetValidationErrors class="mb-4" />

        <form @submit.prevent="submit">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                     <JetLabel for="email" value="Destinatários" />
                     <Tags id="email" type="email" class="form-control w-auto h-auto" placeholder="Email" v-model="form.emails" name="emails" autocomplete="email" :settings="{ originalInputValueFormat: valuesArr => valuesArr.map(item => item.value).join(',')}" :onChange="onChange" required />
                     <JetInputError for="email" class="mt-2" />
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                     <JetLabel for="email" value="Selecione um modelo" />
                     <select id="model" class="form-select p-1 w-full" v-model="form.model" name="model" autocomplete="model" required>
                     <option v-for="row in models" :value="row.id">{{ row.id }} - {{ row.subject }}</option>
					 </select>
                     <JetInputError for="email" class="mt-2" />
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <JetButton type="submit" class="btn btn-primary" title="Cadastrar" aria-label="Cadastrar" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Enviar</JetButton>
            </div>
        </div>
      </form>

</AppLayout>
</template>
