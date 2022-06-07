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
import JetInput from '@/Jetstream/Input.vue';
import JetCheckbox from '@/Jetstream/Checkbox.vue';
import JetLabel from '@/Jetstream/Label.vue';
import JetValidationErrors from '@/Jetstream/ValidationErrors.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import {mask, TheMask}  from 'vue-the-mask'

defineProps({
    appname: String,
    canLogin: Boolean,
    canRegister: Boolean,
    status: String,
    name: String,
    email: String,
    questions: Object,
});

const form = useForm({
    name: '',
    email: '',
    responses: '',
});

const submit = () => {
    const arrayquest = new Array();
	$.each($('#rowgroupquestion input[type="radio"]:checked'),function(index, item){
	var quest = $(item).data('quest');
	var resp = $(item).val();
	var id = $(item).attr('name');
	arrayquest.push({'question': quest, 'response': resp, 'id': id});
	});
	form.responses = arrayquest;
    form.transform(data => ({
        ...data,
    })).post(route('sendfeedback'), {
        onFinish: () => form.reset(),
    });
};
</script>

<template>
   <AppLayout title="Feedback" :appname="appname">

    <Head title="Feedback" />
    <section>
      <div class="max-w-screen-xl mt-4 px-8 md:px-12 lg:px-16 xl:px-32 py-16 mx-auto bg-gray-100 text-gray-900 rounded-lg shadow-lg">
          <div>
            <h2 class="text-4xl lg:text-5xl font-bold leading-tight">Responda a uma breve pesquisa</h2>
            <div class="text-gray-700 mt-5">
              A sua opinião é importante para a melhoria dos nossos serviços.
            </div>
          </div>

        <form class="w-100 mt-8" @submit.prevent="submit">
         <JetValidationErrors class="mb-4" />
         <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
             {{ status }}
         </div>
		<div class="mt-0">
            <JetLabel class="uppercase text-sm text-gray-600 font-bold" value="Nome completo" />
            <JetInput class="mt-1 block w-full" type="text" placeholder="" id="name" v-model="form.name" autocomplete="name" required />
            <div v-if="form.errors.name">{{ form.errors.name }}</div>
          </div> 
          <div class="mt-8">
            <JetLabel class="uppercase text-sm text-gray-600 font-bold" value="Email" />
            <JetInput class="mt-1 block w-full" type="email" id="email" v-model="form.email" autocomplete="email" required />
            <div v-if="form.errors.email">{{ form.errors.email }}</div>
          </div>
          <div class="mt-8">
		    <div v-for="row in questions" :key="row.id">
            <JetLabel class="uppercase text-sm text-gray-600 font-bold" :value="row.question" />
            <div class="p-12 grid grid-cols-1 sm:grid-cols-1 md:grid-cols-3 lg:grid-cols-5 xl:grid-cols-5 gap-5" id="rowgroupquestion">
            <div class="form-check">
               <input class="form-check-input block text-center appearance-none rounded-full h-6 w-6 border border-gray-300 bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain mr-2 cursor-pointer" type="radio" :name="row.id" :id="'flexRadio' + row.id + '1'" :value="row.option1" :data-quest="row.question" required>
               <label class="form-check-label block text-gray-800 w-full" :for="'flexRadio' + row.id + '1'">
                 {{row.option1}}
               </label>
             </div>
             <div class="form-check">
               <input class="form-check-input block text-center appearance-none rounded-full h-6 w-6 border border-gray-300 bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain mr-2 cursor-pointer" type="radio" :name="row.id" :id="'flexRadio' + row.id + '2'" :value="row.option2" :data-quest="row.question" required>
               <label class="form-check-label block text-gray-800 w-full" :for="'flexRadio' + row.id + '2'">
                 {{row.option2}}
               </label>
             </div>
             <div class="form-check">
               <input class="form-check-input block text-center appearance-none rounded-full h-6 w-6 border border-gray-300 bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain mr-2 cursor-pointer" type="radio" :name="row.id" :id="'flexRadio' + row.id + '3'" :value="row.option3" :data-quest="row.question" required>
               <label class="form-check-label block text-gray-800 w-full" :for="'flexRadio' + row.id + '3'">
                 {{row.option3}}
               </label>
             </div>
             <div class="form-check">
               <input class="form-check-input block text-center appearance-none rounded-full h-6 w-6 border border-gray-300 bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain mr-2 cursor-pointer" type="radio" :name="row.id" :id="'flexRadio' + row.id + '4'" :value="row.option4" :data-quest="row.question" required>
               <label class="form-check-label block text-gray-800 w-full" :for="'flexRadio' + row.id + '4'">
                 {{row.option4}}
               </label>
             </div>
             <div class="form-check">
               <input class="form-check-input block text-center appearance-none rounded-full h-6 w-6 border border-gray-300 bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain mr-2 cursor-pointer" type="radio" :name="row.id" :id="'flexRadio' + row.id + '5'" :value="row.option5" :data-quest="row.question" required>
               <label class="form-check-label block text-gray-800 w-full" :for="'flexRadio' + row.id + '5'">
                 {{row.option5}}
               </label>
             </div>
             </div>
            </div>
          </div>
          <div class="mt-8">
		    <JetActionMessage :on="form.recentlySuccessful" class="mr-3 text-white bg-green-500">
               <p class="text-sm text-white bg-green-500 p-2">Registro salvo.</p>
            </JetActionMessage>
            <JetButton  class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing"> Enviar </JetButton>
          </div>
        </form>
      </div>

    </section>
    </AppLayout>
</template>
