<template>
    
    <div class="m-1 px-1 py-1 grid grid-cols-12 sm:grid-cols-12 gap-2">

        <div class="col-span-12 sm:col-span-12" >
            <InputLabel 
                for="name" 
                :value="trnsl('content.name')"
            ></InputLabel>
            <TextInput 
                id="name" 
                v-model="form.name"
                type="text"
            ></TextInput>
            <InputError 
                :message="form.errors.name"
            ></InputError>
        </div>

        <div class="col-span-12 sm:col-span-8" >
            <InputLabel 
                for="ipAddress" 
                :value="trnsl('content.ipAddress')"
            ></InputLabel>
            <TextInput 
                id="ipAddress" 
                v-model="form.ipAddress"
                type="text"
                size="15"
                :disabled="true"
            ></TextInput>
            <InputError 
                :message="form.errors.ipAddress"
            ></InputError>
        </div>

        <div class="col-span-12 sm:col-span-4" >
            <InputLabel 
                for="port" 
                :value="trnsl('content.port')"
            ></InputLabel>
            <TextInput 
                id="port" 
                v-model="form.port"
                type="text"
                size="5"
                :disabled="true"
            ></TextInput>
            <InputError 
                :message="form.errors.port"
            ></InputError>
        </div>

    </div>

    <hr>

    <div class="my-2 px-2 grid grid-cols-12 sm:grid-cols-12 gap-2">
        <div class="col-span-12 sm:col-span-6" >
            <button class="w-full px-2 py-1 text-xs text-white bg-gray-700 rounded" @click="connectionTest">
                {{ trnsl('content.connectionTest') }}
            </button>
        </div>
        <div class="col-span-12 sm:col-span-6" >
            <button class="w-full px-2 py-1 text-xs text-white bg-gray-700 rounded" @click="clearUsers">
                {{ trnsl('content.clearUsers') }}
            </button>
        </div>
        <div class="col-span-12 sm:col-span-6" >
            <button class="w-full px-2 py-1 text-xs text-white bg-gray-700 rounded" @click="clearEvents">
                {{ trnsl('content.clearEvents') }}
            </button>
        </div>
        <div class="col-span-12 sm:col-span-6" >
            <button class="w-full px-2 py-1 text-xs text-white bg-gray-700 rounded" @click="setDateTime">
                {{ trnsl('content.synchronizeDateTime') }}
            </button>
        </div>
        
    </div>


    <hr>

    <div class="p-2 flex justify-end">
        
        

        <PrimaryButton
            class="ml-3"
            :disabled="form.processing"
            @click="save"
            icon="fa fa-save"
        >
            {{ $trnsl('content.save') }}
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

</template>

<script setup>

    import InputError from '@/Components/InputError.vue'
    import InputLabel from '@/Components/InputLabel.vue'
    import TextInput from '@/Components/TextInput.vue'
    import PrimaryButton from '@/Components/PrimaryButton.vue' 
    import SecondaryButton from '@/Components/SecondaryButton.vue'
    import { successMessage, errorMessage, dialogBox, getError } from '@/Helpers/helper'
    import { useForm } from '@inertiajs/vue3';
    import { ref, onMounted } from 'vue';
    import { trnsl } from '@/Lang/languages';

    const props = defineProps({
        clock: Object,
    })

    const emit = defineEmits([
        'event'   
    ])

    const form = useForm({
        'id': '',
        'name': '',
        'ipAddress': '',
        'port': '',
        'project_id': '',
    })

    const event = {
        source: '',
        action: '',
        status: 0,
        data: null,
    }

    const save = () => {
        form.post(route('people.timesheet.clocks.store'), {
            onSuccess: () => { 
                successMessage(trnsl('messages.recordSaved'))
                event.source = 'new'
                event.action = 'store'
                event.status = 1
                emit('event', event)
            },
            onError: (errors) => {
                errorMessage(trnsl('messages.recordNoSaved') + '\n\r '+ getError(errors))
                console.log(errors)
            }
        })
    }

    const cancel = () => {
        event.source = 'new'
        event.action = 'cancel'
        event.status = 1
        emit('event', event)
    }

    const connectionTest = () => {
        axios.get(route('people.timesheet.clocks.isConnected', [props.clock.ipAddress , props.clock.port]))
            .then(response=>{
                let result = response.data 
                console.log(result)
                if (result) {
                    successMessage(trnsl('messages.successfullConnection'))
                }
            })
            .catch(error=>{
                errorMessage(error.message)
            })
    }

    const clearUsers = () => {
        const dialog = dialogBox(props.clock.name, trnsl('messages.confirmClearClockUsers'))
        dialog.fire().then((result) =>{
            if(result.isConfirmed){
                axios.get(route('people.timesheet.clocks.clearUsers', props.clock))
                    .then(response=>{
                        console.log(response.data)
                        successMessage(trnsl('messages.successfullOperation'))
                    })
                    .catch(error=>{
                        errorMessage(error.message)
                        console.log(error.message)
                    })
            }
        });
    }

    const clearEvents = () => {
        const dialog = dialogBox(props.clock.name, trnsl('messages.confirmClearClockEvents'))
        dialog.fire().then((result) =>{
            if(result.isConfirmed){
                axios.get(route('people.timesheet.clocks.clearEvents', props.clock))
                    .then(response=>{
                        let result = response.data 
                        if (result) {
                            successMessage(trnsl('messages.successfullOperation'))
                        }
                    })
                    .catch(error=>{
                        errorMessage(error.message)
                        console.log(error.message)
                    })
            }
        });
    }

    const setDateTime = () => {
        axios.get(route('people.timesheet.clocks.setTime', props.clock))
            .then(response=>{
                let result = response.data 
                if (result) {
                    successMessage(trnsl('messages.successfullOperation'))
                }
            })
            .catch(error=>{
                errorMessage(error.message)
                console.log(error.message)
            })
    }

    onMounted(() => {
        form.id = props.clock.id
        form.name = props.clock.name
        form.ipAddress = props.clock.ipAddress
        form.port = props.clock.port
        form.project_id = props.clock.project_id
    }) 

</script>