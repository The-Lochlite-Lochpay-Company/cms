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

defineProps({
    title: String,
    description: String,
});

const showingNavigationDropdown = ref(false);

const logout = () => {
    Inertia.post(route('logout'));
};
</script>

<template>
    <div>
        <Head :title="title" :description="description" />
	
        <JetBanner />

        <div class="min-h-screen bg-gray-100">
            <nav class="bg-white border-b border-gray-100">
                <!-- Primary Navigation Menu -->
                <div class="max-w-7xl mx-auto px-8 sm:px-6 lg:px-8">
                    <div class="flex justify-around px-0 md:px-8 md:mx-8 h-16">
                        <div class="flex">
                            <!-- Logo -->
                            <div class="shrink-0 flex items-center mr-auto">
                                <Link :href="route('dashboard.index')">
                                    <JetApplicationMark class="block h-10 w-auto" />
                                </Link>
                            </div>

                            <!-- Navigation Links -->
                            <div class="hidden text-center space-x-8 sm:-my-px sm:ml-10 sm:flex">
                                <JetNavLink class="d-none" style="color:#010066;" :href="route('index.index')" :active="route().current('index.index')">
                                    HOME
                                </JetNavLink>
                                <JetNavLink class="d-none" style="color:#010066;" :href="route('blog.index')" :active="route().current('blog.index')">
                                    BLOG
                                </JetNavLink>
                                 <JetNavLink class="d-none" style="color:#010066;" :href="route('contact')" :active="route().current('dashboard.index')">
                                    CONTATO
                                </JetNavLink>
                            </div>
                        </div>

                        <div class="hidden sm:flex sm:items-center sm:ml-6">
                        <Link :href="route('login.index')" class="px-4 py-2 text-white d-none" style="background: #2b1c55;">Login</Link>
                        </div>

                        <!-- Hamburger -->
                        <div class="-mr-2 flex items-center sm:hidden">
                            <button class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition" @click="showingNavigationDropdown = ! showingNavigationDropdown">
                                <svg
                                    class="h-6 w-6"
                                    stroke="currentColor"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        :class="{'hidden': showingNavigationDropdown, 'inline-flex': ! showingNavigationDropdown }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h16"
                                    />
                                    <path
                                        :class="{'hidden': ! showingNavigationDropdown, 'inline-flex': showingNavigationDropdown }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"
                                    />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Responsive Navigation Menu -->
                <div :class="{'block': showingNavigationDropdown, 'hidden': ! showingNavigationDropdown}" class="sm:hidden d-none">
                    <div class="pt-2 pb-3 space-y-1">
                                <JetResponsiveNavLink class="d-none" style="color:#010066;" :href="route('index.index')" :active="route().current('index.index')">
                                    HOME
                                </JetResponsiveNavLink>
                                <JetResponsiveNavLink class="d-none" style="color:#010066;" :href="route('blog.index')" :active="route().current('blog.index')">
                                    BLOG
                                </JetResponsiveNavLink>
                                 <JetResponsiveNavLink class="d-none" style="color:#010066;" :href="route('contact')" :active="route().current('dashboard.index')">
                                    CONTATO
                                </JetResponsiveNavLink>
                    </div>

                    <!-- Responsive Settings Options -->
                    <div class="pt-4 pl-2 pb-1 flex border-t border-gray-200">
                        <Link :href="route('login.index')" class="px-4 py-2 text-white" style="background: #2b1c55;">Login</Link>
                    </div>
                </div>
            </nav>

            <!-- Page Heading -->
            <header v-if="$slots.header" class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <slot name="header" />
                </div>
            </header>

            <!-- Page Content -->
            <main>
			       <slot />
            </main>
        </div>
    </div>
	
	
</template>

