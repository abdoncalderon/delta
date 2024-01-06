<template>
    <div class="border border-gray-500 bg-gray-200 rounded-lg overflow-auto" :style="style">
        <div class="flex justify-between px-3 py-2 text-sm text-white bg-gray-700" >
            <p>{{ title }}</p>
            <button class="text-md" @click="close">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <slot name="body" /> 
    </div>
</template>
<script setup>

    const props = defineProps({
        title: String,
        width: {type: String, default: 'auto'},
        height: {type: String, default: 'auto'},
    })

    const emit = defineEmits([
        'close'   
    ])

    const close = () => {
        emit('close', true)
    }

    const style = {
        width: props.width,
        height: props.height,
    }

</script>