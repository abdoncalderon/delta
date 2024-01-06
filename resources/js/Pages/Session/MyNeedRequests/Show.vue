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
                <TextInput 
                    id="location"
                    v-model="form.location"
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
                    v-model="form.cost_account"
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
                    v-model="form.description"
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
                    v-model="form.expectedCost"
                    type="number"
                    
                    :disabled="true"
                ></TextInput>
            </div>
            
            <div class="col-span-4 sm:col-span-4">
                <InputLabel 
                    for="approver" 
                    :value="trnsl('content.approver')"
                    
                ></InputLabel>
                <SelectInput
                    id="approver"
                    :options="approvers"
                    v-model="form.approver_id"
                    :disabled="true"
                    showField="fullName"
                ></SelectInput>
                
            </div>

        </div>

        <div class="m-2 p-2 border border-gray-400 rounded-lg">
            <Items
                :need_request_id="form.id"
                :unities="unities"
                :needRequestItems="needRequestItems"
                @event="getEvent"
                :isShow="true"
            />
        </div>

        <div class="p-3 mt-2 flex justify-end bg-gray-100">
            
            <SecondaryButton
                class="ml-3"
                :disabled="form.processing"
                icon="fa-solid fa-circle-xmark"
                @click="cancel"
            >
                {{ $trnsl('content.exit') }}
            </SecondaryButton>
        </div>

    </div>

</template>
<script setup>
    import SecondaryButton from '@/Components/SecondaryButton.vue'
    import InputLabel from '@/Components/InputLabel.vue'
    import TextInput from '@/Components/TextInput.vue'
    import SelectInput from '@/Components/SelectInput.vue'
    import TextArea from '@/Components/TextArea.vue'
    import Items from './Items.vue'
    import { trnsl } from '@/Lang/languages'
    import { ref } from 'vue';

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