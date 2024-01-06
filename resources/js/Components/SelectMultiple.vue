<template>
    <div class="py-2 px-2 bg-white rounded-lg border border-gray-600 ">
        <button
            class="px-2 py-1 bg-neutral-800 text-white text-xs rounded-md"
            @click="select"
        >
            {{ textSelectButton }}
        </button>
        <div class="mt-1 p-2 border border-gray-500 rounded-md overflow-auto" :style="style">
            <template v-for="item in list">
                <div class="text-xs py-0.5">
                    <input class="checked:bg-gray-700" type="checkbox" v-model="item.checked"/>
                    <span class="pl-1.5">
                        {{ item.value.name }}
                    </span>
                </div>
            </template>
        </div>
    </div>
</template>

<script setup>  
    import { ref, onMounted } from 'vue';
    import { trnsl } from '@/Lang/languages';

    const props = defineProps({
        data: Array,
        list: Array,
        height: {type: String, default: '400px'}
    });

    defineEmits([
        'update:list'
    ]);

    const textSelectButton = ref('')
    const selectAll = ref(false)
    

    const fill = () => {
        props.list.length = 0
        
        props.data.forEach( (row, i) => {
            let item = {
                value: null,
                checked: false
            }
            item.value = row
            props.list[i] = item
        })
    }

    const select = () => {
        selectAll.value = !selectAll.value
        props.list.forEach((row, i)=>{
            row.checked = selectAll.value
        })
        if (selectAll.value) {
            textSelectButton.value = trnsl('messages.unselectAll')
        } else {
            textSelectButton.value = trnsl('messages.selectAll')
        }
    }

    const style = {
        'height': props.height
    }

    onMounted(() => {
        textSelectButton.value = trnsl('messages.selectAll')
        fill()
    })

</script>