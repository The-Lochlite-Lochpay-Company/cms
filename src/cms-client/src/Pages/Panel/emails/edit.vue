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
import MylochiTinyEditor from  '@/Components/MylochiTinyEditor.vue';
import DOMPurify from 'dompurify';

const props = defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    title: String,
    status: String,
    name: String,
    role: String,
    avatar: String,
    version: String,
    model: Object,
    modelbody: String,
    breadcrumbCurrentTitle: String,
    breadcrumbCurrentSection: String,
});
const form = useForm({
    subject: props.model.subject,
    body: props.model.html_template,
});

const submit = (event) => {
    form.body = tinymce.activeEditor.getContent() || '<p><br><br></p>';
    form.transform(data => ({
        ...data,
    })).put(route('manageremailsmodel.update', {id: event.submitter.dataset.model}), {
        onFinish: () => form.reset(),
    });
};
</script>

<template>
<AppLayout :avatar="avatar" :role="role" :name="name" :version="version" :breadcrumbCurrentTitle="breadcrumbCurrentTitle" :breadcrumbCurrentSection="breadcrumbCurrentSection" :title="title">
        <template #breadcrumb>
              <li class="breadcrumb-item active" aria-current="page">Editando modelo: {{ model.id }} - {{ model.subject }}</li>
        </template>
		
		 <div class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 my-3" role="alert">
             <div class="flex">
             <div class="py-1"><svg class="fill-current h-6 w-6 text-teal-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/></svg></div>
             <div>
                <p class="font-bold">Instruções</p>
                <p class="text-sm">Agora você pode usar dados dinâmicos para enviar emails individualizados.</p>
                <p class="text-sm">Use uma das opções disponíveis dessa forma: <code v-pre>{{ optionname }}</code>, no corpo e/ou assunto do modelo de email.</p>
				<div class="accordion w-100" id="accordionExample">

                 <div class="accordion-item mt-2 w-100">
                    <h2 class="accordion-header mb-0" id="headingThree">
                      <button class="accordion-button collapsed bg-transparent font-bold relative flex items-center w-full text-base text-dark text-left border-0 rounded-none transition focus:outline-none" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                        Ver opções disponíveis
                      </button>
                    </h2>
                    <div id="collapseThree" class="accordion-collapse collapse bg-white w-100" aria-labelledby="headingThree"
                      data-bs-parent="#accordionExample">
                      <div class="accordion-body py-4 px-5 w-100">
                      <table class="table table-responsive w-100">
                        <thead>
                          <tr>
                            <th>Opção</th>
                            <th>Forma de uso</th>
                            <th>Descrição</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>appname</td>
                            <td v-pre>{{ appname }}</td>
                            <td>Adiciona o nome deste site</td>
                          </tr>
                          <tr>
                            <td>name</td>
                            <td v-pre>{{ name }}</td>
                            <td>Adiciona o nome do destinatário</td>
                          </tr>
                          <tr>
                            <td>email</td>
                            <td v-pre>{{ email }}</td>
                            <td>Adiciona o email do destinatário</td>
                          </tr>
                          <tr>
                            <td>phone</td>
                            <td v-pre>{{ phone }}</td>
                            <td>Adiciona o telefone do destinatário</td>
                          </tr>
                          <tr>
                            <td>address</td>
                            <td v-pre>{{ address }}</td>
                            <td>Adiciona o endereço do destinatário</td>
                          </tr>
                          <tr>
                            <td>addressNumber</td>
                            <td v-pre>{{ addressNumber }}</td>
                            <td>Adiciona o número de endereço do destinatário</td>
                          </tr>
                          <tr>
                            <td>city</td>
                            <td v-pre>{{ city }}</td>
                            <td>Adiciona a cidade/distrito do destinatário</td>
                          </tr>
                          <tr>
                            <td>state</td>
                            <td v-pre>{{ state }}</td>
                            <td>Adiciona o estado/província do destinatário</td>
                          </tr>
                          <tr>
                            <td>country</td>
                            <td v-pre>{{ country }}</td>
                            <td>Adiciona o país do destinatário</td>
                          </tr>
                        </tbody>
                      </table>
                      </div>
                    </div>
                  </div>
                 </div>
             </div>
             </div>
         </div>
		
        <JetValidationErrors class="mb-4" />

        <form @submit.prevent="submit">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                     <JetLabel for="subject" value="Assunto" />
                     <JetInput id="subject" type="text" class="form-control mt-1 block w-full" placeholder="Welcome to the {{ appname }}, {{ name }}!" v-model="form.subject" name="subject" autocomplete="subject" />   
                     <JetInputError for="subject" class="mt-2" />
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 mb-3 rowcolumneditor">
             <MylochiTinyEditor data-type="edit" placeholder="Escreva aqui o conteúdo do modelo" v-model="form.body" name="body" id="mylochi-tiny" :data-body="modelbody"></MylochiTinyEditor>
	        </div>
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <JetButton type="submit" class="btn btn-primary" title="Atualizar" aria-label="Atualizar" :data-model="model.id" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Atualizar</JetButton>
            </div>
        </div>
      </form>

</AppLayout>
</template>
