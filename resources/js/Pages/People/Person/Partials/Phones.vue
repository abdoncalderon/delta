<template>

    <!-- ToolBar -->

    <div class="m-2">
        <ToolBar
            :icons="icons"
            @click="clickIconToolBar"
        />
    </div>
        
    <!-- Phones Form -->

    <div v-if="showNew" class="m-2 border border-gray-500 rounded-md">
        
        <h3 class="px-3 py-1 text-xs text-white bg-gray-600">
            {{ $trnsl('content.phones') }}
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
                    v-model="form.country_id"
                    :formAdd="formCountry"
                    :fieldsAdd="fieldsCountry"
                    routeAdd="settings.countries.store"
                    routeGet="/getCountries/"
                    :filterId="region"
                    :withAdd="true"
                ></SelectInputDb>
                <InputError 
                    :message="form.errors.city_id"
                ></InputError>
            </div>

            <div class="col-span-1 sm:col-span-3">
                <InputLabel 
                    for="type" 
                    :value="trnsl('content.type')"
                ></InputLabel>
                <SelectInput 
                    id="type"
                    :options="types"
                    v-model="form.type_id"
                ></SelectInput>
                <InputError 
                    :message="form.errors.type_id"
                ></InputError>
            </div>

            <div class="col-span-1 sm:col-span-3">
                <InputLabel 
                    for="number" 
                    :value="trnsl('content.number')"
                ></InputLabel>
                <TextInput 
                    id="number"
                    v-model="form.number"
                    type="text"
                    :disabled="false"
                ></TextInput>
                <InputError 
                    :message="form.errors.number"
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

    <!-- Phone List -->

    <div class="m-2 rounded-md overflow-auto">
        
        <table :key="reload" class="w-full mb-2 divide-y divide-gray-300 overscrool-x-auto">

            <thead class="bg-gray-600">
                <tr class="tracking-wide">
                    <th class="px-4 py-1 text-xs text-white ">
                        {{ trnsl('content.country') }}
                    </th>
                    <th class="px-4 py-1 text-xs text-white ">
                        {{ trnsl('content.phone') }}
                    </th>
                    <th class="px-4 py-1 text-xs text-white ">
                        {{ trnsl('content.actions') }}
                    </th>
                </tr>
            </thead>

            <tbody class="bg-white divide-y divide-gray-300">
                <tr v-for="(phone, i) in phones" :key="i">
                    <td class=" px-4 py-1 text-xs text-gray-500 text-start">
                        {{ phone.country }}
                    </td>
                    <td class="px-4 py-1 text-xs text-gray-500 text-start">
                        {{ phone.number }}
                    </td>
                    <td class="px-4 py-1 text-xs text-gray-500 text-center">
                        <span class="inline-flex overflow-hidden rounded-md border bg-white shadow-sm">
                            <button 
                                class="inline-block border-e px-2 py-1 text-red-600 hover:bg-gray-50 focus:relative"
                                :title="trnsl('content.delete')"
                                @click="deletePhone(phone)"
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
    import { ref, onMounted } from 'vue';
    import { successMessage, errorMessage, dialogBox, getError } from '@/Helpers/helper'
    import axios from 'axios';

    const props = defineProps({
        person: Object,
        regions: Array,
    })

    const form = useForm({
        'id': '',
        'person_id': '',
        'country_id': '',
        'type_id': '',
        'number': '',
    })

    const formCountry = useForm({
        'id': '',
        'name': '',
        'state_id': '',
    })

    const reload = ref(0)
    const showNew = ref(false)
    const region = ref(0)
    
    let phones = []

    const fieldsCountry = [
        {name: 'name', type: 'text', text: trnsl('content.name'), style: 'sm:col-span-4', length: 255 },
        {name: 'code', type: 'text', text: trnsl('content.code'), style: 'sm:col-span-1', length: 255 },
        {name: 'ccc', type: 'text', text: 'CCC', style: 'sm:col-span-1', length: 255 },
    ]

    const icons = [
        {name: 'new', text: trnsl('content.new'), icon: 'fa fa-plus', hidden: false},
    ]

    const types = [
        {id: 1, name: trnsl('content.house') },
        {id: 2, name: trnsl('content.work') },
        {id: 3, name: trnsl('content.mobile') },
    ]

    const deletePhone = ( phone ) => {
        const dialog = dialogBox(phone.number, trnsl('messages.confirmDelete'))
        dialog.fire().then((result) =>{
            if(result.isConfirmed){
                form.delete(route('people.phones.destroy', phone.id),{
                    onSuccess: () => { 
                        successMessage(trnsl('messages.recordDeleted'))
                        getPhones()
                    },
                    onError: () => {
                        errorMessage(trnsl('messages.recordNoDeleted'))
                    }
                })
            }
        })
    }

    const save = () => {
        form.post(route('people.phones.store'), {
            onSuccess: ( data ) => { 
                successMessage(trnsl('messages.recordSaved'))
                showNew.value = false
                getPhones()
            },
            onError: (errors) => {
                errorMessage(trnsl('messages.recordNoSaved') + '\n\r '+ getError(errors))
                console.log(errors)
            }
        })
    }

    const cancel = () => {
        showNew.value = false
        reload.value += 1
    }

    const getPhones = () => {
        phones.length = 0
        axios.get(route('people.phones.getPhones', props.person.id))
            .then(response=>{
                phones = response.data
                reload.value += 1;
            })
            .catch(error=>{
                console.log(error)
            })
    } 

    const clickIconToolBar = (button) => {
        if (button === 'new') {
            form.person_id = props.person.id
            showNew.value = true
        } 
    }

    onMounted(()=>{
        getPhones()
    })
</script>