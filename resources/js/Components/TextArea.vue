<template>
    <textarea
        class="block w-full text-xs rounded-md form-input focus:border-indigo-600 disabled:opacity-50" 
        :value="modelValue"
        @input="$emit('update:modelValue', $event.target.value)" 
        ref="input" 
        :disabled="disabled"
        :rows="rows"
        
    ></textarea>
</template>

<script setup>

    import { onMounted, ref } from 'vue';

    const props = defineProps(['modelValue','disabled','rows']);

    defineEmits(['update:modelValue']);

    const input = ref(null);

    onMounted(() => {
        if (input.value.hasAttribute('autofocus')) {
            input.value.focus();
        }
    });

</script>
