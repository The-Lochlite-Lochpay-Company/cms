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
    userid: '',
    username: String,
    useremail: String,
    userroles: Object,
    rolesall: Object,
    breadcrumbCurrentTitle: String,
    breadcrumbCurrentSection: String,
    menulang: Object,
    menuitems: Object,
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
<AppLayout :menulang="menulang" :menuitems="menuitems" :avatar="avatar" :role="role" :name="name" :version="version" :breadcrumbCurrentTitle="breadcrumbCurrentTitle" :breadcrumbCurrentSection="breadcrumbCurrentSection" :title="title">
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
