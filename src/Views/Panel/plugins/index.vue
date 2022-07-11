<script setup>
import { ref } from 'vue';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import JetDialogModal from '@/Jetstream/DialogModal.vue';
import JetButton from '@/Jetstream/Button.vue';
import JetValidationErrors from '@/Jetstream/ValidationErrors.vue';
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
    breadcrumbCurrentTitle: String,
    breadcrumbCurrentSection: String,
    menuitems: Object,
    plugins: Object,
});
const form = useForm();
const submit = (event) => {
    form.delete(route('managerposts.destroy', {id: event.submitter.dataset.post}));
};

</script>

<template>
<AppLayout :menuitems="menuitems" :avatar="avatar" :role="role" :name="name" :version="version" :breadcrumbCurrentTitle="breadcrumbCurrentTitle" :breadcrumbCurrentSection="breadcrumbCurrentSection" :title="title">
        <div class="table-responsive overflow-auto h-25 mt-3">
            <table class="table overflow-auto h-25">
                <thead>
                    <tr>
                        <th>Namespace</th>
                        <th>Name</th>
                        <th>Version</th>
                        <th>Path</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(row, index)  in plugins" :key="row.id">
                        <td>{{ row.namespace }}</td>
                        <td>{{ row.name }}</td>
                        <td>{{ row.version }}</td>
                        <td>{{ row.path }}</td>
                        <td>{{ row.status }}</td>
                    </tr>
				 </tbody>
            </table>
        </div>
</AppLayout>
</template>

