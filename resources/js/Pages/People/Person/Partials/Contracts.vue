<template>

    <!-- ToolBar -->

    <div class="m-2">
        <ToolBar
            :icons="icons"
            @click="clickIconToolBar"
        />
    </div>
        
    <!-- Contracts Form -->

    <div v-if="showForm" class="m-2 border border-gray-500 rounded-md">
        
        <h3 class="px-3 py-1 text-xs text-white bg-gray-600">
            {{ $trnsl('content.contracts') }}
        </h3>

        <div class="m-2 grid sm:grid-cols-12 gap-2">

            <div class="col-span-1 sm:col-span-8">
                <InputLabel 
                    for="stakeholder" 
                    :value="trnsl('content.company')"
                ></InputLabel>
                <SelectInput 
                    id="stakeholder"
                    :options="stakeholders"
                    v-model="form.stakeholder_id"
                    :disabled="action=='update'"
                ></SelectInput>
                <InputError 
                    :message="form.errors.stakeholder_id"
                ></InputError>
            </div>
            
            <div class="col-span-1 sm:col-span-2" >
                <InputLabel 
                    for="admissionDate" 
                    :value="trnsl('content.admissionDate')"
                ></InputLabel>
                <TextInput 
                    id="admissionDate" 
                    v-model="form.admissionDate"
                    type="date"
                ></TextInput>
                <InputError 
                    :message="form.errors.admissionDate"
                ></InputError>
            </div>

            <div class="col-span-1 sm:col-span-2" >
                <InputLabel 
                    for="departureDate" 
                    :value="trnsl('content.departureDate')"
                ></InputLabel>
                <TextInput 
                    id="departureDate" 
                    v-model="form.departureDate"
                    type="date"
                    :disabled="action=='new'"
                ></TextInput>
                <InputError 
                    :message="form.errors.departureDate"
                ></InputError>
            </div>

            <div class="col-span-1 sm:col-span-6">
                <InputLabel 
                    for="sector" 
                    :value="trnsl('content.sector')"
                ></InputLabel>
                <SelectInput 
                    id="sector"
                    :options="sectors"
                    v-model="sector"
                ></SelectInput>
            </div>

            <div class="col-span-1 sm:col-span-6">
                <InputLabel 
                    for="department" 
                    :value="trnsl('content.department')"
                ></InputLabel>
                <SelectInputDb 
                    :key="sector"
                    id="department"
                    v-model="form.department_id"
                    routeGet="/getDepartments/"
                    :filterId="sector"
                    :withAdd="false"
                ></SelectInputDb>
                <InputError 
                    :message="form.errors.department_id"
                ></InputError>
            </div>

            <div class="col-span-1 sm:col-span-6">
                <InputLabel 
                    for="function" 
                    :value="trnsl('content.function')"
                ></InputLabel>
                <SelectInput 
                    id="function"
                    :options="functions"
                    v-model="funct1on"
                ></SelectInput>
            </div>

            <div class="col-span-1 sm:col-span-6">
                <InputLabel 
                    for="position" 
                    :value="trnsl('content.position')"
                ></InputLabel>
                <SelectInputDb 
                    :key="funct1on"
                    id="position"
                    v-model="form.position_id"
                    routeGet="/getPositions/"
                    :filterId="funct1on"
                    :withAdd="false"
                ></SelectInputDb>
                <InputError 
                    :message="form.errors.position_id"
                ></InputError>
            </div>

            <div class="col-span-1 sm:col-span-12">
                <InputLabel 
                    for="leader" 
                    :value="trnsl('content.leader')"
                ></InputLabel>
                <SelectDynamic 
                    :options="projectPeople"
                    v-model="form.leader_id"
                    show="fullName"
                ></SelectDynamic>
            </div>

            <div class="col-span-1 sm:col-span-2" >
                    <InputLabel 
                        for="card" 
                        :value="trnsl('content.cardNumber')"
                    ></InputLabel>
                    <TextInput 
                        id="card" 
                        v-model="form.cardNo"
                        type="email"
                    ></TextInput>
                    <InputError 
                        :message="form.errors.businessEmail"
                    ></InputError>
            </div>

            <div class="col-span-1 sm:col-span-3" >
                    <InputLabel 
                        for="businessEmail" 
                        :value="trnsl('content.bussinessEmail')"
                    ></InputLabel>
                    <TextInput 
                        id="businessEmail" 
                        v-model="form.businessEmail"
                        type="email"
                    ></TextInput>
                    <InputError 
                        :message="form.errors.businessEmail"
                    ></InputError>
            </div>
            
            <div class="col-span-1 sm:col-span-2" >
                <InputLabel 
                    for="hiredSince" 
                    :value="trnsl('content.hiredSince')"
                ></InputLabel>
                <TextInput 
                    id="hiredSince" 
                    v-model="form.hiredSince"
                    type="date"
                ></TextInput>
                <InputError 
                    :message="form.errors.hiredSince"
                ></InputError>
            </div>

            <div class="col-span-1 sm:col-span-2" >
                <InputLabel 
                    for="hiredUntil" 
                    :value="trnsl('content.hiredUntil')"
                ></InputLabel>
                <TextInput 
                    id="hiredUntil" 
                    v-model="form.hiredUntil"
                    type="date"
                    :disabled="action=='new'"
                ></TextInput>
                <InputError 
                    :message="form.errors.hiredUntil"
                ></InputError>
            </div>

            <div class="col-span-1 sm:col-span-2" >
                <InputLabel 
                    for="salary" 
                    :value="trnsl('content.salary')"
                ></InputLabel>
                <TextInput 
                    id="salary" 
                    v-model="form.salary"
                    type="number"
                ></TextInput>
                <InputError 
                    :message="form.errors.salary"
                ></InputError>
            </div>

            <div class="col-span-1 sm:col-span-1" >
                <InputLabel 
                    for="isApprover" 
                    :value="trnsl('content.approver')"
                ></InputLabel>
                <Switch
                    v-model:status="form.isApprover"
                    :value="form.isApprover"
                />
            </div>

        </div>

        <div class="mx-2 mt-4 mb-3 flex justify-end">
            <PrimaryButton
                :disabled="form.processing"
                @click="save(action)"
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

    <!-- Contracts List -->

    <div v-if="showList" class="m-2 rounded-md overflow-auto">
        
        <table :key="reload" class="w-full mb-2 divide-y divide-gray-300 overscrool-x-auto">

            <thead class="bg-gray-600">
                <tr class="tracking-wide">
                    <th class="px-4 py-1 text-xs text-white ">
                        {{ trnsl('content.company') }}
                    </th>
                    <th class="px-4 py-1 text-xs text-white ">
                        {{ trnsl('content.hiredSince') }}
                    </th>
                    <th class="px-4 py-1 text-xs text-white ">
                        {{ trnsl('content.hiredUntil') }}
                    </th>
                    <th class="px-4 py-1 text-xs text-white ">
                        {{ trnsl('content.actions') }}
                    </th>
                </tr>
            </thead>

            <tbody class="bg-white divide-y divide-gray-300">
                <tr v-for="(contract, i) in contracts" :key="i">
                    <td class=" px-4 py-1 text-xs text-gray-500 text-start">
                        {{ contract.stakeholder.name }}
                    </td>
                    <td class="px-4 py-1 text-xs text-gray-500 text-start">
                        {{ contract.hiredSince }}
                    </td>
                    <td class="px-4 py-1 text-xs text-gray-500 text-start">
                        {{ contract.hiredUntil }}
                    </td>
                    <td class="px-4 py-1 text-xs text-gray-500 text-center">
                        <span class="inline-flex overflow-hidden rounded-md border bg-white shadow-sm">
                            <button 
                                :disabled="contract.hiredUntil"
                                class="inline-block border-e px-2 py-1 text-blue-600 hover:bg-gray-50 focus:relative disabled:opacity-25"
                                :title="trnsl('content.edit')"
                                @click="editContract(contract)"
                            >
                                <i class="fa fa-pencil"></i>
                            </button>
                            <button 
                                class="inline-block border-e px-2 py-1 text-red-600 hover:bg-gray-50 focus:relative"
                                :title="trnsl('content.delete')"
                                @click="deleteContract(contract)"
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
    import SelectDynamic from '@/Components/SelectDynamic.vue'
    import SelectInputDb from '@/Components/SelectInputDb.vue'
    import Switch from '@/Components/Switch.vue'
    import { trnsl } from '@/Lang/languages';
    import { useForm } from '@inertiajs/vue3';
    import { ref, onMounted } from 'vue';
    import { successMessage, errorMessage, dialogBox, getError } from '@/Helpers/helper'
    import axios from 'axios';

    const props = defineProps({
        person: Object,
        projectPeople: Array,
        functions: Array,
        sectors: Array,
        stakeholders: Array,

    })

    const form = useForm({
        'id': '',
        'stakeholder_id': '',
        'person_id': '',
        'admissionDate': '',
        'departureDate': '',
        'position_id': '',
        'department_id': '',
        'leader_id': '',
        'cardNo': '',
        'businessEmail': '',
        'hiredSince': '',
        'hiredUntil': '',
        'salary': '',
        'contractFile': '',
        'isApprover': 0,
       
    })

    const formCountry = useForm({
        'id': '',
        'name': '',
        'state_id': '',
    })

    const reload = ref(0)
    const showForm = ref(false)
    const showList= ref(true)
    const sector = ref(0)
    const funct1on = ref(0)
    const action = ref('')
    
    let contracts = []

    const icons = [
        {name: 'new', text: trnsl('content.new'), icon: 'fa fa-plus', hidden: false},
    ]

    const editContract = ( contract ) => {
        action.value = 'update'
        sector.value = contract.department.sector_id
        funct1on.value = contract.position.function_id
        form.id = contract.id
        form.stakeholder_id = contract.stakeholder_id
        form.person_id = contract.person_id
        form.admissionDate = contract.admissionDate
        form.departureDate = contract.departureDate
        form.department_id = contract.department_id
        form.position_id = contract.position_id
        form.leader_id = contract.leader_id
        form.cardNo = contract.cardNo
        form.hiredSince = contract.hiredSince
        form.hiredUntil = contract.hiredUntil
        form.businessEmail = contract.businessEmail
        form.salary = contract.salary
        form.isApprover = contract.isApprover
        showForm.value = true
        showList.value = false
    }

    const deleteContract = ( contract ) => {
        const dialog = dialogBox(contract.number, trnsl('messages.confirmDelete'))
        dialog.fire().then((result) =>{
            if(result.isConfirmed){
                form.delete(route('people.contracts.destroy', contract.id),{
                    onSuccess: () => { 
                        successMessage(trnsl('messages.recordDeleted'))
                        getContracts()
                    },
                    onError: () => {
                        errorMessage(trnsl('messages.recordNoDeleted'))
                    }
                })
            }
        })
    }

    const save = () => {
        if (action.value === 'new') {
            form.post(route('people.contracts.store'), {
                onSuccess: ( data ) => { 
                    successMessage(trnsl('messages.recordSaved'))
                    showForm.value = false
                    showList.value = true
                    getContracts()
                },
                onError: (errors) => {
                    errorMessage(trnsl('messages.recordNoSaved') + '\n\r '+ getError(errors))
                    console.log(errors)
                }
            })
        } else {
            let id = form.id
            form.patch(route('people.contracts.update', id), {
                onSuccess: ( data ) => { 
                    successMessage(trnsl('messages.recordSaved'))
                    showForm.value = false
                    showList.value = true
                    getContracts()
                },
                onError: (errors) => {
                    errorMessage(trnsl('messages.recordNoSaved') + '\n\r '+ getError(errors))
                    console.log(errors)
                }
            })
        }
    }

    const cancel = () => {
        showForm.value = false
        showList.value = true
        reload.value += 1
    }

    const getContracts = () => {
        contracts.length = 0
        axios.get(route('people.contracts.getContracts', props.person.id))
            .then(response=>{
                contracts = response.data
                reload.value += 1;
            })
            .catch(error=>{
                console.log(error)
            })
    } 

    const clickIconToolBar = (button) => {
        if (button === 'new') {
            action.value = 'new'
            form.reset()
            form.person_id = props.person.id
            showForm.value = true
            showList.value = false
        } 
    }

    onMounted(()=>{
        getContracts()
    })
</script>