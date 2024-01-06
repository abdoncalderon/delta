<template>
    <select 
        class="block px-2 py-1 text-xs w-full rounded-md focus:border-indigo-600 disabled:opacity-50" 
        :value="modelValue" 
        @change="changeValue" 
        ref="input"
        :disabled="disabled"
    >
        <option v-for="option in options" :key="option.id" :value="option[idField]">{{ option[showField] }}</option>
    </select>
</template>

<script setup>

    import { onMounted, ref } from 'vue';

    const props = defineProps({
        'modelValue': null,
        'options': Array, 
        'disabled': Boolean, 
        'idField': {
            type: String, 
            default: 'id'
        },
        'showField': {
            type: String, 
            default: 'name'
        },
        
    })

    const emit = defineEmits([
        'update:modelValue',
        'change'
    ])

    const input = ref(null);

    const changeValue = ( event ) => {
        emit('update:modelValue', event.target.value)
        emit('change', event.target.value)
    } 

    onMounted(() => {
        if (input.value.hasAttribute('autofocus')) {
            input.value.focus();
        }
    });
    
</script>