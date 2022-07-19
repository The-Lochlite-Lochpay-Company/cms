<script setup>
import { ref } from 'vue';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import JetDialogModal from 'lochlitecms/Views/Components/Layouts/DialogModal.vue';
import JetActionMessage from 'lochlitecms/Views/Components/Layouts/ActionMessage.vue';
import JetButton from 'lochlitecms/Views/Components/Layouts/Button.vue';
import JetSelect from 'lochlitecms/Views/Components/Layouts/Select.vue';
import JetInput from 'lochlitecms/Views/Components/Layouts/Input.vue';
import JetInputError from 'lochlitecms/Views/Components/Layouts/InputError.vue';
import JetCheckbox from 'lochlitecms/Views/Components/Layouts/Checkbox.vue';
import JetLabel from 'lochlitecms/Views/Components/Layouts/Label.vue';
import JetValidationErrors from 'lochlitecms/Views/Components/Layouts/ValidationErrors.vue';
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
    appendcoding: Object,
    menulang: Object,
    menuitems: Object,
});
const form = useForm({
    comment: props.appendcoding.comment,
    position: props.appendcoding.position,
    status: props.appendcoding.status,
    body: props.appendcoding.body,
});
const submit = (event) => {
    form.put(route('managerappendcoding.update', {id: event.submitter.dataset.appendcoding}));
};
</script>

<template>
<AppLayout :menulang="menulang" :menuitems="menuitems" :avatar="avatar" :role="role" :name="name" :version="version" :breadcrumbCurrentTitle="breadcrumbCurrentTitle" :breadcrumbCurrentSection="breadcrumbCurrentSection" :title="title">
        <template #breadcrumb>
              <li class="breadcrumb-item active" aria-current="page">Editar</li>
        </template>
        <JetValidationErrors class="mb-4" />

        <form @submit.prevent="submit">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                     <JetLabel for="comment" value="Comment" />
                     <JetInput id="comment" type="text" class="form-control mt-1 block w-full" placeholder="comment" v-model="form.comment" name="comment" autocomplete="comment" required />
                     <JetInputError for="comment" class="mt-2" />
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="form-group">
                     <JetLabel for="position" value="Position" />
                     <JetSelect id="position" class="form-control mt-1 block w-full" placeholder="position" v-model="form.position" name="position" autocomplete="position" required>
					 <option value="head">Head</option>
					 <option value="body-top">Body-top</option>
					 <option value="body-end">Body-end</option>
					 </JetSelect>
                     <JetInputError for="position" class="mt-2" />
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="form-group">
                     <JetLabel for="status" value="Status" />
                     <JetSelect id="status" class="form-control mt-1 block w-full" placeholder="status" v-model="form.status" name="status" autocomplete="status" required>
					 <option value="active">Active</option>
					 <option value="disable">Disable</option>
					 </JetSelect>
                     <JetInputError for="status" class="mt-2" />
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                     <JetLabel for="body" value="Code" />
                     <textarea id="body" class="form-control mt-1 block w-full" placeholder="body" v-model="form.body" name="body" autocomplete="body" required></textarea>
                     <JetInputError for="body" class="mt-2" />
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <JetButton type="submit" class="btn btn-primary" title="Atualizar" aria-label="Atualizar" :class="{ 'opacity-25': form.processing }" :disabled="form.processing" data-event="submit" data-function="delete" :data-appendcoding="appendcoding.id">Atualizar</JetButton>
            </div>
        </div>
      </form>

</AppLayout>
</template>
