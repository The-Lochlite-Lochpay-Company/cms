<script setup>
import { ref } from 'vue';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import JetDialogModal from '@/Jetstream/DialogModal.vue';
import JetButton from '@/Jetstream/Button.vue';
import JetValidationErrors from '@/Jetstream/ValidationErrors.vue';
import AppLayout from '@/Pages/Panel/AppLayout.vue';

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    title: String,
    status: String,
    name: String,
    role: String,
    avatar: String,
    version: String,
    disk: Number,
    diskfreespace: Number,
    users: Number,
    plugins: Number,
    settings: Number,
    breadcrumbCurrentTitle: String,
    breadcrumbCurrentSection: String,
    menuitems: Object,
});
const form = useForm();
const submit = (event) => {
    form.delete(route('managerusers.destroy', {id: event.submitter.dataset.user}));
};
</script>

<template>
<AppLayout :menuitems="menuitems" :avatar="avatar" :role="role" :name="name" :version="version" :breadcrumbCurrentTitle="breadcrumbCurrentTitle" :breadcrumbCurrentSection="breadcrumbCurrentSection" :title="title">

     <div class="row px-3">
     <div class="col">
     <div class="card shadow-none my-2">
     <div class="row">
         <div class="col-3 py-1 text-center mx-auto align-self-center border-0 bg-primary">
         <i class="fa-solid fa-compact-disc h3 align-self-center text-white"></i>
         </div>   
         <div class="col-9 py-1 px-4 align-self-center border-0 bg-transparent">
         <div class="fw-bold font-bold pt-3 align-self-center">Espaço em disco</div>
		 <p>{{ diskfreespace }}/{{ disk }}</p>
         </div>   
     </div>
     </div>
     </div>
	 
     <div class="col">
     <div class="card shadow-none my-2">
     <div class="row">
         <div class="col-3 py-1 text-center mx-auto align-self-center border-0 bg-warning">
         <i class="fa-solid fa-users h3 align-self-center text-white"></i>
         </div>   
         <div class="col-9 py-1 px-4 align-self-center border-0 bg-transparent">
         <div class="fw-bold font-bold pt-3 mt-1 align-self-center">Total de usuários</div>
		 <p>{{ users }}</p>
         </div>   
     </div>
     </div>
     </div>
     <div class="col">
     <div class="card shadow-none my-2">
     <div class="row">
         <div class="col-3 py-1 text-center mx-auto align-self-center border-0 bg-success">
         <i class="fa-solid fa-plug-circle-check h3 align-self-center text-white"></i>
         </div>   
         <div class="col-9 py-1 px-4 align-self-center border-0 bg-transparent">
         <div class="fw-bold font-bold pt-3 mt-1 align-self-center">Plugins ativos</div>
		 <p>{{ plugins }}</p>
         </div>   
     </div>
     </div>
     </div>
     <div class="col">
     <div class="card shadow-none my-2">
     <div class="row">
         <div class="col-3 py-1 text-center mx-auto align-self-center border-0 bg-danger">
         <i class="fa-solid fa-globe h3 align-self-center text-white"></i>
         </div>   
         <div class="col-9 py-1 px-4 align-self-center border-0 bg-transparent">
         <div class="fw-bold font-bold pt-3 mt-1 align-self-center">Dominios ativos</div>
		 <p>{{ settings }}</p>
         </div>   
     </div>
     </div>
     </div>

     </div>

     <div class="row row-cols-1 row-cols-md-4 w-full w-100">
     <div class="col">
     <Link :href="route('managerstorange.index')" class="card text-center bg-light shadow-none my-2 ">
         <div class="card-header border-0 bg-transparent">
         <i class="fa-solid fa-cloud h3"></i>
         </div>   
         <div class="card-body border-0 bg-transparent">
         Armanezamento
         </div>   
     </Link>
     </div>
	 
     <div class="col">
     <Link :href="route('manageremails.index')" class="card text-center bg-light shadow-none my-2 ">
         <div class="card-header border-0 bg-transparent">
         <i class="fa-solid fa-envelope h3"></i>
         </div>   
         <div class="card-body border-0 bg-transparent">
         Emails
         </div>   
     </Link>   
     </div>   

     <div class="col">
     <Link :href="route('managerusers.index')" class="card text-center bg-light shadow-none my-2">
         <div class="card-header border-0 bg-transparent">
         <i class="fa-solid fa-people-group h3"></i>
         </div>   
         <div class="card-body border-0 bg-transparent">
         Usuários
         </div>   
     </Link>   
     </div>   

     <div class="col">
     <Link :href="route('managersettings.index')" class="card text-center bg-light shadow-none my-2">
         <div class="card-header border-0 bg-transparent">
         <i class="fa-solid fa-gears h3"></i>
         </div>   
         <div class="card-body border-0 bg-transparent">
         Configurações
         </div>   
     </Link>   
     </div>   
     </div>   
 
</AppLayout>
</template>