<template>
    <div class="w-full bg-gray-500 rounded-md overflow-hidden">
        <span class="inline-flex  text-sm ">
            <template
                v-for="icon in icons"
            >
                <button
                    v-if="!icon.hidden"
                    class="inline-block border-e px-2 py-1 bg-gray-500 text-white hover:bg-gray-700 focus:relative disabled:opacity-25"
                    :title="icon.text"
                    :disabled="icon.disabled"
                    @click="clickIcon(icon.name)"
                >
                    <i :class="icon.icon"></i>
                </button>
            </template>
        </span>
    </div>
</template>
<script setup>
     const props = defineProps({
        icons: Array,
     })

     const emit = defineEmits([
        'click'
    ])

    const clickIcon = (icon) => {
        emit('click', icon)
    }
</script>