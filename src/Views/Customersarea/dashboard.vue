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
    posts: Object,
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
     <div class="card card-body dark:border-0 bg-white dark:bg-gray-800 py-4 px-2 md:px-5">
         <div class="h4 mb-4 text-lg font-semibold text-gray-600 dark:text-gray-300">
              <span v-if="lang == 'pt_BR'" class="ml-4">Últimas postagens</span>
              <span v-else-if="lang == 'en_US'" class="ml-4">Latest posts</span>
              <span v-else class="ml-4">Latest posts</span>
         </div>

             <div class="flex flex-wrap -mx-1 lg:-mx-4">
         
                 <!-- Column -->
                 <div v-for="rowposts in posts" class="my-1 px-1 w-full md:w-1/2 lg:my-4 lg:px-4 lg:w-1/3">
         
                     <!-- Article -->
                     <article class="overflow-hidden border border-dark rounded-lg shadow-none">
         
                         <a :href="route('blog.show', {id: rowposts.url})">
                             <img alt="Placeholder" class="block h-auto w-full" :src="rowposts.imgcap">
                         </a>
         
                         <header class="flex items-center justify-between leading-tight p-2 md:p-4">
                             <h1 class="text-lg">
                                 <a class="no-underline hover:underline text-black dark:text-white line-clamp-2" :href="route('blog.show', {id: rowposts.url})">
                                     {{ rowposts.title }}
                                 </a>
                             </h1>
                             <p class="text-grey-darker text-sm">
                                 {{ new Date(rowposts.created_at).toLocaleString() }}
                             </p>
                         </header>
         
                         <footer class="flex items-center justify-between leading-none p-2 md:p-4">
                             <a class="flex items-center no-underline hover:underline text-black" :href="route('blog.show', {id: rowposts.url})">
                                 <img alt="Placeholder" width="46" height="46" class="block rounded-full" :src="rowposts.author_avatar">
                                 <p class="ml-2 text-sm dark:text-white">
                                     {{ rowposts.authors }}
                                 </p>
                             </a>
                             <div class="no-underline text-grey-darker hover:text-red-dark">
                                 <div class="text-xs px-3 bg-gray-800 text-white dark:font-bold rounded-full">{{ rowposts.category }}</div>
                             </div>
                         </footer>
         
                     </article>
                     <!-- END Article -->
         
                 </div>
                 <!-- END Column -->
         
             </div>
			 
          </div>
     </div>
</AppLayout>
</template>
