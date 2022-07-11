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
import MylochiTinyEditor from  '@/Components/MylochiTinyEditor.vue';
import DOMPurify from 'dompurify';

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
    question: '',
    option1: '1',
    option2: '2',
    option3: '3',
    option4: '4',
    option5: '5',
});
const submit = () => {
    form.transform(data => ({
        ...data,
    })).post(route('managerfeedbacks.store'), {
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
                <JetButton type="submit" class="btn btn-primary" title="Cadastrar" aria-label="Cadastrar" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Cadastrar</JetButton>
            </div>
        </div>
      </form>

</AppLayout>
</template>
