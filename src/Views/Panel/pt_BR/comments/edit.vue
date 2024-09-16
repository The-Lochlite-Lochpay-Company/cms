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
import DOMPurify from 'dompurify';
import arrive from 'arrive';
 
const props = defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    title: String,
    status: String,
    name: String,
    role: String,
    avatar: String,
    version: String,
    comment: Object,
    breadcrumbCurrentTitle: String,
    breadcrumbCurrentSection: String,
    menulang: Object,
    menuitems: Object,
});
const form = useForm({
    name: '',
    name: props.comment.name,
    email: props.comment.email,
    status: props.comment.status,
    comment: props.comment.comment,
});

const submit = (event) => {
    form.comment = Base64.encode(DOMPurify.sanitize($('textarea#comment').val() || ''));
    form.transform(data => ({
        ...data,
    })).put(route('managercomments.update', {id: event.submitter.dataset.comment}), {
        onFinish: () => {form.reset(); $('textarea#comment').val(DOMPurify.sanitize(Base64.decode(form.comment)))},
    });
};
$('body').ready(function(){
   $('textarea#comment').val(DOMPurify.sanitize(Base64.decode($('textarea#comment').data('body'))))
})

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
          <select id="status" class="p-1 block w-full" v-model="form.status" name="status" autocomplete="status" required>
            <option value="pending" :selected="comment.status == 'pending'">Pendente</option>
            <option value="approved" :selected="comment.status == 'approved'">Aprovado</option>
          </select>
          <JetInputError for="status" class="mt-2" />
        </div>
      </div>
      <div class="w-full">
        <div class="mb-4">
          <JetLabel for="comment" value="Comentário" />
          <textarea id="comment" class="mt-1 block w-full" placeholder="Texto do comentário aqui" v-model="form.comment" name="comment" :data-body="comment.comment" autocomplete required></textarea>
          <JetInputError for="comment" class="mt-2" />
        </div>
      </div>
      <div class="w-full text-center">
        <JetButton type="submit" class="bg-blue-500 text-white px-4 py-2 rounded" title="Atualizar" aria-label="Atualizar" :data-comment="comment.id" :class="{ 'opacity-50': form.processing }" :disabled="form.processing">Atualizar</JetButton>
      </div>
    </div>
  </form>
</AppLayout>
</template>
