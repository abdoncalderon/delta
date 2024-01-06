<template>
    <div class="border border-neutral-700 bg-gray-200 rounded-lg overflow-auto">

        <h3 class="px-3 py-3 font-semibold text-sm text-white bg-gray-700">
            {{ $trnsl('content.needRequest') + ' - # ' +  zeroPad(needRequest.id, 6) }}
        </h3>

        <div class="m-1 grid grid-cols-4 sm:grid-cols-6 gap-2 px-1 py-1">

           <div class="col-span-4 sm:col-span-3">
                <InputLabel 
                    for="zone" 
                    :value="trnsl('content.zone')"
                ></InputLabel>
                <TextInput 
                    id="zone"
                    v-model="needRequest.zone"
                    type="text"
                    :disabled="true"
                ></TextInput>
            </div>

            <div class="col-span-4 sm:col-span-3">
                <InputLabel 
                    for="location" 
                    :value="trnsl('content.block')"
                ></InputLabel>
                <TextInput 
                    id="location"
                    v-model="needRequest.location.name"
                    type="text"
                    :disabled="true"
                ></TextInput>
            </div> 

            <div class="col-span-4 sm:col-span-6">
                <InputLabel 
                    for="cost_account" 
                    :value="trnsl('content.costAccount')"
                ></InputLabel>
                <TextInput 
                    id="cost_account"
                    v-model="needRequest.cost_account"
                    type="text"
                    :disabled="true"
                ></TextInput>
            </div>

            <div class="col-span-4 sm:col-span-6">
                <InputLabel 
                    for="description" 
                    :value="trnsl('content.description')"
                ></InputLabel>
                <TextArea 
                    id="description" 
                    v-model="needRequest.description"
                    :disabled="true"
                    rows="4"
                ></TextArea>
            </div>

            <div class="col-span-4 sm:col-span-2" >
                <InputLabel 
                    for="expectedCost" 
                    :value="trnsl('content.expectedCost')"
                ></InputLabel>
                <TextInput 
                    id="expectedCost" 
                    v-model="needRequest.expectedCost"
                    type="number"
                    :disabled="true"
                ></TextInput>
            </div>
            
            <div class="col-span-4 sm:col-span-4">
                <InputLabel 
                    for="approver" 
                    :value="trnsl('content.approver')"
                ></InputLabel>
                <TextInput 
                    id="approver"
                    v-model="$page.props.auth.currentPerson.fullName"
                    type="text"
                    :disabled="true"
                ></TextInput>
            </div>

        </div>

        <div class="m-2 p-2 border border-gray-400 rounded-lg">
            <Items
                :need_request_id="needRequest.id"
                :needRequestItems="needRequest.need_request_items"
            />
        </div>

        <div class="p-3 mt-2 flex justify-end bg-gray-100">

            <PrimaryButton
                @click="approve"
                icon="fa fa-check"
            >
                {{ $trnsl('content.approve') }}
            </PrimaryButton>

            <SecondaryButton
                class="ml-3"
                icon="fa fa-ban"
                @click="reject"
                
            >
                {{ $trnsl('content.reject') }}
            </SecondaryButton>
            
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
    import InputLabel from '@/Components/InputLabel.vue'
    import TextInput from '@/Components/TextInput.vue'
    import TextArea from '@/Components/TextArea.vue'
    import Items from './Items.vue'
    import { successMessage, errorMessage, getError, dialogBox } from '@/Helpers/helper'
    import { trnsl } from '@/Lang/languages'
    import { useForm } from '@inertiajs/vue3';
    import { ref } from 'vue';

    const props = defineProps({
        needRequest: Object,
    })

    const emit = defineEmits([
        'event',
    ])

    const form = useForm({
        'status_id': '',
    });

    const zeroPad = ( value, places ) => String(value).padStart(places, '0')

    const haveItems = ref(false)

    const event = {
        source: '',
        action: ''
        status: 0,
        data: null,
    }

    const approve = () => {
        const dialog = dialogBox(trnsl('content.needRequest')+ ' ' + zeroPad(props.needRequest.id, 6), trnsl('messages.confirmApproveNeedRequest'))
        dialog.fire().then((result) =>{
            if(result.isConfirmed){
                form.status_id = 4
                form.patch(route('myApprovals.approve', props.needRequest.id), {
                    onSuccess: (data) => { 
                        successMessage(trnsl('messages.needRequestApproved'))
                        event.source = 'show'
                        event.action = 'approve'
                        event.status = 1
                        event.data = data
                        emit('event', event)
                    },
                    onError: (errors) => {
                        errorMessage(trnsl('messages.needRequestNoApproved') + '\n\r '+ getError(errors))
                        console.log(errors)
                    }
                })
            }
        });
        
    }

    const reject = () => {
        const dialog = dialogBox(trnsl('content.needRequest')+ ' ' + zeroPad(props.needRequest.id, 6), trnsl('messages.confirmRejectNeedRequest'))
        dialog.fire().then((result) =>{
            if(result.isConfirmed){
                form.status_id = 3
                form.patch(route('myApprovals.approve', props.needRequest.id), {
                    onSuccess: (data) => { 
                        successMessage(trnsl('content.needRequestRejected'))
                        event.source = 'show'
                        event.action = 'reject'
                        event.status = 1
                        event.data = data
                        emit('event', event)
                    },
                    onError: (errors) => {
                        errorMessage(trnsl('content.needRequestNoRejected') + '\n\r '+ getError(errors))
                        console.log(errors)
                    }
                })
            }
        });
        
    }

    const cancel = () => {
        event.source = 'show'
        event.action = 'cancel'
        event.status = 0
        event.data = null
        emit('event', event)
    }

    const statusItems = ( value ) => {
        haveItems.value = value > 0
    }

   
</script>