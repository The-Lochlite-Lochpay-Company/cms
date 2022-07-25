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
    mynotifications: Object,
    user: Object,
    email: String,
    name: String,
    avatar: String,
    customersarea: Object,
    history: Object,
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
              <span v-if="lang == 'pt_BR'" class="ml-4">Histórico</span>
              <span v-else-if="lang == 'en_US'" class="ml-4">History</span>
              <span v-else class="ml-4">History</span>
             </div>
                 <div class="w-full mb-8 overflow-hidden rounded-lg shadow-xs">
                     <div class="w-full overflow-x-auto">
                         <table class="w-full whitespace-no-wrap">
                          <thead>
                            <tr
                              class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                              <th class="px-4 py-3">
							   <span v-if="lang == 'pt_BR'" class="ml-4">Descrição</span>
                               <span v-else-if="lang == 'en_US'" class="ml-4">Description</span>
                               <span v-else class="ml-4">Description</span>
							  </th>
                              <th class="px-4 py-3">
							   <span v-if="lang == 'pt_BR'" class="ml-4">Data</span>
                               <span v-else-if="lang == 'en_US'" class="ml-4">Date</span>
                               <span v-else class="ml-4">Date</span>							  
							  </th>
                            </tr>
                          </thead>
                          <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                             <tr v-for="row in history.data" class="text-gray-700 dark:text-gray-400">
                               <td class="px-4 py-3">
                                   {{ row.description }}
                               </td>
                               <td class="px-4 py-3 text-sm">
                                 {{ new Date(row.created_at).toLocaleString() }}
                               </td>
                             </tr>
                         </tbody>
                         </table>
                     </div>
                 </div>
	           	 <div class="card card-body border-light rounded-0 mt-2 shadow-none"><Pagination class="" :links="history.links" /></div>

     </div>
     </div>
</AppLayout>
</template>
