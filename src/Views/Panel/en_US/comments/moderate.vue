<script setup>
import { ref } from 'vue';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import JetDialogModal from 'lochlitecms/Views/Components/Layouts/DialogModal.vue';
import JetButton from 'lochlitecms/Views/Components/Layouts/Button.vue';
import JetValidationErrors from 'lochlitecms/Views/Components/Layouts/ValidationErrors.vue';
import AppLayout from 'lochlitecms/Views/Panel/AppLayout.vue';
import DOMPurify from 'dompurify';

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    title: String,
    status: String,
    name: String,
    role: String,
    avatar: String,
    version: String,
    comments: Object,
    breadcrumbCurrentTitle: String,
    breadcrumbCurrentSection: String,
    menulang: Object,
    menuitems: Object,
});
const form = useForm();
const submit = (event) => {
    form.delete(route('managercomments.destroy', {id: event.submitter.dataset.comment}));
};
const approved = useForm({status: 'approved'});
const submitapprove = (event) => {
    approved.post(route('managercomments.setapproved', {id: event.submitter.dataset.comment}));
};
$('body').ready(function(){
$.each($('td.bodycomment'), function(index, item) {
$(item).html(DOMPurify.sanitize(Base64.atob($(item).data('body'))))
})
})

</script>

<template>
<AppLayout :menulang="menulang" :menuitems="menuitems" :avatar="avatar" :role="role" :name="name" :version="version" :breadcrumbCurrentTitle="breadcrumbCurrentTitle" :breadcrumbCurrentSection="breadcrumbCurrentSection" :title="title">
        <template #breadcrumb></template>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Comment</th>
                        <th>Article</th>
                        <th>Created in</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(row, index)  in allComments" :key="row.id">
                        <td class="text-wrap text-truncate truncate bodycomment" :data-body="row.comment">Undefined</td>
                        <td class="text-wrap w-7/10 block text-truncate truncate">{{ row.post[0].title }}</td>
                        <td>{{ new Date(row.created_at).toLocaleString() }}</td>
                        <td>
                        <div class="btn-group">
                        <form :id="row.id" class="w-100" @submit.prevent="submitapprove">
                         <JetValidationErrors class="mb-4" />
                         <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
                             {{ status }}
                         </div>
                         <JetButton class="btn btn-outline-light bg-light rounded-0 border-0 text-dark" type="submit" data-event="submit" data-function="approved" :data-comment="row.id" :class="{ 'opacity-25': approved.processing }" :disabled="approved.processing" data-bs-toggle="tooltip" data-bs-placement="top" title="To approve"><i class="mdi mdi-check"></i> </JetButton>
						</form>
						<Link :href="route('managercomments.edit', {id: row.id})" class="btn btn-outline-light text-dark" data-event="link" data-function="edit" :data-comments="row.id" data-bs-toggle="tooltip" data-bs-placement="top" title="To edit"><i class="mdi mdi-pencil"></i></Link>
                        <form :id="row.id" class="w-100" @submit.prevent="submit">
                         <JetValidationErrors class="mb-4" />
                         <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
                             {{ status }}
                         </div>
                         <JetButton class="btn btn-outline-light bg-light rounded-0 border-0 text-dark" type="submit" data-event="submit" data-function="delete" :data-comment="row.id" :class="{ 'opacity-25': form.processing }" :disabled="form.processing" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"><i class="mdi mdi-delete"></i> </JetButton>
						</form>
						</div>
						</td>
                    </tr>
				 </tbody>
            </table>
			 <div class="text-center">
             <button class="border border-gray-600 text-gray-600 px-4 py-2 rounded-full hover:bg-gray-600 hover:text-white" @click="loadMore" :disabled="loadingMore">Show More</button>
             </div>
        </div>
 
</AppLayout>
</template>
<script>
  export default {
   data () {
     return {
       loadingMore: false,
       allComments: this.comments.data,
       pagination: this.comments,
     };
   },

    methods: {
      loadMore () {
        if (this.loadingMore) return;
 
         axios.get(`?page=${this.pagination.current_page + 1}`)
            .then(({ data }) => {
              this.allComments = [
                ...data.data,
                ...this.allComments,
              ];
              this.pagination = data;
            }).catch(err => {
            }).finally(() => this.loadingMore = false);
      }
    },
  }
</script>

