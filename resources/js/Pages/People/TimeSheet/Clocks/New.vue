<template>

    <div>
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
                    @keyup="validateIpAddress"
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
                ></TextInput>
                <InputError 
                    :message="form.errors.port"
                ></InputError>
            </div>

        </div>

        <div class="p-2 flex justify-end">
            
            <PrimaryButton
                v-if="showConnectionTest"
                class="ml-3"
                :disabled="form.processing"
                @click="connectionTest"
                icon="fa fa-plug"
            >
                {{ $trnsl('content.connectionTest') }}
            </PrimaryButton>
            <PrimaryButton
                v-if="isConnected"
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

    </div>
    
</template>

<script setup>
    
    import InputError from '@/Components/InputError.vue'
    import InputLabel from '@/Components/InputLabel.vue'
    import TextInput from '@/Components/TextInput.vue'
    import PrimaryButton from '@/Components/PrimaryButton.vue' 
    import SecondaryButton from '@/Components/SecondaryButton.vue'
    import { successMessage, errorMessage, getError } from '@/Helpers/helper'
    import { useForm } from '@inertiajs/vue3';
    import { ref, onMounted } from 'vue';
    import { trnsl } from '@/Lang/languages';

    const props = defineProps({
        project_id: Number,
    })

    const emit = defineEmits([
        'event'   
    ])

    const form = useForm({
        'name': '',
        'ipAddress': '',
        'port': '4370',
        'project_id': '',
    })

    const showConnectionTest = ref(false)
    const isConnected = ref(false)

    const event = {
        source: '',
        action: '',
        status: 0,
        data: null,
    }

    const validateIpAddress = () => {
        if (form.ipAddress.length > 0) {
            showConnectionTest.value = true
        } else { 
            showConnectionTest.value = false 
        }
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

    const connectionTest = () => {
        axios.get(route('people.timesheet.clocks.isConnected', [form.ipAddress , form.port]))
            .then(response=>{
                let result = response.data 
                console.log(result)
                if (result) {
                    isConnected.value = true
                    successMessage(trnsl('messages.successfullConnection'))
                }
            })
            .catch(error=>{
                isConnected.value = false
                errorMessage(error.message)
            })
    }

    const cancel = () => {
        event.source = 'new'
        event.action = 'cancel'
        event.status = 1
        emit('event', event)
    }  
    
    onMounted(() => {
        form.project_id = props.project_id
        
    }) 

</script>