<template>
    <input 
        :value="modelValue"
        type="file" 
        class="block w-full text-xs bg-white rounded-md border border-gray-500 "
        @input="$emit('update:modelValue', $event.target.value)"
        :accept="accept"
    >
</template>
<script setup>
    const props = defineProps(['modelValue','disabled','accept']);
    defineEmits(['update:modelValue']);
</script>