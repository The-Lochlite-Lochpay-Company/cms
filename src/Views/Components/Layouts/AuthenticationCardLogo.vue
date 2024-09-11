<script setup>
import { Link } from '@inertiajs/vue3';
const getOrigin = () => {
   return window.origin;
}
const setFallbackImage = (event) => {
      event.target.src = getOrigin() + '/application/72x72.png';
    }
</script>
<template>
    <Link :href="'/'">
    <img :src="getOrigin() + '/logo.png'" @error="setFallbackImage" alt="logo of company">
    </Link>
</template>
