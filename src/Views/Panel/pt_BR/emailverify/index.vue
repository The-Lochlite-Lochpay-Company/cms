<script setup>
import { ref } from 'vue';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import JetDialogModal from 'lochlitecms/Views/Components/Layouts/DialogModal.vue';
import JetButton from 'lochlitecms/Views/Components/Layouts/Button.vue';
import JetValidationErrors from 'lochlitecms/Views/Components/Layouts/ValidationErrors.vue';
import AppLayout from 'lochlitecms/Views/Panel/AppLayout.vue';

const props = defineProps({
    canLogin: Boolean,
    canemailverify: Boolean,
    title: String,
    status: String,
    name: String,
    role: String,
    avatar: String,
    version: String,
    emailverify: Object,
    breadcrumbCurrentTitle: String,
    breadcrumbCurrentSection: String,
    menulang: Object,
    menuitems: Object,
});
const form = useForm();
const submit = (event) => {
    form.delete(route('manageremailverify.destroy', {id: event.submitter.dataset.emailverify}));
};
</script>

<template>
<AppLayout :menulang="menulang" :menuitems="menuitems" :avatar="avatar" :role="role" :name="name" :version="version" :breadcrumbCurrentTitle="breadcrumbCurrentTitle" :breadcrumbCurrentSection="breadcrumbCurrentSection" :title="title">
        <template #breadcrumb>
              <li class="breadcrumb-item active text-truncate w-50" aria-current="page">Página de verificação de email</li>
        </template>
		<div class="my-3 btn-group border-0 rounded-0">
		<Link class="btn btn-primary me-3 mr-3" :href="route('manageremailverify.create')">Adicionar página de verificação de email</Link>
		<Link class="btn btn-dark" :href="route('manageremailverify.resettest')">Test send</Link>
        </div>
		<div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Dominio</th>
                        <th>Titulo</th>
                        <th>Padrão</th>
                        <th>Status</th>
                        <th>Ação</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(row, index)  in emailverify.data" :key="row.id">
                        <td>{{ row.id }}</td>
                        <td>{{ row.domain }}</td>
                        <td>{{ row.title }}</td>
                        <td>{{ row.default == 1 ? 'true' : 'false' }}</td>
                        <td>{{ row.status }}</td>
                        <td>
                        <div class="btn-group">
						<Link :href="route('manageremailverify.edit', {id: row.id})" class="btn btn-outline-light text-dark" data-event="link" data-function="edit" :data-post="row.id" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar"><i class="mdi mdi-pencil"></i></Link>
                        <form v-if="row.default == false" :id="row.id" class="w-100" @submit.prevent="submit">
                         <JetValidationErrors class="mb-4" />
                         <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
                             {{ status }}
                         </div>
                         <JetButton class="btn btn-outline-light bg-light rounded-0 border-0 text-dark" type="submit" data-event="submit" data-function="delete" :data-emailverify="row.id" :class="{ 'opacity-25': form.processing }" :disabled="form.processing" data-bs-toggle="tooltip" data-bs-placement="top" title="Excluir"><i class="mdi mdi-delete"></i> </JetButton>
						</form>
						</div>
						</td>
                    </tr>
				 </tbody>
            </table>
        </div>
</AppLayout>
</template>
