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
    comments: Object,
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
              <span v-if="lang == 'pt_BR'" class="ml-4">Comentários</span>
              <span v-else-if="lang == 'en_US'" class="ml-4">Comments</span>
              <span v-else class="ml-4">Comments</span>
             </div>
         <div class="w-full mb-8 overflow-hidden rounded-lg shadow-xs">
           <div class="w-full overflow-x-auto">
             <table class="w-full whitespace-no-wrap">
               <thead>
                 <tr
                   class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                   <th class="px-4 py-3">
					<span v-if="lang == 'pt_BR'" class="ml-4">Comentário</span>
                    <span v-else-if="lang == 'en_US'" class="ml-4">Comment</span>
                    <span v-else class="ml-4">Comment</span>				   
				   </th>
                   <th class="px-4 py-3">Status</th>
                   <th class="px-4 py-3">
					 <span v-if="lang == 'pt_BR'" class="ml-4">Data</span>
                     <span v-else-if="lang == 'en_US'" class="ml-4">Date</span>
                     <span v-else class="ml-4">Date</span>				   
				   </th>
                 </tr>
               </thead>
               <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                  <tr v-for="row in comments.data" class="text-gray-700 dark:text-gray-400">
                    <td class="px-4 py-3">
                      <div class="flex items-center text-sm">
                        <div class="relative hidden w-8 h-8 mr-3 rounded-full md:block">
                          <img class="object-cover w-full h-full rounded-full" :src="avatar" :alt="name" loading="lazy" />
                          <div class="absolute inset-0 rounded-full shadow-inner" aria-hidden="true"></div>
                        </div>
                        <div>
                          <p class="font-semibold">{{ row.name }}</p>
                          <p class="text-xs text-gray-600 dark:text-gray-400">
                            {{ row.comment }}
                          </p>
                        </div>
                      </div>
                    </td>
                    <td class="px-4 py-3 text-xs">
                      <span v-if="row.status === 'approved'"
                        class="px-2 py-1 font-semibold leading-tight text-green-500 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">
						 <span v-if="lang == 'pt_BR'" class="ml-4">Aprovado</span>
                         <span v-else-if="lang == 'en_US'" class="ml-4">Approved</span>
                         <span v-else class="ml-4">Approved</span>
                      </span>
                      <span v-if="row.status === 'declined'"
                        class="px-2 py-1 font-semibold leading-tight text-red-500 bg-red-100 rounded-full dark:bg-green-700 dark:text-green-100">
                        Declined
                      </span>
                      <span v-if="row.status === 'pending'"
                        class="px-2 py-1 font-semibold leading-tight text-yellow-500 bg-yellow-100 rounded-full dark:bg-green-700 dark:text-green-100">
						 <span v-if="lang == 'pt_BR'" class="ml-4">Pendente</span>
                         <span v-else-if="lang == 'en_US'" class="ml-4">Pending</span>
                         <span v-else class="ml-4">Pending</span>						
                      </span>
                    </td>
                    <td class="px-4 py-3 text-sm">
                      {{ new Date(row.created_at).toLocaleString() }}
                    </td>
                  </tr>
              </tbody>
              </table>
          </div>
          </div>
		 <div class="card card-body border-light rounded-0 mt-2 shadow-none"><Pagination class="" :links="comments.links" /></div>

     </div>
     </div>
</AppLayout>
</template>
