<script setup>
import { ref } from 'vue';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import JetActionMessage from 'lochlitecms/Views/Components/Layouts/ActionMessage.vue';
import JetButton from 'lochlitecms/Views/Components/Layouts/Button.vue';
import JetValidationErrors from 'lochlitecms/Views/Components/Layouts/ValidationErrors.vue';
import AppLayout from 'lochlitecms/Views/Panel/AppLayout.vue';
import DOMPurify from 'dompurify';

defineProps({
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
$('body').ready(function(){
$.each($('div.bodycomment'), function(index, item) {
$(item).html(DOMPurify.sanitize(Base64.atob($(item).data('body'))))
})
})

</script>
<template>
<AppLayout :menulang="menulang" :menuitems="menuitems" :avatar="avatar" :role="role" :name="name" :version="version" :breadcrumbCurrentTitle="breadcrumbCurrentTitle" :breadcrumbCurrentSection="breadcrumbCurrentSection" :title="title">
  <template #breadcrumb>
    <li class="breadcrumb-item active" aria-current="page">Comentário: {{ comment.id }} - {{ comment.name }}</li>
  </template>
  <div class="flex flex-wrap">
    <div class="w-full md:w-1/2">
      <div class="mb-4">
        <strong>Nome:</strong>
        {{ comment.name }}
      </div>
    </div>
    <div class="w-full md:w-1/2">
      <div class="mb-4">
        <strong>Email:</strong>
        <Link class="ml-2 text-blue-500" :href="route('managerusers.show', {id: comment.user_id})">{{ comment.email }}</Link>
      </div>
    </div>
    <div class="w-full md:w-1/2">
      <div class="mb-4">
        <strong>Criado em:</strong>
        {{ new Date(comment.created_at).toLocaleString() }}
      </div>
    </div>
    <div class="w-full md:w-1/2">
      <div class="mb-4">
        <strong>Atualizado:</strong>
        {{ new Date(comment.updated_at).toLocaleString() }}
      </div>
    </div>
    <div class="w-full">
      <div class="mb-4">
        <strong>Artigo:</strong>
        <Link class="ml-2 text-blue-500" :href="route('blog.show', {id: comment.post[0].id})">{{ comment.post[0].id }} - {{ comment.post[0].title }}</Link>
      </div>
    </div>
    <div class="w-full">
      <div class="mb-4">
        <strong>Comentário:</strong>
        <div class="bodycomment" :data-body="comment.comment"></div>
      </div>
    </div>
    <div class="w-full">
      <div class="mb-4">
        <strong class="mb-3">Respostas ao comentário:</strong>
        <div class="w-full flex flex-col bg-white rounded-lg">
          <div class="w-full flex items-start px-4 py-6" v-for="row in comment.reply">
            <div class="w-12 h-12 mr-4">
              <img class="w-full h-full rounded-full object-cover" :src="row.avatar" alt="avatar">
            </div>
            <div class="flex-1">
              <div class="flex justify-between">
                <div class="font-semibold text-gray-900">
                  <Link class="ml-2 text-blue-500" :href="route('managerusers.show', {id: row.id})">{{ row.name }} - {{ row.email }}</Link>
                </div>
                <div class="text-gray-700">{{ new Date(row.created_at).toLocaleString() }}</div>
                <div><span class="font-bold">status: {{ row.status }}</span></div>
              </div>
              <p class="mt-3 text-md">
                <div class="bodycomment text-md" :data-body="row.comment"></div>
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</AppLayout>
</template>
