<template>
    <button
        :type="type"
        class="inline-flex items-center px-3 py-1 bg-white border border-gray-600 rounded-md text-xs text-gray-700 font-semibold shadow-sm hover:bg-gray-200  disabled:opacity-25 transition ease-in-out duration-150"
    >   
        <span class="pr-1"><i :class="icon"></i></span>
        <slot />
    </button>
</template>

<script setup>
defineProps({
    type: {
        type: String,
        default: 'button',
    },
    icon: String,
});
</script>
