<template>
    <div class="border border-neutral-700 bg-gray-200 rounded-lg overflow-auto">

        <h3 class="px-3 py-3 font-semibold text-sm text-white bg-gray-700">
            {{ $trnsl('content.purchaseRequest') + ' - # ' +  zeroPad(purchaseRequest.id, 6) }}
        </h3>

        <div class="m-1 grid grid-cols-8 sm:grid-cols-12 gap-0">
            <div class="col-span-3 sm:col-span-2">
                <p class="py-1 pr-2 text-xs text-right font-extrabold uppercase ">{{ trnsl('content.zone') }}:</p>
            </div>
            <div class="col-span-5 sm:col-span-10">
                <p class="py-1 text-xs">{{ purchaseRequest.need_request.location.zone.name }}</p>
            </div>
            <div class="col-span-3 sm:col-span-2">
                <p class="py-1 pr-2 text-xs text-right font-extrabold uppercase">{{ trnsl('content.location') }}:</p>
            </div>
            <div class="col-span-5 sm:col-span-10">
                <p class="py-1 text-xs">{{ purchaseRequest.need_request.location.name }}</p>
            </div>
            <div class="col-span-3 sm:col-span-2">
                <p class="py-1 pr-2 text-xs text-right font-extrabold uppercase">{{ trnsl('content.costAccount') }}:</p>
            </div>
            <div class="col-span-5 sm:col-span-10  ">
                <p class="py-1 text-xs">{{ purchaseRequest.need_request.cost_account }}</p>
            </div>
            <div class="col-span-3 sm:col-span-2">
                <p class="py-1 pr-2 text-xs text-right font-extrabold uppercase">{{ trnsl('content.expectedCost') }}:</p>
            </div>
            <div class="col-span-5 sm:col-span-10  ">
                <p class="py-1 text-xs">$ {{ purchaseRequest.need_request.expectedCost }}</p>
            </div>
            <div class="col-span-3 sm:col-span-2">
                <p class="py-1 pr-2 text-xs text-right font-extrabold uppercase">{{ trnsl('content.description') }}:</p>
            </div>
            <div class="col-span-5 sm:col-span-10  ">
                <p class="py-1 text-xs">{{ purchaseRequest.need_request.description }}</p>
            </div>
            <div class="col-span-3 sm:col-span-2">
                <p class="py-1 pr-2 text-xs text-right font-extrabold uppercase">{{ trnsl('content.applicant') }}:</p>
            </div>
            <div class="col-span-5 sm:col-span-10  ">
                <p class="py-1 text-xs">{{ purchaseRequest.need_request.project_user.user.person.fullName }}</p>
            </div>
            <div class="col-span-3 sm:col-span-2">
                <p class="py-1 pr-2 text-xs text-right font-extrabold uppercase">{{ trnsl('content.approvedBy') }}:</p>
            </div>
            <div class="col-span-5 sm:col-span-10  ">
                <p class="py-1 text-xs">{{ purchaseRequest.need_request.approver.user.person.fullName }}</p>
            </div>
            <div class="col-span-3 sm:col-span-2">
                <p class="py-1 pr-2 text-xs text-right font-extrabold uppercase">{{ trnsl('content.classifiedBy') }}:</p>
            </div>
            <div class="col-span-5 sm:col-span-10  ">
                <p class="py-1 text-xs">{{ purchaseRequest.sorter.user.person.fullName }}</p>
            </div>
        </div>
            
        <div class="m-2">

            <p class="px-3 py-2 mb-0.5 bg-gray-600 text-white text-xs ">{{ trnsl('content.items') }}</p>

            <Items
                :purchaseRequestItems="purchaseRequest.purchase_request_items"
            />

        </div>

        <div class="mx-2 my-3"> 
            
            <Notifications 
                :key="reload"
                :purchaseRequest="purchaseRequest"
                :stakeholders="stakeholders"
                @event="getEventNotifications"
            />

        </div>

        <div class="p-3 mt-2 flex justify-end bg-gray-100">

            <PrimaryButton
                v-if="haveNotifications"
                @click="send"
                icon="fa fa-check"
            >
                {{ $trnsl('content.send') }}
            </PrimaryButton>
           
            <SecondaryButton
                class="ml-3"
                icon="fa-solid fa-circle-xmark"
                @click="cancel"

            >
                {{ $trnsl('content.exit') }}
            </SecondaryButton>
        </div>

    </div>
    
</template>

<script setup>
    import PrimaryButton from '@/Components/PrimaryButton.vue' 
    import SecondaryButton from '@/Components/SecondaryButton.vue'
    import Items from './Items.vue'
    import Notifications from './Notifications.vue'
    import { successMessage, errorMessage, dialogBox, getError } from '@/Helpers/helper'
    import { trnsl } from '@/Lang/languages'
    import { ref } from 'vue'
    import axios from 'axios'
    import { onMounted } from 'vue'

    const props = defineProps({
        purchaseRequest: Object,
        stakeholders: Array,
    })

    const emit = defineEmits([
        'event',
    ])

    const zeroPad = ( value, places ) => String(value).padStart(places, '0')

    const reload = ref(0)
    const haveNotifications = ref(false)

    const event = {
        source: '',
        action: '',
        status: 0,
        data: null,
    }

    const cancel = () => {
        event.source = 'send'
        event.action = 'cancel'
        event.status = 0
        event.data = null
        emit('event', event)
    }

    const send = () => {
        const dialog = dialogBox(trnsl('content.purchaseRequest')+ ' ' + zeroPad(props.purchaseRequest.id, 6), trnsl('messages.confirmSendPurchaseRequestNotification'))
        dialog.fire().then((result) =>{
            if (result.isConfirmed) {
                axios.get('/commercial/purchases/purchaseRequests/send/' + props.purchaseRequest.id)
                    .then(response=>{
                        successMessage(trnsl('messages.purchaseRequestNotificationsSended'))
                        event.source = 'send'
                        event.action = 'send'
                        event.status = 1
                        emit('event', event)
                    })
                    .catch( error => {
                        errorMessage(trnsl('messages.recordNoSaved') +  getError(error))
                        console.log(error)
                    })
            }
        });
    }  

    const getEventNotifications = ( event ) => {
        haveNotifications.value = event.data > 0
    }

    onMounted(()=>{
        haveNotifications.value = props.purchaseRequest.purchase_request_notifications.length > 0
    })
    
</script>