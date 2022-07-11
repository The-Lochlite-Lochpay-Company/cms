<script setup>
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import JetAuthenticationCard from '@/Jetstream/AuthenticationCard.vue';
import JetAuthenticationCardLogo from '@/Jetstream/AuthenticationCardLogo.vue';
import JetButton from '@/Jetstream/Button.vue';
import JetInput from '@/Jetstream/Input.vue';
import JetCheckbox from '@/Jetstream/Checkbox.vue';
import JetLabel from '@/Jetstream/Label.vue';
import JetValidationErrors from '@/Jetstream/ValidationErrors.vue';
import AppLayout from '@/Layouts/AppLayout.vue';

const props = defineProps({
    appname: String,
    title: String,
    description: String,
    login: Object,
    email: String,
    token: String,
});

const form = useForm({
    token: props.token,
    email: props.email,
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.put(route('password.request.update', {id: props.token}), {
        onFinish: () => form.reset('password', 'password_confirmation'),
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
                                Forgot your password? No problem.
                            </h1>
                            <p>Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.</p>
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
							<div class="w-full me-2 mr-2">
                                <label class="block mt-4 text-sm">
                                    Password
                                </label>
                                <input type="password"
					                id="password"
                                    v-model="form.password"			
                                    class="w-full px-4 py-2 text-sm border rounded-md focus:border-blue-400 focus:outline-none focus:ring-1 focus:ring-blue-600"
                                    placeholder="********" autocomplete="new-password" required />
                            </div>
							<div class="w-full me-2 mr-2">
                                <label class="block mt-4 text-sm">
                                    Password
                                </label>
                                <input type="password"
					                id="password_confirmation"
                                    v-model="form.password_confirmation"			
                                    class="w-full px-4 py-2 text-sm border rounded-md focus:border-blue-400 focus:outline-none focus:ring-1 focus:ring-blue-600"
                                    placeholder="********" autocomplete="new-password" required />
                            </div>

                            <button :disabled="form.processing" :class="[{'opacity-25': form.processing}, login.buttoncolor, login.buttontextcolor]" class="block w-full px-4 py-2 mt-4 text-sm font-medium leading-5 text-center text-white transition-colors duration-150 bg-blue-600 border border-transparent rounded-lg active:bg-blue-600 hover:bg-blue-700 focus:outline-none focus:shadow-outline-blue" type="submit">
                                EMAIL PASSWORD RESET LINK
                            </button>
                            </form>
                        </div>
                    </div>
                </div>
        </div>

</template>
