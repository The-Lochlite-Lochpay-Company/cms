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
    feedbacks: Object,
    feedbacksresponses: Object,
    breadcrumbCurrentTitle: String,
    breadcrumbCurrentSection: String,
    menulang: Object,
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
        <div class="card-title h4 fw-bold mt-4 mb-3 pb-0">Questions</div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Question</th>
                        <th>Created in</th>
                        <th>Updated in</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(row, index)  in feedbacks" :key="row.id">
                        <td>{{ row.question }}</td>
                        <td>{{ new Date(row.created_at).toLocaleString() }}</td>
                        <td>{{ new Date(row.updated_at).toLocaleString() }}</td>
                        <td>
                        <div class="btn-group">
						<Link :href="route('managerfeedbacks.show', {id: row.id})" class="btn btn-outline-light text-dark" data-event="link" data-function="show" :data-feedback="row.id" data-bs-placement="top" title="To see"><i class="mdi mdi-eye"></i></Link>
						<Link :href="route('managerfeedbacks.edit', {id: row.id})" class="btn btn-outline-light text-dark" data-event="link" data-function="edit" :data-feedback="row.id" data-bs-placement="top" title="To edit"><i class="mdi mdi-pencil"></i></Link>
					    <form method="POST" :id="row.id" class="w-100" @submit.prevent="submit">
						<button type="submit" class="btn btn-outline-light text-dark" data-event="submit" data-function="delete" :data-feedback="row.id" :class="{ 'opacity-25': form.processing }" :disabled="form.processing" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"><i class="mdi mdi-delete"></i></button>
						</form>
						</div>
						</td>
                    </tr>
                </tbody>
            </table>
        </div>
		<Link class="btn btn-primary bg-primary text-white p-2 mt-3" :href="route('managerfeedbacks.create')">New question</Link>
        <div class="card-title h4 fw-bold mt-4 mb-3 pb-0">Latest replies</div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>IP</th>
                        <th>Created in</th>
                        <th>Action</th>
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
						<Link :href="route('managerfeedback-responses.show', {id: resp.id})" class="btn btn-outline-light text-dark" data-event="link" data-function="show" :data-user="resp.id" data-bs-placement="top" title="To see"><i class="mdi mdi-eye"></i></Link>
					    <form method="POST" :id="resp.id" class="w-100" @submit.prevent="submitdeleteresp">
						<button type="submit" class="btn btn-outline-light text-dark" data-event="submit" data-function="delete" :data-feedback="resp.id" :class="{'opacity-25': deleterespform.processing}" :disabled="deleterespform.processing" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"><i class="mdi mdi-delete"></i></button>
						</form>
						</div>
						</td>
                    </tr>
                </tbody>
            </table>
        </div>
		 <div class="card card-body border-light rounded-0 mt-2 shadow-none"><Pagination class="" :links="feedbacksresponses.links" /></div>
</AppLayout>
</template>
