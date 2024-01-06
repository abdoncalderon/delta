<template>
    <div class="relative">
        <input 
            v-model="text"
            class="block px-2 py-1 w-full rounded-md form-input focus:border-indigo-600 text-xs" 
            @keyup="keyUp"
            ref="input" 
            :disabled="disabled"
        />
            <div v-if="(showOptions)&&(!fixed)" class="absolute top-full left-0 w-full bg-white mt-1 py-2 px-1 border border-black rounded-md overflow-auto h-auto">
                <ul :key="itemSelected">
                    <template v-for="(item, i) in items" :key="i"> 
                        <li v-if="i==itemSelected" class="text-xs py-1 px-2 bg-black text-white" @click="selectItem(item)">{{ item[show] }}</li>
                        <li v-else class="text-xs py-1 px-2 hover:bg-black hover:text-white" @click="selectItem(item)">{{ item[show] }}</li>
                    </template>
                </ul>
            </div>
            <div v-if="(showOptions)&&(fixed)" class="w-full bg-white mt-1 py-2 px-1 border border-black rounded-md overflow-auto" style="height: 200px;">
                <ul :key="itemSelected" class="h-400">
                    <template v-for="(item, i) in items" :key="i"> 
                        <li v-if="i==itemSelected" class="text-xs py-1 px-2 bg-black text-white" @click="selectItem(item)">{{ item[show] }}</li>
                        <li v-else class="text-xs py-1 px-2 hover:bg-black hover:text-white" @click="selectItem(item)">{{ item[show] }}</li>
                    </template>
                </ul>
            </div>
        
    </div>
</template>

<script setup>

    import { onMounted, ref, reactive } from 'vue';

    const props = defineProps(['modelValue','options','show','disabled','fixed']);

    const emit = defineEmits([
        'update:modelValue',
        'change',
    ])

    const input = ref(null)
    const text = ref('')
    const items = reactive([])
    const itemSelected = ref(-1)
    const showOptions = ref(false)

    const fillList = () => {
        items.length = 0
        props.options.forEach( (row, i) => {
            items[i] = row
        }) 
    }

    const keyUp = ( event ) => {
        if (event.key==='ArrowUp') {
            if (itemSelected.value >= 1) {
                itemSelected.value = itemSelected.value - 1
            } else {
                itemSelected.value = 0
            }
            text.value = items[itemSelected.value][props.show]
            emit('update:modelValue', items[itemSelected.value].id)
            emit('change', items[itemSelected.value].id)
        } else if (event.key==='ArrowDown') {
            if (itemSelected.value <= items.length - 2) {
                itemSelected.value = itemSelected.value + 1
            } else {
                itemSelected.value = items.length - 1
            }
            text.value = items[itemSelected.value][props.show]
            emit('update:modelValue', items[itemSelected.value].id)
            emit('change', items[itemSelected.value].id)
        } else if(event.key==='Enter') {
            text.value = items[itemSelected.value][props.show]
            emit('update:modelValue', items[itemSelected.value].id)
            emit('change', items[itemSelected.value].id)
            showOptions.value = false
        } else {
            filterList()
        }
    }

    const filterList = () => {
        if (text.value !== '') {
            showOptions.value = true
            let count = 0;
            items.length = 0;
            props.options.forEach( (row, i) => {
                let str = row[props.show]
                str = str.toLowerCase()
                let substr = text.value
                substr = substr.toLowerCase()
                if (str.indexOf(substr)>= 0) {
                    items[count] = row
                    count++
                } 
            })
        } else {
            showOptions.value = false
            fillList()
        }
    }

    /* const updateInput = () => {
        emit('update:modelValue', items[itemSelected.value].id)
    } */

    const selectItem = ( item ) => {
        emit('update:modelValue', item.id)
        emit('change', item.id)
        text.value = item[props.show]
        showOptions.value = false
    }
    

    const loadItem = () => {
        props.options.forEach( (row, i) => {
            if (row.id == props.modelValue) {
                text.value = row[props.show]
            }
        })
    }

    onMounted(() => {
        fillList()
        loadItem()
        if (input.value.hasAttribute('autofocus')) {
            input.value.focus();
        }
    });

</script>

