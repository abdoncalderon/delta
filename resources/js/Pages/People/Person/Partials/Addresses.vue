<template>
    <div class="m-2">
        <ToolBar
            :icons="icons"
            @click="clickIconToolBar"
        />
    </div>
        
    

        
    <!-- Address Form -->

    <div v-if="showNew" class="mb-1 border border-gray-500 rounded-md">
        
        <h3 class="px-3 py-1 text-xs text-white bg-gray-600">
            {{ $trnsl('content.addresses') }}
        </h3>

        <div class="m-2 grid sm:grid-cols-12 gap-2">

            <div class="col-span-1 sm:col-span-3">
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

            <div class="col-span-1 sm:col-span-3">
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

            <div class="col-span-1 sm:col-span-3">
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

            <div class="col-span-1 sm:col-span-3">
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

            <div class="col-span-1 sm:col-span-10">
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

            <div class="col-span-1 sm:col-span-2">
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

        </div>

        <div class="mx-2 mt-4 mb-3 flex justify-end">
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

    </div>

    <!-- Address List -->

    <div class="m-2 rounded-md overflow-auto">
        <table :key="reload" class="w-full mb-2 divide-y divide-gray-300 overscrool-x-auto">

            <thead class="bg-gray-600">
                <tr class="tracking-wide">
                    <th class="px-4 py-1 text-xs text-white ">
                        {{ trnsl('content.city') }}
                    </th>
                    <th class="px-4 py-1 text-xs text-white ">
                        {{ trnsl('content.address') }}
                    </th>
                    <th class="px-4 py-1 text-xs text-white ">
                        {{ trnsl('content.actions') }}
                    </th>
                </tr>
            </thead>

            <tbody class="bg-white divide-y divide-gray-300">
                <tr v-for="(address, i) in addresses" :key="i">
                    <td class=" px-4 py-1 text-xs text-gray-500 text-start">
                        {{ address.city.name }}
                    </td>
                    <td class="px-4 py-1 text-xs text-gray-500 text-start">
                        {{ address.address }}
                    </td>
                    <td class="px-4 py-1 text-xs text-gray-500 text-center">
                        <span class="inline-flex overflow-hidden rounded-md border bg-white shadow-sm">
                            <button 
                                class="inline-block border-e px-2 py-1 text-red-600 hover:bg-gray-50 focus:relative"
                                :title="trnsl('content.delete')"
                                @click="deleteAddress(address)"
                            >
                                <i class="fa fa-trash"></i>
                            </button>
                        </span>
                        
                    </td>
                </tr>
            </tbody>

        </table>
    </div>
        
</template>
<script setup>
    import ToolBar from '@/Components/ToolBar.vue'
    import PrimaryButton from '@/Components/PrimaryButton.vue' 
    import SecondaryButton from '@/Components/SecondaryButton.vue'
    import InputError from '@/Components/InputError.vue'
    import InputLabel from '@/Components/InputLabel.vue'
    import TextInput from '@/Components/TextInput.vue'
    import SelectInput from '@/Components/SelectInput.vue'
    import SelectInputDb from '@/Components/SelectInputDb.vue'
    import { trnsl } from '@/Lang/languages';
    import { useForm } from '@inertiajs/vue3';
    import { ref, reactive, onMounted } from 'vue';
    import { successMessage, errorMessage, dialogBox, getError } from '@/Helpers/helper'
    import axios from 'axios';

    const props = defineProps({
        person: Object,
        regions: Array,
    })

    const form = useForm({
        'id': '',
        'person_id': '',
        'region_id': '',
        'country_id': '',
        'state_id': '',
        'city_id': '',
        'address': '',
        'postalCode': '',
    })

    const formCity = useForm({
        'id': '',
        'name': '',
        'state_id': '',
    })

    const reload = ref(0)
    const showNew = ref(false)
    const region = ref(0)
    const country = ref(0)
    const state = ref(0)
    let addresses = []

    const fieldsCity = [
        {name: 'name', type: 'text', text: trnsl('content.name'), style: 'sm:col-span-4', length: 255, disabled: false },
    ]

    const icons = [
        {name: 'new', text: trnsl('content.new'), icon: 'fa fa-plus', hidden: false},
    ]

    const deleteAddress = ( address ) => {
        const dialog = dialogBox(address.address, trnsl('messages.confirmDelete'))
        dialog.fire().then((result) =>{
            if(result.isConfirmed){
                form.delete(route('people.addresses.destroy', address.id),{
                    onSuccess: () => { 
                        successMessage(trnsl('messages.recordDeleted'))
                        getAddresses()
                    },
                    onError: () => {
                        errorMessage(trnsl('messages.recordNoDeleted'))
                    }
                })
            }
        })
    }

    const save = () => {
        form.post(route('people.addresses.store'), {
            onSuccess: ( data ) => { 
                successMessage(trnsl('messages.recordSaved'))
                showNew.value = false
                getAddresses()
            },
            onError: (errors) => {
                errorMessage(trnsl('messages.recordNoSaved') + '\n\r '+ getError(errors))
                console.log(errors)
            }
        })
    }

    const cancel = () => {
        showNew.value = false
        reload += 1
    }

    const getAddresses = () => {
        addresses.length = 0
        axios.get(route('people.addresses.getAddresses', props.person.id))
            .then(response=>{
                
                addresses = response.data
                reload.value += 1;
            })
            .catch(error=>{
                console.log(error)
            })
    } 

    const setState = ( value ) => {
        formCity.state_id = value
    }

    const clickIconToolBar = (button) => {
        if (button === 'new') {
            form.person_id = props.person.id
            showNew.value = true
        } 
    }

    onMounted(()=>{
        getAddresses()
    })
</script>