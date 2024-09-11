<script setup>
import { ref,onMounted } from 'vue';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import JetActionMessage from 'lochlitecms/Views/Components/Layouts//ActionMessage.vue';
import JetButton from 'lochlitecms/Views/Components/Layouts//Button.vue';
import JetInput from 'lochlitecms/Views/Components/Layouts//Input.vue';
import JetCheckbox from 'lochlitecms/Views/Components/Layouts//Checkbox.vue';
import JetLabel from 'lochlitecms/Views/Components/Layouts//Label.vue';
import JetValidationErrors from 'lochlitecms/Views/Components/Layouts//ValidationErrors.vue';
import {mask, TheMask}  from 'vue-the-mask'

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    status: String,
    name: String,
    avatar: String,
    role: String,
    email: String,
    message: String,
    menuitems: Object,
});

const isCollapsed = ref(false);

const collapseElements = ref([]);

onMounted(() => {
  collapseElements.value = document.querySelectorAll('[ref="collapseElement"]');

  collapseElements.value.forEach(element => {
    $(element).on('show.bs.collapse', () => {
      $(this).classList.remove('collapse');
    });
  });
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
</script>

<template>
<!------ dynamic-active-class-disabled ------->
<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav">
    <li class="nav-item nav-profile not-navigation-link">
      <div class="nav-link">
        <div class="user-wrapper">
          <div class="profile-image">
            <img :src="avatar" alt="name">
          </div>
          <div class="text-wrapper">
            <p class="profile-name text-truncate overflow-none" style="max-width:125px !important;">{{ name}}</p>
              <div class="d-flex inline-block" id="UsersettingsDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                <small class="designation text-muted">{{ role }}</small>
                <span class="status-indicator online"></span>
			   </div>
          </div>
        </div>
        <Link class="btn btn-success btn-block p-2 d-flex justify-content-between" :href="route('managerposts.create')"><span class="align-self-center">Novo artigo</span> <i class="mdi mdi-plus align-self-center"></i></Link>
      </div>
    </li>

    <li v-for="(row, index) in menuitems" class="nav-item">
      <Link v-if="row.dropdown == false" class="nav-link" :class="row.active == true ? 'active' : ''" :id="row.id" :href="row.url">
        <i :class="row.icon"></i>
        <span class="menu-title">{{ row.name }}</span>
      </Link>
	  <div v-else-if="row.dropdown == true">
	  <a class="nav-link" :class="row.active == true ? 'active' : ''" :id="row.id + '-item'" data-bs-toggle="collapse" :href="'#' + row.id" :aria-expanded="row.active == true ? true : false" :aria-controls="'sidebar ' + row.id">
        <i :class="row.icon"></i>
        <span class="menu-title">{{ row.name }}</span>
        <i class="text-right mdi mdi-chevron-right pl-auto ml-auto"></i>
      </a>
  <div ref="collapseElement" class="collapse bg-light" :class="{ 'show': row.active == true, 'collapse': row.active == false }" :id="row.id">
        <ul class="nav flex-column sub-menu bg-light">
          <li v-for="item in row.subitems" class="nav-item">
            <Link class="nav-link" :href="item.url">{{ item.name }}</Link>
          </li>
        </ul>
      </div>
      </div>
    </li>

  </ul>
</nav>
</template>
