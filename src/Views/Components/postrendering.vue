<script setup>
import { defineAsyncComponent } from "vue"

import { Head } from '@inertiajs/inertia-vue3';
import JetAuthenticationCardLogo from 'lochlitecms/Views/Components/Layouts/AuthenticationCardLogo.vue';
import AppLayout from 'lochlitecms/Views/Web/Layouts/AppLayout.vue';
import LoadingComponent from 'lochlitecms/Views/Components/LoadingComponent.vue';
import ErrorComponent from 'lochlitecms/Views/Components/ErrorComponent.vue';
import DOMPurify from 'dompurify';

const props = defineProps({
    appname: String,
    canLogin: Boolean,
    canRegister: Boolean,
    user: Object,
    post: Object,
    postbody: Object,
    comments: Object,
    posted: String,
    likes: Object,
    deslikes: Object,
    voted: Boolean,
});
$('body').ready(function(){$('article#mainarticle').html(DOMPurify.sanitize(Base64.decode($('article#mainarticle').data('body'))))})

const MylochiComment = defineAsyncComponent({
  loader: () => import("lochlitecms/Views/Components/MylochiComment.vue"),
  loadingComponent: LoadingComponent,
  errorComponent: ErrorComponent,
  delay: 500,
  timeout: 5000,
})
</script>
<template>
   <AppLayout :appname="appname" :canLogin="canLogin" :canRegister="canRegister" title="Blog">
 
    <div class="">
        <div class="flex my-10 bg-white shadow-md rounded-lg container mx-auto">
                <div class="w-full">
                    <div class="flex flex-row mt-2 px-2 py-3 mx-3">
                        <div class="w-auto h-auto rounded-full border-2 border-blue-500">
                            <img class='w-12 h-12 object-cover rounded-full shadow cursor-pointer' alt='User avatar' :src="post.author_avatar == null ? '/assets/img/avatar.webp' : post.author_avatar">
                        </div>
                        <div class="flex flex-col mb-2 ml-4 mt-1">
                            <div class='text-gray-600 text-sm font-semibold'>{{ post.authors }}</div>
                            <div class='flex w-full mt-1'>
                                <div class='text-gray-400 font-thin text-xs'>
                                    {{ posted }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="border-b border-gray-100"></div> 
                    <div class="flex justify-start pl-5 text-lg container mx-auto px-3 mt-2">{{ post.title }}</div>
                    <div class="flex justify-start pl-5 text-sm container mx-auto px-3 mt-2">{{ post.description }}</div>
                    <article class="justify-start pl-5 py-4 container mx-auto px-3" id="mainarticle" :data-body="postbody.body">
					<div class="border border-blue-300 rounded-md p-4 w-full mx-auto">
                         <div class="animate-pulse flex space-x-4">
                           <div class="rounded-full bg-slate-700 h-10 w-10"></div>
                           <div class="flex-1 space-y-6 py-1">
                             <div class="h-2 bg-slate-700 rounded"></div>
                             <div class="space-y-3">
                               <div class="grid grid-cols-3 gap-4">
                                 <div class="h-2 bg-slate-700 rounded col-span-2"></div>
                                 <div class="h-2 bg-slate-700 rounded col-span-1"></div>
                               </div>
                               <div class="h-2 bg-slate-700 rounded"></div>
                             </div>
                           </div>
                         </div>
                     </div>
					</article>
					 <mylochi-comment :user="user" :post="post" :comments="comments" :likes="likes" :deslikes="deslikes" :voted="voted"></mylochi-comment>        
                </div>
            </div>
        </div>
 
    </AppLayout>
</template>
