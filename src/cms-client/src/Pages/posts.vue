<script setup>
/**
* The Lochlite & Lochpay Company - Technology that makes people's lives easier
*
* (c) 2019 - 2022 LOCHLITE E LOCHPAY SOFTWARES E PAGAMENTOS LTDA., All Right Reserved.
*
* Software: LOCHLITE CMS
* Version: 2.0.7  
* License: Proprietary
* Made in: Brazil
* Author: The Lochlite & Lochpay Company
* Developer: IGOR MACEDO MONTALVÃO
* Website: https://lochlite.com | https://lochpay.com | https://gpgic.com 
* Support: drcg@gpgic.com | drcg@lochlite.com | drcl@lochlite.com
*
* LEGAL NOTICE: The author(s) of the software grants the user of the software a personal, non-transferable, limited and revocable license without the right to market, resell, distribute, clone or recycle the software; The author(s) reserve the right to renew, revoke or modify the license, as well as impose fines for its violation at its most reasonable discretion.
*
* DISCLAIMER: The author(s) of the Software will not be responsible for any physical, moral, property damages or of any nature due to the software, its enjoyment or risks up to the limits of the legislation in force in Brazil.
*
* ('Art. 43 - LEI No 4.502/1964' - law of brazil) Indústria Brasileira - LOCHLITE E LOCHPAY SOFTWARES E PAGAMENTOS LTDA, CNPJ: 37.816.728/0001-04; Address: SCS QUADRA 9, BLOCO C, 10 ANDAR, SALA 1003, Brasilia, Federal District, Brazil, Zip Code: 70308-200
**/

import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import JetAuthenticationCardLogo from '@/Jetstream/AuthenticationCardLogo.vue';
import AppLayout from '@/Layouts/AppLayout.vue';

defineProps({
    appname: String,
    posts: Object,
	default:0,
});
</script>
<template>
   <AppLayout :appname="appname" title="Blog">

    <Head title="Blog" />
    <section>
     <div class="my-3 p-12 flex-1">
       <div class="container mx-auto">
       <div v-if="posts" class="p-12 grid grid-cols-1 sm:grid-cols-1 md:grid-cols-3 lg:grid-cols-3 xl:grid-cols-3 gap-5">
             <Link v-for="row in allPosts" :key="row.id" :href="route('blog.show', {id: row.url == null ? row.id : row.url })">
             <!--Card -->
             <div class="rounded overflow-hidden shadow-lg bg-white"> 
               <img class="w-full" :src="row.imgcap == null ? '/assets/img/post-default.jpg' : row.imgcap" alt="post img">
               <div class="px-6 py-4">
                 <div class="font-bold text-xl mb-2">{{ row.title}}</div>
                 <p class="text-gray-700 text-base">
                  {{ row.description }}
                 </p>
               </div>
               <div class="px-6 pt-4 pb-2">
                 <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">{{ row.category }}</span>
               </div>
             </div>
             <!-- End Card -->

             </Link>
           </div>
         <div class="text-center">
           <button class="border border-gray-600 text-gray-600 px-4 py-2 rounded-full hover:bg-gray-600 hover:text-white" @click="loadMore" :disabled="loadingMore">Show More</button>
         </div>
       </div>
     </div>
    </section>
    </AppLayout>
</template>
<script>
  export default {
   data () {
     return {
       loadingMore: false,
       allPosts: this.posts.data,
       pagination: this.posts,
     };
   },

    methods: {
      loadMore () {
        if (this.loadingMore) return;
 
         axios.get(`?page=${this.pagination.current_page + 1}`)
            .then(({ data }) => {
              this.allPosts = [
                ...data.data,
                ...this.allPosts,
              ];
              this.pagination = data;
            }).catch(err => {}).finally(() => this.loadingMore = false);}
    },
  }
</script>

