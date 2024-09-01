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
    feedback: Object,
    breadcrumbCurrentTitle: String,
    breadcrumbCurrentSection: String,
    menulang: Object,
    menuitems: Object,
});
</script>

<template>
<AppLayout :menulang="menulang" :menuitems="menuitems" :avatar="avatar" :role="role" :name="name" :version="version" :breadcrumbCurrentTitle="breadcrumbCurrentTitle" :breadcrumbCurrentSection="breadcrumbCurrentSection" :title="title">
        <template #breadcrumb>
              <li class="breadcrumb-item active text-truncate w-50" aria-current="page">Feedback: {{ feedback.id }} - {{ feedback.question }}</li>
        </template>
        <JetValidationErrors class="mb-4" />
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Question:</strong>
                    {{ feedback.question }}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                    <strong>Created by:</strong>
                    {{ feedback.author }}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                    <strong>Created in:</strong>
                    {{ new Date(feedback.created_at).toLocaleString() }}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                    <strong>Updated in:</strong>
                    {{ new Date(feedback.updated_at).toLocaleString() }}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="card-title h3 fw-bold my-3">Possible Answers</div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="row">
                <div class="col">
                <div class="form-group">
                    <strong>Option 1:</strong>
                    {{ feedback.option1 }}
                </div>
                </div>
                <div class="col">
                <div class="form-group">
                    <strong>Option 2:</strong>
                    {{ feedback.option2 }}
                </div>
                </div>
                <div class="col">
                <div class="form-group">
                    <strong>Option 3:</strong>
                    {{ feedback.option3 }}
                </div>
                </div>
                <div class="col">
                <div class="form-group">
                    <strong>Option 4:</strong>
                    {{ feedback.option4 }}
                </div>
                </div>
                <div class="col">
                <div class="form-group">
                    <strong>Option 5:</strong>
                    {{ feedback.option5 }}
                </div>
                </div>
                </div>
            </div>
        </div>
</AppLayout>
</template>