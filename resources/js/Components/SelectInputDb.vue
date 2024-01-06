<template>
    
    <div v-if="withAdd" class="flex w-full ">
        <select 
            class="w-full px-2 py-1 text-xs focus:border-indigo-600 disabled:opacity-50 rounded-l-md" 
            :value="modelValue" 
            @change="changeValue" 
            ref="input"
            :disabled="disabled"
        >
            <option v-for="option in options" :key="option.id" :value="option.id">{{ option.name }}</option>
        </select>
        <button class="w-7 bg-neutral-700 text-white rounded-r-md" @click="modal=true">
            <i class="fa fa-plus"></i>
        </button>
    </div>


    <div v-if="!withAdd" class="flex w-full">
        <select 
            class="w-full px-2 py-1 text-xs focus:border-indigo-600 disabled:opacity-50 rounded-md" 
            :value="modelValue" 
            @change="changeValue" 
            ref="input"
            :disabled="disabled"
        >
            <option v-for="option in options" :key="option.id" :value="option.id">{{ option.name }}</option>
        </select>
    </div>

    <Modal
        :showModal="modal"
        @closeModal="modal=false"
        :title="trnsl('content.add')"
        modal-width="300px"
    >

        <Form
            :fields="fieldsAdd"
            :form="formAdd"
            :routePath="routeAdd"
            operation="store"
            @submit="getEvent"
            :acceptText="trnsl('content.save')"
        />
    </Modal>
    
</template>

<script setup>
    import Form from '@/Components/Form.vue'
    import Modal from '@/Components/Modal.vue'
    import { trnsl } from '@/Lang/languages';
    import { onMounted, ref, reactive } from 'vue';

    const props = defineProps([
        'id',
        'modelValue',
        'routeGet',
        'routeAdd',
        'formAdd',
        'fieldsAdd',
        'filterId',
        'disabled',
        'withAdd',
    ]);

    const emit = defineEmits([
        'update:modelValue',
        'change'
    ])

    const input = ref(null);
    const modal = ref(false)
    const options = reactive([])

    const changeValue = ( event ) => {
        emit('update:modelValue', event.target.value)
        emit('change', event.target.value)
    } 

    const getEvent = ( event ) => {
        if (event.action==='store'){
            if (event.status==1){
                getItems()
                modal.value = false
            } 
        } else {
            modal.value = false
        }
    }

    const getItems = () => {
        options.length = 0
        axios.get(props.routeGet + props.filterId)
            .then(response=>{
                response.data.forEach( (row, i) => {
                    options[i] = row
                })
            })
            .catch(error=>{
                console.log(error)
            })
    }

    onMounted(() => {
        getItems()
        if (input.value.hasAttribute('autofocus')) {
            input.value.focus();
        }
    });
    
</script>