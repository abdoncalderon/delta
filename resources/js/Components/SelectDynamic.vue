<template>
        <input 
            :id="id"
            v-model="text"
            class="block mt-1 w-full rounded-md form-input focus:border-indigo-600 text-xs" 
            @change="updateInput"
            @keyup="filterList"
            ref="input" 
            :disabled="disabled"
        />
        <div class="bg-white mt-1 py-2 px-1 border border-black rounded-md overflow-auto h-28">
            <ul>
                <template v-for="(item, i) in items" :key="i"> 
                    <li class="text-xs py-1 px-2 hover:bg-black hover:text-white" @click="selectItem(i)">{{ item[show] }}</li>
                </template>
            </ul>
        </div>
</template>

<script setup>

    import { onMounted, ref, reactive } from 'vue';

    const props = defineProps(['id','modelValue','options','show','disabled']);

    // defineEmits(['update:modelValue']);

    const emit = defineEmits([
        'update:modelValue'
    ])

    const input = ref(null);
    const text = ref('')
    const items = reactive([]);
    const itemSelected = ref(0)

    const fillList = () => {
        items.length = 0
        props.options.forEach( (row, i) => {
            items[i] = row
        }) 
    }

    const filterList = () => {
        if (text.value !== '') {
            let count = 0;
            items.length = 0;
            props.options.forEach( (row, i) => {
                let str = row[props.show]
                let substr = text.value
                if (str.indexOf(substr)>= 0) {
                    items[count] = row
                    count++
                } 
            })
        } else {
            fillList()
        }
    }

    const updateInput = () => {
        emit('update:modelValue', items[itemSelected.value].id)
    }

    const selectItem = (id) => {
        itemSelected.value = id
        emit('update:modelValue', items[itemSelected.value].id)
        text.value = items[itemSelected.value][props.show]
    }

    onMounted(() => {
        console.log(props.modelValue)
        fillList()
        if (input.value.hasAttribute('autofocus')) {
            input.value.focus();
        }
    });
</script>