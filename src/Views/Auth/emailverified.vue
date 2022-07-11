<script setup>
import { computed } from 'vue';
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
    canLogin: Boolean,
    canRegister: Boolean,
    canResetPassword: Boolean,
    login: Object,
    status: String,
});

const form = useForm();

const submit = () => {
    form.post(route('verification.send'));
};

const verificationLinkSent = computed(() => props.status === 'verification-link-sent');
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
                                Thanks for signing up!
                            </h1>
                            <p>Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn't receive the email, we will gladly send you another.</p>
                            <JetValidationErrors class="mb-4" />
		                    
                            <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
                                {{ status }}
                            </div>

                            <div v-if="verificationLinkSent" class="mb-4 font-medium text-sm text-green-600">
                                A new verification link has been sent to the email address you provided during registration.
                            </div>
		                    
                            <form @submit.prevent="submit">
                            <div class="mt-4 flex items-center justify-between">
                            <button :disabled="form.processing" :class="[{'opacity-25': form.processing}, login.buttoncolor, login.buttontextcolor]" class="block w-75 px-4 py-2 mt-4 text-sm font-medium leading-5 text-center text-white transition-colors duration-150 bg-blue-600 border border-transparent rounded-lg active:bg-blue-600 hover:bg-blue-700 focus:outline-none focus:shadow-outline-blue" type="submit">
                                Resend Verification Email
                            </button>

                             <Link
                                 :href="route('logout')"
                                 method="post"
                                 as="button"
                                 class="underline block px-4 py-2 mt-4 text-sm font-medium leading-5 text-center text-dark transition-colors duration-150 bg-light border border-transparent rounded-lg active:bg-blue-600 hover:bg-blue-700 focus:outline-none focus:shadow-outline-blue"
                             >
                                 Log Out
                             </Link>
				             </div>
				             </form>
                        </div>
                    </div>
                </div>
        </div>

</template>
