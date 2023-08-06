<template>
    <input 
        class="block mt-1 w-full rounded-md form-input focus:border-indigo-600" 
        :value="modelValue"
        @input="$emit('update:modelValue', $event.target.value)" 
        ref="input" 
        :disabled="disabled"
    />
</template>

<script setup>
    import { onMounted, ref } from 'vue';

    const props = defineProps(['modelValue','disabled']);

    defineEmits(['update:modelValue']);

    const input = ref(null);

    onMounted(() => {
        if (input.value.hasAttribute('autofocus')) {
            input.value.focus();
        }
    });
</script>
