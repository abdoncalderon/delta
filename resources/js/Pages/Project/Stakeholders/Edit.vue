<template>
    <div class="border border-neutral-700 rounded-lg overflow-auto">
        <h3 class="px-3 py-3 font-semibold text-sm text-white bg-gray-700">
            {{ $trnsl('messages.editStakeholder') }}
        </h3>
        
        <div class="m-1 grid grid-cols-4 sm:grid-cols-12 gap-2 px-1 py-1">

            <div class="col-span-4 sm:col-span-12">
                <InputLabel 
                    for="project" 
                    :value="trnsl('content.project')"
                    
                ></InputLabel>
                <TextInput 
                    id="project"
                    v-model="project.name"
                    type="text"
                    
                    :disabled="true"
                ></TextInput>
            </div>

            <div class="col-span-4 sm:col-span-8">
                <InputLabel 
                    for="name" 
                    :value="trnsl('content.name')"
                    
                ></InputLabel>
                <TextInput 
                    id="name"
                    v-model="form.name"
                    type="text"
                    
                    :disabled="false"
                ></TextInput>
                <InputError 
                    :message="form.errors.name"
                ></InputError>
            </div>

            <div class="col-span-4 sm:col-span-2">
                <InputLabel 
                    for="code" 
                    :value="trnsl('content.code')"
                    
                ></InputLabel>
                <TextInput 
                    id="code"
                    v-model="form.code"
                    type="text"
                    
                    :disabled="false"
                ></TextInput>
                <InputError 
                    :message="form.errors.code"
                ></InputError>
            </div>

            <div class="col-span-4 sm:col-span-2">
                <InputLabel 
                    for="taxId" 
                    :value="trnsl('content.taxId')"
                    
                ></InputLabel>
                <TextInput 
                    id="taxId"
                    v-model="form.taxId"
                    type="text"
                    
                    :disabled="false"
                ></TextInput>
                <InputError 
                    :message="form.errors.taxId"
                ></InputError>
            </div>

            <div class="col-span-4 sm:col-span-3">
                <InputLabel 
                    for="region" 
                    :value="trnsl('content.region')"
                    
                ></InputLabel>
                <SelectInput 
                    id="region"
                    :options="regions"
                    v-model="region"
                ></SelectInput>
            </div>

            <div class="col-span-4 sm:col-span-3">
                <InputLabel 
                    for="country" 
                    :value="trnsl('content.country')"
                    
                ></InputLabel>
                <SelectInputDb 
                    :key="region"
                    id="country"
                    v-model="country"
                    routeGet="/getCountries/"
                    :filterId="region"
                    :withAdd="false"
                ></SelectInputDb>
            </div>

            <div class="col-span-4 sm:col-span-3">
                <InputLabel 
                    for="state" 
                    :value="trnsl('content.state')"
                    
                ></InputLabel>
                <SelectInputDb 
                    :key="country"
                    id="state"
                    v-model="state"
                    routeGet="/getStates/"
                    :filterId="country"
                    :withAdd="false"
                    @change="setState"
                ></SelectInputDb>
            </div>
            
            <div class="col-span-4 sm:col-span-3">
                <InputLabel 
                    for="city" 
                    :value="trnsl('content.city')"
                    
                ></InputLabel>
                <SelectInputDb 
                    :key="state"
                    id="city"
                    v-model="form.city_id"
                    :formAdd="formCity"
                    :fieldsAdd="fieldsCity"
                    routeAdd="settings.cities.store"
                    routeGet="/getCities/"
                    :filterId="state"
                    :withAdd="true"
                ></SelectInputDb>
                <InputError 
                    :message="form.errors.city_id"
                ></InputError>
            </div>

            <div class="col-span-4 sm:col-span-8">
                <InputLabel 
                    for="address" 
                    :value="trnsl('content.address')"
                    
                ></InputLabel>
                <TextInput 
                    id="address"
                    v-model="form.address"
                    type="text"
                    
                    :disabled="false"
                ></TextInput>
                <InputError 
                    :message="form.errors.address"
                ></InputError>
            </div>

            <div class="col-span-4 sm:col-span-2">
                <InputLabel 
                    for="zipCode" 
                    :value="trnsl('content.zipCode')"
                    
                ></InputLabel>
                <TextInput 
                    id="zipCode"
                    v-model="form.zipCode"
                    type="text"
                    
                    :disabled="false"
                ></TextInput>
                <InputError 
                    :message="form.errors.zipCode"
                ></InputError>
            </div>

            <div class="col-span-4 sm:col-span-2">
                <InputLabel 
                    for="phoneNumber" 
                    :value="trnsl('content.phoneNumber')"
                    
                ></InputLabel>
                <TextInput 
                    id="phoneNumber"
                    v-model="form.phoneNumber"
                    type="text"
                    
                    :disabled="false"
                ></TextInput>
                <InputError 
                    :message="form.errors.phoneNumber"
                ></InputError>
            </div>

            <div class="col-span-4 sm:col-span-4">
                <InputLabel 
                    for="email" 
                    :value="trnsl('content.email')"
                    
                ></InputLabel>
                <TextInput 
                    id="email"
                    v-model="form.email"
                    type="text"
                    
                    :disabled="false"
                ></TextInput>
                <InputError 
                    :message="form.errors.email"
                ></InputError>
            </div>

            <div class="col-span-4 sm:col-span-4">
                <InputLabel 
                    for="logofile" 
                    :value="trnsl('content.logo')"
                    
                ></InputLabel>
                <TextInput 
                    id="logofile"
                    type="file"
                    accept="image/png, .jpg"
                    class="mt-1 p-1 text-xs"
                    @input="form.logofile = $event.target.files[0]"
                    :disabled="false"
                ></TextInput>
                <InputError 
                    :message="form.errors.logofile"
                ></InputError>
            </div>

            <div class="col-span-4 sm:col-span-4">
                <InputLabel 
                    for="stakeholder_type" 
                    :value="trnsl('content.type')"
                    
                ></InputLabel>
                <SelectInput 
                    id="stakeholder_type"
                    :options="stakeholder_types"
                    v-model="form.stakeholder_type_id"
                ></SelectInput>
                <InputError 
                    :message="form.errors.stakeholder_type_id"
                ></InputError>
            </div>
            
        </div>

        <div class="p-3 mt-2 flex justify-end bg-gray-100">
            <PrimaryButton
                :disabled="form.processing"
                @click="update"
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
    import PrimaryButton from '@/Components/PrimaryButton.vue' 
    import SecondaryButton from '@/Components/SecondaryButton.vue'
    import InputError from '@/Components/InputError.vue'
    import InputLabel from '@/Components/InputLabel.vue'
    import TextInput from '@/Components/TextInput.vue'
    import SelectInput from '@/Components/SelectInput.vue'
    import SelectInputDb from '@/Components/SelectInputDb.vue'
    import SelectDynamic from '@/Components/SelectDynamic.vue'
    import TextArea from '@/Components/TextArea.vue'
    import { successMessage, errorMessage, dialogBox } from '@/Helpers/helper'
    import { useForm } from '@inertiajs/vue3';
    import { trnsl } from '@/Lang/languages';
    import { ref, onMounted, reactive } from 'vue';
    import axios from 'axios'

    const props = defineProps({
        form: Object,
        project: Object,
        regions: Array,
    })

    const emit = defineEmits([
        'event'   
    ])

    const formCity = useForm({
        'id': '',
        'name': '',
        'state_id': '',
    });

    const region = ref(0)
    const country = ref(0)
    const state = ref(0)

    const fieldsCity = [
        {name: 'name', type: 'text', text: trnsl('content.name'), style: 'sm:col-span-4', length: 255, disabled: false },
    ];

    const stakeholder_types = [
        {id: 1, name: trnsl('content.contractor')},
        {id: 2, name: trnsl('content.client')},
        {id: 3, name: trnsl('content.inspector')},
        {id: 4, name: trnsl('content.supplier')},
    ]

    const event = {
        source: '',
        action: '',
        status: 0,
        data: null,
    }

    const update = () => {
        props.form.post(route('project.stakeholders.update', props.form.id ), {
            onSuccess: () => { 
                successMessage(trnsl('messages.recordUpdated'))
                event.source = 'edit'
                event.action = 'update'
                event.status = 1
                emit('event', event)
            },
            onError: (errors) => {
                successMessage(trnsl('messages.recordNoUpdated'))
                console.log(errors)
            }
        })
    }

    const cancel = () => {
        event.source = 'edit'
        event.action = 'cancel'
        event.status = 1
        emit('event', event)
    }

    const setState = ( value ) => {
        formCity.state_id = value
    }

    onMounted(()=>{
        region.value = props.form.region_id
        country.value = props.form.country_id
        state.value = props.form.state_id
        setState( state.value )
      
    })

    

</script>