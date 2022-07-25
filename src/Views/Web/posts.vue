<script setup>
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import AppLayout from 'lochlitecms/Views/Web/Layouts/AppLayout.vue';

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

