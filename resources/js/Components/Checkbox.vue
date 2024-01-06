<template>
    <div class="flex justify-center border border-gray-500 rounded-md ">
        <input type="checkbox" :value="value" v-model="proxyChecked" class="my-1 text-indigo-600">
    </div>
   
</template>

<script setup>
import { computed } from 'vue';

const emit = defineEmits(['update:checked']);

const props = defineProps({
    checked: {
        type: [Array, Boolean, Number],
        default: false,
    },
    value: {
        default: null,
    },
});

const proxyChecked = computed({
    get() {
        let flag = false
        if (props.checked) { flag = true }
        return flag;
    },

    set(val) {
        emit('update:checked', val);
    },
});
</script>
