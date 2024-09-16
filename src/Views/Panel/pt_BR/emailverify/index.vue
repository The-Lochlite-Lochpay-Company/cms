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
		<div class="my-3 flex space-x-3">
		<Link class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" :href="route('manageremailverify.create')">Adicionar página de verificação de email</Link>
		<Link class="bg-gray-800 hover:bg-gray-900 text-white font-bold py-2 px-4 rounded" :href="route('manageremailverify.resettest')">Test send</Link>
        </div>
		<div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dominio</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Titulo</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Padrão</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ação</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr v-for="(row, index)  in emailverify.data" :key="row.id">
                        <td class="px-6 py-4 whitespace-nowrap">{{ row.id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ row.domain }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ row.title }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ row.default == 1 ? 'true' : 'false' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ row.status }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex space-x-2">
						<Link :href="route('manageremailverify.edit', {id: row.id})" class="bg-transparent text-gray-700 hover:text-gray-900" data-event="link" data-function="edit" :data-post="row.id" title="Editar"><i class="mdi mdi-pencil"></i></Link>
                        <form v-if="row.default == false" :id="row.id" class="w-full" @submit.prevent="submit">
                         <JetValidationErrors class="mb-4" />
                         <div v-if="status" class="mb-4 text-sm text-green-600">
                             {{ status }}
                         </div>
                         <JetButton class="bg-transparent text-gray-700 hover:text-gray-900" type="submit" data-event="submit" data-function="delete" :data-emailverify="row.id" :class="{ 'opacity-25': form.processing }" :disabled="form.processing" title="Excluir"><i class="mdi mdi-delete"></i> </JetButton>
						</form>
						</div>
						</td>
                    </tr>
				 </tbody>
            </table>
        </div>
</AppLayout>
</template>
