<template>
    <Link class="block px-4 py-2 text-xs text-gray-700 hover:bg-gray-600 hover:text-white">
        <slot />
    </Link>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
</script>
