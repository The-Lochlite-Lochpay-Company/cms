<script setup>
/**
* The Lochlite & Lochpay Company - Technology that makes people's lives easier
*
* (c) 2019 - 2022 LOCHLITE E LOCHPAY SOFTWARES E PAGAMENTOS LTDA., All Right Reserved.
*
* Software: LOCHLITE CMS
* Version: 2.0.7  
* License: Proprietary
* Made in: Brazil
* Author: The Lochlite & Lochpay Company
* Developer: IGOR MACEDO MONTALVÃO
* Website: https://lochlite.com | https://lochpay.com | https://gpgic.com 
* Support: drcg@gpgic.com | drcg@lochlite.com | drcl@lochlite.com
*
* LEGAL NOTICE: The author(s) of the software grants the user of the software a personal, non-transferable, limited and revocable license without the right to market, resell, distribute, clone or recycle the software; The author(s) reserve the right to renew, revoke or modify the license, as well as impose fines for its violation at its most reasonable discretion.
*
* DISCLAIMER: The author(s) of the Software will not be responsible for any physical, moral, property damages or of any nature due to the software, its enjoyment or risks up to the limits of the legislation in force in Brazil.
*
* ('Art. 43 - LEI No 4.502/1964' - law of brazil) Indústria Brasileira - LOCHLITE E LOCHPAY SOFTWARES E PAGAMENTOS LTDA, CNPJ: 37.816.728/0001-04; Address: SCS QUADRA 9, BLOCO C, 10 ANDAR, SALA 1003, Brasilia, Federal District, Brazil, Zip Code: 70308-200
**/

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
    file: Object,
    fileurl: String,
    breadcrumbCurrentTitle: String,
    breadcrumbCurrentSection: String,
});
</script>

<template>
<AppLayout :avatar="avatar" :role="role" :name="name" :version="version" :breadcrumbCurrentTitle="breadcrumbCurrentTitle" :breadcrumbCurrentSection="breadcrumbCurrentSection" :title="title">
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
