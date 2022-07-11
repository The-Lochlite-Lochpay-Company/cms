<script setup>
import { ref } from 'vue';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import JetActionMessage from '@/Jetstream/ActionMessage.vue';
import JetValidationErrors from '@/Jetstream/ValidationErrors.vue';
import DOMPurify from 'dompurify';

defineProps({
    status: '',
});

const form = useForm({
    email: '',
});

const submit = () => {
    form.email = DOMPurify.sanitize($('#email').val());
    form.transform(data => ({
        ...data,
    })).post(route('subscriptnewsletter'), {
        onFinish: () => form.reset('email'),
    });
};

</script>
<template>
  <div class="bg-dark w-full p-2 grid grid-rows-1 grid-cols-1 md:grid-cols-2 gap-2 px-4">
     <div class="align-self-center self-center">
      <div class="h2 font-semibold text-white text-start">Não perca!</div>
      <p class="text-base leading-normal text-start text-white mt-2">
       Assine a nossa newsletter para ficar por dentro das novidades.
      </p>
      </div>
      <div class="w-full">
      <form class="sm:border border-white flex sm:flex-row flex-col w-full" @submit.prevent="submit">
         <JetValidationErrors class="mb-4" />
         <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
             {{ status }}
         </div>
        <input type="email" class="border border-white md:border-transparent text-base w-full md:w-4/5 font-medium leading-none text-white p-4 focus:outline-none bg-transparent placeholder-white" id="email" v-model="form.email" placeholder="Email Address" autocomplete required/>
        <button type="submit" class="focus:outline-none focus:ring-offset-2 focus:ring border border-white sm:border-transparent w-full md:w-4/5 sm:w-auto bg-white py-3 px-6 hover:bg-opacity-75" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Inscreva-se</button>
      </form>
      </div>
  </div>
</template>
