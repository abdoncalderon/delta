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

        <div class="m-2 p-2 border border-gray-400 rounded-lg  overflow-auto">
            
            <div class="my-2">
                <table class="min-w-full divide-y divide-gray-300 rounded-lg">

                    <thead class="bg-gray-600">
                        <tr class="tracking-wide">
                            <th class="px-2 py-1 text-xs text-white tracking-wider">
                                #
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
                        <tr v-for="(item, i) in needRequest.need_request_items" :key="i">
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
                                <SelectInput 
                                    :options="classes"
                                    v-model="itemClass[i]"
                                ></SelectInput>
                            </td>
                        </tr>
                    </tbody>

                </table>

            </div>
        </div>

        <div class="p-3 mt-2 flex justify-end bg-gray-100">

            <PrimaryButton
                @click="process"
                icon="fa fa-check"
            >
                {{ $trnsl('content.process') }}
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
    import InputLabel from '@/Components/InputLabel.vue'
    import TextInput from '@/Components/TextInput.vue'
    import TextArea from '@/Components/TextArea.vue'
    import SelectInput from '@/Components/SelectInput.vue'
    import { successMessage, errorMessage, getError, dialogBox } from '@/Helpers/helper'
    import { trnsl } from '@/Lang/languages'
    import { useForm } from '@inertiajs/vue3'
    import { ref } from 'vue'

    const props = defineProps({
        needRequest: Object,
        unities: Array,
    })

    const emit = defineEmits([
        'event',
    ])

    const form = useForm({
        'need_request_id': '',
        'needRequestItems': [],
    });

    const zeroPad = ( value, places ) => String(value).padStart(places, '0')

    const haveItems = ref(false)

    let itemClass = []


    const statuses = [
        {id: 1, name: trnsl('content.draft') },
        {id: 2, name: trnsl('content.sent') },
        {id: 3, name: trnsl('content.rejected') },
        {id: 4, name: trnsl('content.approved') },
        {id: 5, name: trnsl('messages.inProcess') },
        {id: 6, name: trnsl('content.delivered') },
    ]

    const classes = [
        {id: 1, name: trnsl('content.purchase') },
        {id: 2, name: trnsl('content.destocking') },
    ]

    let event = {
        source: '',
        action: '',
        status: 0,
        data: null,
    }

    

    const process = () => {
        form.need_request_id = props.needRequest.id
        props.needRequest.need_request_items.forEach( (row, i) => {
            row.class_id = itemClass[i]
            form.needRequestItems[i] = row
        });

        const dialog = dialogBox(trnsl('content.needRequest')+ ' ' + zeroPad(props.needRequest.id, 6), trnsl('messages.confirmProcessNeedRequestItems'))
        dialog.fire().then((result) =>{
            if(result.isConfirmed){
                form.status_id = 4
                form.post(route('commercial.controls.needRequests.process'), {
                    onSuccess: (data) => { 
                        successMessage(trnsl('messages.needRequestProcessed'))
                        event.source = 'classify'
                        event.action = 'process'
                        event.status = 1
                        event.data = data
                        emit('event', event)
                    },
                    onError: (errors) => {
                        errorMessage(trnsl('messages.needRequestNoProcessed') + '\n\r '+ getError(errors))
                        console.log(errors)
                    }
                })
            }
        });
    }

    const cancel = () => {
        event.source = 'classify'
        event.action = ''
        event.status = 0
        event.data = null
        emit('event', event)
    }

    const statusItems = ( value ) => {
        haveItems.value = value > 0
    }
    
</script>