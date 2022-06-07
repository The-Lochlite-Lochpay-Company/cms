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
    userid: '',
    username: String,
    useremail: String,
    userroles: Object,
    rolesall: Object,
    breadcrumbCurrentTitle: String,
    breadcrumbCurrentSection: String,
});
const form = useForm({
    name: '',
    name: props.username,
    email: props.useremail,
    password: '',
    password_confirmation: '',
    roles: [],
});

const submit = (event) => {
    const arrayquest = new Array();
	$.each($('#rowgrouproles input[type="checkbox"]:checked'),function(index, item){
	var id = $(item).val();
	arrayquest.push(id);
	});
	form.roles = arrayquest;
    form.transform(data => ({
        ...data,
    })).put(route('managerusers.update', {id: event.submitter.dataset.user}), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
<AppLayout :avatar="avatar" :role="role" :name="name" :version="version" :breadcrumbCurrentTitle="breadcrumbCurrentTitle" :breadcrumbCurrentSection="breadcrumbCurrentSection" :title="title">
        <template #breadcrumb>
              <li class="breadcrumb-item active" aria-current="page">Editar</li>
        </template>
        <JetValidationErrors class="mb-4" />

        <form @submit.prevent="submit">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="form-group">
                     <JetLabel for="name" value="Nome" />
                     <JetInput id="name" type="text" class="form-control mt-1 block w-full" placeholder="Nome" v-model="form.name" name="name" autocomplete="name" />   
                     <JetInputError for="name" class="mt-2" />
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="form-group">
                     <JetLabel for="email" value="Email" />
                     <JetInput id="email" type="email" class="form-control mt-1 block w-full" placeholder="Email" v-model="form.email" name="email" autocomplete="email" />
                     <JetInputError for="email" class="mt-2" />
                </div>
            </div> 
            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="form-group">
                     <JetLabel for="password" value="Nova senha" />
                     <JetInput id="password" type="password" class="form-control mt-1 block w-full" placeholder="Nova senha" v-model="form.password" name="password" autocomplete="new-password" />
                     <JetInputError for="password" class="mt-2" />
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="form-group">
                     <JetLabel for="password_confirmation" value="Confirme a nova senha" />
                     <JetInput id="password_confirmation" type="password" class="form-control mt-1 block w-full" placeholder="Confirme a nova senha" v-model="form.password_confirmation" name="password_confirmation" autocomplete="new-password" />
                     <JetInputError for="password_confirmation" class="mt-2" />
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <JetLabel for="permissions" value="Permissões" />
                    <div class="grid grid-cols-1 md:grid-cols-4 lg:grid-cols-5 gap-3" id="rowgrouproles">
                    <div class="form-check" v-for="(row, index) in rolesall">
					  <JetCheckbox class="h-4 w-4 border border-gray-300 rounded-sm me-2 mr-2" type="checkbox" :id="'flexSelectOptionrow' + row.id" :value="row.id" v-model="form.roles" name="roles[]" :checked="userroles.includes(row.name) == true" />
                      <JetLabel class="inline-block" :for="'flexSelectOptionrow' + row.id">{{row.name}}</JetLabel>
                     </div>
                     </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <JetButton type="submit" class="btn btn-primary" title="Atualizar" aria-label="Atualizar" :data-user="userid" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Atualizar</JetButton>
            </div>
        </div>
      </form>

</AppLayout>
</template>
