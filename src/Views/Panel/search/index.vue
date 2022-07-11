<script setup>
import { ref } from 'vue';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import JetDialogModal from '@/Jetstream/DialogModal.vue';
import JetButton from '@/Jetstream/Button.vue';
import JetSelect from '@/Jetstream/Select.vue';
import JetInput from '@/Jetstream/Input.vue';
import JetInputError from '@/Jetstream/InputError.vue';
import JetCheckbox from '@/Jetstream/Checkbox.vue';
import JetLabel from '@/Jetstream/Label.vue';
import JetValidationErrors from '@/Jetstream/ValidationErrors.vue';
import AppLayout from '@/Pages/Panel/AppLayout.vue';
import Pagination from '@/Components/Pagination.vue';

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
    type: String,
    query: String,
    search: Object,
    menuitems: Object,
});

const form = useForm({
type: 'posts',
query: '',
});
const submit = (event) => {
    form.post(route('managersearch.store'));
};
</script>

<template>
<AppLayout :menuitems="menuitems" :avatar="avatar" :role="role" :name="name" :version="version" :breadcrumbCurrentTitle="breadcrumbCurrentTitle" :breadcrumbCurrentSection="breadcrumbCurrentSection" :title="title">
        <template #breadcrumb></template>
        <JetValidationErrors class="mb-4" />
	  
    <div class="card card-body shadow-none rounded-0 mb-5">
        <form @submit.prevent="submit">
            <div class="input-group">
                 <select v-model="form.type" id="type" class="form-select border-dark h-8 h py-0 focus:shadow-outline  transition ease-in-out focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="type" required>
				 <option value="posts" selected>Posts</option>
				 <option value="pages">Pages</option>
				 <option value="comments">Comments</option>
				 <option value="routes">Routes</option>
				 <option value="emails">Emails</option>
				 <option value="users">Users</option>
				 </select>
				 <input type="search" id="query" class="form-control border-dark border-left-0 border-right-0 border-l-0 border-r-0 rounded-left-0 rounded-right-0 hover:border-blue focus:shadow-outline transition ease-in-out focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" v-model="form.query" name="query" autocomplete required>  
                 <button type="submit" class="btn btn-primary border-primary rounded-0 rounded-none" title="Search" aria-label="Search" data-module="search" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Search</button>
            </div>
                 <JetInputError for="query" class="mt-2" />
        </form>
      </div>
	  
	 <div v-if="search" class="card card-body bg-light shadow-none rounded-0 my-3 mx-4">
	 <div class="container">
	 <div class="h5 text-dark">Searching for: '{{ query }}' in {{ type }}</div>
	    <div v-for="row in search.data" class="mt-2">
	         <div v-if="type == 'posts'">
	         <Link :href="route('managerposts.show', {id: row.id})" class="text-primary h5">{{ row.title }}</Link>
	         <p class="card-text text-dark">The post was registered on: {{ new Date(row.created_at).toLocaleString() }}, and the last update was on: {{ new Date(row.updated_at).toLocaleString() }}.</p>
	         </div>
	         <div v-else-if="type == 'pages'">
	         <Link :href="route('managerpages.show', {id: row.id})" class="text-primary h5">{{ row.title }}</Link>
	         <p class="card-text text-dark">The page was registered on: {{ new Date(row.created_at).toLocaleString() }}, and the last update was on: {{ new Date(row.updated_at).toLocaleString() }}.</p>
	         </div>
	         <div v-else-if="type == 'comments'">
	         <Link :href="route('managercomments.show', {id: row.id})" class="text-primary h5">{{ row.name }} - {{ row.email }}</Link>
	         <p class="card-text text-dark">The comment was registered on: {{ new Date(row.created_at).toLocaleString() }}, and the last update was on: {{ new Date(row.updated_at).toLocaleString() }}.</p>
	         </div>
	         <div v-else-if="type == 'routes'">
	         <Link :href="route('managerroutes.show', {id: row.id})" class="text-primary h5">{{ row.url }} - {{ row.name }}</Link>
	         <p class="card-text text-dark">The route was registered on: {{ new Date(row.created_at).toLocaleString() }}, and the last update was on: {{ new Date(row.updated_at).toLocaleString() }}.</p>
	         </div>
	         <div v-else-if="type == 'emails'">
	         <Link :href="route('manageremails.show', {id: row.id})" class="text-primary h5">{{ row.to }} - {{ row.subject }}</Link>
	         <p class="card-text text-dark">The email was registered on: {{ new Date(row.created_at).toLocaleString() }}, and the last update was on: {{ new Date(row.updated_at).toLocaleString() }}.</p>
	         </div>
	         <div v-else-if="type == 'users'">
	         <Link :href="route('managerusers.show', {id: row.id})" class="text-primary h5">{{ row.name }} - {{ row.email }}</Link>
	         <p class="card-text text-dark">The user was registered on: {{ new Date(row.created_at).toLocaleString() }}, and the last update was on: {{ new Date(row.updated_at).toLocaleString() }}.</p>
	         </div>
	    </div>
        <Pagination class="mt-2" :links="search.links" :query="'inlinesearch=true&type=' + type + '&query=' + query" />		
     </div>
     </div>
 
</AppLayout>
</template>
