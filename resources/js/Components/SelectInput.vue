<template>
    <select 
        class="block mt-1 w-full rounded-md focus:border-indigo-600" 
        :value="modelValue" 
        @change="$emit('update:modelValue', $event.target.value)" 
        ref="input"
        :disabled="disabled"
    >
        <option v-for="option in options" :key="option.id" :value="option.id">{{ option.name }}</option>
    </select>
</template>

<script setup>

    import { onMounted, ref } from 'vue';

    defineProps(['modelValue','options', 'disabled']);

    defineEmits(['update:modelValue']);

    const input = ref(null);

    onMounted(() => {
        if (input.value.hasAttribute('autofocus')) {
            input.value.focus();
        }
    });
    
</script>