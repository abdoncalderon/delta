<template>
    <div class="w-12 bg-gray-300 rounded-lg" @click="changeStatus">
        
        <span v-if="value" class="flex justify-end p-0.5 bg-green-500 border border-gray-500  rounded-xl text-xl text-white">
            <i class="fa fa-circle"></i>
        </span>
        <span v-else class="flex p-0.5 bg-white border border-gray-500  rounded-xl text-xl text-gray-300">
            <i class="fa fa-circle"></i>
        </span>
    </div>
    
</template>
<script setup>

    import { ref, onMounted } from 'vue';

    const props = defineProps([
        'status',
        'value',
    ])

    const emit = defineEmits(['update:status']);

    const flag = ref(false)

    const changeStatus = () => {
        flag.value = !flag.value
        emit('update:status', flag.value)
    }

    onMounted(()=>{
        flag.value = props.value
    })

    

</script>