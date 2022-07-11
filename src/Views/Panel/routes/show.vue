<script setup>
import { ref } from 'vue';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import JetActionMessage from '@/Jetstream/ActionMessage.vue';
import JetButton from '@/Jetstream/Button.vue';
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
    showroute: Object,
});
</script>

<template>
<AppLayout :menuitems="menuitems" :avatar="avatar" :role="role" :name="name" :version="version" :breadcrumbCurrentTitle="breadcrumbCurrentTitle" :breadcrumbCurrentSection="breadcrumbCurrentSection" :title="title">
        <template #breadcrumb>
              <li class="breadcrumb-item active text-truncate w-50" aria-current="page">Rota: {{ showroute.id }} - {{ showroute.name }}</li>
        </template>
        <JetValidationErrors class="mb-4" />

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="form-group">
                     <strong class="h5 text-dark fw-bold"> Type: </strong>
                     {{ showroute.type }}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="form-group">
                     <strong class="h5 text-dark fw-bold"> URL: </strong>
                     {{ showroute.url }}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="form-group">
                     <strong class="h5 text-dark fw-bold">Controller:</strong>
                     {{ showroute.controller }}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="form-group">
                     <strong class="h5 text-dark fw-bold">Action:</strong>
                     {{ showroute.action }}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                     <strong class="h5 text-dark fw-bold">Name:</strong>
                     {{ showroute.name }}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                     <div class="h5 text-dark fw-bold">Middleware:</div>
                     {{ showroute.middleware }}
                </div>
            </div>
             <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                     <div class="h5 text-dark fw-bold">Only:</div>
                     {{ showroute.only }}
                </div>
            </div>
             <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                     <div class="h5 text-dark fw-bold">Except:</div>
                     {{ showroute.except }}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                     <strong class="h5 text-dark fw-bold">Criado em:</strong>
                     {{ new Date(showroute.created_at).toLocaleString() }}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                     <strong class="h5 text-dark fw-bold">Atualizado em:</strong>
                     {{ new Date(showroute.updated_at).toLocaleString() }}
                </div>
            </div>
        </div>
</AppLayout>
</template>