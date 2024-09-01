<script setup>
import { ref } from 'vue';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import JetDialogModal from 'lochlitecms/Views/Components/Layouts/DialogModal.vue';
import JetButton from 'lochlitecms/Views/Components/Layouts/Button.vue';
import JetValidationErrors from 'lochlitecms/Views/Components/Layouts/ValidationErrors.vue';
import AppLayout from 'lochlitecms/Views/Panel/AppLayout.vue';

defineProps({
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
    menulang: Object,
    menuitems: Object,
    updates: Object,
});
const form = useForm();
const submit = (event) => {
    form.post(route('managerupdates.store'));
};
</script>

<template>
<AppLayout :menulang="menulang" :menuitems="menuitems" :avatar="avatar" :role="role" :name="name" :version="version" :breadcrumbCurrentTitle="breadcrumbCurrentTitle" :breadcrumbCurrentSection="breadcrumbCurrentSection" :title="title">
         <div class="card shadow-none mb-3">
           <div class="row g-0">
             <div class="col-md-4">
               <img src="/application/update.jpg" class="img-fluid rounded-start" alt="...">
             </div>
             <div class="col-md-8">
               <div class="card-body">
                 <h5 class="card-title">Preserve a segurança do seu site</h5>
                 <p class="card-text">Mantenha a sua instalação sempre atualizada para receber as mais recentes correções de segurança e desempenho, alem de novos recursos que facilitam o seu dia a dia.</p>
                 <form id="formupdate" class="w-100 row" @submit.prevent="submit">
                 <button type="submit" class="btn btn-dark text-white fw-bold me-auto mr-auto" data-event="submit" data-function="store" :class="{ 'opacity-25': form.processing }" :disabled="form.processing" data-bs-toggle="tooltip" data-bs-placement="top" title="Clique para atualizar">Verificar se há atualizações</button>
                 <div class="col-12 col-md-6">
				 <JetValidationErrors class="mb-4" />
                 <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
                     {{ status }}
                 </div>
                 </div>
                 </form>
               </div>
             </div>
           </div>
         </div>
	  
         <div class="p-2 my-3 card card-body card-text text-center text-white fw-bold font-bold font-weight-bold bg-purple-800" style="background-color: rgb(107 33 168);">Versão atual: {{ version }}</div>

         <div class="table-responsive overflow-auto h-25 mt-3">
            <table class="table overflow-auto h-25">
                <thead>
                    <tr>
                        <th>Versão</th>
                        <th>Versão anterior</th>
                        <th>Data</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(row, index) in updates.data" :key="row.id">
                        <td>{{ row.version }}</td>
                        <td>{{ row.lastversion }}</td>
                        <td>{{ new Date(row.created_at).toLocaleString() }}</td>
                        <td>{{ row.status }}</td>
                    </tr>
				 </tbody>
            </table>
        </div>
</AppLayout>
</template>

