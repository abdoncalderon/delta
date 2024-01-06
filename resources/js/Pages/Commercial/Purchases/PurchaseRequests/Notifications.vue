<template>

    <div class="flex mb-0.5 bg-gray-600 justify-between">
        <p class="px-3 py-2  text-white text-xs ">{{ trnsl('content.notifications') }}</p>
        <button class="m-1  py-1 px-3 text-xs text-white bg-gray-500 rounded" @click="addNotification"><i class="fa fa-plus"></i></button>
    </div>

    <table class="min-w-full divide-y divide-gray-300 rounded-lg">

        <thead class="bg-gray-600">
            <tr class="tracking-wide">
                <th class="px-3 py-1 text-xs text-white tracking-wider">
                    {{ trnsl('content.supplier') }}
                </th>
                <th class="px-3 py-1 text-xs text-white tracking-wider">
                    {{ trnsl('content.status') }}
                </th>
                <th class="px-3 py-1 text-xs text-white tracking-wider">
                    {{ trnsl('content.actions') }}
                </th>
            </tr>
        </thead>

        <tbody class="bg-white divide-y divide-gray-300">
            <tr v-for="(notification, i) in notifications" :key="i">
                <td class="whitespace-wrap px-3 py-1 text-xs text-gray-500 text-start">
                    {{ notification.stakeholder.name }}
                </td>
                <td class="whitespace-wrap px-3 py-1 text-xs text-gray-500 text-start">
                    {{ statuses[notification.status_id - 1].name }}
                </td>
                
                <td class="whitespace-wrap px-3 py-1 text-xs text-gray-500 text-center">
                    <span class="inline-flex overflow-hidden rounded-md border bg-white shadow-sm">
                        <button 
                            class="inline-block border-e px-2 py-1 text-red-600 hover:bg-gray-50 focus:relative disabled:opacity-25"
                            :title="trnsl('content.attachment')"
                            @click="deleteNotification(notification)"
                        >
                            <i class="fa fa-trash"></i>
                        </button>
                    </span>
                </td> 
            </tr>
        </tbody>

    </table>

    <Modal
        :showModal="showAddNotification"
        @closeModal="closeNotification"
        :title="trnsl('messages.addSupplierNotification')"
        modal-width="350px"
    >
        <Form
            :fields="fields"
            :form="form"
            routePath="purchaseRequestNotifications.store"
            operation="store"
            @submit="submitNotification"
            :acceptText="trnsl('content.add')"
        />
    </Modal>

</template>

<script setup>

    import Modal from '@/Components/Modal.vue'
    import Form from '@/Components/Form.vue'
    import { successMessage, errorMessage, getError, dialogBox } from '@/Helpers/helper'
    import { trnsl } from '@/Lang/languages'
    import { useForm } from '@inertiajs/vue3'
    import { onMounted, ref, reactive } from 'vue'

    const props = defineProps({
        purchaseRequest: Object,
        stakeholders: Array,
    })

    const emit = defineEmits([
        'event',
    ])

    const form = useForm({
        'purchase_request_id': '',
        'stakeholder_id': '',
    })

    const showAddNotification = ref(false)
    const notifications = reactive([])

    const fields = [
        {name: 'stakeholder_id', type: 'select', text: trnsl('content.supplier'), style: 'sm:col-span-4', items:[], disabled: false}, 
    ]

    const statuses = [
        {id: 1, name: trnsl('content.added') },
        {id: 2, name: trnsl('content.sent') },
        {id: 3, name: trnsl('content.rejected') },
        {id: 4, name: trnsl('content.accepted') },
    ]

    const event = {
        source: 'notifications',
        action: '',
        status: '',
        data: null
    }

    const addNotification = () => {
        form.purchase_request_id = props.purchaseRequest.id
        showAddNotification.value = true
    }

    const closeNotification = () => {
        showAddNotification.value = false
    }

    const deleteNotification = (notification) => {
        const dialog = dialogBox(notification.stakeholder.name, trnsl('messages.confirmDelete'))
        dialog.fire().then((result) =>{
            if(result.isConfirmed){
                form.delete(route('purchaseRequestNotifications.destroy', notification.id),{
                    onSuccess: () => { 
                        successMessage(trnsl('messages.recordDeleted'))
                        getNotifications()
                    },
                    onError: (errors) => {
                        errorMessage(trnsl('messages.recordNoDeleted') +  getError(errors))
                    }
                })
            }
        });
    }

    const getNotifications = () => {
        notifications.length = 0
        axios.get('/getPurchaseRequestNotifications/' + props.purchaseRequest.id)
            .then(response=>{
                response.data.forEach( (row, i) => {
                    notifications[i] = row
                })
                event.data = notifications.length
                emit('event',event)
            })
            .catch(error=>{
                console.log(error)
            })
    }

    const submitNotification = ( event ) => {
        getNotifications()
        showAddNotification.value = false
    }

    onMounted(()=>{
        getNotifications()
        fields[0].items = props.stakeholders
    })

</script>