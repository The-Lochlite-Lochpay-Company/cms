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

const props = defineProps({
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
const form = useForm({
    name: props.contact.name,
    email: props.contact.email,
    status: props.contact.status,
    message: props.contact.message,
});

const submit = (event) => {
    form.transform(data => ({
        ...data,
    })).put(route('managercontacts.update', {id: event.submitter.dataset.contact}), {
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
            <option value="received" :selected="contact.status == 'received'">Recebido</option>
            <option value="answered" :selected="contact.status == 'answered'">Respondido</option>
            <option value="refused" :selected="contact.status == 'refused'">Recusado</option>
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
        <JetButton type="submit" class="bg-blue-500 text-white px-4 py-2 rounded" title="Atualizar" aria-label="Atualizar" :data-contact="contact.id" :class="{ 'opacity-50': form.processing }" :disabled="form.processing">Atualizar</JetButton>
      </div>
    </div>
  </form>
</AppLayout>
</template>
