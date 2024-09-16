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
<nav class="w-full min-w-screen h-[60px] p-0 fixed top-0 flex flex-row mb-8 text-withe">
  <div class="ps-28 bg-dark w-full flex items-center self-center justify-between">
  <div class="flex items-start justify-start me-auto">
        <div class="text-start flex self-center items-start justify-center me-4 pt-3 z-50">
    <div class="text-white font-bold text-lg">
      Lochlite
    </div>
    <Link class="self-center text-dark px-3 h1" :href="route('managerdashboard.index')">
      <img class="w-full h-full" :src="getOrigin() + '/application/32x32.png'">
    </Link>
  </div>
    <button class="self-center active text-white ms-4" type="button" data-toggle="minimize">
      <span class="mdi mdi-menu"></span>
    </button>
    </div>
  <div class="ms-auto flex items-center self-center justify-end">
<ul class="flex flex-row space-x-4 self-center text-white">
  <li class="hidden lg:flex">
    <Link :href="route('managercontacts.index')" class="flex items-center text-withe pt-3 me-2">
      <i class="mdi mdi-face-agent me-2 text-white"></i><strong class="text-white">Contatos</strong></Link>
  </li>
  <li class="hidden lg:flex">
    <Link :href="route('managerfeedbacks.index')" class="flex items-center text-withe pt-3 me-2">
      <i class="mdi mdi-message-draw me-2 text-white"></i><strong class="text-white">Feedbacks</strong></Link>
  </li>
  <li class="hidden md:flex">
    <Link :href="route('managerscheduling.index')" class="flex items-center text-withe pt-3 me-2">
      <i class="mdi mdi-calendar-clock me-2 text-white"></i><strong class="text-white">Agendamentos</strong></Link>
  </li>
  <li class="hidden lg:flex">
    <Link :href="route('managerscheduling.index')" class="flex items-center text-withe pt-3 me-2">
      <strong class="text-white"><i class="mdi mdi-plus me-2 text-white text-md"></i></strong>
    </Link>
  </li>
</ul>
 <ul class="flex flex-row space-x-4">
  <li class="dropdown">
    <Link class="nav-link text-withe pt-4" :href="route('managersearch.index')">
      <i class="mdi mdi-magnify text-2xl pt-4 text-white"></i>
    </Link>
  </li>
  <li class="dropdown">
    <Link class="nav-link relative text-withe pt-4" id="notificationDropdown" :href="route('managernotifications.index')">
      <i class="mdi mdi-bell-outline pt-4 text-2xl text-white"></i>
      <span class="absolute top-0 right-0 mt-4 bg-green-500 text-white rounded-full text-xs px-1">0</span>
    </Link>
  </li>
  <li class="dropdown">
    <a class="nav-link relative text-withe pt-4" id="langDropdown" href="#langDropdown" data-bs-toggle="dropdown" aria-expanded="false">
      <i class="mdi mdi-web pt-4 text-white"></i>
      <strong class="font-bold ml-1 pt-4 text-white">{{ menulang.current ?? 'pt_BR' }}</strong>
    </a>
    <div class="dropdown-menu right-0 mt-2">
      <div class="card card-body">
        <form @submit.prevent="submitlang" v-for="(row, index) in menulang.items" :id="'lang-' + index">
          <button type="submit" :data-lang="row.code" class="btn btn-outline-light text-dark" :class="{active: row.active}">{{ row.name }}</button>
        </form>
      </div>
    </div>
  </li>
  <li class="dropdown hidden xl:flex">
    <a class="nav-link flex items-center text-withe pt-4" id="UserDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
      <strong class="hidden md:inline-flex align-self-center text-truncate text-white max-w-[125px]">{{name}}</strong>
      <img class="inline-block w-8 h-8 rounded-full ml-2" :src="avatar" alt="Profile image">
      <svg class="inline-block w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
    </a>
    <div class="dropdown-menu right-0 mt-2 z-50">
      <div class="card card-body">
        <form @submit.prevent="logout">
          <button type="submit" class="btn btn-outline-light text-dark"> Logout </button>
        </form>
      </div>
    </div>
  </li>
</ul>
<button class="lg:hidden self-center text-withe" type="button" data-toggle="offcanvas">
  <span class="mdi mdi-menu icon-menu"></span>
</button>
</div>
</div>
     </nav>
</template>
