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
    wallpaper: String,
    customersarea: Object,
});
const themingcolor = props.customersarea.themecolor;
const urlwallpaper = 'url(' + (props.wallpaper ?? '/application/wallpaper.jpg') + ')';
const Pagination = defineAsyncComponent({
  loader: () => import("lochlitecms/Views/Components/Pagination.vue"),
  loadingComponent: LoadingComponent,
  errorComponent: ErrorComponent,
  delay: 500,
  timeout: 5000,
})

</script>
<style scoped>
.border-theming{
    border-color: v-bind(themingcolor);
}
.text-theming{
    color: v-bind(themingcolor);
    fill: v-bind(themingcolor);
}
.bg-background{
    position: relative;
}
.bg-background::before{
     content: " ";
     display: block;
     position: absolute;
     left: 0;
     top: 0;
     width: 100%;
     height: 100%;
     z-index: 0;
     background-image: v-bind(urlwallpaper);
     background-repeat: no-repeat;
     background-position: top;
     object-fit: cover;
     background-size: 100% 100%;
     margin: 0;
     padding: 0;
}
</style>
<template>
<AppLayout :totalmessages="mynotifications.total" :customersarea="customersarea" :lang="lang" :user="user" :name="name" :email="email" :avatar="avatar" :title="title">
     <div class="container">
         <div class="card card-body bg-white dark:bg-gray-800 py-3 px-4">
             
         <div class="bg-background rounded-md section-1 h-52 md:h-64">

             <div class="px-6 pt-14 mt-8 absolute z-10 flex">                
                 <div class="relative w-16 h-16  md:w-28 md:h-28">
                   <img :src="avatar" class="cat rounded-full w-full h-full border-theming border-2 border-blue-500">
                   <div :class="{'bg-green-600': !user.email_verified_at == null, 'bg-red-500': user.email_verified_at == null}" class="absolute w-4 h-4 right-0 md:right-2 bottom-1 md:bottom-2 rounded-full text-white text-xs text-center leading-4">
                     <svg v-if="!user.email_verified_at == null" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                       <title>This account is verified</title>
                       <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                     </svg>
					 <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <title>This account has not been verified</title>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                     </svg>
                   </div>
                 </div>
                 <div class="relative mx-4 bottom-2 px-2 md:px-0 py-3 md:py-10 font-mono text-xl md:text-2xl text-gray-300">
                     <p class="font-bold fw-bold">{{ name }}</p>
                     <div class="my-2 flex space-x-4">
                         <a :href="route('dashboard.editprofile') + '?tab=photo'"><span class="bg-blue-600 text-gray-200 text-xs px-2 py-1 rounded-full">Editar foto</span></a>
                     </div>                     
                 </div>
             </div> 
			 
         </div>

         <div class="w-full py-4 px-8 bg-white dark:bg-gray-800 shadow-sm dark:shadow-md rounded-lg my-20">
           <div class="flex justify-center md:justify-end -mt-16">
             <Link :href="route('dashboard.editprofile') + '?tab=address'" class="p-2 rounded-full border-2 border-theming">
			 <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
             </svg>
             </Link>
           </div>
           <address class="text-dark dark:text-white">
             <div class="h4 font-normal text-dark dark:text-white text-3xl">{{ user.address ?? '________________________________' }}</div>
             {{ user.city ?? '__________'}} {{ user.state ?? '_____________' }} {{ user.country ?? '_____________' }} <br/>
             {{ user.zipcode ?? '_____________' }} <br/>
           </address>
           <div class="flex justify-end mt-4">
             <div class="text-xl font-medium text-theming">Address</div>
           </div>
         </div>
		 
         <div class="w-full py-4 px-8 bg-white dark:bg-gray-800 shadow-sm dark:shadow-md rounded-lg my-20">
           <div class="flex justify-center md:justify-end -mt-16">
             <Link :href="route('dashboard.editprofile') + '?tab=personal'" class="p-2 rounded-full border-2 border-theming">
			 <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
             </svg>
             </Link>
           </div>
           <div class="text-dark dark:text-white">
             <div class="h4 font-normal text-dark dark:text-white text-3xl">{{ user.name ?? '________' }} {{ user.last_name ?? '________ ________' }}</div>
             {{ user.email ?? '_______ @ _____ . ___'}} {{ user.phone ?? '+__ (__) _____________' }} <br/>
           </div>
           <div class="flex justify-end mt-4">
             <div class="text-xl font-medium text-theming">Personal information</div>
           </div>
         </div>

     </div>
     </div>
</AppLayout>
</template>
