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
    feedbacksresponses: Object,
    breadcrumbCurrentTitle: String,
    breadcrumbCurrentSection: String,
    menulang: Object,
    menuitems: Object,
});

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
        <div class="card-title h4 fw-bold mb-3 pb-0">Answers</div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>IP</th>
                        <th>Created in</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(row, index) in feedbacksresponses.data" :key="row.id">
                        <td>{{ row.name }}</td>
                        <td>{{ row.email }}</td>
                        <td>{{ row.visitor }}</td>
                        <td>{{ new Date(row.created_at).toLocaleString() }}</td>
                        <td>
                        <div class="btn-group">
						<Link :href="route('managerfeedback-responses.show', {id: row.id})" class="btn btn-outline-light text-dark" data-event="link" data-function="show" :data-feedback="row.id" data-bs-placement="top" title="To see"><i class="mdi mdi-eye"></i></Link>
					    <form method="POST" :id="row.id" class="w-100" @submit.prevent="submitdeleteresp">
						<button type="submit" class="btn btn-outline-light text-dark" data-event="submit" data-function="delete" :data-feedback="row.id" :class="{'opacity-25': deleterespform.processing}" :disabled="deleterespform.processing" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"><i class="mdi mdi-delete"></i></button>
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
