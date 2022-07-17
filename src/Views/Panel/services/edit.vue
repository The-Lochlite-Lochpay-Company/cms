<script setup>
import { ref } from 'vue';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import JetDialogModal from '@/Jetstream/DialogModal.vue';
import JetActionMessage from '@/Jetstream/ActionMessage.vue';
import JetButton from '@/Jetstream/Button.vue';
import JetSelect from '@/Jetstream/Select.vue';
import JetInput from '@/Jetstream/Input.vue';
import JetInputError from '@/Jetstream/InputError.vue';
import JetCheckbox from '@/Jetstream/Checkbox.vue';
import JetLabel from '@/Jetstream/Label.vue';
import JetValidationErrors from '@/Jetstream/ValidationErrors.vue';
import AppLayout from 'lochlitecms/Views/Panel/AppLayout.vue';
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
    service: Object,
    breadcrumbCurrentTitle: String,
    breadcrumbCurrentSection: String,
});
const form = useForm({
    domain: props.service.domain,
    name: props.service.name,
    host: props.service.host,
    query: props.service.query,
    callback: props.service.callback,
    type: 'post',
    datatype: 'json',
    items: props.service.api,
});
const submit = () => {
    var objall = {};
    var objapi = {};
    var original = [];
	$.each($('div.apiitem'), function(index, item){
	var key = $(item).find('input[name="key"]').val();
	var value = $(item).find('input[name="value"]').val();
	original.push({key: key, value: value});
	objapi[key] = value;
	});
	objall['original'] = original;
	objall['api'] = objapi;
	form.items = objall;
    form.put(route('managerservices.update', {id: props.service.id}));
};
$('body').on('click', '#newitem', function(){
var id = $('.apiitem').length + 1;
$('.apiitemgroup').append('<div id="item' + id + '" class="position-relative relative border border-primary py-2 px-2 apiitem mb-4"> <div class="row"> <div class="col-xs-12 col-sm-12 col-md-6"> <div class="form-group"> <label for="key' + id + '">Key</label> <input id="key' + id + '" type="text" class="form-control mt-1 block w-full" placeholder="Key" name="key" autocomplete="key" required /> </div> </div> <div class="col-xs-12 col-sm-12 col-md-6"> <div class="form-group"> <label for="value' + id + '">Value</label> <input id="value' + id + '" type="text" class="form-control mt-1 block w-full" placeholder="value' + id + '" name="value" autocomplete="value" required />  </div> </div> </div> <button data-id="item' + id + '" class="btn btn-light shadow-sm p-2 px-2 text-center align-self-center cursor-text rounded-circle text-dark absolute top-0 right-0 -translate-y-6 translate-x-6 deleteitem"> <i class="menu-icon mdi mdi-trash-can"></i> </button> </div>');
});
$('body').on('click', '.deleteitem', function(){
var id = $(this).data('id');
$('#' + id).remove();
});
</script>

