<script setup>
import { ref, defineAsyncComponent } from 'vue';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import AppLayout from 'lochlitecms/Views/Customersarea/AppLayout.vue';
import LoadingComponent from 'lochlitecms/Views/Components/LoadingComponent.vue';
import ErrorComponent from 'lochlitecms/Views/Components/ErrorComponent.vue';

const props = defineProps({
    title: String,
    lang: String,
    status: String,
    user: Object,
    email: String,
    name: String,
    avatar: String,
    tab: String,
    customersarea: Object,
    mynotifications: Object,
    notifications: Object,
});

const Pagination = defineAsyncComponent({
  loader: () => import("lochlitecms/Views/Components/Pagination.vue"),
  loadingComponent: LoadingComponent,
  errorComponent: ErrorComponent,
  delay: 500,
  timeout: 5000,
})

</script>

<template>
<AppLayout :totalmessages="mynotifications.total" :customersarea="customersarea" :lang="lang" :user="user" :name="name" :email="email" :avatar="avatar" :title="title">
     <div class="container">
         <div class="card card-body bg-white dark:bg-gray-800 py-3 px-4">
             <div class="h4 mb-4 text-lg font-semibold text-gray-600 dark:text-gray-300">
              <span v-if="lang == 'pt_BR'" class="ml-4">Notificações</span>
              <span v-else-if="lang == 'en_US'" class="ml-4">Notifications</span>
              <span v-else class="ml-4">Notifications</span>
             </div>
		     <ul class="nav nav-tabs flex flex-col md:flex-row flex-wrap list-none border-b-0 pl-0 mb-4" id="tabs-tab" role="tablist">
                 <li class="nav-item" role="presentation">
                   <a href="#tabs-home" class="
                     nav-link
                     block
                     font-medium
                     text-xs
                     leading-tight
                     uppercase
                     border-x-0 border-t-0 border-b-2 border-transparent
                     px-6
                     py-3
                     my-2
                     hover:border-transparent hover:bg-gray-100
                     focus:border-transparent
                   " :class="{'active': tab == null || tab == 'mynotifications'}" id="tabs-home-tab" data-bs-toggle="pill" data-bs-target="#tabs-home" role="tab" aria-controls="tabs-home"
                     aria-selected="true">
                         <span v-if="lang == 'pt_BR'" class="ml-4">Minhas notificações</span>
                         <span v-else-if="lang == 'en_US'" class="ml-4">My notifications</span>
                         <span v-else class="ml-4">My notifications</span>							  					 
					 </a>
                 </li>
                 <li class="nav-item" role="presentation">
                   <a href="#tabs-profile" class="
                     nav-link
                     block
                     font-medium
                     text-xs
                     leading-tight
                     uppercase
                     border-x-0 border-t-0 border-b-2 border-transparent
                     px-6
                     py-3
                     my-2
                     hover:border-transparent hover:bg-gray-100
                     focus:border-transparent
                   " :class="{'active': tab == 'notifications'}" id="tabs-profile-tab" data-bs-toggle="pill" data-bs-target="#tabs-profile" role="tab"
                     aria-controls="tabs-profile" aria-selected="false">
                        <span v-if="lang == 'pt_BR'" class="ml-4">Todas as notificações</span>
                        <span v-else-if="lang == 'en_US'" class="ml-4">All notifications</span>
                        <span v-else class="ml-4">All notifications</span>							  					 
					 </a>
                 </li>
             </ul>
             <div class="tab-content" id="tabs-tabContent">
             <div class="tab-pane fade" :class="{'active show': tab == null || tab == 'mynotifications'}" id="tabs-home" role="tabpanel" aria-labelledby="tabs-home-tab">
                 <div class="w-full mb-8 overflow-hidden rounded-lg shadow-xs">
                     <div class="w-full overflow-x-auto">
                         <table class="w-full whitespace-no-wrap">
                          <thead>
                            <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                              <th class="px-4 py-3">
                               <span v-if="lang == 'pt_BR'" class="ml-4">Assunto</span>
                               <span v-else-if="lang == 'en_US'" class="ml-4">Subject</span>
                               <span v-else class="ml-4">Subject</span>							  
							  </th>
                              <th class="px-4 py-3">
                               <span v-if="lang == 'pt_BR'" class="ml-4">Mensagem</span>
                               <span v-else-if="lang == 'en_US'" class="ml-4">Message</span>
                               <span v-else class="ml-4">Message</span>							  
							  </th>
                              <th class="px-4 py-3">
							     <span v-if="lang == 'pt_BR'" class="ml-4">Data</span>
                                 <span v-else-if="lang == 'en_US'" class="ml-4">Date</span>
                                 <span v-else class="ml-4">Date</span>
							  </th>
                            </tr>
                          </thead>
                          <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                             <tr v-for="row in mynotifications.data" class="text-gray-700 dark:text-gray-400">
                               <td class="px-4 py-3">
                                   {{ row.title }}
                               </td>
                               <td class="px-4 py-3">
                                   {{ row.body }}
                               </td>
                               <td class="px-4 py-3 text-sm">
                                 {{ new Date(row.created_at).toLocaleString() }}
                               </td>
                             </tr>
                         </tbody>
                         </table>
                     </div>
                 </div>
	           	 <div class="card card-body border-light rounded-0 mt-2 shadow-none"><Pagination class="" :links="mynotifications.links" /></div>
             </div>
             <div class="tab-pane fade" :class="{'active show': tab == 'notifications'}" id="tabs-profile" role="tabpanel" aria-labelledby="tabs-profile-tab">
	  	         <div class="w-full mb-8 overflow-hidden rounded-lg shadow-xs">
                     <div class="w-full overflow-x-auto">
                     <table class="w-full whitespace-no-wrap">
                          <thead>
                            <tr
                              class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                              <th class="px-4 py-3">
                               <span v-if="lang == 'pt_BR'" class="ml-4">Assunto</span>
                               <span v-else-if="lang == 'en_US'" class="ml-4">Subject</span>
                               <span v-else class="ml-4">Subject</span>							  
							  </th>
                              <th class="px-4 py-3">
                               <span v-if="lang == 'pt_BR'" class="ml-4">Mensagem</span>
                               <span v-else-if="lang == 'en_US'" class="ml-4">Message</span>
                               <span v-else class="ml-4">Message</span>							  
							  </th>
                              <th class="px-4 py-3">
							     <span v-if="lang == 'pt_BR'" class="ml-4">Data</span>
                                 <span v-else-if="lang == 'en_US'" class="ml-4">Date</span>
                                 <span v-else class="ml-4">Date</span>
							  </th>
                            </tr>
                          </thead>
                       <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                          <tr v-for="row in notifications.data" class="text-gray-700 dark:text-gray-400">
                            <td class="px-4 py-3">
                                {{ row.title }}
                            </td>
                            <td class="px-4 py-3">
                                {{ row.body }}
                            </td>
                            <td class="px-4 py-3 text-sm">
                              {{ new Date(row.created_at).toLocaleString() }}
                            </td>
                          </tr>
                      </tbody>
                      </table>
                     </div>
                 </div>
	  	         <div class="card card-body border-light rounded-0 mt-2 shadow-none"><Pagination class="" :links="notifications.links" /></div>
             </div>
	     </div>
		 
     </div>
     </div>
</AppLayout>
</template>
