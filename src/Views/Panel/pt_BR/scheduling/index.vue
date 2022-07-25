<script setup>
import { defineAsyncComponent, ref } from 'vue';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import JetDialogModal from 'lochlitecms/Views/Components/Layouts/DialogModal.vue';
import JetButton from 'lochlitecms/Views/Components/Layouts/Button.vue';
import JetValidationErrors from 'lochlitecms/Views/Components/Layouts/ValidationErrors.vue';
import AppLayout from 'lochlitecms/Views/Panel/AppLayout.vue';
import LoadingComponent from 'lochlitecms/Views/Components/LoadingComponent.vue';
import ErrorComponent from 'lochlitecms/Views/Components/ErrorComponent.vue';

const props = defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    title: String,
    status: String,
    name: String,
    role: String,
    avatar: String,
    version: String,
    event: Object,
    breadcrumbCurrentTitle: String,
    breadcrumbCurrentSection: String,
    menulang: Object,
    menuitems: Object,
});

const MylochiCalendar = defineAsyncComponent({
  loader: () => import("lochlitecms/Views/Components/MylochiCalendar.vue"),
  loadingComponent: LoadingComponent,
  errorComponent: ErrorComponent,
  delay: 500,
  timeout: 5000,
})

</script>

<template>
     <AppLayout :menulang="menulang" :menuitems="menuitems" :avatar="avatar" :role="role" :name="name" :version="version" :breadcrumbCurrentTitle="breadcrumbCurrentTitle" :breadcrumbCurrentSection="breadcrumbCurrentSection" :title="title">
     <template #breadcrumb></template>
     <template #modal>
	 <div class="font-bold mb-2">Cadastrar novo evento</div>
	 <form class="form-group" id="newevent">
	 <div class="mb-3">
     <label for="exampleFormControlInput1" class="form-label">Titulo</label>
     <input type="text" class="form-control" id="inputEventTitle" required />
     </div>
	 <div class="mb-3">
     <label for="exampleFormControlInput1" class="form-label">inicio</label>
	 <input type="datetime-local" class="form-control" id="inputEventStart" required />
     </div>
	 <div class="mb-3">
     <label for="exampleFormControlInput1" class="form-label">Termino</label>
	 <input type="datetime-local" class="form-control" id="inputEventEnd" required />
     </div>
	 <button type="submit" class="btn btn-primary bg-primary">Salvar</button>
     </form>
     </template>
     <mylochi-calendar></mylochi-calendar>
     </AppLayout>
</template> 
