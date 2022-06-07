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

import { defineAsyncComponent, ref } from 'vue';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import JetDialogModal from '@/Jetstream/DialogModal.vue';
import JetButton from '@/Jetstream/Button.vue';
import JetValidationErrors from '@/Jetstream/ValidationErrors.vue';
import AppLayout from '@/Pages/Panel/AppLayout.vue';
import LoadingComponent from '@/Pages/LoadingComponent.vue';
import ErrorComponent from '@/Pages/ErrorComponent.vue';

const props = defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    title: String,
    status: String,
    name: String,
    role: String,
    avatar: String,
    version: String,
    event: Object,
    breadcrumbCurrentTitle: String,
    breadcrumbCurrentSection: String,
});

const MylochiCalendar = defineAsyncComponent({
  loader: () => import("@/Components/MylochiCalendar.vue"),
  loadingComponent: LoadingComponent,
  errorComponent: ErrorComponent,
  delay: 500,
  timeout: 5000,
})

</script>

<template>
     <AppLayout :avatar="avatar" :role="role" :name="name" :version="version" :breadcrumbCurrentTitle="breadcrumbCurrentTitle" :breadcrumbCurrentSection="breadcrumbCurrentSection" :title="title">
     <template #breadcrumb></template>
     <template #modal>
	 <div class="font-bold mb-2">Cadastrar novo evento</div>
	 <form class="form-group" id="newevent">
	 <div class="mb-3">
     <label for="exampleFormControlInput1" class="form-label">Titulo</label>
     <input type="text" class="form-control" id="inputEventTitle" required />
     </div>
	 <div class="mb-3">
     <label for="exampleFormControlInput1" class="form-label">inicio</label>
	 <input type="datetime-local" class="form-control" id="inputEventStart" required />
     </div>
	 <div class="mb-3">
     <label for="exampleFormControlInput1" class="form-label">Termino</label>
	 <input type="datetime-local" class="form-control" id="inputEventEnd" required />
     </div>
	 <button type="submit" class="btn btn-primary bg-primary">Salvar</button>
     </form>
     </template>
     <mylochi-calendar></mylochi-calendar>
     </AppLayout>
</template> 
