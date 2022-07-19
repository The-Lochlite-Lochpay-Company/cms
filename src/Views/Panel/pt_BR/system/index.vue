<script setup>
import { ref } from 'vue';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import JetDialogModal from 'lochlitecms/Views/Components/Layouts/DialogModal.vue';
import JetButton from 'lochlitecms/Views/Components/Layouts/Button.vue';
import JetValidationErrors from 'lochlitecms/Views/Components/Layouts/ValidationErrors.vue';
import AppLayout from 'lochlitecms/Views/Panel/AppLayout.vue';

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
    license: String,
    framework: Number,
    host: String,
    langplatform: Number,
    extensions: Object,
    mysql: Number,
    server: String,
});
const form = useForm();
const submit = (event) => {
    form.delete(route('managerposts.destroy', {id: event.submitter.dataset.post}));
};
</script>

<template>
<AppLayout :menulang="menulang" :menuitems="menuitems" :avatar="avatar" :role="role" :name="name" :version="version" :breadcrumbCurrentTitle="breadcrumbCurrentTitle" :breadcrumbCurrentSection="breadcrumbCurrentSection" :title="title">
      <div class="row mb-3">
      <div class="col"><img src="/application/lochlite.png"></div>
      <div class="col">
      <div class="">Framework: Laravel V{{ framework }}</div>
      <div class="">Lochlite CMS: {{ version }}</div>
      <div class="">License key: {{ license }}</div>
      <p><a href="https://lochlite.com" class="fw-bold font-bold text-primary">Requisitos técnicos do software</a></p>
      <p><a href="https://lochlite.com" class="fw-bold font-bold text-primary">Manual de uso do software</a></p>
      <p><a href="https://lochlite.com" class="fw-bold font-bold text-primary">Termo de licença de software</a></p>
	  </div>
	  </div>
      <div class="">Server: {{ server }}</div>
      <div class="">Server Host: {{ host }}</div>
      <div class="">PHP Version: {{ langplatform }}</div>
      <div class="">MySQL: {{ mysql }}</div>
        <div class="table-responsive overflow-auto h-25 mt-3">
            <table class="table overflow-auto h-25">
                <thead>
                    <tr>
                        <th>Extension</th>
                        <th>Version</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(row, index)  in extensions" :key="row.id">
                        <td>{{ index }}</td>
                        <td>{{ row }}</td>
                    </tr>
				 </tbody>
            </table>
        </div>
</AppLayout>
</template>

