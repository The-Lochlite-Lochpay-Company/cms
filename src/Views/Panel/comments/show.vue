<script setup>
import { ref } from 'vue';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import JetActionMessage from '@/Jetstream/ActionMessage.vue';
import JetButton from '@/Jetstream/Button.vue';
import JetValidationErrors from '@/Jetstream/ValidationErrors.vue';
import AppLayout from '@/Pages/Panel/AppLayout.vue';
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
    comment: Object,
    breadcrumbCurrentTitle: String,
    breadcrumbCurrentSection: String,
    menuitems: Object,
});
$('body').ready(function(){
$.each($('div.bodycomment'), function(index, item) {
$(item).html(DOMPurify.sanitize(Base64.atob($(item).data('body'))))
})
})

</script>

<template>
<AppLayout :menuitems="menuitems" :avatar="avatar" :role="role" :name="name" :version="version" :breadcrumbCurrentTitle="breadcrumbCurrentTitle" :breadcrumbCurrentSection="breadcrumbCurrentSection" :title="title">
        <template #breadcrumb>
              <li class="breadcrumb-item active" aria-current="page">Comentário: {{ comment.id }} - {{ comment.name }}</li>
        </template>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="form-group">
                    <strong>Nome:</strong>
                    {{ comment.name }}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="form-group">
                    <strong>Email:</strong>
                    <Link class="ml-2 text-primary" :href="route('managerusers.show', {id: comment.user_id})">{{ comment.email }}</Link>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="form-group">
                    <strong>Criado em:</strong>
                    {{ new Date(comment.created_at).toLocaleString() }}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="form-group">
                    <strong>Atualizado:</strong>
                    {{ new Date(comment.updated_at).toLocaleString() }}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Artigo:</strong>
                    <Link class="ml-2 text-primary" :href="route('blog.show', {id: comment.post[0].id})">{{ comment.post[0].id }} - {{ comment.post[0].title }}</Link>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Comentário:</strong>
                    <div class="bodycomment" :data-body="comment.comment"></div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong class="mb-3">Respostas ao comentário:</strong>
                    <div class="w-full row bg-white rounded-lg">
                    <div class="w-full col-12 align-items-start px-4 py-6" v-for="row in comment.reply">
                    <div class="row">
                    <div class="col-1">
                    <img class="w-12 h-12 rounded-full object-cover mr-4" :src="row.avatar" alt="avatar">
                    </div>
                    <div class="col">
                       <div class="row row-cols-3 w-full">
                          <div class="col font-semibold text-gray-900 mr-auto"><Link class="ml-2 text-primary" :href="route('managerusers.show', {id: row.id})">{{ row.name }} - {{ row.email }} </Link> </div>
                          <div class="col text-gray-700">{{ new Date(row.created_at).toLocaleString() }}</div>
                          <div class="col"><span class="fw-bold">status: {{ row.status }}</span></div>
                    </div>
                    <p class="mt-3 text-md">
                       <div class="bodycomment text-md" :data-body="row.comment"></div>
                    </p>
                    </div>
                    </div>
                    </div>
					</div>
                </div>
            </div>
        </div>
</AppLayout>
</template>
