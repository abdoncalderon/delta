<template>
    <div class="w-full p-1 bg-white border-neutral-300 border rounded-lg my-2">
        <span class="inline-flex text-xs overflow-hidden rounded-md border bg-white shadow-sm">
            <template
                v-for="button in buttons"
            >
                <button
                    class="inline-block border-e px-2 py-1 hover:bg-gray-50 focus:relative"
                    :title="button.text"
                    @click="clickButton(button.name)"
                >
                    <i :class="button.icon"></i>
                </button>
            </template>
        </span>
    </div>
</template>
<script setup>
     const props = defineProps({
        buttons: Array,
     })

     const emit = defineEmits([
        'click'
    ])

    const clickButton = (button) => {
        emit('click', button)
    }
</script>