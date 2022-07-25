<script setup>
import { defineAsyncComponent } from "vue"

import { Head } from '@inertiajs/inertia-vue3';
import JetAuthenticationCardLogo from 'lochlitecms/Views/Components/Layouts/AuthenticationCardLogo.vue';
import AppLayout from 'lochlitecms/Views/Web/Layouts/AppLayout.vue';
import DOMPurify from 'dompurify';

const props = defineProps({
    appname: String,
    canLogin: Boolean,
    canRegister: Boolean,
    user: Object,
    page: Object,
    pagebody: Object,
});
$('body').ready(function(){$('div#mainpage').html(Base64.decode(props.pagebody.body))})
</script>
<template>
   <AppLayout :appname="appname" :canLogin="canLogin" :canRegister="canRegister" :title="page.title">

    <div class="">
        <div class="w-full" id="mainpage">
		<div class="border border-blue-300 rounded-md p-4 w-full mx-auto">
            <div class="animate-pulse flex space-x-4">
              <div class="rounded-full bg-slate-700 h-10 w-10"></div>
              <div class="flex-1 space-y-6 py-1">
                <div class="h-2 bg-slate-700 rounded"></div>
                <div class="space-y-3">
                  <div class="grid grid-cols-3 gap-4">
                    <div class="h-2 bg-slate-700 rounded col-span-2"></div>
                    <div class="h-2 bg-slate-700 rounded col-span-1"></div>
                  </div>
                  <div class="h-2 bg-slate-700 rounded"></div>
                </div>
              </div>
            </div>
        </div>
		</div>
        </div>
    </AppLayout>
</template>
