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
</script>

<template>
<AppLayout :menulang="menulang" :menuitems="menuitems" :avatar="avatar" :role="role" :name="name" :version="version" :breadcrumbCurrentTitle="breadcrumbCurrentTitle" :breadcrumbCurrentSection="breadcrumbCurrentSection" :title="title">
        <template #breadcrumb></template>
        <div class="table-responsive">
	                 <table class="table table-hover">
                     <thead>
                       <tr>
                         <th scope="col">#</th>
                         <th scope="col">Domain</th>
                         <th scope="col">Status</th>
                         <th scope="col">Atualizado em</th>
                         <th scope="col">Ação</th>
                       </tr>
                     </thead>
                     <tbody>
                       <tr v-for="(row,index) in domains.data">
                         <th scope="row">{{ row.id }}</th>
                         <td>{{ row.domain }}</td>
                         <td>{{ row.status }}</td>
                         <td>{{ new Date(row.updated_at).toLocaleString() }}</td>
                         <td>
                         <div class="btn-group">
                         <form v-if="row.status == 'pending'" :id="row.id" class="w-100" @submit.prevent="approved">
						 <JetButton type="submit" class="btn btn-outline-light text-success fw-bold font-bold" data-event="submit" data-function="store" :data-domain="row.id"  :class="{ 'opacity-25': formapproved.processing }" :disabled="formapproved.processing" data-bs-toggle="tooltip" data-bs-placement="top" title="To approve"><i class="mdi mdi-check-circle"></i></JetButton>
                         </form>
                         <form :id="row.id" class="w-100" @submit.prevent="submit">
                          <JetValidationErrors class="mb-4" />
                          <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
                              {{ status }}
                          </div>
                          <JetButton class="btn btn-outline-light bg-light rounded-0 border-0 text-dark" type="submit" data-event="submit" data-function="delete" :data-domain="row.id" :class="{ 'opacity-25': form.processing }" :disabled="form.processing" data-bs-toggle="tooltip" data-bs-placement="top" title="Excluir"><i class="mdi mdi-delete"></i> </JetButton>
						 </form>
						 </div>
						 </td>
                       </tr>
                     </tbody>
                     </table>
        </div>
 
</AppLayout>
</template>