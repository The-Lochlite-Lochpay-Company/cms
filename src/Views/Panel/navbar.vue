<script setup>
import { ref } from 'vue';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import JetActionMessage from 'lochlitecms/Views/Components/Layouts//ActionMessage.vue';
import JetButton from 'lochlitecms/Views/Components/Layouts//Button.vue';
import JetInput from 'lochlitecms/Views/Components/Layouts//Input.vue';
import JetCheckbox from 'lochlitecms/Views/Components/Layouts//Checkbox.vue';
import JetLabel from 'lochlitecms/Views/Components/Layouts//Label.vue';
import JetValidationErrors from 'lochlitecms/Views/Components/Layouts//ValidationErrors.vue';
import {mask, TheMask}  from 'vue-the-mask'

const props = defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    status: String,
    avatar: String,
    menulang: Object,
    user: Object,
    name: String,
    email: String,
    message: String,
});

const form = useForm({
    name: '',
    email: '',
    message: '',
});

const submit = () => {
    form.transform(data => ({
        ...data,
        remember: form.remember ? 'on' : '',
    })).post(route('sendcontact'), {
        onFinish: () => form.reset('email'),
    });
};

const formlang = useForm({language: props.menulang.current});
const submitlang = (event) => {
    formlang.language = event.submitter.dataset.lang;
    formlang.put(route('managersettings.update', {id: 'lang'}));
};

const logout = () => {
    useForm().post(route('logout'));
};

const getOrigin = () => {
   return window.origin;
}
</script>

<template>
     <nav class="navbar default-layout col-lg-12 col-12 w-100 p-0 fixed-top d-flex flex-row" style="height:60px">
       <div class="text-center navbar-brand-wrapper d-flex align-items-top justify-content-center">
         <a class="navbar-brand brand-logo text-dark" href="route('managerdashboard.index')">
           Lochlite  </a>
         <Link class="brand-logo-mini align-self-center text-dark px-3 h1" :href="route('managerdashboard.index')">
           <img class="w-full h-full w-100 h-100" :src="getOrigin() + '/application/72x72.png'"> </Link>
       </div>
       <div class="navbar-menu-wrapper bg-dark d-flex align-items-center justify-content-end">
         <button class="navbar-toggler navbar-toggler align-self-cente active" type="button" data-toggle="minimize">
           <span class="mdi mdi-menu"></span>
         </button>
         <ul class="navbar-nav navbar-nav-left header-links">
           <li class="nav-item d-none d-lg-flex">
             <Link :href="route('managercontacts.index')" class="nav-link">
               <i class="mdi mdi-face-agent"></i>Contatos</Link>
           </li>
           <li class="nav-item d-none d-lg-flex">
             <Link :href="route('managerfeedbacks.index')" class="nav-link">
               <i class="mdi mdi-message-draw"></i>Feedbacks</Link>
           </li>
           <li class="nav-item d-none d-md-flex">
             <Link :href="route('managerscheduling.index')" class="nav-link">
               <i class="mdi mdi-calendar-clock"></i>Agendamentos</Link>
           </li>
           <li class="nav-item d-none d-lg-flex">
             <Link :href="route('managerscheduling.index')" class="nav-link">
               <i class="mdi mdi-plus"></i>
			 </Link>
           </li>
         </ul>
         <ul class="navbar-nav navbar-nav-right">
           <li class="nav-item dropdown">
             <Link class="nav-link" :href="route('managersearch.index')">
               <i class="mdi mdi-magnify"></i>
             </Link>
           </li>
           <li class="nav-item dropdown">
             <Link class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" :href="route('managernotifications.index')">
               <i class="mdi mdi-bell-outline"></i>
               <span class="count bg-success">0</span>
             </Link>
           </li>
           <li class="nav-item dropdown">
             <a class="nav-link count-indicator dropdown-toggle" id="langDropdown" href="#langDropdown" data-bs-toggle="dropdown" aria-expanded="false">
               <i class="mdi mdi-web"></i>
               <span class="fw-bold font-bold ms-1 ml-1">{{ menulang.current ?? 'pt_BR' }}</span>
             </a>
             <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="langDropdown">
             <div class="card card-body">
			     <form @submit.prevent="submitlang" v-for="(row, index) in menulang.items" :id="'lang-' + index">
                 <button type="submit" :data-lang="row.code" class="btn btn-outline-light text-dark" :class="{active: row.active}">{{ row.name }}</button>
                 </form>
             </div>
             </div>
           </li>
           <li class="nav-item dropdown d-none d-xl-inline-block">
             <a class="nav-link d-flex" id="UserDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
               <span class="d-inlie-block profile-text d-none d-md-inline-flex align-self-center text-truncate overflow-none" style="max-width:125px !important;">{{name}}</span>
               <img class="d-inlie-block img-xs rounded-circle align-self-center" :src="avatar" alt="Profile image">
               <svg class="d-inlie-block w-4 h-4 ml-2 align-self-center" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
     		</a>
             <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
             <div class="card card-body">
               <form @submit.prevent="logout">
               <button type="submit" class="btn btn-outline-light text-dark"> Logout </button>
               </form>
             </div>
             </div>
           </li>
         </ul>
         <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
           <span class="mdi mdi-menu icon-menu"></span>
         </button>
       </div>
     </nav>
</template>
