<template>

    <div class="m-2">
        
        <div class="my-2 grid grid-cols-1 sm:grid-cols-12 gap-2">
            
            <div class="col-span-1 sm:col-span-12">
                <InputLabel 
                    for="stakeholder" 
                    :value="trnsl('content.company')"
                ></InputLabel>
                <SelectInput 
                    :options="stakeholders"
                    v-model="stakeholder"
                    @change="getStakeholderPeople"
                ></SelectInput>
            </div>

            <div class="col-span-1 sm:col-span-6">
                <InputLabel 
                    for="users" 
                    :value="trnsl('content.users')"
                ></InputLabel>
                <SelectMultiple
                    :key="reload"
                    :list="form.users"
                    :data="stakeholderPeople"
                    height="300px"
                />
            </div> 

            <div class="col-span-1 sm:col-span-6">
                <InputLabel 
                    for="clocks" 
                    :value="trnsl('content.clocks')"
                ></InputLabel>
                <SelectMultiple
                    :list="form.clocks"
                    :data="clocks"
                    height="300px"
                />
            </div> 
        </div>

        <div class="flex justify-end">
            <PrimaryButton
                class="ml-3"
                :disabled="form.processing"
                @click="uploadUsers"
                icon="fa fa-upload"
            >
                {{ $trnsl('content.upload') }}
            </PrimaryButton>
        </div>

    </div>

</template>

<script setup>
    
    import SelectMultiple from '@/Components/SelectMultiple.vue'
    import SelectInput from '@/Components/SelectInput.vue'
    import InputLabel from '@/Components/InputLabel.vue'
    import PrimaryButton from '@/Components/PrimaryButton.vue'
    import { trnsl } from '@/Lang/languages';
    import { useForm, Head, usePage, router } from '@inertiajs/vue3';
    import { successMessage, errorMessage, getError, dialogBox } from '@/Helpers/helper'
    import { ref, computed } from 'vue';
    import axios from 'axios'
    

    const props = defineProps({
        clocks: Array,
        stakeholders: Array,
    })

    const form = useForm({
        'clocks': [],
        'users': [],
    })

    const reload = ref(0)

    const stakeholder = ref(0)

    let stakeholderPeople = []

    const getStakeholderPeople = () => {
        stakeholderPeople.length = 0
        axios.get(route('people.contracts.getStakeholderPeople',stakeholder.value))
            .then(response=>{
                stakeholderPeople = response.data
                reload.value += 1
            })
            .catch(error=>{
                console.log(error)
            })
    }

    const uploadUsers = () => {
        if ((form.users.length > 0) && (form.clocks.length > 0)){
            const dialog = dialogBox( trnsl('content.uploadUsers'), trnsl('messages.confirmUploadUsersToClock'))
            dialog.fire().then((result) =>{
                if(result.isConfirmed){
                    form.post(route('people.timesheet.users.upload'),{
                        onSuccess: () => { 
                            successMessage(trnsl('messages.successfullOperation'))
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