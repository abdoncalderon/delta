<template>
    <Window
        :title="trnsl('content.needRequest')"
        @close=""
    >
        <template #body>

            <div class="m-1 grid grid-cols-4 sm:grid-cols-6 gap-2 px-1 py-1">

                <div class="col-span-4 sm:col-span-3">
                    <InputLabel 
                        for="zone" 
                        :value="trnsl('content.zone')"
                    ></InputLabel>
                    <SelectInput
                        id="zone"
                        :options="zones"
                        v-model="zone"
                    ></SelectInput>
                </div>

                <div class="col-span-4 sm:col-span-3">
                    <InputLabel 
                        for="location" 
                        :value="trnsl('content.block')"
                    ></InputLabel>
                    <SelectInputDb 
                        :key="zone"
                        id="location"
                        v-model="form.location_id"
                        routeGet="/getLocationsProjectUserByZone/"
                        :filterId="zone"
                        :withAdd="false"
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
                        :message="form.errors.approver_if"
                    ></InputError>
                </div>

            </div>

            <div class="p-3 mt-2 flex justify-end">
                <PrimaryButton
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
        
    </Window>
    
</template>
<script setup>
    import Window from '@/Components/Window.vue' 
    import PrimaryButton from '@/Components/PrimaryButton.vue' 
    import SecondaryButton from '@/Components/SecondaryButton.vue'
    import InputError from '@/Components/InputError.vue'
    import InputLabel from '@/Components/InputLabel.vue'
    import TextInput from '@/Components/TextInput.vue'
    import SelectInputDb from '@/Components/SelectInputDb.vue'
    import SelectDynamic from '@/Components/SelectDynamic.vue'
    import SelectInput from '@/Components/SelectInput.vue'
    import TextArea from '@/Components/TextArea.vue'
    import { successMessage, errorMessage, getError } from '@/Helpers/helper'
    import { trnsl } from '@/Lang/languages';
    import { ref, onMounted, reactive } from 'vue';

    const props = defineProps({
        form: Object,
        zones: Array,
        approvers: Array,
        cost_accounts: Array,
    })

    const emit = defineEmits([
        'event'   
    ])

    const zone = ref(0)

    const event = {
        source: '',
        action: '',
        status: 0,
        data: null,
    }


    const save = () => {
        props.form.post(route('myNeedRequests.store'), {
            onSuccess: () => { 
                successMessage(trnsl('messages.recordSaved'))
                event.source = 'new'
                event.action = 'save'
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

        emit('event', ['cancel', 0])
    }


</script>