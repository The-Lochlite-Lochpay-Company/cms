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
    disk: Number,
    diskfreespace: Number,
    users: Number,
    plugins: Number,
    settings: Number,
    domains: Object,
    breadcrumbCurrentTitle: String,
    breadcrumbCurrentSection: String,
    menulang: Object,
    menuitems: Object,
});
const form = useForm({});
const submit = (event) => {
  form.transform((data) => ({
   module: event.submitter.dataset.module
  }))	
  .post(route('managersettings.store'));
};

</script>

<template>
<AppLayout :menulang="menulang" :menuitems="menuitems" :avatar="avatar" :role="role" :name="name" :version="version" :breadcrumbCurrentTitle="breadcrumbCurrentTitle" :breadcrumbCurrentSection="breadcrumbCurrentSection" :title="title">

     <div class="row px-3">
     <div class="col">
     <div class="card shadow-none my-2">
     <div class="row">
         <div class="col-12 col-md-3 py-1 text-center mx-auto align-self-center border-0 bg-primary">
         <i class="fa-solid fa-compact-disc h3 align-self-center text-white"></i>
         </div>   
         <div class="col-12 col-md-9 py-1 px-4 align-self-center border-0 bg-transparent">
         <div class="fw-bold font-bold pt-3 align-self-center">Disk Space</div>
		 <p>{{ diskfreespace }}/{{ disk }}</p>
         </div>   
     </div>
     </div>
     </div>
	 
     <div class="col">
     <div class="card shadow-none my-2">
     <div class="row">
         <div class="col-12 col-md-3 py-1 text-center mx-auto align-self-center border-0 bg-warning">
         <i class="fa-solid fa-users h3 align-self-center text-white"></i>
         </div>   
         <div class="col-12 col-md-9 py-1 px-4 align-self-center border-0 bg-transparent">
         <div class="fw-bold font-bold pt-3 mt-1 align-self-center">Total users</div>
		 <p>{{ users }}</p>
         </div>   
     </div>
     </div>
     </div>
     <div class="col">
     <div class="card shadow-none my-2">
     <div class="row">
         <div class="col-12 col-md-3 py-1 text-center mx-auto align-self-center border-0 bg-success">
         <i class="fa-solid fa-plug-circle-check h3 align-self-center text-white"></i>
         </div>   
         <div class="col-12 col-md-9 py-1 px-4 align-self-center border-0 bg-transparent">
         <div class="fw-bold font-bold pt-3 mt-1 align-self-center">Active plugins</div>
		 <p>{{ plugins }}</p>
         </div>   
     </div>
     </div>
     </div>
     <div class="col">
     <div class="card shadow-none my-2">
     <div class="row">
         <div class="col-12 col-md-3 py-1 text-center mx-auto align-self-center border-0 bg-danger">
         <i class="fa-solid fa-globe h3 align-self-center text-white"></i>
         </div>   
         <div class="col-12 col-md-9 py-1 px-4 align-self-center border-0 bg-transparent">
         <div class="fw-bold font-bold pt-3 mt-1 align-self-center">Active domains</div>
		 <p>{{ domains.length }}</p>
         </div>   
     </div>
     </div>
     </div>

     </div>

     <div class="row row-cols-1 row-cols-md-4 w-full w-100">
     <div class="col">
     <Link :href="route('managerstorange.index')" class="card text-center bg-light shadow-none my-2 ">
         <div class="card-header border-0 bg-transparent">
         <i class="fa-solid fa-cloud h3"></i>
         </div>   
         <div class="card-body border-0 bg-transparent">
         Storage
         </div>   
     </Link>
     </div>
	 
     <div class="col">
     <Link :href="route('manageremails.index')" class="card text-center bg-light shadow-none my-2 ">
         <div class="card-header border-0 bg-transparent">
         <i class="fa-solid fa-envelope h3"></i>
         </div>   
         <div class="card-body border-0 bg-transparent">
         Emails
         </div>   
     </Link>   
     </div>   

     <div class="col">
     <Link :href="route('managerusers.index')" class="card text-center bg-light shadow-none my-2">
         <div class="card-header border-0 bg-transparent">
         <i class="fa-solid fa-people-group h3"></i>
         </div>   
         <div class="card-body border-0 bg-transparent">
         Users
         </div>   
     </Link>   
     </div>   

     <div class="col">
     <Link :href="route('managersettings.index')" class="card text-center bg-light shadow-none my-2">
         <div class="card-header border-0 bg-transparent">
         <i class="fa-solid fa-gears h3"></i>
         </div>   
         <div class="card-body border-0 bg-transparent">
         Settings
         </div>   
     </Link>   
     </div>   
     </div> 

     <div class="row bg-light py-4 px-3 mt-4">
         <div class="col-12 col-md-6">
             <div class="card shadow-none h-100">
                 <div class="card-header border-0 bg-white">
				 <div class="h4">Domains</div>
				 </div>
                 <div class="card-body table-responsive">
	                 <table class="table table-hover">
                     <thead>
                       <tr>
                         <th scope="col">#</th>
                         <th scope="col">Domain</th>
                         <th scope="col">Status</th>
                         <th scope="col">Updated in</th>
                       </tr>
                     </thead>
                     <tbody>
                       <tr v-for="(row,index) in domains">
                         <th scope="row">{{ row.id }}</th>
                         <td>{{ row.domain }}</td>
                         <td>{{ row.status }}</td>
                         <td>{{ new Date(row.updated_at).toLocaleString() }}</td>
                       </tr>
                     </tbody>
                     </table>
                 </div>   
             </div>   
         </div>   
         <div class="col-12 col-md-6">
             <div class="card shadow-none h-100">
                 <div class="card-header border-0 bg-white">
				 <div class="h4">Shortcuts</div>
				 </div>
                 <div class="card-body">
                     <ul class="list-group">
                       <li class="list-group-item list-group-item-action border-light d-flex justify-content-between align-items-center">
                         Optimize the site
                        <form id="optimize" method="POST" @submit.prevent="submit">
                        <button type="submit" class="btn btn-primary" data-module="optimize" :class="{ 'opacity-25': form.processing }" :disabled="form.processing"><i class="mdi mdi-lightning-bolt"></i></button>
                        </form>
                       </li>
                       <li class="list-group-item list-group-item-action border-light d-flex justify-content-between align-items-center">
                         Clear website cache
                         <form id="cleanall" method="POST" @submit.prevent="submit">
                         <button type="submit" class="btn btn-primary" data-module="cleanall" :class="{ 'opacity-25': form.processing }" :disabled="form.processing"><i class="mdi mdi-vacuum"></i></button>
                         </form>
                       </li>
                       <li class="list-group-item list-group-item-action border-light d-flex justify-content-between align-items-center">
                         Send an email
                         <Link :href="route('manageremails.create')" class="btn btn-primary"><i class="mdi mdi-button-cursor"></i></Link>
                       </li>
                       <li class="list-group-item list-group-item-action border-light d-flex justify-content-between align-items-center">
                         Create new user
                         <Link :href="route('managerusers.create')" class="btn btn-primary"><i class="mdi mdi-account-multiple-plus"></i></Link>
                       </li>
                     </ul>	 
                 </div>   
             </div>   
         </div>   
     </div>   
 
</AppLayout>
</template>