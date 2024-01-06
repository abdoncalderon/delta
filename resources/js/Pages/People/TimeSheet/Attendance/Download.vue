<template>
    <div>
        <div class="p-2 grid grid-cols-1 sm:grid-cols-12 gap-2">
            
            <div class="col-span-1 sm:col-span-12">
                <InputLabel 
                    for="clocks" 
                    :value="trnsl('content.clocks')"
                ></InputLabel>
                <SelectMultiple
                    :list="form.clocks"
                    :data="clocks"
                    height="340px"
                />
            </div> 
            
            
        </div>
        <div class="p-3 mt-2 flex justify-end bg-gray-100">
            <PrimaryButton
                :disabled="form.processing"
                icon="fa fa-save"
                @click="downloadEVents"
            >
                {{ $trnsl('content.download') }}
            </PrimaryButton>
            <SecondaryButton
                class="ml-3"
                :disabled="form.processing"
                icon="fa fa-ban"
                @click="cancel"
            >
                {{ $trnsl('content.cancel') }}
            </SecondaryButton>
        </div>
    </div>
</template>

<script setup>

    import InputLabel from '@/Components/InputLabel.vue'
    import SelectMultiple from '@/Components/SelectMultiple.vue'
    import PrimaryButton from '@/Components/PrimaryButton.vue' 
    import SecondaryButton from '@/Components/SecondaryButton.vue'
    import TextInput from '@/Components/TextInput.vue'
    import { trnsl } from '@/Lang/languages';
    import { useForm, Head, usePage, router } from '@inertiajs/vue3';
    import { successMessage, errorMessage, getError, dialogBox } from '@/Helpers/helper'
    import { ref, computed } from 'vue';
    import axios from 'axios'

    const props = defineProps({
        clocks: Array,
        
    })

    const emit = defineEmits([
        'event'   
    ])

    const form = useForm({
        'clocks': [],
    })

    const event = {
        source: '',
        action: '',
        status: 0,
        data: null,
    }

    const cancel = () => {
        event.source = 'new'
        event.action = 'cancel'
        event.status = 1
        emit('event', event)
    } 

    const downloadEVents = () => {
        if (form.clocks.length > 0){
            const dialog = dialogBox( trnsl('content.downloadEvents'), trnsl('messages.confirmDownloadEventsFromClock'))
            dialog.fire().then((result) =>{
                if(result.isConfirmed){
                    form.post(route('people.timesheet.attendance.download'),{
                        onSuccess: () => { 
                            successMessage(trnsl('messages.successfullOperation'))
                            event.source = 'download'
                            event.action = 'download'
                            event.status = 1
                            emit('event', event)
                        },
                        onError: (errors) => {
                            errorMessage(trnsl('content.error') + '\n\r '+ getError(errors))
                            console.log(errors)
                        }
                    })
                }
            })
        }
        
    }
</script>