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
import JetDialogModal from '@/Jetstream/DialogModal.vue';
import JetButton from '@/Jetstream/Button.vue';
import JetInput from '@/Jetstream/Input.vue';
import JetInputError from '@/Jetstream/InputError.vue';
import JetCheckbox from '@/Jetstream/Checkbox.vue';
import JetLabel from '@/Jetstream/Label.vue';
import JetValidationErrors from '@/Jetstream/ValidationErrors.vue';
import AppLayout from '@/Pages/Panel/AppLayout.vue';

const props = defineProps({
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
});
const form = useForm({});
const submit = (event) => {
  form.transform((data) => ({
   module: event.submitter.dataset.module
  }))	
  .post(route('managersettings.store'));
};
</script>

<template>
<AppLayout :avatar="avatar" :role="role" :name="name" :version="version" :breadcrumbCurrentTitle="breadcrumbCurrentTitle" :breadcrumbCurrentSection="breadcrumbCurrentSection" :title="title">
        <template #breadcrumb>
             <li class="breadcrumb-item active" aria-current="page">Dados armazenados</li>
		</template>
        <JetValidationErrors class="mb-4" />

        <div class="row">
        <div class="col-12 col-md-4">
        <div class="card card-body shadow-none border border-primary rounded-0 static relative mb-5">
        <div class="fw-bold my-3">Limpar cache do CMS</div>
        <p class="card-text my-3">Essa operação pode reduzir o desempenho do site momentaneamente</p>
        <form id="cache" action="/manager/settings" method="POST" @submit.prevent="submit">
        <input type="hidden" name="_method" value="post"/>
        <input type="hidden" name="module" value="cache" id="inputcache"/>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <JetButton type="submit" class="btn btn-primary" title="Limpar" aria-label="Limpar" data-module="cache" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Limpar</JetButton>
            </div>
            </div>
      </form>
            <div class="btn btn-light shadow-sm p-2 px-2 text-center align-self-center cursor-text rounded-circle text-dark absolute top-0 right-0 -translate-y-6 translate-x-6">
			<i class="menu-icon mdi mdi-server-security"></i>
            </div>
      </div>
      </div>
	  
        <div class="col-12 col-md-4">
        <div class="card card-body shadow-none border border-primary rounded-0 static relative mb-5">
        <div class="fw-bold my-3">Limpar cache de configurações</div>
        <p class="card-text my-3">Essa operação pode reduzir o desempenho do site momentaneamente</p>
        <form id="config" action="/manager/settings" method="POST" @submit.prevent="submit">
        <input type="hidden" name="_method" value="post"/>
        <input type="hidden" name="module" value="config" id="inputconfig"/>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <JetButton type="submit" class="btn btn-primary" title="Limpar" aria-label="Limpar" data-module="config" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Limpar</JetButton>
            </div>
            </div>
      </form>
            <div class="btn btn-light shadow-sm p-2 px-2 text-center align-self-center cursor-text rounded-circle text-dark absolute top-0 right-0 -translate-y-6 translate-x-6">
			<i class="menu-icon mdi mdi-server-security"></i>
            </div>
      </div>
      </div>
	  
        <div class="col-12 col-md-4">
        <div class="card card-body shadow-none border border-primary rounded-0 static relative mb-5">
        <div class="fw-bold my-3">Limpar cache de renderização</div>
        <p class="card-text my-3">Essa operação pode reduzir o desempenho do site momentaneamente</p>
        <form id="view" action="/manager/settings" method="POST" @submit.prevent="submit">
        <input type="hidden" name="_method" value="post"/>
        <input type="hidden" name="module" value="view" id="inputview"/>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <JetButton type="submit" class="btn btn-primary" title="Limpar" aria-label="Limpar" data-module="view" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Limpar</JetButton>
            </div>
            </div>
      </form>
            <div class="btn btn-light shadow-sm p-2 px-2 text-center align-self-center cursor-text rounded-circle text-dark absolute top-0 right-0 -translate-y-6 translate-x-6">
			<i class="menu-icon mdi mdi-server-security"></i>
            </div>
      </div>
      </div>
	  
        <div class="col-12 col-md-4">
        <div class="card card-body shadow-none border border-primary rounded-0 static relative mb-5">
        <div class="fw-bold my-3">Limpar cache de rotas</div>
        <p class="card-text my-3">Essa operação pode reduzir o desempenho do site momentaneamente</p>
        <form id="route" action="/manager/settings" method="POST" @submit.prevent="submit">
        <input type="hidden" name="_method" value="post"/>
        <input type="hidden" name="module" value="route" id="inputroute"/>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <JetButton type="submit" class="btn btn-primary" title="Limpar" aria-label="Limpar" data-module="route" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Limpar</JetButton>
            </div>
            </div>
      </form>
            <div class="btn btn-light shadow-sm p-2 px-2 text-center align-self-center cursor-text rounded-circle text-dark absolute top-0 right-0 -translate-y-6 translate-x-6">
			<i class="menu-icon mdi mdi-server-security"></i>
            </div>
      </div>
      </div>
	  
        <div class="col-12 col-md-4">
        <div class="card card-body shadow-none border border-primary rounded-0 static relative mb-5">
        <div class="fw-bold my-3">Limpar todos os tipos de cache</div>
        <p class="card-text my-3">Essa operação pode reduzir o desempenho do site momentaneamente</p>
        <form id="cleanall" action="/manager/settings" method="POST" @submit.prevent="submit">
        <input type="hidden" name="_method" value="post"/>
        <input type="hidden" name="module" value="cleanall" id="inputcleanall"/>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <JetButton type="submit" class="btn btn-primary" title="Limpar" aria-label="Limpar" data-module="cleanall" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Limpar</JetButton>
            </div>
            </div>
      </form>
            <div class="btn btn-light shadow-sm p-2 px-2 text-center align-self-center cursor-text rounded-circle text-dark absolute top-0 right-0 -translate-y-6 translate-x-6">
			<i class="menu-icon mdi mdi-server-security"></i>
            </div>
      </div>
      </div>
	  
        <div class="col-12 col-md-4">
        <div class="card card-body shadow-none border border-success rounded-0 static relative mb-5">
        <div class="fw-bold my-3">Otimizar o site</div>
        <p class="card-text my-3">Essa operação atualiza todo o cache existente e melhora o desempenho do site</p>
        <form id="optimize" action="/manager/settings" method="POST" @submit.prevent="submit">
        <input type="hidden" name="_method" value="post"/>
        <input type="hidden" name="module" value="optimize" id="inputoptimize"/>
		<div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <JetButton type="submit" class="btn btn-success" title="Otimizar" aria-label="Otimizar" data-module="optimize" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Otimizar</JetButton>
            </div>
            </div>
        </form>
            <div class="btn btn-light shadow-sm p-2 px-2 text-center align-self-center cursor-text rounded-circle text-dark absolute top-0 right-0 -translate-y-6 translate-x-6">
			<i class="menu-icon mdi mdi-server-security"></i>
            </div>
      </div>
      </div>
	  
      </div>
</AppLayout>
</template>
