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
    feedback: Object,
    breadcrumbCurrentTitle: String,
    breadcrumbCurrentSection: String,
});
const form = useForm({
    question: props.feedback.question,
    option1: props.feedback.option1,
    option2: props.feedback.option2,
    option3: props.feedback.option3,
    option4: props.feedback.option4,
    option5: props.feedback.option5,
});
const submit = () => {
    form.transform(data => ({
        ...data,
    })).put(route('managerfeedbacks.update', {id: props.feedback.id}), {
        onFinish: () => form.reset(),
    });
};
</script>

<template>
<AppLayout :avatar="avatar" :role="role" :name="name" :version="version" :breadcrumbCurrentTitle="breadcrumbCurrentTitle" :breadcrumbCurrentSection="breadcrumbCurrentSection" :title="title">
        <template #breadcrumb>
              <li class="breadcrumb-item active" aria-current="page">Editar: {{ feedback.id }} - {{ feedback.question }}</li>
        </template>
        <JetValidationErrors class="mb-4" />

        <form @submit.prevent="submit">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                     <JetLabel for="question" value="Pergunta" />
                     <JetInput id="question" type="text" class="form-control mt-1 block w-full" placeholder="Ex: Em uma média de 1 a 5, qual o seu nível de satisfação?" v-model="form.question" name="question" autocomplete="question" required />
                     <JetInputError for="question" class="mt-2" />
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="row">
            <div class="col">
                <div class="form-group">
                     <JetLabel for="option1" value="Opção 1" />
                     <JetInput id="option1" type="text" class="form-control mt-1 block w-full" placeholder="option 1" name="option1" autocomplete="option1" v-model="form.option1" required />
                     <JetInputError for="option1" class="mt-2" />
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                     <JetLabel for="option2" value="Opção 2" />
                     <JetInput id="option2" type="text" class="form-control mt-1 block w-full" placeholder="option 2" name="option2" autocomplete="option2" v-model="form.option2" required />
                     <JetInputError for="option2" class="mt-2" />
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                     <JetLabel for="option3" value="Opção 3" />
                     <JetInput id="option3" type="text" class="form-control mt-1 block w-full" placeholder="option 3" name="option3" autocomplete="option3" v-model="form.option3" />
                     <JetInputError for="option3" class="mt-2" />
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                     <JetLabel for="option4" value="Opção 4" />
                     <JetInput id="option4" type="text" class="form-control mt-1 block w-full" placeholder="option 4" name="option4" autocomplete="option4" v-model="form.option4" />
                     <JetInputError for="option4" class="mt-2" />
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                     <JetLabel for="option5" value="Opção 5" />
                     <JetInput id="option5" type="text" class="form-control mt-1 block w-full" placeholder="option 5" name="option5" autocomplete="option5" v-model="form.option5" />
                     <JetInputError for="option5" class="mt-2" />
                </div>
            </div>
            </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <JetButton type="submit" class="btn btn-primary" title="Atualizar" aria-label="Atualizar" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Atualizar</JetButton>
            </div>
        </div>
      </form>

</AppLayout>
</template>
