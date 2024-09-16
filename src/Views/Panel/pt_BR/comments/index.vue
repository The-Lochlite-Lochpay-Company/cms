<script setup>
import { ref, defineAsyncComponent } from 'vue';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import JetDialogModal from 'lochlitecms/Views/Components/Layouts/DialogModal.vue';
import JetButton from 'lochlitecms/Views/Components/Layouts/Button.vue';
import JetValidationErrors from 'lochlitecms/Views/Components/Layouts/ValidationErrors.vue';
import AppLayout from 'lochlitecms/Views/Panel/AppLayout.vue';
import LoadingComponent from 'lochlitecms/Views/Components/LoadingComponent.vue';
import ErrorComponent from 'lochlitecms/Views/Components/ErrorComponent.vue';

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    title: String,
    status: String,
    name: String,
    role: String,
    avatar: String,
    version: String,
    comments: Object,
    breadcrumbCurrentTitle: String,
    breadcrumbCurrentSection: String,
    menulang: Object,
    menuitems: Object,
});
const form = useForm();
const submit = (event) => {
    form.delete(route('managercomments.destroy', {id: event.submitter.dataset.comment}));
};

const Pagination = defineAsyncComponent({
  loader: () => import("lochlitecms/Views/Components/Pagination.vue"),
  loadingComponent: LoadingComponent,
  errorComponent: ErrorComponent,
  delay: 500,
  timeout: 5000,
})

</script>
<template>
<AppLayout :menulang="menulang" :menuitems="menuitems" :avatar="avatar" :role="role" :name="name" :version="version" :breadcrumbCurrentTitle="breadcrumbCurrentTitle" :breadcrumbCurrentSection="breadcrumbCurrentSection" :title="title">
  <template #breadcrumb></template>
  <div class="overflow-x-auto">
    <table class="min-w-full bg-white">
      <thead>
        <tr>
          <th class="px-4 py-2">Artigo</th>
          <th class="px-4 py-2">Nome</th>
          <th class="px-4 py-2">Email</th>
          <th class="px-4 py-2">Criado em</th>
          <th class="px-4 py-2">Atualizado em</th>
          <th class="px-4 py-2">Ação</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(row, index) in comments.data" :key="row.id" class="hover:bg-gray-100">
          <td class="text-wrap w-7/10 block text-truncate truncate">{{ row.post[0].title }}</td>
          <td>{{ row.name }}</td>
          <td>{{ row.email }}</td>
          <td>{{ new Date(row.created_at).toLocaleString() }}</td>
          <td>{{ new Date(row.updated_at).toLocaleString() }}</td>
          <td>
            <div class="flex space-x-2">
              <Link :href="route('managercomments.show', {id: row.id})" class="bg-gray-200 text-gray-800 px-2 py-1 rounded" data-event="link" data-function="show" :data-comments="row.id" title="Ver"><i class="mdi mdi-eye"></i></Link>
              <Link :href="route('managercomments.edit', {id: row.id})" class="bg-gray-200 text-gray-800 px-2 py-1 rounded" data-event="link" data-function="edit" :data-comments="row.id" title="Editar"><i class="mdi mdi-pencil"></i></Link>
              <form :id="row.id" @submit.prevent="submit" class="inline">
                <JetValidationErrors class="mb-4" />
                <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
                  {{ status }}
                </div>
                <JetButton class="bg-gray-200 text-gray-800 px-2 py-1 rounded" type="submit" data-event="submit" data-function="delete" :data-comment="row.id" :class="{ 'opacity-50': form.processing }" :disabled="form.processing" title="Excluir"><i class="mdi mdi-delete"></i></JetButton>
              </form>
            </div>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
  <div class="mt-2">
    <Pagination :links="comments.links" />
  </div>
</AppLayout>
</template>
