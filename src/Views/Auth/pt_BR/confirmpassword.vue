<script setup>
import { ref } from 'vue';
import { Head, useForm } from '@inertiajs/inertia-vue3';
import JetAuthenticationCard from 'lochlitecms/Views/Components/Layouts/AuthenticationCard.vue';
import JetAuthenticationCardLogo from 'lochlitecms/Views/Components/Layouts/AuthenticationCardLogo.vue';
import JetButton from 'lochlitecms/Views/Components/Layouts/Button.vue';
import JetInput from 'lochlitecms/Views/Components/Layouts/Input.vue';
import JetCheckbox from 'lochlitecms/Views/Components/Layouts/Checkbox.vue';
import JetLabel from 'lochlitecms/Views/Components/Layouts/Label.vue';
import JetValidationErrors from 'lochlitecms/Views/Components/Layouts/ValidationErrors.vue';
import AppLayout from 'lochlitecms/Views/Web/Layouts/AppLayout.vue';

defineProps({
    appname: String,
    title: String,
    description: String,
    canLogin: Boolean,
    canRegister: Boolean,
    canResetPassword: Boolean,
    login: Object,
    status: String,
});

const form = useForm({
    password: '',
});

const passwordInput = ref(null);

const submit = () => {
    form.post(route('password.confirm.store'), {
        onFinish: () => {
            form.reset();

            passwordInput.value.focus();
        },
    });
};
</script>

<template>
    <Head :title="title ?? appname" :description="description" />
        <div class="d-md-flex tems-center min-h-screen h-full bg-white rounded-lg shadow-xl">
                <div class="w-100 d-md-flex flex-md-col flex-md-row">
                    <div class="d-none d-md-block hidden md:block h-32 md:h-auto md:w-1/2">
                        <img v-if="login.imagevisible" class="object-cover w-full h-full" :src="login.image" alt="img" />
                    </div>
                    <div class="d-md-flex items-center justify-center p-8 sm:p-12 mx-auto md:mx-0 md:w-1/2">
                        <div class="w-full h-full">
                            <div class="flex justify-center">
                             <img v-if="login.logo" width="72" height="72" class="responsive-image" :src="login.logo" alt="img" />
                            </div>
                            <h1 class="mb-4 mt-2 text-2xl font-bold text-center text-gray-700">
                               Confirme sua identidade
                            </h1>
                            <p>Esta é uma área segura do aplicativo. Por favor, confirme sua senha antes de continuar.</p>
                            <JetValidationErrors class="mb-4" />
		                    
                            <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
                                {{ status }}
                            </div>
		                    
                            <form @submit.prevent="submit">
							<div class="w-full me-2 mr-2">
                                <label class="block mt-4 text-sm">
                                    Senha
                                </label>
                                <input type="password"
					                id="password"
                                    ref="passwordInput"
                                    v-model="form.password"			
                                    class="w-full px-4 py-2 text-sm border rounded-md focus:border-blue-400 focus:outline-none focus:ring-1 focus:ring-blue-600"
                                    placeholder="********" autocomple="false" autofocus required />
                            </div>

                            <button :disabled="form.processing" :class="[{'opacity-25': form.processing}, login.buttoncolor, login.buttontextcolor]" class="block w-full px-4 py-2 mt-4 text-sm font-medium leading-5 text-center text-white transition-colors duration-150 bg-blue-600 border border-transparent rounded-lg active:bg-blue-600 hover:bg-blue-700 focus:outline-none focus:shadow-outline-blue" type="submit">
                                Confirmar
                            </button>
                            </form>
                        </div>
                    </div>
                </div>
        </div>

</template>
