<script setup>
import { ref } from "vue";
import { HomeIcon, CursorClickIcon, ClipboardListIcon, DuplicateIcon, MenuIcon, ChartPieIcon, CollectionIcon } from "@heroicons/vue/outline";
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import JetAuthenticationCardLogo from 'lochlitecms/Views/Components/Layouts//AuthenticationCardLogo.vue';

const { lang, isSideMenuOpen, customersarea } = defineProps(['lang', 'customersarea', 'isSideMenuOpen'])
const emits = defineEmits(['closeSideMenu'])

const isPagesMenuOpen = ref(false);
const text_sidebar = customersarea.textsidebar || 'black';
const bg_theming = customersarea.themecolor || 'black';
const bg_coloredsidebar = customersarea.coloredsidebar || 'white';
const bg_themingbutton = customersarea.buttoncolor || 'black';

function togglePagesMenu() {
  isPagesMenuOpen.value = !isPagesMenuOpen.value;
}

function closeSideMenu() {
  return emits('closeSideMenu')
}
</script>
<style scoped>
.text-sidebar{
color: v-bind(text_sidebar)
}
.text-sidebar.active, .text-sidebar:active{
color: white
}
.bg-coloredsidebar{
background-color: v-bind(bg_coloredsidebar)
}
.bg-theming, .bg-theming:active, .hover-theming:hover{
background-color: v-bind(bg_theming)
}
.bg-theming-button, .bg-theming-button:active{
background-color: v-bind(bg_themingbutton)
}
</style>


