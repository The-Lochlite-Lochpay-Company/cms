<script setup>
import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import { Head, Link } from '@inertiajs/inertia-vue3';
import JetApplicationMark from 'lochlitecms/Views/Components/Layouts/ApplicationMark.vue';
import JetBanner from 'lochlitecms/Views/Components/Layouts/Banner.vue';
import JetDropdown from 'lochlitecms/Views/Components/Layouts/Dropdown.vue';
import JetDropdownLink from 'lochlitecms/Views/Components/Layouts/DropdownLink.vue';
import JetNavLink from 'lochlitecms/Views/Components/Layouts/NavLink.vue';
import JetResponsiveNavLink from 'lochlitecms/Views/Components/Layouts/ResponsiveNavLink.vue';
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
  <div class="min-h-screen flex flex-col" id="app">
    <Navbarpanel :menulang="menulang" :avatar="avatar" :name="name" :user="user" />
    <div class="flex flex-1">
      <Sidebarpanel :menuitems="menuitems" :avatar="avatar" :name="name" :role="role" />
      <div class="flex-1 flex flex-col">
        <main class="flex-1 p-4 pt-12 mt-14">
          <JetBanner />
          <div class="bg-white shadow rounded-lg">
            <div class="p-4">
              <header v-if="$slots.breadcrumb">
                <div class="text-2xl font-bold mb-4">{{ breadcrumbCurrentTitle }}</div>
                <nav aria-label="breadcrumb">
                  <ol class="flex space-x-2 text-gray-600">
                    <li><a href="/dashboard" class="hover:underline">Dashboard</a></li>
                    <li class="text-gray-500">{{ breadcrumbCurrentSection }}</li>
                    <slot name="breadcrumb" />
                  </ol>
                </nav>
              </header>
              <slot />
            </div>
          </div>
        </main>
        <footer class="bg-gray-100 p-4">
          <div class="container mx-auto flex justify-between items-center">
            <span class="text-gray-600">Copyright © <a href="https://www.lochlite.com/" target="_blank" class="hover:underline">The Lochlite & Lochpay Company</a></span>
            <span class="text-gray-600"><a href="https://www.lochlite.com/solutions/cms" target="_blank" class="hover:underline">Lochlite CMS</a> - Version {{ version }}</span>
          </div>
        </footer>
      </div>
    </div>
  </div>
  <div v-if="$slots.modal">
    <!-- Modal -->
    <div class="fixed inset-0 flex items-center justify-center z-50">
      <div class="bg-white rounded-lg shadow-lg">
        <div class="p-4">
          <slot name="modal" />
        </div>
        <div class="flex justify-end p-4">
          <button type="button" class="btn btn-dark bg-dark text-white" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
</template>
