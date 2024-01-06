<template>
    <Window 
        :title="trnsl('content.assignShiftsToEmployees')"
        @close="cancel"
    >
        <template #body>

            <div class="m-2 grid grid-cols-1 sm:grid-cols-12 gap-2">

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

                <div class="col-span-1 sm:col-span-8">
                    <InputLabel 
                        for="employees" 
                        :value="trnsl('content.employees')"
                    ></InputLabel>
                    <SelectMultiple
                        :key="reload"
                        :list="form.employees"
                        :data="stakeholderPeople"
                        height="230px"
                    />
                </div> 

                <div class="col-span-1 sm:col-span-4">
                    <div class="grid grid-cols-1 sm:grid-cols-12 gap-2">
                        <div class="col-span-1 sm:col-span-6">
                            <InputLabel 
                                for="since" 
                                :value="trnsl('content.since')"
                            ></InputLabel>
                            <TextInput 
                                id="since" 
                                v-model="form.since"
                                type="date"
                            ></TextInput>
                        </div>
                        <div class="col-span-1 sm:col-span-6">
                            <InputLabel 
                                for="until" 
                                :value="trnsl('content.until')"
                            ></InputLabel>
                            <TextInput 
                                id="until" 
                                v-model="form.until"
                                type="date"
                            ></TextInput>
                        </div>
                        <div class="col-span-1 sm:col-span-12">
                            <InputLabel 
                                for="shifts" 
                                :value="trnsl('content.shift')"
                            ></InputLabel>
                            <SelectInput 
                                :options="shifts"
                                v-model="form.shift_id"
                            ></SelectInput>
                        </div> 
                    </div>

                </div>

            </div>
            <div class="p-3 mt-2 flex justify-end bg-gray-100">
                <PrimaryButton
                    :disabled="form.processing"
                    @click="assignShifts"
                    icon="fa fa-save"
                >
                    {{ trnsl('content.assign') }}
                </PrimaryButton>
                <SecondaryButton
                    class="ml-3"
                    :disabled="form.processing"
                    icon="fa-solid fa-circle-xmark"
                    @click="cancel"
                >
                    {{ trnsl('content.cancel') }}
                </SecondaryButton>
            </div>
        </template>

    </Window>
    
</template>


<script setup>
    import Window from '@/Components/Window.vue'
    import PrimaryButton from '@/Components/PrimaryButton.vue' 
    import SecondaryButton from '@/Components/SecondaryButton.vue'
    import InputError from '@/Components/InputError.vue'
    import InputLabel from '@/Components/InputLabel.vue'
    import TextInput from '@/Components/TextInput.vue'
    import SelectInput from '@/Components/SelectInput.vue'
    import SelectMultiple from '@/Components/SelectMultiple.vue'
    import { successMessage, errorMessage, dialogBox, getError } from '@/Helpers/helper'
    import { useForm, usePage } from '@inertiajs/vue3';
    import { trnsl } from '@/Lang/languages';
    import { ref, onMounted, reactive } from 'vue';
    import dayjs from 'dayjs';
    import axios from 'axios'

    const props = defineProps({
        shifts: Array,
        stakeholders: Array,
    })

    const form = useForm({
        'shift_id': 1,
        'employees': [],
        'since': dayjs(undefined).format('YYYY-MM-DD'),
        'until': dayjs(undefined).format('YYYY-MM-DD'),
    })

    const emit = defineEmits([
        'event'   
    ])

    const stakeholder = ref(0)
    const reload = ref(0)

    let stakeholderPeople = []

    const event = {
        source: 'assign',
        action: '',
        status: 0,
        data: null,
    }

    const cancel = () => {
        event.action = 'cancel'
        event.status = 0
        emit('event', event)
    }
      

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

    const assignShifts = () => {
        if (form.shift_id > 0) {
            const dialog = dialogBox( trnsl('content.assignShiftsToEmployees'), trnsl('messages.confirmAssignShiftsToEmployees'))
            dialog.fire().then((result) =>{
                if(result.isConfirmed){
                    form.post(route('people.timesheet.shifts.assign'),{
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