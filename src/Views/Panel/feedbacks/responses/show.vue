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
    feedback: Object,
    breadcrumbCurrentTitle: String,
    breadcrumbCurrentSection: String,
    menuitems: Object,
});
</script>

<template>
<AppLayout :menuitems="menuitems" :avatar="avatar" :role="role" :name="name" :version="version" :breadcrumbCurrentTitle="breadcrumbCurrentTitle" :breadcrumbCurrentSection="breadcrumbCurrentSection" :title="title">
        <template #breadcrumb>
              <li class="breadcrumb-item active text-truncate w-50" aria-current="page">Resposta: {{ feedback.id }} - {{ feedback.name }}</li>
        </template>
        <JetValidationErrors class="mb-4" />
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Nome:</strong>
                    {{ feedback.name }}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="form-group">
                    <strong>Email:</strong>
                    {{ feedback.email }}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="form-group">
                    <strong>IP:</strong>
                    {{ feedback.visitor }}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="form-group">
                    <strong>Criado em:</strong>
                    {{ new Date(feedback.created_at).toLocaleString() }}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="form-group">
                    <strong>Atualizado em:</strong>
                    {{ new Date(feedback.updated_at).toLocaleString() }}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="card-title h3 fw-bold my-3">Perguntas e respostas</div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="card shadow-none border border-primary py-3 px-4 mb-3" v-for="(row, index) in JSON.parse(feedback.responses)" :key="row.id">
                <div class="row">
                <div class="col-12">
                <div class="form-group">
                    <strong>Pergunta:</strong>
                    {{ row.question }}
                </div>
                </div>
                <div class="col-12">
                <div class="form-group">
                    <strong>Resposta:</strong>
                    {{ row.response }}
                </div>
                </div>
                </div>
                </div>

            </div>
        </div>
</AppLayout>
</template>