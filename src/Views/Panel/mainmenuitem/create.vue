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
    breadcrumbCurrentTitle: String,
    breadcrumbCurrentSection: String,
    menuid: Number,
    mainmenu: Object,
    menuitems: Object,
});
const form = useForm({
         menu: props.menuid,
         items: [],
});
const submit = () => {
    var arrayitems = [];
	$.each($('div.menuitem'), function(index, item){
	var text = $(item).find('input[name="text"]').val();
	var link = $(item).find('input[name="link"]').val();
	arrayitems.push({text: text, link: link});
	});
	form.items = arrayitems;
    form.post(route('managermainmenuitem.store'));
};
$('body').on('click', '#newitem', function(){
var id = $('.menuitem').length + 1;
$('.menuitemgroup').append('<div id="item' + id + '" class="position-relative relative border border-primary py-2 px-2 menuitem mb-4"> <div class="row"> <div class="col-xs-12 col-sm-12 col-md-6"> <div class="form-group"> <label for="text' + id + '">Text</label> <input id="text' + id + '" type="text" class="form-control mt-1 block w-full" placeholder="Text" name="text" autocomplete="text" required /> </div> </div> <div class="col-xs-12 col-sm-12 col-md-6"> <div class="form-group"> <label for="link' + id + '">URL</label> <input id="link' + id + '" type="url" class="form-control mt-1 block w-full" placeholder="https://domain.com/page' + id + '" name="link" autocomplete="link" required />  </div> </div> </div> <button data-id="item' + id + '" class="btn btn-light shadow-sm p-2 px-2 text-center align-self-center cursor-text rounded-circle text-dark absolute top-0 right-0 -translate-y-6 translate-x-6 deleteitem"> <i class="menu-icon mdi mdi-trash-can"></i> </button> </div>');
});
$('body').on('click', '.deleteitem', function(){
var id = $(this).data('id');
$('#' + id).remove();
});
</script>

<template>
<AppLayout :menuitems="menuitems" :avatar="avatar" :role="role" :name="name" :version="version" :breadcrumbCurrentTitle="breadcrumbCurrentTitle" :breadcrumbCurrentSection="breadcrumbCurrentSection" :title="title">
        <template #breadcrumb>
              <li class="breadcrumb-item active" aria-current="page">Adicionar item ao menu</li>
        </template>
        <JetValidationErrors class="mb-4" />

        <form @submit.prevent="submit">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                     <JetLabel for="menu" value="Menu" />
                     <JetSelect id="menu" class="form-control mt-1 block w-full" placeholder="menu" v-model="form.menu" name="menu" autocomplete="menu" required>
					 <option v-for="row in mainmenu" :value="row.id">{{row.name}} - {{row.domain}}</option>
					 </JetSelect>
                     <JetInputError for="menu" class="mt-2" />
                </div>
            </div>
			
			<div class="col-xs-12 col-sm-12 col-md-12 py-2 card card-body fw-bold font-bold text-dark bg-light w-full w-100 my-5">
			<div class="row">
			<div class="col me-auto mr-auto"><strong>Items</strong></div>
			<div clas="col-3"><button type="button" id="newitem" class="btn btn-primary btn-block">Add item</button></div>
			</div>
			</div>
            <div class="col-xs-12 col-sm-12 col-md-12 menuitemgroup">
            <div id="item1" class="border border-primary py-2 px-2 menuitem mb-4">
            <div class="row">
			
            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="form-group">
                     <JetLabel for="text1" value="Text" />
                     <JetInput id="text1" type="text" class="form-control mt-1 block w-full" placeholder="Text" name="text" autocomplete="text" required />
                     <JetInputError for="text1" class="mt-2" />
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="form-group">
                     <JetLabel for="link1" value="URL" />
                     <JetInput id="link1" type="url" class="form-control mt-1 block w-full" placeholder="https://domain.com/page" name="link" autocomplete="link" required />
                     <JetInputError for="link1" class="mt-2" />
                </div>
            </div>
			
            </div>
            </div>	
            </div>	
			
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <JetButton type="submit" class="btn btn-primary" title="Salvar" aria-label="Salvar" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Salvar</JetButton>
            </div>
        </div>
      </form>

</AppLayout>
</template>
