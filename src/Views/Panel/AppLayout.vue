<script setup>
import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import { Head, Link } from '@inertiajs/inertia-vue3';
import JetApplicationMark from '@/Jetstream/ApplicationMark.vue';
import JetBanner from 'lochlitecms/Views/Components/Layouts/Banner.vue';
import JetDropdown from '@/Jetstream/Dropdown.vue';
import JetDropdownLink from '@/Jetstream/DropdownLink.vue';
import JetNavLink from '@/Jetstream/NavLink.vue';
import JetResponsiveNavLink from '@/Jetstream/ResponsiveNavLink.vue';
import 'lochlitecms/Views/Panel/dist/settings.js';
import 'lochlitecms/Views/Panel/dist/sparkline.js';
import 'lochlitecms/Views/Panel/dist/todo.js';
import 'lochlitecms/Views/Panel/dist/todolist.js';
import 'lochlitecms/Views/Panel/dist/misc.js';
import 'lochlitecms/Views/Panel/dist/hoverable-collapse.js';
import 'lochlitecms/Views/Panel/dist/off-canvas.js';
import 'lochlitecms/Views/Panel/dist/bootstrap-table.js';
import 'lochlitecms/Views/Panel/dist/calendar.js';
import 'lochlitecms/Views/Panel/dist/dashboard.js';
import Navbarpanel from 'lochlitecms/Views/Panel/navbar.vue';
import Sidebarpanel from 'lochlitecms/Views/Panel/sidebar.vue';

defineProps({
    title: String,
	canLogin: Boolean,
    canRegister: Boolean,
    breadcrumbCurrentTitle: String,
    breadcrumbCurrentSection: String,
    user: Object,
    menulang: Object,
    menuitems: Object,
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
                 <Navbarpanel :menulang="menulang" :avatar="avatar" :name="name" :user="user" />
               <div class="container-fluid page-body-wrapper">
                 <Sidebarpanel :menuitems="menuitems" :avatar="avatar" :name="name" :role="role" />
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
