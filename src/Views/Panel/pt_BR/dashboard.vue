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
    disk: Number,
    diskfreespace: Number,
    users: Number,
    plugins: Number,
    settings: Number,
    domains: Object,
    breadcrumbCurrentTitle: String,
    breadcrumbCurrentSection: String,
    menulang: Object,
    menuitems: Object,
});
const form = useForm({});
const submit = (event) => {
  form.transform((data) => ({
   module: event.submitter.dataset.module
  }))	
  .post(route('managersettings.store'));
};

</script>

<template>
<AppLayout :menulang="menulang" :menuitems="menuitems" :avatar="avatar" :role="role" :name="name" :version="version" :breadcrumbCurrentTitle="breadcrumbCurrentTitle" :breadcrumbCurrentSection="breadcrumbCurrentSection" :title="title">

  <div class="flex flex-wrap px-3">
    <div class="w-full md:w-1/2 lg:w-1/4">
      <div class="shadow-none my-2">
        <div class="flex">
          <div class="w-full md:w-1/4 py-1 text-center mx-auto flex items-center justify-center bg-blue-500">
            <i class="fa-solid fa-compact-disc text-white text-3xl"></i>
          </div>   
          <div class="w-full md:w-3/4 py-1 px-4 flex flex-col items-center bg-transparent">
            <div class="font-bold pt-3">Espaço em disco</div>
            <div>{{ diskfreespace }}/{{ disk }}</div>
          </div>   
        </div>
      </div>
    </div>
    
    <div class="w-full md:w-1/2 lg:w-1/4">
      <div class="shadow-none my-2">
        <div class="flex">
          <div class="w-full md:w-1/4 py-1 text-center mx-auto flex items-center justify-center bg-yellow-500">
            <i class="fa-solid fa-users text-white text-3xl"></i>
          </div>   
          <div class="w-full md:w-3/4 py-1 px-4 flex items-center bg-transparent">
            <div class="font-bold pt-3 mt-1">Total de usuários</div>
            <p>{{ users }}</p>
          </div>   
        </div>
      </div>
    </div>
    
    <div class="w-full md:w-1/2 lg:w-1/4">
      <div class="shadow-none my-2">
        <div class="flex">
          <div class="w-full md:w-1/4 py-1 text-center mx-auto flex items-center justify-center bg-green-500">
            <i class="fa-solid fa-plug-circle-check text-white text-3xl"></i>
          </div>   
          <div class="w-full md:w-3/4 py-1 px-4 flex items-center bg-transparent">
            <div class="font-bold pt-3 mt-1">Plugins ativos</div>
            <p>{{ plugins }}</p>
          </div>   
        </div>
      </div>
    </div>
    
    <div class="w-full md:w-1/2 lg:w-1/4">
      <div class="shadow-none my-2">
        <div class="flex">
          <div class="w-full md:w-1/4 py-1 text-center mx-auto flex items-center justify-center bg-red-500">
            <i class="fa-solid fa-globe text-white text-3xl"></i>
          </div>   
          <div class="w-full md:w-3/4 py-1 px-4 flex items-center bg-transparent">
            <div class="font-bold pt-3 mt-1">Dominios ativos</div>
            <p>{{ domains.length }}</p>
          </div>   
        </div>
      </div>
    </div>
  </div>

<div class="grid grid-cols-1 md:grid-cols-4 gap-4 w-full">
  <div class="col">
    <Link :href="route('managerstorange.index')" class="bg-gray-100 shadow-none my-2 text-center">
      <div class="border-0 bg-transparent p-4">
        <i class="fa-solid fa-cloud text-3xl"></i>
      </div>   
      <div class="border-0 bg-transparent p-4">
        Armanezamento
      </div>   
    </Link>
  </div>
  
  <div class="col">
    <Link :href="route('manageremails.index')" class="bg-gray-100 shadow-none my-2 text-center">
      <div class="border-0 bg-transparent p-4">
        <i class="fa-solid fa-envelope text-3xl"></i>
      </div>   
      <div class="border-0 bg-transparent p-4">
        Emails
      </div>   
    </Link>   
  </div>   

  <div class="col">
    <Link :href="route('managerusers.index')" class="bg-gray-100 shadow-none my-2 text-center">
      <div class="border-0 bg-transparent p-4">
        <i class="fa-solid fa-people-group text-3xl"></i>
      </div>   
      <div class="border-0 bg-transparent p-4">
        Usuários
      </div>   
    </Link>   
  </div>   

  <div class="col">
    <Link :href="route('managersettings.index')" class="bg-gray-100 shadow-none my-2 text-center">
      <div class="border-0 bg-transparent p-4">
        <i class="fa-solid fa-gears text-3xl"></i>
      </div>   
      <div class="border-0 bg-transparent p-4">
        Configurações
      </div>   
    </Link>   
  </div>   
</div>

<div class="flex flex-wrap bg-gray-100 py-4 px-3 mt-4">
  <div class="w-full md:w-1/2">
    <div class="shadow-none h-full">
      <div class="border-0 bg-white p-4">
        <div class="text-xl font-bold">Domains</div>
      </div>
      <div class="overflow-x-auto">
        <table class="min-w-full bg-white">
          <thead>
            <tr>
              <th class="px-4 py-2">#</th>
              <th class="px-4 py-2">Domain</th>
              <th class="px-4 py-2">Status</th>
              <th class="px-4 py-2">Atualizado em</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(row, index) in domains" :key="index" class="hover:bg-gray-100">
              <td class="border px-4 py-2">{{ row.id }}</td>
              <td class="border px-4 py-2">{{ row.domain }}</td>
              <td class="border px-4 py-2">{{ row.status }}</td>
              <td class="border px-4 py-2">{{ new Date(row.updated_at).toLocaleString() }}</td>
            </tr>
          </tbody>
        </table>
      </div>   
    </div>   
  </div>   
  <div class="w-full md:w-1/2">
    <div class="shadow-none h-full">
      <div class="border-0 bg-white p-4">
        <div class="text-xl font-bold">Shortcuts</div>
      </div>
      <div class="p-4 bg-white">
        <ul class="list-none bg-white">
          <li class="flex justify-between items-center border-b py-2">
            Otimizar o site
            <form id="optimize" method="POST" @submit.prevent="submit">
              <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded" data-module="optimize" :class="{ 'opacity-50': form.processing }" :disabled="form.processing"><i class="mdi mdi-lightning-bolt"></i></button>
            </form>
          </li>
          <li class="flex justify-between items-center border-b py-2">
            Limpar o cache do site
            <form id="cleanall" method="POST" @submit.prevent="submit">
              <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded" data-module="cleanall" :class="{ 'opacity-50': form.processing }" :disabled="form.processing"><i class="mdi mdi-vacuum"></i></button>
            </form>
          </li>
          <li class="flex justify-between items-center border-b py-2">
            Enviar um email
            <Link :href="route('manageremails.create')" class="bg-blue-500 text-white px-4 py-2 rounded"><i class="mdi mdi-button-cursor"></i></Link>
          </li>
          <li class="flex justify-between items-center border-b py-2">
            Criar novo usuário
            <Link :href="route('managerusers.create')" class="bg-blue-500 text-white px-4 py-2 rounded"><i class="mdi mdi-account-multiple-plus"></i></Link>
          </li>
        </ul>	 
      </div>   
    </div>   
  </div>   
</div>    
</AppLayout>
</template>