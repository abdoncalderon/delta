<template>
    <div class="border border-neutral-700 bg-gray-200 rounded-lg overflow-auto">

        <h3 class="px-3 py-3 font-semibold text-sm text-white bg-gray-700">
            {{ $trnsl('content.needRequest') + ' - # ' +  zeroPad(form.id, 6) }}
        </h3>

        <div class="m-1 grid grid-cols-4 sm:grid-cols-6 gap-2 px-1 py-1">

            <div class="col-span-4 sm:col-span-3">
                <InputLabel 
                    for="zone" 
                    :value="trnsl('content.zone')"
                    
                ></InputLabel>
                <SelectInput
                    id="zone"
                    :options="zones"
                    v-model="form.zone_id"
                    :disabled="true"
                ></SelectInput>
            </div>

            <div class="col-span-4 sm:col-span-3">
                <InputLabel 
                    for="location" 
                    :value="trnsl('content.block')"
                    
                ></InputLabel>
                <SelectInputDb 
                    :key="form.zone_id"
                    id="location"
                    v-model="form.location_id"
                    routeGet="/getLocations/"
                    :filterId="form.zone_id"
                    :withAdd="false"
                    :disabled="true"
                ></SelectInputDb>
                <InputError 
                    :message="form.errors.location_id"
                ></InputError>
            </div>

            <div class="col-span-4 sm:col-span-6">
                <InputLabel 
                    for="cost_account" 
                    :value="trnsl('content.costAccount')"
                    
                ></InputLabel>
                <SelectDynamic 
                    :options="cost_accounts"
                    v-model="form.cost_account_id"
                    show="name"
                    :disabled="false"
                ></SelectDynamic>
                <InputError 
                    :message="form.errors.cost_account_id"
                ></InputError>
            </div>

            <div class="col-span-4 sm:col-span-6">
                <InputLabel 
                    for="description" 
                    :value="trnsl('content.description')"
                    
                ></InputLabel>
                <TextArea 
                    id="description" 
                    v-model="form.description"
                    rows="3"
                ></TextArea>
                <InputError 
                    :message="form.errors.description"
                ></InputError>
            </div>

            <div class="col-span-4 sm:col-span-2" >
                <InputLabel 
                    for="expectedCost" 
                    :value="trnsl('content.expectedCost')"
                    
                ></InputLabel>
                <TextInput 
                    id="expectedCost" 
                    v-model="form.expectedCost"
                    type="number"
                    
                ></TextInput>
                <InputError 
                    :message="form.errors.expectedCost"
                ></InputError>
            </div>
            
            <div class="col-span-4 sm:col-span-4">
                <InputLabel 
                    for="approver" 
                    :value="trnsl('content.approver')"
                    
                ></InputLabel>
                <SelectDynamic 
                    :options="approvers"
                    v-model="form.approver_id"
                    show="fullName"
                    :disabled="false"
                ></SelectDynamic>
                <InputError 
                    :message="form.errors.approver_id"
                ></InputError>
            </div>

        </div>

        <div class="m-2 p-2 border border-gray-400 rounded-lg">
            <Items
                :need_request_id="form.id"
                :unities="unities"
                :needRequestItems="needRequestItems"
                :isShow="false"
                @event="getEvent"
            />
        </div>

        <div class="p-3 mt-2 flex justify-end bg-gray-100">

            <PrimaryButton
                :disabled="form.processing"
                @click="update"
                icon="fa fa-save"
            >
                {{ $trnsl('content.update') }}
            </PrimaryButton>

            <PrimaryButton
                v-if="haveItems"
                :disabled="form.processing"
                @click="send"
                icon="fa fa-arrow-right"
                class="ml-3"
            >
                {{ $trnsl('content.send') }}

            </PrimaryButton>
            <SecondaryButton
                class="ml-3"
                :disabled="form.processing"
                icon="fa-solid fa-circle-xmark"
                @click="cancel"
            >
                {{ $trnsl('content.cancel') }}
            </SecondaryButton>
        </div>

       
    </div>
</template>
<script setup>
    import PrimaryButton from '@/Components/PrimaryButton.vue' 
    import SecondaryButton from '@/Components/SecondaryButton.vue'
    import InputError from '@/Components/InputError.vue'
    import InputLabel from '@/Components/InputLabel.vue'
    import TextInput from '@/Components/TextInput.vue'
    import SelectInputDb from '@/Components/SelectInputDb.vue'
    import SelectDynamic from '@/Components/SelectDynamic.vue'
    import SelectInput from '@/Components/SelectInput.vue'
    import TextArea from '@/Components/TextArea.vue'
    import Items from './Items.vue'
    import { successMessage, errorMessage, getError, dialogBox } from '@/Helpers/helper'
    import { trnsl } from '@/Lang/languages'
    import { computed, onMounted, ref } from 'vue';

    const props = defineProps({
        form: Object,
        zones: Array,
        approvers: Array,
        cost_accounts: Array,
        unities: Array,
        needRequestItems: Array,
    })

    const emit = defineEmits([
        'event',
    ])

    const zeroPad = ( value, places ) => String(value).padStart(places, '0')

    const haveItems = ref(false)

    const event = {
        source: '',
        action: '',
        status: 0,
        data: null,
    }

    const update = () => {
        props.form.patch(route('myNeedRequests.update', props.form.id), {
            onSuccess: () => { 
                successMessage(trnsl('messages.recordSaved'))
                event.source = 'edit',
                event.action = 'update'
                event.status = 1 
                emit('event', event)
            },
            onError: (errors) => {
                errorMessage(trnsl('messages.recordNoSaved') + '\n\r '+ getError(errors))
                console.log(errors)
            }
        })
    }

    const send = () => {
        const dialog = dialogBox(trnsl('content.needRequest')+ ' ' + props.form.id, trnsl('messages.confirmSendNeedRequest'))
        dialog.fire().then((result) =>{
            if(result.isConfirmed){
                props.form.status_id = 2
                props.form.patch(route('myNeedRequests.send', props.form.id), {
                    onSuccess: () => { 
                        successMessage(trnsl('messages.needRequestSended'))
                        event.source = 'edit',
                        event.action = 'send'
                        event.status = 1 
                        emit('event', event)
                    },
                    onError: (errors) => {
                        errorMessage(trnsl('messages.needRequestNoSended') + '\n\r '+ getError(errors))
                        console.log(errors)
                    }
                })
            }
        });
        
    }

    const cancel = () => {
        event.source = 'edit',
        event.action = 'cancel'
        event.status = 1 
        emit('event', event)
    }

    const getEvent = ( event ) => {
        haveItems.value = event.data > 0
    }
   
</script>