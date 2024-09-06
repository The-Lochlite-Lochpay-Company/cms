<script setup>
import { ref } from 'vue';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import JetActionMessage from 'lochlitecms/Views/Components/Layouts/ActionMessage.vue';
import JetButton from 'lochlitecms/Views/Components/Layouts/Button.vue';
import JetInput from 'lochlitecms/Views/Components/Layouts/Input.vue';
import JetSelect from 'lochlitecms/Views/Components/Layouts/Select.vue';
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
    status: String,
    name: String,
    email: String,
});

</script>
<template>

         <div class="relative items-top justify-center min-h-screen bg-white sm:items-center py-4 sm:pt-0">
            <section id="home" class="py-20 bg-white">
                <div class="flex flex-col px-8 mx-auto space-y-12 max-w-7xl xl:px-12">
                    <div class="relative">
                        <h2 class="w-full h1 font-bold text-center sm:text-4xl md:text-5xl"> Welcome to Lochlite CMS </h2>
                        <p class="w-full py-8 mx-auto -mt-2 text-lg text-center text-gray-700 intro sm:max-w-3xl">Lochlite hopes to provide you with the best possible experience using our products and services, and is at your disposal to help you on this new journey.</p>
                    </div>
                    <div class="flex flex-col mb-8 animated fadeIn sm:flex-row">
                        <div class="flex items-center mb-8 sm:w-1/2 md:w-5/12 sm:order-last">
                            <img class="rounded-lg shadow-xl" :src="windows.origin + '/application/welcome.jpg'" alt="">
                        </div>
                        <div class="flex flex-col justify-center mt-5 mb-8 md:mt-0 sm:w-1/2 md:w-7/12 sm:pr-16">
                            <p class="mb-2 text-sm font-semibold leading-none text-left text-indigo-600 uppercase">Social Network Integration</p>
                            <h3 class="mt-2 text-2xl sm:text-left md:text-4xl">Safe and intuitive as it should be</h3>
                            <p class="mt-5 text-lg text-gray-700 text md:text-left">A comfortable and unforgettable experience is what your users need. Forget passwords and log in with your social network in the best style.</p>
                        </div>
                    </div>
             </div>
         </section>
     </div>
</template>