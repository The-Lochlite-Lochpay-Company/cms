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
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Article</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Created in</th>
                        <th>Updated in</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(row, index)  in comments.data" :key="row.id">
                        <td class="text-wrap w-7/10 block text-truncate truncate">{{ row.post[0].title }}</td>
                        <td>{{ row.name }}</td>
                        <td>{{ row.email }}</td>
                        <td>{{ new Date(row.created_at).toLocaleString() }}</td>
                        <td>{{ new Date(row.updated_at).toLocaleString() }}</td>
                        <td>
                        <div class="btn-group">
						<Link :href="route('managercomments.show', {id: row.id})" class="btn btn-outline-light text-dark" data-event="link" data-function="show" :data-comments="row.id" data-bs-toggle="tooltip" data-bs-placement="top" title="To see"><i class="mdi mdi-eye"></i></Link>
						<Link :href="route('managercomments.edit', {id: row.id})" class="btn btn-outline-light text-dark" data-event="link" data-function="edit" :data-comments="row.id" data-bs-toggle="tooltip" data-bs-placement="top" title="To edit"><i class="mdi mdi-pencil"></i></Link>
                        <form :id="row.id" class="w-100" @submit.prevent="submit">
                         <JetValidationErrors class="mb-4" />
                         <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
                             {{ status }}
                         </div>
                         <JetButton class="btn btn-outline-light bg-light rounded-0 border-0 text-dark" type="submit" data-event="submit" data-function="delete" :data-comment="row.id" :class="{ 'opacity-25': form.processing }" :disabled="form.processing" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"><i class="mdi mdi-delete"></i> </JetButton>
						</form>
						</div>
						</td>
                    </tr>
				 </tbody>
            </table>
        </div>
 		 <div class="card card-body border-light rounded-0 mt-2 shadow-none"><Pagination class="" :links="comments.links" /></div>

</AppLayout>
</template>