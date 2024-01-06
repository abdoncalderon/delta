<template>
    <button 
        :type="type" 
        class="rounded-md bg-gray-500 px-3 py-1 text-center text-xs text-white hover:bg-gray-700 disabled:opacity-25"
    >
        <span class="pr-1"><i :class="icon"></i></span>
        <slot />
    </button>
</template>

<script setup>
defineProps({
    type: {
        type: String,
        default: 'submit',
    },
    icon: String,
});
</script>
