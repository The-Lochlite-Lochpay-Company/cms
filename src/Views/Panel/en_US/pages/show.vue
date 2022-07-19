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
    page: Object,
    breadcrumbCurrentTitle: String,
    breadcrumbCurrentSection: String,
    menulang: Object,
    menuitems: Object,
});
</script>

<template>
<AppLayout :menulang="menulang" :menuitems="menuitems" :avatar="avatar" :role="role" :name="name" :version="version" :breadcrumbCurrentTitle="breadcrumbCurrentTitle" :breadcrumbCurrentSection="breadcrumbCurrentSection" :title="title">
        <template #breadcrumb>
              <li class="breadcrumb-item active text-truncate w-50" aria-current="page">Page: {{ page.id }} - {{ page.title }}</li>
        </template>
        <JetValidationErrors class="mb-4" />

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="form-group">
                     <strong class="h5 text-dark fw-bold"> Title: </strong>
                     {{ page.title }}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="form-group">
                     <strong class="h5 text-dark fw-bold">Keywords:</strong>
                     {{ page.keywords }}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="form-group">
                     <strong class="h5 text-dark fw-bold">Main page:</strong>
                     {{ page.welcome == true ? 'True' : 'False' }}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="form-group">
                     <strong class="h5 text-dark fw-bold">Author:</strong>
                     {{ page.authors }}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                     <div class="h5 text-dark fw-bold">Description:</div>
                     {{ page.description }}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                     <strong class="h5 text-dark fw-bold">Created in:</strong>
                     {{ new Date(page.created_at).toLocaleString() }}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                     <strong class="h5 text-dark fw-bold">Updated in:</strong>
                     {{ new Date(page.updated_at).toLocaleString() }}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <Link class="btn btn-primary" title="Access page" aria-label="Access page" :href="route('show', {id: page.url == null ? page.id : page.url})">Access page</Link>
            </div>
        </div>
</AppLayout>
</template>