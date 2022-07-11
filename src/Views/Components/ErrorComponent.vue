<script setup>
import { ref } from 'vue';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import JetDialogModal from '@/Jetstream/DialogModal.vue';
import JetButton from '@/Jetstream/Button.vue';
import JetValidationErrors from '@/Jetstream/ValidationErrors.vue';
</script>
<template>
     <div class="bg-white h-full lg:px-24 lg:py-24 md:py-20 md:px-44 px-4 py-24 items-center flex justify-center flex-col-reverse lg:flex-row md:gap-28 gap-16">
            <div class="xl:pt-24 w-full xl:w-1/2 relative pb-12 lg:pb-0">
                <div class="relative">
                    <div class="absolute">
                        <div class="">
                            <h1 class="my-2 text-gray-800 font-bold text-2xl">
                                Ocorreu um erro ao carregar esta sessão
                            </h1>
                            <p class="my-2 mb-3 text-gray-800">Desculpe por isso! Por favor, visite nossa página inicial para ver outras informações úteis.</p>
                            <Link :href="route('index')" class="sm:w-full lg:w-auto mt-2 border rounded md py-2 px-8 text-center bg-indigo-600 text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-700 focus:ring-opacity-50">Leve-me até lá!</Link>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <img src="/assets/img/error.webp" />
            </div>
     </div> 
</template>