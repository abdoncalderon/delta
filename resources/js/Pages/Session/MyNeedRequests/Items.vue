<template>
    
    <ToolBar
        :icons="icons"
        @click="clickIconToolBar"
    />

    <div class="my-2">

        <table class="min-w-full divide-y divide-gray-300 rounded-lg overflow-x-auto">

            <thead class="bg-gray-600">
                <tr class="tracking-wide">
                    <th class="px-2 py-1 text-xs text-white tracking-wider">
                        {{ trnsl('content.quantity') }}
                    </th>
                    <th class="px-2 py-1 text-xs text-white tracking-wider">
                        {{ trnsl('content.measurement') }}
                    </th>
                    <th class="px-2 py-1 text-xs text-white tracking-wider">
                        {{ trnsl('content.reference') }}
                    </th>
                    <th class="px-2 py-1 text-xs text-white tracking-wider">
                        {{ trnsl('content.status') }}
                    </th>
                    <th class="px-2 py-1 text-xs text-white tracking-wider">
                        {{ trnsl('content.actions') }}
                    </th>
                </tr>
            </thead>

            <tbody class="bg-white divide-y divide-gray-300">
                <tr v-for="(item, i) in myNeedRequestItems" :key="i">
                    <td class="whitespace-wrap px-2 py-1 text-xs text-gray-500 text-start">
                        {{ item.quantity }}
                    </td>
                    <td class="whitespace-wrap px-2 py-1 text-xs text-gray-500 text-start">
                        {{ item.unity.code }}
                    </td>
                    <td class="whitespace-wrap px-2 py-1 text-xs text-gray-500 text-start">
                        {{ item.reference }}
                    </td>
                    <td class="whitespace-wrap px-2 py-1 text-xs text-gray-500 text-center">
                        {{ statuses[item.status_id - 1].name }}
                    </td>
                    <td class="px-2 py-1 text-xs text-gray-500 text-center">
                        <span class="inline-flex overflow-hidden rounded-md border bg-white shadow-sm">
                            <button 
                                class="inline-block border-e px-2 py-1 text-green-600 hover:bg-gray-50 focus:relative disabled:opacity-25"
                                :title="trnsl('content.attachment')"
                                @click="viewAttachment(item)"
                                :disabled="!item.attachment"
                            >
                                <i class="fa fa-paperclip"></i>
                            </button>
                            <button 
                                class="inline-block border-e px-2 py-1 text-red-600 hover:bg-gray-50 focus:relative disabled:opacity-25"
                                :title="trnsl('content.delete')"
                                @click="deleteItem(item)"
                                :disabled="item.deleteFlag"
                            >
                                <i class="fa fa-trash"></i>
                            </button>
                        </span>
                    </td>
                </tr>
            </tbody>

        </table>

    </div>

    <Modal
        :showModal="newItem"
        @closeModal="newItem=false"
        :title="trnsl('messages.newItem')"
        modalWidth="300px"
    >
        <Form
            :fields="fields"
            :form="form"
            routePath="myNeedRequestItems.store"
            operation="store"
            @submit="getEvent"
            :acceptText="trnsl('content.save')"
        />
    </Modal>

    <Modal
        :showModal="showAttachment"
        @closeModal="closeAttachment"
        :title="trnsl('content.attachment')"
        modal-width="500px"
        modal-height="700px"
    >
        <embed class="w-full h-screen" :src="file" />
    </Modal>
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
    ])

    const newItem = ref(false)
    const showAttachment = ref(false)
    const file = ref('')
    const myNeedRequestItems = reactive([])

 
    const fields = [
        {name: 'quantity', type: 'number', text: trnsl('content.quantity'), style: 'sm:col-span-2', length: 255, disabled: false },
        {name: 'unity_id', type: 'select', text: trnsl('messages.unitOfMeasurement'), style: 'sm:col-span-2', items:[], disabled: false}, 
        {name: 'reference', type: 'textarea', text: trnsl('content.reference'), style: 'sm:col-span-4', length: 255, disabled: false },
        {name: 'attachment', type: 'file', text: trnsl('content.attachment'), style: 'sm:col-span-4', accept: 'image/*, .pdf', disabled: false}
    ]

    const statuses = [
        {id: 1, name: trnsl('content.draft') },
        {id: 2, name: trnsl('messages.sentToApprove') },
        {id: 3, name: trnsl('content.rejected') },
        {id: 4, name: trnsl('content.approved') },
        {id: 5, name: trnsl('messages.inProcessOfPurchase') },
        {id: 6, name: trnsl('messages.readyForDelivery') },
        {id: 7, name: trnsl('content.delivered') },
    ]

    const icons = [
        {name: 'new', text: trnsl('content.new'), icon: 'fa fa-plus', disabled: props.isShow},
    ]

    const event = {
        source: '',
        action: '',
        status: 0,
        data: null,
    }

    const closeAttachment = () => {
        showAttachment.value = false
    }

    const getNeedRequestItems = () => {
        myNeedRequestItems.length = 0
        axios.get('/getNeedRequestItems/' + props.need_request_id)
            .then(response=>{
                response.data.forEach( (row, i) => {
                    myNeedRequestItems[i] = row
                })
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

    const viewAttachment = (item) => {
        file.value = 'http://delta.test/storage/kapatax/documents/commercial/needRequests/' + item.attachment 
        showAttachment.value = true
    }

    const getEvent = ( event ) => {
        getNeedRequestItems()
        newItem.value = false
        form.reset()
    }

    onMounted(()=>{
        getNeedRequestItems()
    })

</script>


