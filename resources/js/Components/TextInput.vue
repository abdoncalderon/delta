<template>
    <input 
        :class="customClass" 
        :value="modelValue"
        @input="$emit('update:modelValue', $event.target.value)" 
        ref="input" 
        :disabled="disabled"
        :maxlength="size"
        :pattern="pattern"
    />
</template>

<script setup>
    import { onMounted, ref } from 'vue';

    const props = defineProps(['modelValue','disabled','size', 'pattern']);

    defineEmits(['update:modelValue']);

    const input = ref(null);
    const customClass = ref('') 

    onMounted(() => {
        if (input.value.hasAttribute('autofocus')) {
            input.value.focus();
        }
        if (input.value.getAttribute('type')==='number') {
            customClass.value = 'block px-2 py-1 w-full text-xs rounded-md form-input focus:border-indigo-600 disabled:opacity-50 text-end'
        } else {
            customClass.value = 'block px-2 py-1 w-full text-xs rounded-md form-input focus:border-indigo-600 disabled:opacity-50'
        }
    });
</script>

<!-- :class="block mt-1 w-full rounded-md form-input focus:border-indigo-600 disabled:opacity-50"  -->
