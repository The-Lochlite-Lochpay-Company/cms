<script setup>
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
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
    canrecoverypassword: Boolean,
    canRegister: Boolean,
    canResetPassword: Boolean,
    recoverypassword: Object,
    status: String,
});

const form = useForm({
    email: '',
});

const submit = () => {
    form.post(route('password.request.store'));
};
</script>

<template>
    <Head :title="title ?? appname" :description="description" />
        <div class="flex items-center bg-gray-50" :class="{'min-h-screen': recoverypassword.centered == 1, 'h-screen': recoverypassword.centered == 0}">
            <div class="flex-1 h-full mx-auto bg-white" :class="{'rounded-lg': recoverypassword.rounded == 1, 'shadow-xl': recoverypassword.shadow == 1, 'max-w-4xl': recoverypassword.centered == 1, 'w-full': recoverypassword.centered == 0}">
                <div class="flex flex-col md:flex-row">
                    <div v-if="recoverypassword.imagevisible" class="hidden md:block h-32 md:h-auto md:w-1/2">
					<img class="object-cover w-full h-full" :class="{'h-screen': recoverypassword.centered == 0}" :src="recoverypassword.image" alt="img" />
                    </div>
                    <div class="flex items-center justify-center p-6 sm:p-12" :class="{'md:w-1/2': recoverypassword.imagevisible == 1, 'w-full': recoverypassword.imagevisible == 0}">
                        <div class="w-full h-full">
                            <div class="flex justify-center">
                             <img v-if="recoverypassword.logo" width="72" height="72" class="responsive-image" :src="recoverypassword.logo" alt="img" />
                            </div>
                            <h1 class="mb-4 mt-2 text-2xl font-bold text-center text-gray-700">
                                {{ recoverypassword.emphasis ?? 'Esqueceu sua senha? Sem problemas.' }}
                            </h1>
                            <p>{{ recoverypassword.instruction ?? 'Basta nos informar seu endereço de e-mail e nós lhe enviaremos um link de redefinição de senha que permitirá que você escolha uma nova.' }}</p>
                            <JetValidationErrors class="mb-4" />
		                    
                            <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
                                {{ status }}
                            </div>
		                    
                            <form @submit.prevent="submit">
							<div class="w-full me-2 mr-2">
                                <label class="block mt-4 text-sm">
                                    Email
                                </label>
                                <input type="email"
					                id="email"
                                    v-model="form.email"			
                                    class="w-full px-4 py-2 text-sm border rounded-md focus:border-blue-400 focus:outline-none focus:ring-1 focus:ring-blue-600"
                                    placeholder="" required />
                            </div>
                            <p class="mt-4">
                                <Link :href="route('login.index')" class="text-sm text-blue-600 hover:underline" href="#login">
                                   {{ recoverypassword.logintext ?? 'Você se lembrou da sua senha? Clique aqui' }}
                                </Link>
                            </p>

                            <button :disabled="form.processing" :class="[{'opacity-25': form.processing}, recoverypassword.buttoncolor, recoverypassword.buttontextcolor]" class="block w-full px-4 py-2 mt-4 text-sm font-medium leading-5 text-center text-white transition-colors duration-150 bg-blue-600 border border-transparent rounded-lg active:bg-blue-600 hover:bg-blue-700 focus:outline-none focus:shadow-outline-blue" type="submit">
                                {{ recoverypassword.buttontext ?? 'RECEBER O LINK DE RECUPERAÇÃO DE SENHA' }}
                            </button>
                            </form>
                        </div>
                    </div>
                </div>
        </div>
        </div>

</template>
