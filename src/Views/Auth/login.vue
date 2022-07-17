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
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.transform(data => ({
        ...data,
        remember: form.remember ? 'on' : '',
    })).post(route('login.store'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <Head :title="title ?? appname" :description="description" />
        <div class="flex items-center bg-gray-50" :class="{'min-h-screen': login.centered == 1, 'h-screen': login.centered == 0}">
            <div class="flex-1 h-full mx-auto bg-white" :class="{'rounded-lg': login.rounded == 1, 'shadow-xl': login.shadow == 1, 'max-w-4xl': login.centered == 1, 'w-full': login.centered == 0}">
                <div class="flex flex-col md:flex-row">
                    <div v-if="login.imagevisible" class="hidden md:block h-32 md:h-auto md:w-1/2">
					<img class="object-cover w-full h-full" :class="{'h-screen': login.centered == 0}" :src="login.image" alt="img" />
                    </div>
                    <div class="flex items-center justify-center p-6 sm:p-12" :class="{'md:w-1/2': login.imagevisible == 1, 'w-full': login.imagevisible == 0}">
                        <div class="h-full w-full">
                             <div class="flex justify-center">
                             <img v-if="login.logo" width="72" height="72" class="responsive-image" :src="login.logo" alt="img" />
                            </div>
                            <h1 class="mb-4 mt-2 text-2xl font-bold text-center text-gray-700">
                                {{ login.emphasis ?? 'Login to Your Account' }}
                            </h1>
                            <JetValidationErrors class="mb-4" />
		                    
                            <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
                                {{ status }}
                            </div>
		                    
                            <form @submit.prevent="submit">
							<div>
                                <label class="block text-sm">
                                    Email
                                </label>
                                <input type="email"
					                id="email"
                                    v-model="form.email"			
                                    class="w-full px-4 py-2 text-sm border rounded-md focus:border-blue-400 focus:outline-none focus:ring-1 focus:ring-blue-600"
                                    placeholder="you@mail.com" required />
                            </div>
                            <div>
                                <label class="block mt-4 text-sm">
                                    Password
                                </label>
                                <input
                                    id="password"
                                    v-model="form.password"
                                    class="w-full px-4 py-2 text-sm border rounded-md focus:border-blue-400 focus:outline-none focus:ring-1 focus:ring-blue-600"
                                    placeholder="********" type="password" required />
                            </div>
                            <p class="mt-4">
                                <a :href="route('password.request.index')" class="text-sm text-blue-600 hover:underline" href="./forgot-password.html">
                                   {{ login.forgottext ?? 'Forgot your password?' }}
                                </a>
                            </p>


                            <button :disabled="form.processing" :class="[{'opacity-25': form.processing}, login.buttoncolor, login.buttontextcolor]" class="block w-full px-4 py-2 mt-4 text-sm font-medium leading-5 text-center text-white transition-colors duration-150 bg-blue-600 border border-transparent rounded-lg active:bg-blue-600 hover:bg-blue-700 focus:outline-none focus:shadow-outline-blue" type="submit">
                                {{ login.buttontext ?? 'Log in' }}
                            </button>
                            </form>

                            <hr v-if="login.facebook || login.twitter || login.google" class="my-8 px-0 px-md-3" />

                            <div class="flex items-center justify-center gap-4">
                                <a v-if="login.facebook" class="flex items-center justify-center w-full mb-4 px-4 py-2 text-sm text-primary text-gray-700 border border-gray-300 rounded-lg hover:border-gray-500 focus:border-gray-500" href="/oauth/facebook">
                                    <i class="fa-brands fa-facebook mr-2"></i>
                                    Facebook
                                </a>
                                <a v-if="login.twitter" class="flex items-center justify-center w-full mb-4 px-4 py-2 text-sm text-info text-gray-700 border border-gray-300 rounded-lg hover:border-gray-500 focus:border-gray-500" href="/oauth/twitter">
                                    <i class="fa-brands fa-twitter mr-2"></i>
                                    Twitter
                                </a>
                                <a v-if="login.google" class="flex items-center justify-center w-full mb-4 px-4 py-2 text-sm text-dark text-gray-700 border border-gray-300 rounded-lg hover:border-gray-500 focus:border-gray-500" href="/oauth/google">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                        class="w-4 h-4 mr-2" viewBox="0 0 48 48">
                                        <defs>
                                            <path id="a"
                                                d="M44.5 20H24v8.5h11.8C34.7 33.9 30.1 37 24 37c-7.2 0-13-5.8-13-13s5.8-13 13-13c3.1 0 5.9 1.1 8.1 2.9l6.4-6.4C34.6 4.1 29.6 2 24 2 11.8 2 2 11.8 2 24s9.8 22 22 22c11 0 21-8 21-22 0-1.3-.2-2.7-.5-4z" />
                                        </defs>
                                        <clipPath id="b">
                                            <use xlink:href="#a" overflow="visible" />
                                        </clipPath>
                                        <path clip-path="url(#b)" fill="#FBBC05" d="M0 37V11l17 13z" />
                                        <path clip-path="url(#b)" fill="#EA4335" d="M0 11l17 13 7-6.1L48 14V0H0z" />
                                        <path clip-path="url(#b)" fill="#34A853" d="M0 37l30-23 7.9 1L48 0v48H0z" />
                                        <path clip-path="url(#b)" fill="#4285F4" d="M48 48L17 24l-4-3 35-10z" />
                                    </svg>Google
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
        </div>
</template>
