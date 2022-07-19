<script setup>
import { ref } from 'vue';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import JetActionMessage from 'lochlitecms/Views/Components/Layouts/ActionMessage.vue';
import JetButton from 'lochlitecms/Views/Components/Layouts/Button.vue';
import JetValidationErrors from 'lochlitecms/Views/Components/Layouts/ValidationErrors.vue';
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
    file: Object,
    fileurl: String,
    breadcrumbCurrentTitle: String,
    breadcrumbCurrentSection: String,
    menulang: Object,
    menuitems: Object,
});
</script>

<template>
<AppLayout :menulang="menulang" :menuitems="menuitems" :avatar="avatar" :role="role" :name="name" :version="version" :breadcrumbCurrentTitle="breadcrumbCurrentTitle" :breadcrumbCurrentSection="breadcrumbCurrentSection" :title="title">
        <template #breadcrumb>
              <li class="breadcrumb-item active" aria-current="page">Arquivo: {{ file.id }} - {{ file.filename }}</li>
        </template>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="form-group">
                    <strong>ID do arquivo:</strong>
                    {{ file.id }}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="form-group">
                    <strong>ID do usuário de origem:</strong>
                    {{ file.user_id }}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="form-group">
                    <strong>Nome do usuário de origem:</strong>
                    <Link class="text-primary ml-2" :href="route('managerusers.show', {id: file.user_id})">{{ file.user_name }}</Link>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="form-group">
                    <strong>IP do usuário de origem:</strong>
                    {{ file.visitor }}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="form-group">
                    <strong>Nome do arquivo:</strong>
                    {{ file.filename }}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="form-group">
                    <strong>Formato de arquivo:</strong>
                    {{ file.mimetype }}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Path:</strong>
                    {{ file.path }}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>URL:</strong>
                    {{ route('filefiling', {date: new Date(file.created_at).toISOString().split('T')[0], url: file.url}) }}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
            <div class="row">
                <div class="col">
                      <a :href="route('filefiling', {date: new Date(file.created_at).toISOString().split('T')[0], url: file.url})" class="btn btn-primary bg-primary rounded-0 border-0 text-white" data-event="link" data-function="show" :data-file="file.id" data-bs-toggle="tooltip" data-bs-placement="top" title="Visualizar" target=”_blank” rel=”noopener”>Visualizar </a>
                </div>
                <div class="col">
                      <a :href="route('managerstorange.download', {id: file.id})" class="btn btn-dark bg-dark rounded-0 border-0 text-white" type="button" data-event="button" data-function="download" :data-file="file.id" data-bs-toggle="tooltip" data-bs-placement="top" title="Baixar" download>Baixar </a>
                </div>
            </div>
            </div>
        </div>
</AppLayout>
</template>
