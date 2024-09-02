<script setup>
import { ref } from 'vue';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import JetDialogModal from 'lochlitecms/Views/Components/Layouts/DialogModal.vue';
import JetButton from 'lochlitecms/Views/Components/Layouts/Button.vue';
import JetValidationErrors from 'lochlitecms/Views/Components/Layouts/ValidationErrors.vue';
import AppLayout from 'lochlitecms/Views/Panel/AppLayout.vue';

const props = defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    title: String,
    status: String,
    name: String,
    role: String,
    avatar: String,
    version: String,
    register: Object,
    breadcrumbCurrentTitle: String,
    breadcrumbCurrentSection: String,
    menulang: Object,
    menuitems: Object,
});
const form = useForm();
const submit = (event) => {
    form.delete(route('managerregister.destroy', {id: event.submitter.dataset.register}));
};
</script>

<template>
<AppLayout :menulang="menulang" :menuitems="menuitems" :avatar="avatar" :role="role" :name="name" :version="version" :breadcrumbCurrentTitle="breadcrumbCurrentTitle" :breadcrumbCurrentSection="breadcrumbCurrentSection" :title="title">
        <template #breadcrumb>
              <li class="breadcrumb-item active text-truncate w-50" aria-current="page">Registration pages</li>
        </template>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Domain</th>
                        <th>Title</th>
                        <th>Default</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(row, index)  in register.data" :key="row.id">
                        <td>{{ row.id }}</td>
                        <td>{{ row.domain }}</td>
                        <td>{{ row.title }}</td>
                        <td>{{ row.default == 1 ? 'true' : 'false' }}</td>
                        <td>{{ row.status }}</td>
                        <td>
                        <div class="btn-group">
						<Link :href="row.id + '/register'" class="btn btn-outline-light text-dark" data-event="link" data-function="show" :data-post="row.id" data-bs-toggle="tooltip" data-bs-placement="top" title="To see"><i class="mdi mdi-eye"></i></Link>
						<Link :href="route('managerregister.edit', {id: row.id})" class="btn btn-outline-light text-dark" data-event="link" data-function="edit" :data-post="row.id" data-bs-toggle="tooltip" data-bs-placement="top" title="To edit"><i class="mdi mdi-pencil"></i></Link>
                        <form v-if="row.default == false" :id="row.id" class="w-100" @submit.prevent="submit">
                         <JetValidationErrors class="mb-4" />
                         <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
                             {{ status }}
                         </div>
                         <JetButton class="btn btn-outline-light bg-light rounded-0 border-0 text-dark" type="submit" data-event="submit" data-function="delete" :data-register="row.id" :class="{ 'opacity-25': form.processing }" :disabled="form.processing" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"><i class="mdi mdi-delete"></i> </JetButton>
						</form>
						</div>
						</td>
                    </tr>
				 </tbody>
            </table>
        </div>
</AppLayout>
</template>