<template>
  <div>
    <aside
      class="z-20 flex-shrink-0 hidden w-64 overflow-y-auto bg-coloredsidebar dark:bg-gray-800 md:block h-screen border-r border-gray-200 dark:border-gray-700">
      <div class="pb-4 text-gray-500 dark:text-gray-400">
        <Link class="w-full" :href="route('dashboard.index')">
             <span :class="{'text-gray-800': customersarea.coloredsidebar == '#FFFFFF', 'text-white': customersarea.coloredsidebar !== '#FFFFFF'}" class="pt-4 ml-6 text-lg font-bold dark:text-gray-200" v-if="customersarea.logotype == 'text'">{{ customersarea.logo }}</span>
             <img v-else :width="customersarea.logowidth ?? '56'" :height="customersarea.logoheight ?? '56'" class="responsive-image w-full" :src="customersarea.logo" alt="img" />
        </Link>
        <ul class="mt-12">
          <li class="relative px-6 py-1">
            <Link :class="{'bg-theming text-white active': route().current() == 'dashboard.index'}"
              class="text-sidebar inline-flex items-center w-full text-sm font-semibold transition duration-200 ease-in hover-theming hover:font-bold hover:text-white  py-2 px-2 rounded-lg "
              :href="route('dashboard.index')">
              <component :is="HomeIcon" class="flex-shrink-0 h-6 w-6" aria-hidden="true" />
              <span v-if="lang == 'pt_BR'" class="ml-4">Início</span>
              <span v-else-if="lang == 'en_US'" class="ml-4">Dashboard</span>
              <span v-else class="ml-4">Dashboard</span>
            </Link>
          </li>
          <li class="relative px-6 py-1">
            <Link :class="{'bg-theming text-white active': route().current() == 'dashboard.comments'}"
              class="text-sidebar inline-flex items-center w-full text-sm font-semibold transition duration-200 ease-in hover-theming hover:font-bold hover:text-white  py-2 px-2 rounded-lg "
              :href="route('dashboard.comments')">
              <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
              </svg>
              <span v-if="lang == 'pt_BR'" class="ml-4">Comentários</span>
              <span v-else-if="lang == 'en_US'" class="ml-4">Comments</span>
              <span v-else class="ml-4">Comments</span>
            </Link>
          </li>
          <li class="relative px-6 py-1">
            <Link :class="{'bg-theming text-white active': route().current() == 'dashboard.notifications'}"
              class="text-sidebar inline-flex items-center w-full text-sm font-semibold transition duration-200 ease-in hover-theming hover:font-bold hover:text-white  py-2 px-2 rounded-lg "
              :href="route('dashboard.notifications')">
              <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                 <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
              </svg>
              <span v-if="lang == 'pt_BR'" class="ml-4">Notificações</span>
              <span v-else-if="lang == 'en_US'" class="ml-4">Notifications</span>
              <span v-else class="ml-4">Notifications</span>
            </Link>
          </li>
          <li class="relative px-6 py-1">
            <Link :class="{'bg-theming text-white active': route().current() == 'dashboard.history'}"
              class="text-sidebar inline-flex items-center w-full text-sm font-semibold transition duration-200 ease-in hover-theming hover:font-bold hover:text-white  py-2 px-2 rounded-lg "
              :href="route('dashboard.history')">
              <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                 <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
              <span v-if="lang == 'pt_BR'" class="ml-4">Histórico</span>
              <span v-else-if="lang == 'en_US'" class="ml-4">History</span>
              <span v-else class="ml-4">History</span>
            </Link>
          </li>
          <li class="relative px-6 py-1">
            <Link :class="{'bg-theming text-white active': route().current() == 'dashboard.profile'}"
              class="text-sidebar inline-flex items-center w-full text-sm font-semibold transition duration-200 ease-in hover-theming hover:font-bold hover:text-white  py-2 px-2 rounded-lg "
              :href="route('dashboard.profile')">
              <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
              <span v-if="lang == 'pt_BR'" class="ml-4">Perfil</span>
              <span v-else-if="lang == 'en_US'" class="ml-4">Profile</span>
              <span v-else class="ml-4">Profile</span>
            </Link>
          </li>
          <li v-for="row in customersarea.items" class="relative px-6 py-1">
            <Link class="text-sidebar inline-flex items-center w-full text-sm font-semibold transition duration-200 ease-in hover-theming hover:font-bold hover:text-white py-2 px-2 rounded-lg"
              :href="row.url">
              <i :class="row.icon"></i>
              <span class="ml-4">{{ row.name }}</span>
            </Link>
          </li>
        </ul>
        <div class="px-6 my-6">
          <Link v-if="customersarea.button" :href="customersarea.buttonurl"
            :class="{'bg-theming-button': customersarea.buttoncolor}" class="flex items-center justify-between w-full px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-blue-600 border border-transparent rounded-lg active:bg-blue-600 hover-theming hover:font-bold focus:outline-none focus:shadow-outline-purple">
            {{ customersarea.buttontext ?? 'Exemple link' }}
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
            </svg>
          </Link>
        </div>
      </div>
    </aside>

    <!-- Mobile Sidebar -->
    <div v-if="isSideMenuOpen" x-transition:enter="transition ease-in-out duration-150"
      x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
      x-transition:leave="transition ease-in-out duration-150" x-transition:leave-start="opacity-100"
      x-transition:leave-end="opacity-0"
      class="fixed inset-0 z-10 flex items-end bg-black bg-opacity-50 sm:items-center sm:justify-center"
      v-on:click="closeSideMenu"></div>
    <aside class="fixed inset-y-0 z-20 flex-shrink-0 w-96 mt-16 overflow-y-auto bg-coloredsidebar dark:bg-gray-800 md:hidden"
      v-if="isSideMenuOpen" x-transition:enter="transition ease-in-out duration-150"
      x-transition:enter-start="opacity-0 transform -translate-x-20" x-transition:enter-end="opacity-100"
      x-transition:leave="transition ease-in-out duration-150" x-transition:leave-start="opacity-100"
      x-transition:leave-end="opacity-0 transform -translate-x-20" @keydown.escape="closeSideMenu">
      <div class="pb-4 text-gray-500 dark:text-gray-400">
        <Link :href="route('dashboard.index')">
             <span :class="{'text-gray-800': customersarea.coloredsidebar == '#FFFFFF', 'text-white': customersarea.coloredsidebar !== '#FFFFFF'}" class="pt-4 ml-6 text-lg font-bold dark:text-gray-200" v-if="customersarea.logotype == 'text'">{{ customersarea.logo }}</span>
             <img v-else :width="customersarea.logowidth ?? '56'" :height="customersarea.logoheight ?? '56'" class="responsive-image w-full" :src="customersarea.logo" alt="img" />
        </Link>
        <ul>
          <li class="relative px-6 py-3">
            <Link :class="{'font-bold text-dark': route().current() == 'dashboard.index'}"
              class="text-sidebar inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 hover:font-bold dark:hover:text-gray-200"
              :href="route('dashboard.index')">
              <component :is="HomeIcon" class="flex-shrink-0 h-6 w-6" aria-hidden="true" />
              <span v-if="lang == 'pt_BR'" class="ml-4">Início</span>
              <span v-else-if="lang == 'en_US'" class="ml-4">Dashboard</span>
              <span v-else class="ml-4">Dashboard</span>
            </Link>
          </li>
          <li class="relative px-6 py-3">
            <Link :class="{'font-bold text-dark': route().current() == 'dashboard.comments'}"
              class="text-sidebar inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 hover:font-bold dark:hover:text-gray-200"
              :href="route('dashboard.comments')">
              <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
              </svg>
              <span v-if="lang == 'pt_BR'" class="ml-4">Comentários</span>
              <span v-else-if="lang == 'en_US'" class="ml-4">Comments</span>
              <span v-else class="ml-4">Comments</span>
            </Link>
          </li>
          <li class="relative px-6 py-3">
            <Link :class="{'font-bold text-dark': route().current() == 'dashboard.notifications'}"
              class="text-sidebar inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 hover:font-bold dark:hover:text-gray-200"
              :href="route('dashboard.notifications')">
              <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                 <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
              </svg>
              <span v-if="lang == 'pt_BR'" class="ml-4">Notificações</span>
              <span v-else-if="lang == 'en_US'" class="ml-4">Notifications</span>
              <span v-else class="ml-4">Notifications</span>
            </Link>
          </li>
          <li class="relative px-6 py-3">
            <Link :class="{'font-bold text-dark': route().current() == 'dashboard.history'}"
              class="text-sidebar inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 hover:font-bold dark:hover:text-gray-200"
              :href="route('dashboard.history')">
              <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                 <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
              <span v-if="lang == 'pt_BR'" class="ml-4">Histórico</span>
              <span v-else-if="lang == 'en_US'" class="ml-4">History</span>
              <span v-else class="ml-4">History</span>
            </Link>
          </li>
          <li class="relative px-6 py-3">
            <Link :class="{'font-bold text-dark': route().current() == 'dashboard.profile'}"
              class="text-sidebar inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 hover:font-bold dark:hover:text-gray-200"
              :href="route('dashboard.profile')">
              <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
              <span v-if="lang == 'pt_BR'" class="ml-4">Perfil</span>
              <span v-else-if="lang == 'en_US'" class="ml-4">Profile</span>
              <span v-else class="ml-4">Profile</span>
            </Link>
          </li>
          <li v-for="row in customersarea.items" class="relative px-6 py-1">
            <Link class="text-sidebar inline-flex items-center w-full text-sm font-semibold transition duration-200 ease-in hover-theming hover:font-bold hover:text-white py-2 px-2 rounded-lg"
              :href="row.url">
              <i :class="row.icon"></i>
              <span class="ml-4">{{ row.name }}</span>
            </Link>
          </li>
        </ul>
        <div class="px-6 my-6">
          <Link v-if="customersarea.button" :href="customersarea.buttonurl"
            :class="{'bg-theming-button': customersarea.buttoncolor}"
			class="flex items-center justify-between px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 border border-transparent rounded-lg hover-theming hover:font-bold focus:outline-none focus:shadow-outline-white">
            {{ customersarea.buttontext ?? 'Exemple link' }}
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
            </svg>
          </Link>
        </div>
      </div>
    </aside>
  </div>
</template>
