<script setup>
import { computed } from 'vue';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import JetAuthenticationCard from 'lochlitecms/Views/Components/Layouts/AuthenticationCard.vue';
import JetAuthenticationCardLogo from 'lochlitecms/Views/Components/Layouts/AuthenticationCardLogo.vue';
import JetButton from 'lochlitecms/Views/Components/Layouts/Button.vue';
import JetInput from 'lochlitecms/Views/Components/Layouts/Input.vue';
import JetCheckbox from 'lochlitecms/Views/Components/Layouts/Checkbox.vue';
import JetLabel from 'lochlitecms/Views/Components/Layouts/Label.vue';
import JetValidationErrors from 'lochlitecms/Views/Components/Layouts/ValidationErrors.vue';
import AppLayout from 'lochlitecms/Views/Web/Layouts/AppLayout.vue';

const props = defineProps({
    appname: String,
    title: String,
    description: String,
    canemailverify: Boolean,
    canRegister: Boolean,
    canResetPassword: Boolean,
    emailverify: Object,
    status: String,
});

const formchangemail = useForm({
email: ''
});

const changemail = () => {
    formchangemail.post(route('verification.changeemail'));
};

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
                        <img v-if="emailverify.imagevisible" class="object-cover w-full h-full" :src="emailverify.image" alt="img" />
                    </div>
                    <div class="d-md-flex items-center justify-center p-8 sm:p-12 mx-auto md:mx-0 md:w-1/2">
                        <div class="w-full h-full">
                            <div class="flex justify-center">
                             <img v-if="emailverify.logo" width="72" height="72" class="responsive-image" :src="emailverify.logo" alt="img" />
                            </div>
                            <h1 class="mb-4 mt-2 text-2xl font-bold text-center text-gray-700">
                                {{ emailverify.emphasis ?? 'Obrigado por inscrever-se!' }}
                            </h1>
                            <p>{{ emailverify.instruction ?? "Antes de começar, você poderia verificar seu endereço de e-mail clicando no link que acabamos de enviar para você? Se você não recebeu o e-mail, teremos o prazer de lhe enviar outro." }}</p>
                            <JetValidationErrors class="mb-4" />
		                    
                            <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
                                {{ status }}
                            </div>

                            <div v-if="verificationLinkSent" class="mb-4 font-medium text-sm text-green-600">
                                {{ emailverify.confirmationsend ?? 'Um novo link de verificação foi enviado para o endereço de e-mail fornecido durante o registro.' }}
                            </div>
		                    
                            <form @submit.prevent="submit">
                            <div class="mt-4 flex items-center justify-between">
                            <button :disabled="form.processing" :class="[{'opacity-25': form.processing}, emailverify.buttoncolor, emailverify.buttontextcolor]" class="block w-75 px-4 py-2 mt-4 text-sm font-medium leading-5 text-center text-white transition-colors duration-150 bg-blue-600 border border-transparent rounded-lg active:bg-blue-600 hover:bg-blue-700 focus:outline-none focus:shadow-outline-blue" type="submit">
                               {{ emailverify.buttontext ?? 'Reenviar email de verificação' }}
                            </button>

                             <Link
                                 :href="route('logout')"
                                 method="post"
                                 as="button"
                                 class="underline block px-4 py-2 mt-4 text-sm font-medium leading-5 text-center text-dark transition-colors duration-150 bg-light border border-transparent rounded-lg active:bg-blue-600 hover:bg-blue-700 focus:outline-none focus:shadow-outline-blue"
                             >
                                 Sair
                             </Link>
				             </div>
				             </form>
							 <button type="button" data-bs-toggle="collapse" data-bs-target="#collapseEmailchange" aria-expanded="false" aria-controls="collapseEmailchange" class="mt-3 underline block px-4 py-2 mt-4 text-sm font-medium leading-5 text-center text-dark transition-colors duration-150 bg-white border-0 border-transparent rounded-0 active:bg-blue-600 hover:bg-blue-700 focus:outline-none focus:shadow-outline-blue">
                                 {{ emailverify.changeemailtext ?? 'Precisa alterar o email? Clique aqui' }}
                             </button>
							 <div class="collapse" id="collapseEmailchange">
                             <div class="card card-body border-0 rounded-0">
                             <label for="inputemailchange">Novo email</label>
							 <form @submit.prevent="changemail" class="input-group">
                               <input id="inputemailchange" v-model="formchangemail.email" autocomplete="email" name="email" type="email" placeholder="new@email.com" class="form-control rounded-0" required>
							   <button :disabled="formchangemail.processing" :class="{'opacity-25': formchangemail.processing}" type="submit" class="btn btn-dark text-white rounded-0">Salvar</button>
                             </form>
                             </div>
                             </div>
                        </div>
                    </div>
                </div>
        </div>

</template>
