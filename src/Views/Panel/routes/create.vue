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
    menuitems: Object,
    currentdomain: String,
});
const form = useForm({
    name: '',
    type: '',
    url: '',
    controller: '',
    action: '',
    middleware: '',
    status: 'active',
    only: '',
    except: '',
});
const submit = () => {
    form.post(route('managerroutes.store'));
};
</script>
<template>
<AppLayout :menuitems="menuitems" :avatar="avatar" :role="role" :name="name" :version="version" :breadcrumbCurrentTitle="breadcrumbCurrentTitle" :breadcrumbCurrentSection="breadcrumbCurrentSection" :title="title">
        <template #breadcrumb>
              <li class="breadcrumb-item active" aria-current="page">Editar</li>
        </template>
        <JetValidationErrors class="mb-4" />

        <form @submit.prevent="submit">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="form-group">
                     <JetLabel for="controller" value="Controller" />
                     <JetInput id="controller" type="text" class="form-control mt-1 block w-full" placeholder="controller" v-model="form.controller" name="controller" required />
                     <JetInputError for="controller" class="mt-2" />
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="form-group">
                     <JetLabel for="action" value="Action" />
                     <JetInput id="action" type="text" class="form-control mt-1 block w-full" placeholder="action" v-model="form.action" name="action" required />
                     <JetInputError for="action" class="mt-2" />
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="form-group">
                     <JetLabel for="name" value="Name" />
                     <JetInput id="name" type="text" class="form-control mt-1 block w-full" placeholder="name" v-model="form.name" name="name" required />
                     <JetInputError for="name" class="mt-2" />
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="form-group">
                     <JetLabel for="middleware" value="Middleware" />
                     <JetInput id="middleware" type="text" class="form-control block w-full" placeholder="middleware" v-model="form.middleware" name="middleware" required />
                     <JetInputError for="middleware" class="mt-2" />
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="form-group">
                     <JetLabel for="url" value="URL" />
                     <div class="input-group mt-1" data-bs-toggle="tooltip" title="Do not include the domain and do not insert / at the beginning">
                     <label for="url" class="form-control appearance-none border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-0 text-gray-700 leading-tight bg-light fw-bold font-bold text-right">{{ currentdomain + '/' }}</label>
                     <JetInput id="url" type="text" class="form-control block w-full border-left-0" placeholder="Ex: knowledge/faq" v-model="form.url" name="url" required />
                     </div>
                     <JetInputError for="url" class="mt-2" />
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="form-group">
                     <JetLabel for="type" value="Type" />
                     <JetSelect id="type" class="form-control mt-1 block w-full" placeholder="type" v-model="form.type" name="type" autocomplete="type" required>
					 <option value="get">GET</option>
					 <option value="post">POST</option>
					 <option value="put">PUT</option>
					 <option value="delete">DELETE</option>
					 <option value="resource">RESOURCE</option>
					 <option value="['GET','POST']">GET | POST</option>
					 <option value="['POST','PUT']">POST | PUT</option>
					 <option value="['POST','DELETE']">POST | DELETE</option>
					 <option value="['HEAD','GET']">HEAD | GET</option>
					 <option value="['PATCH','POST']">PATCH | POST</option>
					 <option value="['HEAD','GET','PATCH','POST']">HEAD | GET | PATCH | POST</option>
					 </JetSelect>
                     <JetInputError for="type" class="mt-2" />
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                     <JetLabel for="status" value="Status" />
                     <JetSelect id="status" class="form-control mt-1 block w-full" placeholder="status" v-model="form.status" name="status" autocomplete="status" required>
					 <option value="active">Active</option>
					 <option value="disable">Disable</option>
					 </JetSelect>
                     <JetInputError for="status" class="mt-2" />
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="form-group">
                     <JetLabel for="only" value="Only" />
                     <JetSelect id="only" class="form-control mt-1 block w-full" placeholder="only" v-model="form.only" name="only" autocomplete="only">
					 <option value=""></option>
					 <option value="index">index</option>
					 <option value="show">show</option>
					 <option value="store">store</option>
					 <option value="edit">edit</option>
					 <option value="create">create</option>
					 <option value="update">update</option>
					 <option value="destroy">destroy</option>
					 <option value="['index','show']">index | show</option>
					 <option value="['create','store']">create | store</option>
					 <option value="['edit','update']">edit | update</option>
					 <option value="['show','create','store']">show | create | store</option>
					 <option value="['show','edit','update']">show | edit | update</option>
					 <option value="['edit','update','destroy']">edit | update | destroy</option>
					 <option value="['index','show','destroy']">index | show | destroy</option>
					 <option value="['index','create','store']">index | create | store</option>
					 <option value="['index','edit','update']">index | edit | update</option>
					 <option value="['index','create','store','destroy']">index | create | store | destroy</option>
					 <option value="['create','edit','update','store','destroy']">create | edit | update | store | destroy</option>
					 </JetSelect>
                     <JetInputError for="only" class="mt-2" />
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="form-group">
                     <JetLabel for="except" value="Except" />
                     <JetSelect id="except" class="form-control mt-1 block w-full" placeholder="except" v-model="form.except" name="except" autocomplete="except">
					 <option value=""></option>
					 <option value="index">index</option>
					 <option value="show">show</option>
					 <option value="store">store</option>
					 <option value="edit">edit</option>
					 <option value="create">create</option>
					 <option value="update">update</option>
					 <option value="destroy">destroy</option>
					 <option value="['index','show']">index | show</option>
					 <option value="['create','store']">create | store</option>
					 <option value="['edit','update']">edit | update</option>
					 <option value="['show','create','store']">show | create | store</option>
					 <option value="['show','edit','update']">show | edit | update</option>
					 <option value="['edit','update','destroy']">edit | update | destroy</option>
					 <option value="['index','show','destroy']">index | show | destroy</option>
					 <option value="['index','create','store']">index | create | store</option>
					 <option value="['index','edit','update']">index | edit | update</option>
					 <option value="['index','create','store','destroy']">index | create | store | destroy</option>
					 <option value="['create','edit','update','store','destroy']">create | edit | update | store | destroy</option>
					 </JetSelect>
                     <JetInputError for="except" class="mt-2" />
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <JetButton type="submit" class="btn btn-primary" title="Adicionar" aria-label="Adicionar" :class="{ 'opacity-25': form.processing }" :disabled="form.processing" data-event="submit" data-function="create">Adicionar</JetButton>
            </div>
        </div>
      </form>

</AppLayout>
</template>
