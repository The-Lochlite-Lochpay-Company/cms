<script setup>
import { ref } from 'vue';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import JetDialogModal from 'lochlitecms/Views/Components/Layouts/DialogModal.vue';
import JetButton from 'lochlitecms/Views/Components/Layouts/Button.vue';
import JetInput from 'lochlitecms/Views/Components/Layouts/Input.vue';
import JetInputError from 'lochlitecms/Views/Components/Layouts/InputError.vue';
import JetCheckbox from 'lochlitecms/Views/Components/Layouts/Checkbox.vue';
import JetLabel from 'lochlitecms/Views/Components/Layouts/Label.vue';
import JetValidationErrors from 'lochlitecms/Views/Components/Layouts/ValidationErrors.vue';
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
    menulang: Object,
    menuitems: Object,
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
<AppLayout :menulang="menulang" :menuitems="menuitems" :avatar="avatar" :role="role" :name="name" :version="version" :breadcrumbCurrentTitle="breadcrumbCurrentTitle" :breadcrumbCurrentSection="breadcrumbCurrentSection" :title="title">
        <template #breadcrumb>
             <li class="breadcrumb-item active" aria-current="page">Stored data</li>
		</template>
        <JetValidationErrors class="mb-4" />

        <div class="row">
        <div class="col-12 col-md-4">
        <div class="card card-body shadow-none border border-primary rounded-0 static relative mb-5">
        <div class="fw-bold my-3">Clear CMS cache</div>
        <p class="card-text my-3">This operation may momentarily reduce site performance.</p>
        <form id="cache" action="/manager/settings" method="POST" @submit.prevent="submit">
        <input type="hidden" name="_method" value="post"/>
        <input type="hidden" name="module" value="cache" id="inputcache"/>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <JetButton type="submit" class="btn btn-primary" title="Clean" aria-label="Clean" data-module="cache" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Clean</JetButton>
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
        <div class="fw-bold my-3">Clear cache settings</div>
        <p class="card-text my-3">This operation may momentarily reduce site performance.</p>
        <form id="config" action="/manager/settings" method="POST" @submit.prevent="submit">
        <input type="hidden" name="_method" value="post"/>
        <input type="hidden" name="module" value="config" id="inputconfig"/>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <JetButton type="submit" class="btn btn-primary" title="Clean" aria-label="Clean" data-module="config" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Clean</JetButton>
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
        <div class="fw-bold my-3">Clear render cache</div>
        <p class="card-text my-3">This operation may momentarily reduce site performance.</p>
        <form id="view" action="/manager/settings" method="POST" @submit.prevent="submit">
        <input type="hidden" name="_method" value="post"/>
        <input type="hidden" name="module" value="view" id="inputview"/>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <JetButton type="submit" class="btn btn-primary" title="Clean" aria-label="Clean" data-module="view" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Clean</JetButton>
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
        <div class="fw-bold my-3">Clear cache of routes</div>
        <p class="card-text my-3">This operation may momentarily reduce site performance.</p>
        <form id="route" action="/manager/settings" method="POST" @submit.prevent="submit">
        <input type="hidden" name="_method" value="post"/>
        <input type="hidden" name="module" value="route" id="inputroute"/>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <JetButton type="submit" class="btn btn-primary" title="Clean" aria-label="Clean" data-module="route" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Clean</JetButton>
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
        <div class="fw-bold my-3">Clear all types of cache</div>
        <p class="card-text my-3">This operation may momentarily reduce site performance.</p>
        <form id="cleanall" action="/manager/settings" method="POST" @submit.prevent="submit">
        <input type="hidden" name="_method" value="post"/>
        <input type="hidden" name="module" value="cleanall" id="inputcleanall"/>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <JetButton type="submit" class="btn btn-primary" title="Clean" aria-label="Clean" data-module="cleanall" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Clean</JetButton>
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
        <div class="fw-bold my-3">Optimize the site</div>
        <p class="card-text my-3">This operation refreshes all existing cache and improves site performance</p>
        <form id="optimize" action="/manager/settings" method="POST" @submit.prevent="submit">
        <input type="hidden" name="_method" value="post"/>
        <input type="hidden" name="module" value="optimize" id="inputoptimize"/>
		<div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <JetButton type="submit" class="btn btn-success" title="Optimize" aria-label="Optimize" data-module="optimize" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Optimize</JetButton>
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
