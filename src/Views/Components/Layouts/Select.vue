<script setup>
import { onMounted, ref } from 'vue';

defineProps({
    modelValue: String,
});

defineEmits(['update:modelValue']);

const select = ref(null);

onMounted(() => {
    if (select.value.hasAttribute('autofocus')) {
        select.value.focus();
    }
});

defineExpose({ focus: () => select.value.focus() });
</script>

<template>
    <select
	    ref="select"
        class="form-select appearance-none border-gray-300 bg-white bg-clip-padding bg-no-repeat transition ease-in-out focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-0 w-full font-normal h6 h-8 px-4 py-0 pr-8 m-0 text-gray-700 focus:shadow-outline"
        :value="modelValue"
		@input="$emit('update:modelValue', $event.target.value)">
	    <slot />
	</select>
</template>
