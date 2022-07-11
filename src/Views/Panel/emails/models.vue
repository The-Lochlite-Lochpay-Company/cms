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
    emails: Object,
    breadcrumbCurrentTitle: String,
    breadcrumbCurrentSection: String,
    menuitems: Object,
});
</script>

<template>
<AppLayout :menuitems="menuitems" :avatar="avatar" :role="role" :name="name" :version="version" :breadcrumbCurrentTitle="breadcrumbCurrentTitle" :breadcrumbCurrentSection="breadcrumbCurrentSection" :title="title">
        <template #breadcrumb></template>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Assunto</th>
                        <th>Criado em</th>
                        <th>Atualizado em</th>
                        <th>Ação</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(row, index)  in allEmails" :key="row.id">
                        <td>{{ row.subject }}</td>
                        <td>{{ new Date(row.created_at).toLocaleString() }}</td>
                        <td>{{ new Date(row.updated_at).toLocaleString() }}</td>
                        <td>
                        <div class="btn-group">
						<Link :href="route('manageremailsmodel.show', {id: row.id})" class="btn btn-outline-light text-dark" data-event="link" data-function="show" :data-model="row.id" data-bs-toggle="tooltip" data-bs-placement="top" title="Ver"><i class="mdi mdi-eye"></i></Link>
						<Link :href="route('manageremailsmodel.edit', {id: row.id})" class="btn btn-outline-light text-dark" data-event="link" data-function="edit" :data-model="row.id" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar"><i class="mdi mdi-pencil"></i></Link>
						</div>
						</td>
                    </tr>
				 </tbody>
            </table>
			 <div class="text-center">
             <button class="border border-gray-600 text-gray-600 px-4 py-2 rounded-full hover:bg-gray-600 hover:text-white" @click="loadMore" :disabled="loadingMore">Show More</button>
             </div>
        </div>
 
</AppLayout>
</template>
<script>
  export default {
   data () {
     return {
       loadingMore: false,
       allEmails: this.emails.data,
       pagination: this.emails,
     };
   },

    methods: {
      loadMore () {
        if (this.loadingMore) return;
 
         axios.get(`?page=${this.pagination.current_page + 1}`)
            .then(({ data }) => {
              this.allEmails = [
                ...data.data,
                ...this.allEmails,
              ];
              this.pagination = data;
            }).catch(err => {
            }).finally(() => this.loadingMore = false);
      }
    },
  }
</script>

