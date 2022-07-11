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
import AppLayout from '@/Pages/Panel/AppLayout.vue';
import DOMPurify from 'dompurify';
import arrive from 'arrive';
 
const props = defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    title: String,
    status: String,
    name: String,
    role: String,
    avatar: String,
    version: String,
    comment: Object,
    breadcrumbCurrentTitle: String,
    breadcrumbCurrentSection: String,
    menuitems: Object,
});
const form = useForm({
    name: '',
    name: props.comment.name,
    email: props.comment.email,
    status: props.comment.status,
    comment: props.comment.comment,
});

const submit = (event) => {
    form.comment = Base64.encode(DOMPurify.sanitize($('textarea#comment').val() || ''));
    form.transform(data => ({
        ...data,
    })).put(route('managercomments.update', {id: event.submitter.dataset.comment}), {
        onFinish: () => {form.reset(); $('textarea#comment').val(DOMPurify.sanitize(Base64.decode(form.comment)))},
    });
};
$('body').ready(function(){
   $('textarea#comment').val(DOMPurify.sanitize(Base64.decode($('textarea#comment').data('body'))))
})

</script>

<template>
<AppLayout :menuitems="menuitems" :avatar="avatar" :role="role" :name="name" :version="version" :breadcrumbCurrentTitle="breadcrumbCurrentTitle" :breadcrumbCurrentSection="breadcrumbCurrentSection" :title="title">
        <template #breadcrumb>
              <li class="breadcrumb-item active" aria-current="page">Criar</li>
        </template>
        <JetValidationErrors class="mb-4" />

        <form @submit.prevent="submit">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="form-group">
                     <JetLabel for="name" value="Nome" />
                     <JetInput id="name" type="text" class="form-control mt-1 block w-full" placeholder="Nome" v-model="form.name" name="name" autocomplete="name" />   
                     <JetInputError for="name" class="mt-2" />
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="form-group">
                     <JetLabel for="email" value="Email" />
                     <JetInput id="email" type="email" class="form-control mt-1 block w-full" placeholder="Email" v-model="form.email" name="email" autocomplete="email" />
                     <JetInputError for="email" class="mt-2" />
                </div>
            </div> 
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                     <JetLabel for="status" value="Status" />
                     <select id="status" class="form-select p-1 block w-full" v-model="form.status" name="status" autocomplete="status" required>
					 <option value="pending" :selected="comment.status == 'pending'">Pendente</option>
					 <option value="approved" :selected="comment.status == 'approved'">Aprovado</option>
					 </select>
                     <JetInputError for="status" class="mt-2" />
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                     <JetLabel for="comment" value="Comentário" />
                     <textarea id="comment" class="form-control mt-1 block w-full" placeholder="Texto do comentário aqui" v-model="form.comment" name="comment" :data-body="comment.comment" autocomplete required></textarea>
                     <JetInputError for="comment" class="mt-2" />
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <JetButton type="submit" class="btn btn-primary" title="Atualizar" aria-label="Atualizar" :data-comment="comment.id" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Atualizar</JetButton>
            </div>
        </div>
      </form>

</AppLayout>
</template>
