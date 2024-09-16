<script setup>
import { ref } from 'vue';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import JetDialogModal from 'lochlitecms/Views/Components/Layouts/DialogModal.vue';
import JetButton from 'lochlitecms/Views/Components/Layouts/Button.vue';
import JetInput from 'lochlitecms/Views/Components/Layouts/Input.vue';
import JetInputError from 'lochlitecms/Views/Components/Layouts/InputError.vue';
import JetCheckbox from 'lochlitecms/Views/Components/Layouts/Checkbox.vue';
import JetLabel from 'lochlitecms/Views/Components/Layouts/Label.vue';
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
});
const form = useForm({
    name: '',
    email: '',
    status: '',
    message: '',
});

const submit = (event) => {
    form.transform(data => ({
        ...data,
    })).post(route('managercontacts.store'), {
        onFinish: () => form.reset(),
    });
};

</script>
<template>
<AppLayout :menulang="menulang" :menuitems="menuitems" :avatar="avatar" :role="role" :name="name" :version="version" :breadcrumbCurrentTitle="breadcrumbCurrentTitle" :breadcrumbCurrentSection="breadcrumbCurrentSection" :title="title">
  <template #breadcrumb>
    <li class="breadcrumb-item active" aria-current="page">Criar</li>
  </template>
  <JetValidationErrors class="mb-4" />

  <form @submit.prevent="submit">
    <div class="flex flex-wrap">
      <div class="w-full md:w-1/2">
        <div class="mb-4">
          <JetLabel for="name" value="Nome" />
          <JetInput id="name" type="text" class="mt-1 block w-full" placeholder="Nome" v-model="form.name" name="name" autocomplete="name" />   
          <JetInputError for="name" class="mt-2" />
        </div>
      </div>
      <div class="w-full md:w-1/2">
        <div class="mb-4">
          <JetLabel for="email" value="Email" />
          <JetInput id="email" type="email" class="mt-1 block w-full" placeholder="Email" v-model="form.email" name="email" autocomplete="email" />
          <JetInputError for="email" class="mt-2" />
        </div>
      </div> 
      <div class="w-full">
        <div class="mb-4">
          <JetLabel for="status" value="Status" />
          <select id="status" class="p-1 w-full" v-model="form.status" name="status" autocomplete required>
            <option value="received" selected>Recebido</option>
            <option value="answered">Respondido</option>
            <option value="refused">Recusado</option>
          </select>
          <JetInputError for="status" class="mt-2" />
        </div>
      </div>
      <div class="w-full">
        <div class="mb-4">
          <JetLabel for="message" value="Mensagem" />
          <textarea class="w-full" v-model="form.message" name="message" required></textarea>
          <JetInputError for="message" class="mt-2" />
        </div>
      </div>
      <div class="w-full text-center">
        <JetButton type="submit" class="bg-blue-500 text-white px-4 py-2 rounded" title="Cadastrar" aria-label="Cadastrar" :class="{ 'opacity-50': form.processing }" :disabled="form.processing">Cadastrar</JetButton>
      </div>
    </div>
  </form>
</AppLayout>
</template>
