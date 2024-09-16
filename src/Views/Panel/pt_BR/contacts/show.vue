<script setup>
import { ref } from 'vue';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import JetActionMessage from 'lochlitecms/Views/Components/Layouts/ActionMessage.vue';
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
    contact: Object,
    breadcrumbCurrentTitle: String,
    breadcrumbCurrentSection: String,
    menulang: Object,
    menuitems: Object,
});
</script>
<template>
<AppLayout :menulang="menulang" :menuitems="menuitems" :avatar="avatar" :role="role" :name="name" :version="version" :breadcrumbCurrentTitle="breadcrumbCurrentTitle" :breadcrumbCurrentSection="breadcrumbCurrentSection" :title="title">
  <template #breadcrumb>
    <li class="breadcrumb-item active" aria-current="page">Mensagem: {{ contact.id }} - {{ contact.name }}</li>
  </template>
  <div class="flex flex-wrap">
    <div class="w-full md:w-1/3">
      <div class="mb-4">
        <strong>Nome:</strong>
        {{ contact.name }}
      </div>
    </div>
    <div class="w-full md:w-1/3">
      <div class="mb-4">
        <strong>Email:</strong>
        {{ contact.email }}
      </div>
    </div>
    <div class="w-full md:w-1/3">
      <div class="mb-4">
        <strong>IP do usuário:</strong>
        {{ contact.visitor }}
      </div>
    </div>
    <div class="w-full md:w-1/3">
      <div class="mb-4">
        <strong class="mr-2">Status:</strong>
        <span v-if="contact.status == 'received'">Recebido</span>
        <span v-else-if="contact.status == 'answered'">Respondido</span>
        <span v-else="contact.status == 'refused'">Recusado</span>
      </div>
    </div>
    <div class="w-full md:w-1/3">
      <div class="mb-4">
        <strong>Criado em:</strong>
        {{ new Date(contact.created_at).toLocaleString() }}
      </div>
    </div>
    <div class="w-full md:w-1/3">
      <div class="mb-4">
        <strong>Atualizado em:</strong>
        {{ new Date(contact.updated_at).toLocaleString() }}
      </div>
    </div>
    <div class="w-full">
      <div class="mb-4">
        <strong>Mensagem:</strong>
        <p>{{ contact.message }}</p>
      </div>
    </div>
  </div>
</AppLayout>
</template>
