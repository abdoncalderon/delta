<template>
    
    

   

    
</template>

<script setup>
    import ToolBar from '@/Components/ToolBar.vue'
    import Form from '@/Components/Form.vue'
    import Modal from '@/Components/Modal.vue'
    
    import axios from 'axios'
    import { useForm } from '@inertiajs/vue3';
    import { trnsl } from '@/Lang/languages';
    import { ref, onMounted, reactive } from 'vue';
    import { successMessage, errorMessage, dialogBox, getError } from '@/Helpers/helper'

    const props = defineProps({
        need_request_id: Number,
        unities: Array,
        needRequestItems: Array,
        isShow: Boolean,
    })

    const form = useForm({
        'id': '',
        'need_request_id': '',
        'reference': '',
        'quantity': '',
        'unity_id': '',
        'status_id': '',
        'attachment': '',
    });

    const emit = defineEmits([
        'event',
        'classification'
    ])

    const newItem = ref(false)
    const attachment = ref(false)
    const file = ref('')
    const reload = ref(0)
    const myNeedRequestItems = reactive([])

    
    const headers = [
        {name: 'quantity', text: trnsl('content.quantity'), type: 'text', align: 'right'},
        {name: 'unity.name', text: trnsl('content.measurement'), type: 'text', align: 'left'},
        {name: 'reference', text: trnsl('content.reference'), type: 'text', align: 'left'},
        {name: 'status_id', text: trnsl('content.status'), type: 'list', align: 'left', items: []},
    ]

    const fields = [
        {name: 'quantity', type: 'number', text: trnsl('content.quantity'), style: 'sm:col-span-1', length: 255, disabled: false },
        {name: 'unity_id', type: 'select', text: trnsl('messages.unitOfMeasurement'), style: 'sm:col-span-1', items:[], disabled: false}, 
        {name: 'reference', type: 'text', text: trnsl('content.reference'), style: 'sm:col-span-4', length: 255, disabled: false },
        {name: 'attachment', type: 'file', text: trnsl('content.attachment'), style: 'sm:col-span-4', accept: 'image/*, .pdf', disabled: false}
    ]

    const event = {
        source: '',
        action: '',
        status: 0,
        data: null,
    }

    const icons = [
        {name: 'new', text: trnsl('content.new'), icon: 'fa fa-plus', disabled: props.isShow},
    ];

    const getNeedRequestItems = () => {
        myNeedRequestItems.length = 0
        axios.get('/getNeedRequestItems/' + props.need_request_id)
            .then(response=>{
                response.data.forEach( (row, i) => {
                    myNeedRequestItems[i] = row
                })
                reload.value += 1
                event.source = 'items'
                event.status = 1
                event.data = myNeedRequestItems.length
                emit('event', event)
            })
            .catch(error=>{
                console.log(error)
            })
    }

    const clickIconToolBar = (button) => {
        if (button === 'new') {
            form.reset()
            form.need_request_id = props.need_request_id
            form.status_id = 1
            fields[1].items = props.unities
            newItem.value = true
        } 
    }

    const deleteItem = (item) => {
        const dialog = dialogBox(item.reference, trnsl('messages.confirmDelete'))
        dialog.fire().then((result) =>{
            if(result.isConfirmed){
                form.delete(route('myNeedRequestItems.destroy', item.id),{
                    onSuccess: () => { 
                        successMessage(trnsl('messages.recordDeleted'))
                        getNeedRequestItems()
                    },
                    onError: (errors) => {
                        errorMessage(trnsl('messages.recordNoDeleted') +  getError(errors))
                    }
                })
            }
        });
    }

    const showAttachment = (item) => {
        file.value = 'http://delta.test/storage/kapatax/documents/commercial/needRequests/' + item.attachment 
        attachment.value = true
    }

    const getEvent = ( event ) => {
        getNeedRequestItems()
        newItem.value = false
        form.reset()
    }

    onMounted(()=>{
        getNeedRequestItems()
        headers[3].items = statuses
    })

</script>


