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
    domains: Object,
    breadcrumbCurrentTitle: String,
    breadcrumbCurrentSection: String,
    menulang: Object,
    menuitems: Object,
});
const formapproved = useForm({domain: ''});
const approved = (event) => {
    formapproved.domain = event.submitter.dataset.domain;
    formapproved.post(route('managerdomains.store'));
};
const form = useForm();
const submit = (event) => {
    form.delete(route('managerdomains.destroy', {id: event.submitter.dataset.domain}));
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
	                 <table class="min-w-full divide-y divide-gray-200">
                     <thead class="bg-gray-50">
                       <tr>
                         <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                         <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Domain</th>
                         <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                         <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Atualizado em</th>
                         <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ação</th>
                       </tr>
                     </thead>
                     <tbody class="bg-white divide-y divide-gray-200">
                       <tr v-for="(row,index) in domains.data" :key="index">
                         <th scope="row" class="px-6 py-4 whitespace-nowrap">{{ row.id }}</th>
                         <td class="px-6 py-4 whitespace-nowrap">{{ row.domain }}</td>
                         <td class="px-6 py-4 whitespace-nowrap">{{ row.status }}</td>
                         <td class="px-6 py-4 whitespace-nowrap">{{ new Date(row.updated_at).toLocaleString() }}</td>
                         <td class="px-6 py-4 whitespace-nowrap">
                         <div class="flex space-x-2">
                         <form v-if="row.status == 'pending'" :id="row.id" class="w-full" @submit.prevent="approved">
						 <JetButton type="submit" class="bg-transparent text-green-500 font-bold" data-event="submit" data-function="store" :data-domain="row.id"  :class="{ 'opacity-25': formapproved.processing }" :disabled="formapproved.processing" title="To approve"><i class="mdi mdi-check-circle"></i></JetButton>
                         </form>
                         <form :id="row.id" class="w-full" @submit.prevent="submit">
                          <JetValidationErrors class="mb-4" />
                          <div v-if="status" class="mb-4 text-sm text-green-600">
                              {{ status }}
                          </div>
                          <JetButton class="bg-transparent text-gray-700" type="submit" data-event="submit" data-function="delete" :data-domain="row.id" :class="{ 'opacity-25': form.processing }" :disabled="form.processing" title="Excluir"><i class="mdi mdi-delete"></i> </JetButton>
						 </form>
						 </div>
						 </td>
                       </tr>
                     </tbody>
                     </table>
        </div>
		 <div class="mt-2"><Pagination :links="domains.links" /></div>
 
</AppLayout>
</template>
