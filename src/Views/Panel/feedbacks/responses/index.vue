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
    feedbacksresponses: Object,
    breadcrumbCurrentTitle: String,
    breadcrumbCurrentSection: String,
    menuitems: Object,
});

const deleterespform = useForm();
const submitdeleteresp = (event) => {
    form.delete(route('managerfeedback-responses.destroy', {id: event.submitter.dataset.feedback}));
};
</script>

<template>
<AppLayout :menuitems="menuitems" :avatar="avatar" :role="role" :name="name" :version="version" :breadcrumbCurrentTitle="breadcrumbCurrentTitle" :breadcrumbCurrentSection="breadcrumbCurrentSection" :title="title">
        <template #breadcrumb></template>
        <div class="card-title h4 fw-bold mb-3 pb-0">Respostas</div>
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
                    <tr v-for="(row, index) in feedbacksresponses.data" :key="row.id">
                        <td>{{ row.name }}</td>
                        <td>{{ row.email }}</td>
                        <td>{{ row.visitor }}</td>
                        <td>{{ new Date(row.created_at).toLocaleString() }}</td>
                        <td>
                        <div class="btn-group">
						<Link :href="route('managerfeedback-responses.show', {id: row.id})" class="btn btn-outline-light text-dark" data-event="link" data-function="show" :data-feedback="row.id" data-bs-placement="top" title="Ver"><i class="mdi mdi-eye"></i></Link>
					    <form method="POST" :id="row.id" class="w-100" @submit.prevent="submitdeleteresp">
						<button type="submit" class="btn btn-outline-light text-dark" data-event="submit" data-function="delete" :data-feedback="row.id" :class="{'opacity-25': deleterespform.processing}" :disabled="deleterespform.processing" data-bs-toggle="tooltip" data-bs-placement="top" title="Excluir"><i class="mdi mdi-delete"></i></button>
						</form>
						</div>
						</td>
                    </tr>

                </tbody>
            </table>
			 <div class="text-center">
             <button class="border border-gray-600 text-gray-600 px-4 py-2 rounded-full hover:bg-gray-600 hover:text-white mt-3" @click="loadMore" :disabled="loadingMore">Show More</button>
             </div>			
        </div>
</AppLayout>
</template>
<script>
  export default {
   data () {
     return {
       loadingMore: false,
       allResponses: this.feedbacksresponses.data,
       pagination: this.feedbacksresponses,
     };
   },

    methods: {
      loadMore () {
        if (this.loadingMore) return;
 
         axios.get(`?page=${this.pagination.current_page + 1}`)
            .then(({ data }) => {
              this.allResponses = [
                ...data.data,
                ...this.allResponses,
              ];
              this.pagination = data;
            }).catch(err => {
            }).finally(() => this.loadingMore = false);
      }
    },
  }
</script>