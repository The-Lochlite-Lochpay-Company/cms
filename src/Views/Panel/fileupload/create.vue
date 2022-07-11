<script setup>
import { ref } from 'vue';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import JetDialogModal from '@/Jetstream/DialogModal.vue';
import JetButton from '@/Jetstream/Button.vue';
import JetInput from '@/Jetstream/Input.vue';
import JetInputError from '@/Jetstream/InputError.vue';
import JetCheckbox from '@/Jetstream/Checkbox.vue';
import JetLabel from '@/Jetstream/Label.vue';
import JetValidationErrors from '@/Jetstream/ValidationErrors.vue';
import AppLayout from 'lochlitecms/Views/Panel/AppLayout.vue';

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    title: String,
    status: String,
    name: String,
    role: String,
    avatar: String,
    version: String,
    breadcrumbCurrentTitle: String,
    breadcrumbCurrentSection: String,
    menuitems: Object,
});

</script>

<template>
<AppLayout :menuitems="menuitems" :avatar="avatar" :role="role" :name="name" :version="version" :breadcrumbCurrentTitle="breadcrumbCurrentTitle" :breadcrumbCurrentSection="breadcrumbCurrentSection" :title="title">
        <template #breadcrumb>
              <li class="breadcrumb-item active" aria-current="page">Novo arquivo</li>
        </template>
        <JetValidationErrors class="mb-4" />

    <DropZone 
		method="POST" 
        :maxFiles="Number(100)" 
	    :headers="{ 'X-CSRF-TOKEN': token }"
        :url="route('managerstorange.store')" 
        :uploadOnDrop="true" 
        :multipleUpload="true" 
        :parallelUpload="3"
		 @sending="onSuccessUpload" @errorUpload="onErrorUpload" />
         <div id="status"></div>                         
</AppLayout>
</template>
<script>
const token = document.head.querySelector('meta[name="_token"]').content
export default{
data(){
return{
onErrorUpload(a,b,c){
$('div#status').html('<div class="fixed-bottom shadow-sm bg-danger max-w-screen-xl mx-auto py-2 px-3 sm:px-6 lg:px-8"><p class="ml-3 font-medium text-sm text-white truncate">Ocorreu um erro no carregamento.</p></div></div>');
setTimeout(function(){$('div#status').html('');}, 8000);
}
}
}
}
</script>