<template>
<AppLayout :apiitems="apiitems" :avatar="avatar" :role="role" :name="name" :version="version" :breadcrumbCurrentTitle="breadcrumbCurrentTitle" :breadcrumbCurrentSection="breadcrumbCurrentSection" :title="title">
        <template #breadcrumb>
              <li class="breadcrumb-item active" aria-current="page">Editar serviço</li>
        </template>
        <JetValidationErrors class="mb-4" />
         
        <form @submit.prevent="submit">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="form-group">
                     <JetLabel for="domain" value="Domain" />
                     <JetInput type="url" id="domain" class="form-control mt-1 block w-full" placeholder="https://domain.com" v-model="form.domain" name="domain" autocomplete="domain" required />
                     <JetInputError for="domain" class="mt-2" />
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="form-group">
                     <JetLabel for="name" value="name" />
                     <JetInput type="text" id="name" class="form-control mt-1 block w-full" placeholder="name" v-model="form.name" name="name" autocomplete="name" required />
                     <JetInputError for="name" class="mt-2" />
                </div>
            </div>
			
			<div class="col-xs-12 col-sm-12 col-md-12 py-2 card card-body fw-bold font-bold text-dark bg-light w-full w-100 my-5">
			<div class="row">
			<div class="col me-auto mr-auto"><strong>API Connect</strong></div>
			</div>
			</div>
            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                     <JetLabel for="host" value="Host" />
                     <JetInput v-model="form.host" id="host" type="url" class="form-control mt-1 block w-full" placeholder="https://api.domain.com" name="host" autocomplete="host" required />
                     <JetInputError for="host" class="mt-2" />
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                     <JetLabel for="callback" value="Callback" />
                     <JetInput v-model="form.callback" id="callback" type="url" class="form-control mt-1 block w-full" placeholder="https://mydomain.com/exemple" name="callback" autocomplete="callback" required />
                     <JetInputError for="callback" class="mt-2" />
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                     <JetLabel for="type" value="Type" />
                     <JetSelect v-model="form.type" id="type" class="form-control mt-1 block w-full" placeholder="json" name="type" autocomplete="type" required>
					 <option value="get" selected>get</option>
					 <option value="post" selected>post</option>
					 </JetSelect>
                     <JetInputError for="type" class="mt-2" />
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                     <JetLabel for="data" value="Data type" />
                     <JetSelect v-model="form.datatype" id="data" class="form-control mt-1 block w-full" placeholder="data" name="data" autocomplete="data" required>
					 <option value="json" selected>json</option>
					 </JetSelect>
                     <JetInputError for="data" class="mt-2" />
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                     <JetLabel for="query" value="URL Query" />
                     <JetInput v-model="form.query" id="query" type="text" class="form-control mt-1 block w-full" placeholder="?query=value&query2=value&query3=value..." name="query" autocomplete="query" />
                     <JetInputError for="query" class="mt-2" />
                </div>
            </div>
			
 			<div class="col-xs-12 col-sm-12 col-md-12 py-2 card card-body fw-bold font-bold text-dark bg-light w-full w-100 my-5">
			<div class="row">
			<div class="col me-auto mr-auto"><strong>API Data</strong></div>
			<div clas="col-3"><button type="button" id="newitem" class="btn btn-primary btn-block">Add item</button></div>
			</div>
			</div>
            <div class="col-xs-12 col-sm-12 col-md-12 apiitemgroup">
            <div v-for="(row, index) in service.api.original" :id="'item' + index" :class="{'position-relative relative': index > 0}" class="border border-primary py-2 px-2 apiitem mb-4">
            <div class="row">
			
            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="form-group">
                     <JetLabel :for="'key' + index" value="Key" />
                     <JetInput :id="'key' + index" type="text" class="form-control mt-1 block w-full" :placeholder="'Key' + index" name="key" autocomplete="key" :value="row.key" required />
                     <JetInputError :for="'key' + index" class="mt-2" />
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="form-group">
                     <JetLabel :for="'value' + index" value="Value" />
                     <JetInput :id="'value' + index" type="text" class="form-control mt-1 block w-full" :placeholder="'value' + index" name="value" autocomplete="value" :value="row.value" required />
                     <JetInputError :for="'value' + index" class="mt-2" />
                </div>
            </div>
			
            </div>
            <button v-if="index > 0" data-id="item' + index + '" class="btn btn-light shadow-sm p-2 px-2 text-center align-self-center cursor-text rounded-circle text-dark absolute top-0 right-0 -translate-y-6 translate-x-6 deleteitem"> <i class="menu-icon mdi mdi-trash-can"></i> </button>			
            </div>	
            </div>	
			
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <JetButton type="submit" class="btn btn-primary" title="Salvar" aria-label="Salvar" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Salvar</JetButton>
            </div>
        </div>
      </form>

</AppLayout>
</template>
