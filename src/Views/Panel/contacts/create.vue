<script setup>
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

defineProps({
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
});
const form = useForm({
    name: '',
    email: '',
    status: '',
    message: '',
});

const submit = (event) => {
    form.transform(data => ({
        ...data,
    })).post(route('managercontacts.store'), {
        onFinish: () => form.reset(),
    });
};

</script>

<template>
<AppLayout :menuitems="menuitems" :avatar="avatar" :role="role" :name="name" :version="version" :breadcrumbCurrentTitle="breadcrumbCurrentTitle" :breadcrumbCurrentSection="breadcrumbCurrentSection" :title="title">
        <template #breadcrumb>
              <li class="breadcrumb-item active" aria-current="page">Criar</li>
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
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                     <JetLabel for="status" value="Status" />
                     <select id="status" class="form-select p-1 w-full" v-model="form.status" name="status" autocomplete required>
					 <option value="received" selected>Recebido</option>
					 <option value="answered">Respondido</option>
					 <option value="refused">Recusado</option>
					 </select>
                     <JetInputError for="status" class="mt-2" />
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                     <JetLabel for="message" value="Mensagem" />
                     <textarea class="form-control w-100" v-model="form.message" name="message" required></textarea>
                     <JetInputError for="message" class="mt-2" />
				</div>
            </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <JetButton type="submit" class="btn btn-primary" title="Cadastrar" aria-label="Cadastrar" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Cadastrar</JetButton>
            </div>
      </form>

</AppLayout>
</template>
