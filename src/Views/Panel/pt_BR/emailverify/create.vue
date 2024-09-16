<script setup>
import { ref } from 'vue';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import JetDialogModal from 'lochlitecms/Views/Components/Layouts/DialogModal.vue';
import JetActionMessage from 'lochlitecms/Views/Components/Layouts/ActionMessage.vue';
import JetButton from 'lochlitecms/Views/Components/Layouts/Button.vue';
import JetInput from 'lochlitecms/Views/Components/Layouts/Input.vue';
import JetInputError from 'lochlitecms/Views/Components/Layouts/InputError.vue';
import JetCheckbox from 'lochlitecms/Views/Components/Layouts/Checkbox.vue';
import JetLabel from 'lochlitecms/Views/Components/Layouts/Label.vue';
import JetSelect from 'lochlitecms/Views/Components/Layouts/Select.vue';
import JetValidationErrors from 'lochlitecms/Views/Components/Layouts/ValidationErrors.vue';
import AppLayout from 'lochlitecms/Views/Panel/AppLayout.vue';
import MylochiTinyEditor from  'lochlitecms/Views/Components/MylochiTinyEditor.vue';
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
    menulang: Object,
    menuitems: Object,
});
const form = useForm({
    domain: window.location.origin,
    default: 0,
    logo: window.location.origin + '/application/72x72.png',
    image: 'https://source.unsplash.com/user/erondu/1600x900',
    imagevisible: 1,
    emphasis: 'Thanks for signing up!',
    instruction: "Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn't receive the email, we will gladly send you another.",
    title: 'Email Verify',
    description: 'Thanks for signing up!',
    confirmationsend: 'A new verification link has been sent to the email address you provided during registration.',
    changeemailtext: 'Need to update email? Click here',
    buttontext: 'Resend Verification Email',
    buttoncolor: 'bg-blue-600',
    buttontextcolor: 'text-white',
});
const submit = () => {
    form.post(route('manageremailverify.store'));
};
</script>
<template>
    <AppLayout :menulang="menulang" :menuitems="menuitems" :avatar="avatar" :role="role" :name="name" :version="version" :breadcrumbCurrentTitle="breadcrumbCurrentTitle" :breadcrumbCurrentSection="breadcrumbCurrentSection" :title="title">
        <template #breadcrumb>
            <li class="breadcrumb-item active" aria-current="page">Nova página de recuperação de senha</li>
        </template>
        <JetValidationErrors class="mb-4" />

        <form @submit.prevent="submit">
            <div class="flex flex-wrap -mx-3 mb-6">
                <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                    <div class="mb-4">
                        <JetLabel for="domain" value="Domain" />
                        <JetInput id="domain" type="text" class="mt-1 block w-full" placeholder="https://domain.com" v-model="form.domain" name="domain" autocomplete="domain" autofocus required />
                        <JetInputError for="domain" class="mt-2" />
                    </div>
                </div>
                <div class="w-full md:w-1/2 px-3">
                    <div class="mb-4">
                        <JetLabel for="default" value="Default" />
                        <JetSelect id="default" class="mt-1 block w-full" placeholder="Default" v-model="form.default" name="default" autocomplete required>
                            <option value="0">False</option>
                            <option value="1">True</option>
                        </JetSelect>
                        <JetInputError for="default" class="mt-2" />
                    </div>
                </div>
                <div class="w-full card border-0 shadow-none">
                    <div class="card-header">SEO</div>
                    <div class="card-body">
                        <div class="flex flex-wrap -mx-3 mb-6">
                            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                                <div class="mb-4">
                                    <JetLabel for="title" value="Title" />
                                    <JetInput id="title" type="text" class="mt-1 block w-full" placeholder="Title" v-model="form.title" name="title" autocomplete="title" />
                                    <JetInputError for="title" class="mt-2" />
                                </div>
                            </div>
                            <div class="w-full md:w-1/2 px-3">
                                <div class="mb-4">
                                    <JetLabel for="description" value="Description" />
                                    <input id="description" class="mt-1 block w-full" placeholder="Escreva a descrição que aparecerá nos buscadores" v-model="form.description" name="description" autocomplete required />
                                    <JetInputError for="description" class="mt-2" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="w-full card border-0 shadow-none">
                    <div class="card-header">Image</div>
                    <div class="card-body">
                        <div class="flex flex-wrap -mx-3 mb-6">
                            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                                <div class="mb-4">
                                    <JetLabel for="image" value="Image URL" />
                                    <JetInput id="image" type="url" class="mt-1 block w-full" placeholder="https://exemple.com/image.png" v-model="form.image" name="image" autocomplete="image" required />
                                    <JetInputError for="image" class="mt-2" />
                                </div>
                            </div>
                            <div class="w-full md:w-1/2 px-3">
                                <div class="mb-4">
                                    <JetLabel for="imagevisible" value="Image visible" />
                                    <JetSelect id="imagevisible" class="mt-1 block w-full" placeholder="imagevisible" v-model="form.imagevisible" name="imagevisible" autocomplete required>
                                        <option value="0">False</option>
                                        <option value="1">True</option>
                                    </JetSelect>
                                    <JetInputError for="imagevisible" class="mt-2" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="w-full card border-0 shadow-none">
                    <div class="card-header">Details</div>
                    <div class="card-body">
                        <div class="flex flex-wrap -mx-3 mb-6">
                            <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                                <div class="mb-4">
                                    <JetLabel for="logo" value="Logo" />
                                    <JetInput id="logo" type="url" class="mt-1 block w-full" placeholder="https://exemple.com/image.png" v-model="form.logo" name="logo" autocomplete="logo" required />
                                    <JetInputError for="logo" class="mt-2" />
                                </div>
                            </div>
                            <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                                <div class="mb-4">
                                    <JetLabel for="emphasis" value="Emphasis" />
                                    <JetInput id="emphasis" type="text" class="mt-1 block w-full" placeholder="Emphasis" v-model="form.emphasis" name="emphasis" autocomplete="emphasis" required />
                                    <JetInputError for="emphasis" class="mt-2" />
                                </div>
                            </div>
                            <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                                <div class="mb-4">
                                    <JetLabel for="instruction" value="Instruction" />
                                    <JetInput id="instruction" type="text" class="mt-1 block w-full" placeholder="Instruction" v-model="form.instruction" name="instruction" autocomplete="instruction" required />
                                    <JetInputError for="instruction" class="mt-2" />
                                </div>
                            </div>
                            <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                                <div class="mb-4">
                                    <JetLabel for="changeemailtext" value="Change Email Text" />
                                    <input id="changeemailtext" class="mt-1 block w-full" placeholder="Change Email Text" v-model="form.changeemailtext" name="changeemailtext" autocomplete required />
                                    <JetInputError for="changeemailtext" class="mt-2" />
                                </div>
                            </div>
                            <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                                <div class="mb-4">
                                    <JetLabel for="confirmationsend" value="Confirmation Send" />
                                    <input id="confirmationsend" class="mt-1 block w-full" placeholder="Confirmation Send" v-model="form.confirmationsend" name="confirmationsend" autocomplete required />
                                    <JetInputError for="confirmationsend" class="mt-2" />
                                </div>
                            </div>
                            <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                                <div class="mb-4">
                                    <JetLabel for="buttontext" value="Button Text" />
                                    <input id="buttontext" class="mt-1 block w-full" placeholder="Button Text" v-model="form.buttontext" name="buttontext" autocomplete required />
                                    <JetInputError for="buttontext" class="mt-2" />
                                </div>
                            </div>
                            <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                                <div class="mb-4">
                                    <JetLabel for="buttoncolor" value="Button Color" />
                                    <JetSelect id="buttoncolor" class="mt-1 block w-full" placeholder="Button Color" v-model="form.buttoncolor" name="buttoncolor" autocomplete required>
                                        <option value="bg-blue-600">Default</option>
                                        <option value="bg-blue-500">Blue</option>
                                        <option value="bg-blue-300">Light Blue</option>
                                        <option value="bg-gray-200">Light</option>
                                        <option value="bg-red-600">Red</option>
                                        <option value="bg-yellow-500">Yellow</option>
                                        <option value="bg-black">Black</option>
                                    </JetSelect>
                                    <JetInputError for="buttoncolor" class="mt-2" />
                                </div>
                            </div>
                            <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                                <div class="mb-4">
                                    <JetLabel for="buttontextcolor" value="Button Text Color" />
                                    <JetSelect id="buttontextcolor" class="mt-1 block w-full" placeholder="Button text color" v-model="form.buttontextcolor" name="buttontextcolor" autocomplete required>
                                        <option value="text-white">White</option>
                                        <option value="text-blue-500">Blue</option>
                                        <option value="text-blue-300">Light blue</option>
                                        <option value="text-gray-200">Light</option>
                                        <option value="text-red-500">Red</option>
                                        <option value="text-yellow-500">Yellow</option>
                                        <option value="text-black">Black</option>
                                    </JetSelect>
                                    <JetInputError for="buttontextcolor" class="mt-2" />
                                </div>
                            </div>

                            <div class="w-full text-center">
                                <JetButton
                                    type="submit"
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                                    title="Adicionar"
                                    aria-label="Adicionar"
                                    :class="{ 'opacity-25': form.processing }"
                                    :disabled="form.processing"
                                >
                                    Adicionar
                                </JetButton>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </AppLayout>
</template>
