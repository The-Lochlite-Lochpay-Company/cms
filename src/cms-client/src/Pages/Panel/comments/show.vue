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
});
$('body').ready(function(){
$.each($('div.bodycomment'), function(index, item) {
$(item).html(DOMPurify.sanitize(Base64.atob($(item).data('body'))))
})
})

</script>

<template>
<AppLayout :avatar="avatar" :role="role" :name="name" :version="version" :breadcrumbCurrentTitle="breadcrumbCurrentTitle" :breadcrumbCurrentSection="breadcrumbCurrentSection" :title="title">
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
