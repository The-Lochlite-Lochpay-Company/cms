<script setup>
/**
* The Lochlite & Lochpay Company - Technology that makes people's lives easier
*
* (c) 2019 - 2022 LOCHLITE E LOCHPAY SOFTWARES E PAGAMENTOS LTDA., All Right Reserved.
*
* Software: LOCHLITE CMS
* Version: 2.0.7  
* License: Proprietary
* Made in: Brazil
* Author: The Lochlite & Lochpay Company
* Developer: IGOR MACEDO MONTALVÃO
* Website: https://lochlite.com | https://lochpay.com | https://gpgic.com 
* Support: drcg@gpgic.com | drcg@lochlite.com | drcl@lochlite.com
*
* LEGAL NOTICE: The author(s) of the software grants the user of the software a personal, non-transferable, limited and revocable license without the right to market, resell, distribute, clone or recycle the software; The author(s) reserve the right to renew, revoke or modify the license, as well as impose fines for its violation at its most reasonable discretion.
*
* DISCLAIMER: The author(s) of the Software will not be responsible for any physical, moral, property damages or of any nature due to the software, its enjoyment or risks up to the limits of the legislation in force in Brazil.
*
* ('Art. 43 - LEI No 4.502/1964' - law of brazil) Indústria Brasileira - LOCHLITE E LOCHPAY SOFTWARES E PAGAMENTOS LTDA, CNPJ: 37.816.728/0001-04; Address: SCS QUADRA 9, BLOCO C, 10 ANDAR, SALA 1003, Brasilia, Federal District, Brazil, Zip Code: 70308-200
**/

import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import { Head, Link } from '@inertiajs/inertia-vue3';
import JetApplicationMark from '@/Jetstream/ApplicationMark.vue';
import JetBanner from '@/Jetstream/Banner.vue';
import JetDropdown from '@/Jetstream/Dropdown.vue';
import JetDropdownLink from '@/Jetstream/DropdownLink.vue';
import JetNavLink from '@/Jetstream/NavLink.vue';
import JetResponsiveNavLink from '@/Jetstream/ResponsiveNavLink.vue';
import '@/lib/settings.js';
import '@/lib/sparkline.js';
import '@/lib/todo.js';
import '@/lib/todolist.js';
import '@/lib/misc.js';
import '@/lib/hoverable-collapse.js';
import '@/lib/off-canvas.js';
import '@/lib/bootstrap-table.js';
import '@/lib/calendar.js';
import '@/lib/dashboard.js';
import Navbarpanel from '@/Pages/Panel/navbar.vue';
import Sidebarpanel from '@/Pages/Panel/sidebar.vue';

defineProps({
    title: String,
	canLogin: Boolean,
    canRegister: Boolean,
    breadcrumbCurrentTitle: String,
    breadcrumbCurrentSection: String,
    user: Object,
    name: String,
    avatar: String,
    role: String,
    version: String,
    year: String,
});

const year = new Date().getFullYear();

const showingNavigationDropdown = ref(false);


const logout = () => {
    Inertia.post(route('logout'));
};
</script>

<template>
        <Head :title="title" />
           
            <div class="container-scroller" id="app">
                 <Navbarpanel :avatar="avatar" :name="name" :user="user" />
               <div class="container-fluid page-body-wrapper">
                 <Sidebarpanel :avatar="avatar" :name="name" :role="role" />
                 <div class="main-panel">
                   <main class="content-wrapper">
                   <JetBanner />
                   <div class="card">
                   <div class="card-body">
	               <header v-if="$slots.breadcrumb">
                   <div class="card-title h3 fw-bold mb-0 pb-0">{{ breadcrumbCurrentTitle }}</div>
                   <nav aria-label="breadcrumb">
                   <ol class="breadcrumb pl-0 border-0">
                     <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                     <li class="breadcrumb-item active">{{ breadcrumbCurrentSection }}</li>
                           <slot name="breadcrumb" />
                   </ol>
                   </nav> 
                   </header>
			       <slot />
                   </div>
                   </div>
				   </main>
                   <footer class="footer">
                     <div class="container-fluid clearfix">
                       <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright ©  <a href="https://www.lochlite.com/" target="_blank">The Lochlite & Lochpay Company</a></span>
                       <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center"><a href="https://www.lochlite.com/solutions/cms" target="_blank">Lochlite CMS</a> - Version {{ version }}</span>
                     </div>
                   </footer>
                 </div>
               </div>
             </div>
			  <div v-if="$slots.modal">
              <!-- Modal -->
              <div class="modal fade" id="modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content bg-white">
                    <div class="modal-body bg-white">
                        <slot name="modal" />
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-dark bg-dark text-white" data-bs-dismiss="modal">Close</button>
                    </div>
                  </div>
                </div>
              </div>
              </div>
</template>
