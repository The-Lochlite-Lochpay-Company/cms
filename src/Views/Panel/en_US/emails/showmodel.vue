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
    model: Object,
    breadcrumbCurrentTitle: String,
    breadcrumbCurrentSection: String,
    menulang: Object,
    menuitems: Object,
});
</script>

<template>
<AppLayout :menulang="menulang" :menuitems="menuitems" :avatar="avatar" :role="role" :name="name" :version="version" :breadcrumbCurrentTitle="breadcrumbCurrentTitle" :breadcrumbCurrentSection="breadcrumbCurrentSection" :title="title">
        <template #breadcrumb>
              <li class="breadcrumb-item active" aria-current="page">Model: {{ model.id }} - {{ model.subject }}</li>
        </template>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Subject:</strong>
                    {{ model.subject }}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Email body:</strong>
                    <div class="card card-body bg-light mt-3"><div class="card-text text-start">{{ model.html_template }}</div></div>
                </div>
            </div>
        </div>
</AppLayout>
</template>
