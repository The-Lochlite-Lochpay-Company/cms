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
   <AppLayout :title="appname" :appname="appname">

    <Head :title="appname" />
             <div style="background: #2b1c55;">
                <div class="px-3 px-md-auto py-4 row">
				<img class="col-12 col-md-2 d-none d-lg-block" width="200" src="/assets/img/vector.png">
				<div class="col-12 col-md-4 text-white display-3 font-weight-bold w-25 self-center mb-2 md:mb-0">VAMOS SIMPLIFICAR O 3° SETOR!!</div>
				<img class="col-12 col-md-6" width="750" src="/assets/img/vector2.png">
				</div>
                <div class="mt-3 py-4 mx-5 px-3 md:px-8 row row-cols-2 ">
				<img class="" width="250" src="/assets/img/vector3.png">
				<div class="col-12 col-md-5 self-center">
				    <div class="text-white display-4 font-weight-bold italic">SEU PROJETO ENVOLVE GASTOS PUBLICOS?</div>
				    <div class="display-4 font-weight-bold self-center" style="color:#ff6600">VOCÊ DEVE ATENTAR-SE A CERTOS DETALHES NA HORA DE ORGANIZA-LO.</div>
				</div>
				</div>
                <div class="mt-3 py-4 mx-5 px-8">
				    <div class="text-white text-center display-4 font-weight-bold">Assista aos últimos vídeos do nosso canal </div>
				    <div class="row py-3 text-center mx-auto">
				     <iframe class="col-12 col-md-4" width="100%" height="100%" src="https://www.youtube.com/embed/pW0_R-K_XD0" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                     <iframe class="col-12 col-md-4" width="100%" height="100%" src="https://www.youtube.com/embed/TyMIhqUFcDc" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
	                 <iframe class="col-12 col-md-4" width="100%" height="100%" src="https://www.youtube.com/embed/-PZErq61EkY" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
					</div>
				<div class="text-white text-center display-5">Fique por dentro de tudo o que acontece clicando em seguir.</div>
				<div class="text-center mt-3 pb-5 md:pb-1"><button class="hover:bg-white hover:text-dark text-white font-bold py-2 px-4" style="background:#ff6600">Seguir</button></div>
				</div>
				  <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" id="visual" viewBox="0 0 1080 75" width="100%" version="1.1">
				  <path d="M0 57L25.7 55.3C51.3 53.7 102.7 50.3 154.2 49.2C205.7 48 257.3 49 308.8 50.3C360.3 51.7 411.7 53.3 463 55.7C514.3 58 565.7 61 617 60.7C668.3 60.3 719.7 56.7 771.2 54.7C822.7 52.7 874.3 52.3 925.8 53.2C977.3 54 1028.7 56 1054.3 57L1080 58L1080 76L1054.3 76C1028.7 76 977.3 76 925.8 76C874.3 76 822.7 76 771.2 76C719.7 76 668.3 76 617 76C565.7 76 514.3 76 463 76C411.7 76 360.3 76 308.8 76C257.3 76 205.7 76 154.2 76C102.7 76 51.3 76 25.7 76L0 76Z" fill="#ff6600" stroke-linecap="round" stroke-linejoin="miter"/>
				  </svg>
				  </div>
                  <div class="mt-0 pt-0" style="background:#ff6600">				
                  <div class="px-3 md:px-8 mx-5 row row-cols-2 pb-10 md:pb-1">				
                  <div class="col-12 col-md-2 text-center relative">
				  <img src="/assets/img/icons/whatsapp2.png" width="200" class="mb-4 mx-auto left-0 right-0 self-center" style="margin-top:-70px" />
				  <div class="text-white display-4 font-weight-bold">ENTRE EM CONTATO CONOSCO AGORA MESMO!</div>
				  </div>			
                  <div class="pt-2 pb-5 mb-3 col-12 col-md-10">
                      <form class="form-group">
                      <input type="text" class="form-control placeholder-white bg-transparent border-white border-left-0 border-right-0 border-top-0 border-2 text-white mb-1 pl-1" placeholder="Nome" />
                      <input type="tel" class="form-control placeholder-white bg-transparent border-white border-left-0 border-right-0 border-top-0 border-2 text-white mb-1 pl-1" placeholder="Telefone" />
                      <input type="email" class="form-control placeholder-white bg-transparent border-white border-left-0 border-right-0 border-top-0 border-2 text-white mb-1 pl-1" placeholder="Email" />
                      <textarea class="form-control placeholder-white bg-transparent border-white border-2 text-white my-3 pt-1 pl-1" style="height:150px;" placeholder="Mensagem"></textarea>
				      <div class="text-right float-right pb-4 mb-8 md:mb-1 md:pb-1"><button class="hover:bg-dark hover:text-white text-dark bg-white font-bold py-2 px-4">ENVIAR</button></div>
				      </form>	
				  </div>			

				  </div>
				  <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" id="visual" viewBox="0 0 1080 75" width="100%" version="1.1">
				  <path d="M0 57L25.7 55.3C51.3 53.7 102.7 50.3 154.2 49.2C205.7 48 257.3 49 308.8 50.3C360.3 51.7 411.7 53.3 463 55.7C514.3 58 565.7 61 617 60.7C668.3 60.3 719.7 56.7 771.2 54.7C822.7 52.7 874.3 52.3 925.8 53.2C977.3 54 1028.7 56 1054.3 57L1080 58L1080 76L1054.3 76C1028.7 76 977.3 76 925.8 76C874.3 76 822.7 76 771.2 76C719.7 76 668.3 76 617 76C565.7 76 514.3 76 463 76C411.7 76 360.3 76 308.8 76C257.3 76 205.7 76 154.2 76C102.7 76 51.3 76 25.7 76L0 76Z" fill="#2b1c55" stroke-linecap="round" stroke-linejoin="miter"/>
				  </svg>
				  </div>
                  <div class="w-full py-4" style="background:#2b1c55">				
                   <div class="relative py-5 text-center flex items-center content-center">				
				   <img class="absolute mx-auto left-0 right-0 self-center" style="margin-top:-200px" width="325" height="auto" src="/logo.png">
				   </div>
				   <img class="w-full mt-4" width="100%" height="auto" src="/partner.png">
				  </div>
    </AppLayout>
</template>
