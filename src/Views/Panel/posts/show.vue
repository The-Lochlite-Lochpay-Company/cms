<script setup>
import { ref } from 'vue';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import JetActionMessage from '@/Jetstream/ActionMessage.vue';
import JetButton from '@/Jetstream/Button.vue';
import JetValidationErrors from '@/Jetstream/ValidationErrors.vue';
import AppLayout from '@/Pages/Panel/AppLayout.vue';

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    title: String,
    status: String,
    name: String,
    role: String,
    avatar: String,
    version: String,
    post: Object,
    breadcrumbCurrentTitle: String,
    breadcrumbCurrentSection: String,
    menuitems: Object,
});
</script>

<template>
<AppLayout :menuitems="menuitems" :avatar="avatar" :role="role" :name="name" :version="version" :breadcrumbCurrentTitle="breadcrumbCurrentTitle" :breadcrumbCurrentSection="breadcrumbCurrentSection" :title="title">
        <template #breadcrumb>
              <li class="breadcrumb-item active text-truncate w-50" aria-current="page">Artigo: {{ post.id }} - {{ post.title }}</li>
        </template>
        <JetValidationErrors class="mb-4" />

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="form-group">
                     <strong class="h5 text-dark fw-bold"> Titulo: </strong>
                     {{ post.title }}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="form-group">
                     <strong class="h5 text-dark fw-bold">Keywords:</strong>
                     {{ post.keywords }}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="form-group">
                     <strong class="h5 text-dark fw-bold">Imagem de capa:</strong>
                     {{ post.imgcap }}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="form-group">
                     <strong class="h5 text-dark fw-bold">Autor:</strong>
                     {{ post.authors }}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                     <div class="h5 text-dark fw-bold">Descrição:</div>
                     {{ post.description }}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                     <strong class="h5 text-dark fw-bold">Criado em:</strong>
                     {{ new Date(post.created_at).toLocaleString() }}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                     <strong class="h5 text-dark fw-bold">Atualizado em:</strong>
                     {{ new Date(post.updated_at).toLocaleString() }}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <Link class="btn btn-primary" title="Acessar artigo" aria-label="Acessar artigo" :href="route('blog.show', {id: post.id})">Ver artigo</Link>
            </div>
        </div>
</AppLayout>
</template>