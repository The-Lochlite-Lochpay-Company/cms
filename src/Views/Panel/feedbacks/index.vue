<script setup>
import { ref } from 'vue';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import JetDialogModal from '@/Jetstream/DialogModal.vue';
import JetButton from '@/Jetstream/Button.vue';
import JetValidationErrors from '@/Jetstream/ValidationErrors.vue';
import AppLayout from '@/Pages/Panel/AppLayout.vue';

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    title: String,
    status: String,
    name: String,
    role: String,
    avatar: String,
    version: String,
    feedbacks: Object,
    feedbacksresponses: Object,
    breadcrumbCurrentTitle: String,
    breadcrumbCurrentSection: String,
    menuitems: Object,
});
const form = useForm();
const submit = (event) => {
    form.delete(route('managerfeedbacks.destroy', {id: event.submitter.dataset.feedback}));
};
const deleterespform = useForm();
const submitdeleteresp = (event) => {
    form.delete(route('managerfeedback-responses.destroy', {id: event.submitter.dataset.feedback}));
};
</script>

<template>
<AppLayout :menuitems="menuitems" :avatar="avatar" :role="role" :name="name" :version="version" :breadcrumbCurrentTitle="breadcrumbCurrentTitle" :breadcrumbCurrentSection="breadcrumbCurrentSection" :title="title">
        <template #breadcrumb></template>
        <div class="card-title h4 fw-bold mt-4 mb-3 pb-0">Perguntas</div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Pergunta</th>
                        <th>Criado em</th>
                        <th>Atualizado em</th>
                        <th>Ação</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(row, index)  in feedbacks" :key="row.id">
                        <td>{{ row.question }}</td>
                        <td>{{ new Date(row.created_at).toLocaleString() }}</td>
                        <td>{{ new Date(row.updated_at).toLocaleString() }}</td>
                        <td>
                        <div class="btn-group">
						<Link :href="route('managerfeedbacks.show', {id: row.id})" class="btn btn-outline-light text-dark" data-event="link" data-function="show" :data-feedback="row.id" data-bs-placement="top" title="Ver"><i class="mdi mdi-eye"></i></Link>
						<Link :href="route('managerfeedbacks.edit', {id: row.id})" class="btn btn-outline-light text-dark" data-event="link" data-function="edit" :data-feedback="row.id" data-bs-placement="top" title="Editar"><i class="mdi mdi-pencil"></i></Link>
					    <form method="POST" :id="row.id" class="w-100" @submit.prevent="submit">
						<button type="submit" class="btn btn-outline-light text-dark" data-event="submit" data-function="delete" :data-feedback="row.id" :class="{ 'opacity-25': form.processing }" :disabled="form.processing" data-bs-toggle="tooltip" data-bs-placement="top" title="Excluir"><i class="mdi mdi-delete"></i></button>
						</form>
						</div>
						</td>
                    </tr>
                </tbody>
            </table>
        </div>
		<Link class="btn btn-primary bg-primary text-white p-2 mt-3" :href="route('managerfeedbacks.create')">Nova pergunta</Link>
        <div class="card-title h4 fw-bold mt-4 mb-3 pb-0">Últimas respostas</div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>IP</th>
                        <th>Criado em</th>
                        <th>Ação</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(resp, index)  in feedbacksresponses.data" :key="resp.id">
                        <td>{{ resp.name }}</td>
                        <td>{{ resp.email }}</td>
                        <td>{{ resp.visitor }}</td>
                        <td>{{ new Date(resp.created_at).toLocaleString() }}</td>
                        <td>
                        <div class="btn-group">
						<Link :href="route('managerfeedback-responses.show', {id: resp.id})" class="btn btn-outline-light text-dark" data-event="link" data-function="show" :data-user="resp.id" data-bs-placement="top" title="Ver"><i class="mdi mdi-eye"></i></Link>
					    <form method="POST" :id="resp.id" class="w-100" @submit.prevent="submitdeleteresp">
						<button type="submit" class="btn btn-outline-light text-dark" data-event="submit" data-function="delete" :data-feedback="resp.id" :class="{'opacity-25': deleterespform.processing}" :disabled="deleterespform.processing" data-bs-toggle="tooltip" data-bs-placement="top" title="Excluir"><i class="mdi mdi-delete"></i></button>
						</form>
						</div>
						</td>
                    </tr>
                </tbody>
            </table>
        </div>
</AppLayout>
</template>
