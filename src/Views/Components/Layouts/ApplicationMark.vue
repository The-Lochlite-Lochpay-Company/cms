<script setup>
const getOrigin = () => {
   return window.origin;
}
const setFallbackImage = (event) => {
      event.target.src = getOrigin() + '/application/72x72.png';
    }
</script>
<template>
    <img :src="getOrigin() + '/logo.png'" @error="setFallbackImage" alt="logo of company">
</template>