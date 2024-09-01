<script setup>
import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import { Head, Link } from '@inertiajs/inertia-vue3';
import JetApplicationMark from 'lochlitecms/Views/Components/Layouts//ApplicationMark.vue';
import JetBanner from 'lochlitecms/Views/Components/Layouts//Banner.vue';
import JetDropdown from 'lochlitecms/Views/Components/Layouts//Dropdown.vue';
import JetDropdownLink from 'lochlitecms/Views/Components/Layouts//DropdownLink.vue';
import JetNavLink from 'lochlitecms/Views/Components/Layouts//NavLink.vue';
import JetResponsiveNavLink from 'lochlitecms/Views/Components/Layouts//ResponsiveNavLink.vue';
import navbar from 'lochlitecms/Views/Customersarea/navbar.vue';
import sidebar from 'lochlitecms/Views/Customersarea/sidebar.vue';

defineProps({
    title: String,
    breadcrumbCurrentTitle: String,
    breadcrumbCurrentSection: String,
    customersarea: Object,
    totalmessages: Number,
    user: Object,
    email: String,
    name: String,
    avatar: String,
    role: String,
    lang: String,
    version: String,
    year: String,
});

const year = new Date().getFullYear();

const logout = () => {
    Inertia.post(route('logout'));
};

const isSideMenuOpen = ref(false);

</script>

<template>
    <Head :title="title" />
     <div class="flex h-screen bg-gray-50 dark:bg-gray-900">
	     <sidebar :customersarea="customersarea" :lang="lang" :role="role" :email="email" :avatar="avatar" :name="name" :user="user" :isSideMenuOpen="isSideMenuOpen" @close-side-menu="isSideMenuOpen = false"></sidebar>
         <div class="flex flex-col flex-1 w-full">
	     <navbar :totalmessages="totalmessages" :customersarea="customersarea" :lang="lang" :role="role" :email="email" :avatar="avatar" :name="name" :user="user" @open-side-menu="isSideMenuOpen = !isSideMenuOpen" />
         <main class="p-6 dark:text-white w-full h-full px-4 overflow-y-auto">
             <JetBanner />
			 <div v-if="(customersarea?.alert || 0).length > 0" class="bg-indigo-500">
             <div class="max-w-screen-xl mx-auto py-2 px-3 sm:px-6 lg:px-8">
                 <div class="flex items-center justify-between flex-wrap">
                     <div class="w-0 flex-1 flex items-center min-w-0">
                         <span class="flex p-2 rounded-lg bg-indigo-600">
                             <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                             <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                             </svg>
                         </span>
			 
                         <p class="ml-3 font-medium text-sm text-white truncate self-center align-self-center py-auto my-auto">
                             {{ customersarea.alert }}
                         </p>
                     </div>                     
                 </div>
             </div>
             </div>
             <div class="card">
                 <div class="card-body">
			     <slot />
                 </div>
             </div>
         </main>
         </div>		
     </div>
</template>
