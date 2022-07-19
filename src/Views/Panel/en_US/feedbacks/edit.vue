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
    feedback: Object,
    breadcrumbCurrentTitle: String,
    breadcrumbCurrentSection: String,
    menulang: Object,
    menuitems: Object,
});
const form = useForm({
    question: props.feedback.question,
    option1: props.feedback.option1,
    option2: props.feedback.option2,
    option3: props.feedback.option3,
    option4: props.feedback.option4,
    option5: props.feedback.option5,
});
const submit = () => {
    form.transform(data => ({
        ...data,
    })).put(route('managerfeedbacks.update', {id: props.feedback.id}), {
        onFinish: () => form.reset(),
    });
};
</script>

<template>
<AppLayout :menulang="menulang" :menuitems="menuitems" :avatar="avatar" :role="role" :name="name" :version="version" :breadcrumbCurrentTitle="breadcrumbCurrentTitle" :breadcrumbCurrentSection="breadcrumbCurrentSection" :title="title">
        <template #breadcrumb>
              <li class="breadcrumb-item active" aria-current="page">Editing: {{ feedback.id }} - {{ feedback.question }}</li>
        </template>
        <JetValidationErrors class="mb-4" />

        <form @submit.prevent="submit">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                     <JetLabel for="question" value="Question" />
                     <JetInput id="question" type="text" class="form-control mt-1 block w-full" placeholder="Ex: On an average of 1 to 5, what is your level of satisfaction?" v-model="form.question" name="question" autocomplete="question" required />
                     <JetInputError for="question" class="mt-2" />
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="row">
            <div class="col">
                <div class="form-group">
                     <JetLabel for="option1" value="Option 1" />
                     <JetInput id="option1" type="text" class="form-control mt-1 block w-full" placeholder="option 1" name="option1" autocomplete="option1" v-model="form.option1" required />
                     <JetInputError for="option1" class="mt-2" />
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                     <JetLabel for="option2" value="Option 2" />
                     <JetInput id="option2" type="text" class="form-control mt-1 block w-full" placeholder="option 2" name="option2" autocomplete="option2" v-model="form.option2" required />
                     <JetInputError for="option2" class="mt-2" />
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                     <JetLabel for="option3" value="Option 3" />
                     <JetInput id="option3" type="text" class="form-control mt-1 block w-full" placeholder="option 3" name="option3" autocomplete="option3" v-model="form.option3" />
                     <JetInputError for="option3" class="mt-2" />
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                     <JetLabel for="option4" value="Option 4" />
                     <JetInput id="option4" type="text" class="form-control mt-1 block w-full" placeholder="option 4" name="option4" autocomplete="option4" v-model="form.option4" />
                     <JetInputError for="option4" class="mt-2" />
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                     <JetLabel for="option5" value="Option 5" />
                     <JetInput id="option5" type="text" class="form-control mt-1 block w-full" placeholder="option 5" name="option5" autocomplete="option5" v-model="form.option5" />
                     <JetInputError for="option5" class="mt-2" />
                </div>
            </div>
            </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <JetButton type="submit" class="btn btn-primary" title="Update" aria-label="Update" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Update</JetButton>
            </div>
        </div>
      </form>

</AppLayout>
</template>
