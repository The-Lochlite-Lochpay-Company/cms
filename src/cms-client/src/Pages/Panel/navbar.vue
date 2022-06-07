<script setup>
/**
* The Lochlite & Lochpay Company - Technology that makes people's lives easier
*
* (c) 2019 - 2022 LOCHLITE E LOCHPAY SOFTWARES E PAGAMENTOS LTDA., All Right Reserved.
*
* Software: LOCHLITE CMS
* Version: 2.0.7  
* License: Proprietary
* Made in: Brazil
* Author: The Lochlite & Lochpay Company
* Developer: IGOR MACEDO MONTALVÃO
* Website: https://lochlite.com | https://lochpay.com | https://gpgic.com 
* Support: drcg@gpgic.com | drcg@lochlite.com | drcl@lochlite.com
*
* LEGAL NOTICE: The author(s) of the software grants the user of the software a personal, non-transferable, limited and revocable license without the right to market, resell, distribute, clone or recycle the software; The author(s) reserve the right to renew, revoke or modify the license, as well as impose fines for its violation at its most reasonable discretion.
*
* DISCLAIMER: The author(s) of the Software will not be responsible for any physical, moral, property damages or of any nature due to the software, its enjoyment or risks up to the limits of the legislation in force in Brazil.
*
* ('Art. 43 - LEI No 4.502/1964' - law of brazil) Indústria Brasileira - LOCHLITE E LOCHPAY SOFTWARES E PAGAMENTOS LTDA, CNPJ: 37.816.728/0001-04; Address: SCS QUADRA 9, BLOCO C, 10 ANDAR, SALA 1003, Brasilia, Federal District, Brazil, Zip Code: 70308-200
**/

import { ref } from 'vue';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import JetActionMessage from '@/Jetstream/ActionMessage.vue';
import JetButton from '@/Jetstream/Button.vue';
import JetInput from '@/Jetstream/Input.vue';
import JetCheckbox from '@/Jetstream/Checkbox.vue';
import JetLabel from '@/Jetstream/Label.vue';
import JetValidationErrors from '@/Jetstream/ValidationErrors.vue';
import {mask, TheMask}  from 'vue-the-mask'

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    status: String,
    avatar: String,
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


const logout = () => {
    useForm().post(route('logout'));
};

</script>

<template>
     <nav class="navbar default-layout col-lg-12 col-12 w-100 p-0 fixed-top d-flex flex-row" style="height:60px">
       <div class="text-center navbar-brand-wrapper d-flex align-items-top justify-content-center">
         <a class="navbar-brand brand-logo text-dark" href="route('dashboard')">
           Lochlite  </a>
         <a class="brand-logo-mini align-self-center text-dark px-3 h1" href="route('index')">
           L </a>
       </div>
       <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
         <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
           <span class="mdi mdi-menu"></span>
         </button>
         <ul class="navbar-nav navbar-nav-left header-links">
           <li class="nav-item active d-none d-lg-flex">
             <Link :href="route('managercontacts.index')" class="nav-link">
               <i class="mdi mdi-face-agent"></i>Contatos</Link>
           </li>
           <li class="nav-item active d-none d-lg-flex">
             <Link :href="route('managerfeedbacks.index')" class="nav-link">
               <i class="mdi mdi-message-draw"></i>Feedbacks</Link>
           </li>
           <li class="nav-item d-none d-md-flex">
             <Link :href="route('managerscheduling.index')" class="nav-link">
               <i class="mdi mdi-calendar-clock"></i>Agendamentos</Link>
           </li>
         </ul>
         <ul class="navbar-nav navbar-nav-right">
           <li class="nav-item">
             <div class="collapse" id="collapseExample">
             <div class="input-group">
             <input class="form-control" name="search" required>
             <button class="btn btn-primary">Search</button>
             </div>
             </div>
           </li>
           <li class="nav-item dropdown">
             <a class="nav-link" href="#collapseExample" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
               <i class="mdi mdi-magnify"></i>
             </a>
           </li>
           <li class="nav-item dropdown">
             <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" :href="route('managernotifications.index')">
               <i class="mdi mdi-bell-outline"></i>
               <span class="count bg-success">0</span>
             </a>
           </li>
           <li class="nav-item dropdown d-none d-xl-inline-block">
             <a class="nav-link d-flex" id="UserDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
               <span class="d-inlie-block profile-text d-none d-md-inline-flex align-self-center text-truncate overflow-none" style="max-width:125px !important;">{{name}}</span>
               <img class="d-inlie-block img-xs rounded-circle align-self-center" :src="avatar" alt="Profile image">
               <svg class="d-inlie-block w-4 h-4 ml-2 align-self-center" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
     		</a>
             <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
               <form @submit.prevent="logout">
               <button type="submit" class="dropdown-item"> Logout </button>
               </form>
             </div>
           </li>
         </ul>
         <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
           <span class="mdi mdi-menu icon-menu"></span>
         </button>
       </div>
     </nav>
</template>
