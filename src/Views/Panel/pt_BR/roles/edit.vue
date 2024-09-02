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
    rolePermissions: Object,
    permission: Object,
    roledata: Object,
    breadcrumbCurrentTitle: String,
    breadcrumbCurrentSection: String,
    menulang: Object,
    menuitems: Object,
});
const form = useForm({
    name: props.roledata.name,
    permission: [],
});

const submit = (event) => {
    const arraypermission = new Array();
	$.each($('#rowgrouppermission input[type="checkbox"]:checked'),function(index, item){
	var id = $(item).val();
	arraypermission.push(id);
	});
	form.permission = arraypermission;
    form.transform(data => ({
        ...data,
    })).put(route('managerroles.update', {id: event.submitter.dataset.role}));
};
</script>

<template>
<AppLayout :menulang="menulang" :menuitems="menuitems" :avatar="avatar" :role="role" :name="name" :version="version" :breadcrumbCurrentTitle="breadcrumbCurrentTitle" :breadcrumbCurrentSection="breadcrumbCurrentSection" :title="title">
        <template #breadcrumb>
              <li class="breadcrumb-item active" aria-current="page">Editar: {{ roledata.id }} - {{ roledata.name }}</li>
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
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <JetLabel for="permissions" value="Permissões" />
                    <div class="grid grid-cols-1 md:grid-cols-4 lg:grid-cols-5 gap-3" id="rowgrouppermission">
                    <div class="form-check" v-for="(row, index) in permission">
					  <JetCheckbox class="h-4 w-4 border border-gray-300 rounded-sm me-2 mr-2" type="checkbox" :id="'flexSelectOptionrow' + row.id" :value="row.id" v-model="form.permission" name="permission[]" :checked="rolePermissions.includes(row.id) == true" />
                      <JetLabel class="inline-block" :for="'flexSelectOptionrow' + row.id">{{row.name}}</JetLabel>
                     </div>
                     </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <JetButton type="submit" class="btn btn-primary" title="Atualizar" aria-label="Atualizar" :data-role="roledata.id" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Atualizar</JetButton>
            </div>
        </div>
      </form>

</AppLayout>
</template>
