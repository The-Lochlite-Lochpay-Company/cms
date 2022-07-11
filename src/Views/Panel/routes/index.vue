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
    routes: Object,
    breadcrumbCurrentTitle: String,
    breadcrumbCurrentSection: String,
    menuitems: Object,
});
const form = useForm();
const submit = (event) => {
    form.delete(route('managerroutes.destroy', {id: event.submitter.dataset.route}));
};
</script>

<template>
<AppLayout :menuitems="menuitems" :avatar="avatar" :role="role" :name="name" :version="version" :breadcrumbCurrentTitle="breadcrumbCurrentTitle" :breadcrumbCurrentSection="breadcrumbCurrentSection" :title="title">
        <template #breadcrumb></template>
		<div class="my-2"><Link :href="route('managerroutes.create')" class="btn btn-primary">Adicionar rota</Link></div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>URL</th>
                        <th>Nome</th>
                        <th>Tipo</th>
                        <th>Atualizado em</th>
                        <th>Ação</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(row, index)  in allRoutes" :key="row.id">
                        <td>{{ row.id }}</td>
                        <td>{{ row.url }}</td>
                        <td>{{ row.name }}</td>
                        <td>{{ row.type }}</td>
                        <td>{{ new Date(row.updated_at).toLocaleString() }}</td>
                        <td>
                        <div class="btn-group">
						<Link :href="route('managerroutes.show', {id: row.id})" class="btn btn-outline-light text-dark" data-event="link" data-function="show" :data-post="row.id" data-bs-toggle="tooltip" data-bs-placement="top" title="Ver"><i class="mdi mdi-eye"></i></Link>
						<Link v-if="row.system == false" :href="route('managerroutes.edit', {id: row.id})" class="btn btn-outline-light text-dark" data-event="link" data-function="edit" :data-post="row.id" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar"><i class="mdi mdi-pencil"></i></Link>
                        <form v-if="row.system == false" :id="row.id" class="w-100" @submit.prevent="submit">
                         <JetValidationErrors class="mb-4" />
                         <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
                             {{ status }}
                         </div>
                         <JetButton class="btn btn-outline-light bg-light rounded-0 border-0 text-dark" type="submit" data-event="submit" data-function="delete" :data-route="row.id" :class="{ 'opacity-25': form.processing }" :disabled="form.processing" data-bs-toggle="tooltip" data-bs-placement="top" title="Excluir"><i class="mdi mdi-delete"></i> </JetButton>
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
       allRoutes: this.routes.data,
       pagination: this.routes,
     };
   },

    methods: {
      loadMore () {
        if (this.loadingMore) return;
 
         axios.get(`?page=${this.pagination.current_page + 1}`)
            .then(({ data }) => {
              this.allRoutes = [
                ...data.data,
                ...this.allRoutes,
              ];
              this.pagination = data;
            }).catch(err => {
            }).finally(() => this.loadingMore = false);
      }
    },
  }
</script>

