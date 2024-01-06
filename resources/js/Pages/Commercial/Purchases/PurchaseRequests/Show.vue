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

            <div class="flex mb-0.5 bg-gray-600 justify-between">
                <p class="px-3 py-2  text-white text-xs ">{{ trnsl('content.notifications') }}</p>
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
                    </tr>
                </thead>

                <tbody class="bg-white divide-y divide-gray-300">
                    <tr v-for="(notification, i) in purchaseRequest.purchase_request_notifications" :key="i">
                        <td class="whitespace-wrap px-3 py-1 text-xs text-gray-500 text-start">
                            {{ notification.stakeholder.name }}
                        </td>
                        <td class="whitespace-wrap px-3 py-1 text-xs text-gray-500 text-start">
                            {{ statuses[notification.status_id - 1].name }}
                        </td>
                    </tr>
                </tbody>

            </table>

        </div>

        <div class="p-3 mt-2 flex justify-end bg-gray-100">

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
    import { successMessage, errorMessage, dialogBox, getError } from '@/Helpers/helper'
    import { trnsl } from '@/Lang/languages'
    import { ref } from 'vue'
    import axios from 'axios'
    import { onMounted } from 'vue'

    const props = defineProps({
        purchaseRequest: Object,
    })

    const emit = defineEmits([
        'event',
    ])

    const zeroPad = ( value, places ) => String(value).padStart(places, '0')

    const statuses = [
        {id: 1, name: trnsl('content.added') },
        {id: 2, name: trnsl('content.sent') },
        {id: 3, name: trnsl('content.rejected') },
        {id: 4, name: trnsl('content.accepted') },
    ]

    const event = {
        source: '',
        action: '',
        status: 0,
        data: null,
    }

    const cancel = () => {
        event.source = 'show'
        event.action = 'cancel'
        event.status = 0
        event.data = null
        emit('event', event)
    }
    
</script>