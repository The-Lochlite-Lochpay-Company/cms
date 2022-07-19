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
    breadcrumbCurrentTitle: String,
    breadcrumbCurrentSection: String,
    menulang: Object,
    menuitems: Object,
    appendcoding: Object,
});
</script>

<template>
<AppLayout :menulang="menulang" :menuitems="menuitems" :avatar="avatar" :role="role" :name="name" :version="version" :breadcrumbCurrentTitle="breadcrumbCurrentTitle" :breadcrumbCurrentSection="breadcrumbCurrentSection" :title="title">
        <template #breadcrumb>
              <li class="breadcrumb-item active text-truncate w-50" aria-current="page">Code: {{ appendcoding.id }}</li>
        </template>
        <JetValidationErrors class="mb-4" />

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                     <strong class="h5 text-dark fw-bold"> Comment: </strong>
                     {{ appendcoding.comment }}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="form-group">
                     <strong class="h5 text-dark fw-bold"> Position: </strong>
                     {{ appendcoding.position }}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="form-group">
                     <strong class="h5 text-dark fw-bold">Status:</strong>
                     {{ appendcoding.status }}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="form-group">
                     <strong class="h5 text-dark fw-bold">Criado em:</strong>
                     {{ new Date(appendcoding.created_at).toLocaleString() }}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="form-group">
                     <strong class="h5 text-dark fw-bold">Atualizado em:</strong>
                     {{ new Date(appendcoding.updated_at).toLocaleString() }}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="card card-body bg-light">
                     <p>{{ appendcoding.body }}</p>
                </div>
            </div>
        </div>
</AppLayout>
</template>