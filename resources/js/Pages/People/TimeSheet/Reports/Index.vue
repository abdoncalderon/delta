<template>
    <AuthenticatedLayout>
        <Head :title="$trnsl('content.reports')"></Head>
        
        <template #header>
            {{ $trnsl('content.reports') }}
        </template>

        <template #subheader>
            {{ $trnsl('content.timesheet') }}
        </template>

        <template #content>

            <div class="my-2">
                <ToolBar
                    :icons="icons"
                    @click="clickIconToolBar"
                />
            </div>

            <div class="my-2 grid grid-cols-1 sm:grid-cols-12 gap-2">
                
                <div class="p-2 col-span-1 sm:col-span-3 border border-gray-500 rounded-lg">

                    <div class="grid grid-cols-12  gap-1">

                        <div class="col-span-12">
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
                        <div class="col-span-6">
                            <InputLabel 
                                for="since" 
                                :value="trnsl('content.from')"
                            ></InputLabel>
                            <TextInput 
                                id="since" 
                                v-model="filter.since"
                                type="date"
                            ></TextInput>
                        </div>
                        <div class="col-span-6">
                            <InputLabel 
                                for="until" 
                                :value="trnsl('content.until')"
                            ></InputLabel>
                            <TextInput 
                                id="until" 
                                v-model="filter.until"
                                type="date"
                            ></TextInput>
                        </div>
                        <div class="col-span-12">
                            <InputLabel 
                                for="employees" 
                                :value="trnsl('content.employees')"
                            ></InputLabel>
                            <SelectMultiple
                                :key="reload"
                                :list="filter.employees"
                                :data="stakeholderPeople"
                                height="270px"
                            />
                        </div> 
                        <div class="mt-1 col-span-12 flex justify-end">
                            <PrimaryButton
                                @click="cleanFilter"
                                icon="fa fa-search"
                                class="mr-1"
                            >
                                {{ trnsl('content.clean') }}
                            </PrimaryButton>
                            <PrimaryButton
                                @click="getTimesheet"
                                icon="fa fa-search"
                            >
                                {{ trnsl('content.search') }}
                            </PrimaryButton>
                        </div>

                    </div>
                    
                </div>

                <div class="col-span-1 sm:col-span-9">
                    <DataTable
                        :key="reload"
                        :headers="headers"
                        :actions="actions"
                        :dataset="timesheet"
                        :title="trnsl('content.timesheet')"
                        fieldSearch="name"
                        :showActions="false"
                    />
                </div>

            </div>
            
        </template>
        
    </AuthenticatedLayout>
</template>

<script setup>
    
    import Modal from '@/Components/Modal.vue'
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
    import DataTable from '@/Components/DataTable.vue'
    import SelectMultiple from '@/Components/SelectMultiple.vue'
    import TextInput from '@/Components/TextInput.vue'
    import PrimaryButton from '@/Components/PrimaryButton.vue' 
    import ToolBar from '@/Components/ToolBar.vue'
    import SelectInput from '@/Components/SelectInput.vue'
    import InputLabel from '@/Components/InputLabel.vue'
    import { trnsl } from '@/Lang/languages';
    import { Head, useForm, router } from '@inertiajs/vue3';
    import { successMessage, errorMessage, getError, dialogBox } from '@/Helpers/helper'
    import { ref } from 'vue';
    import axios from 'axios';
    import dayjs from 'dayjs';
    

    const props = defineProps({
        clocks: Array,
        stakeholders: Array,
    })

    const filter = {
        'since': dayjs(undefined).format('YYYY-MM-DD'),
        'until': dayjs(undefined).format('YYYY-MM-DD'),
        'employees': [],
    }

    const form = useForm({
        'since': dayjs(undefined).format('YYYY-MM-DD'),
        'until': dayjs(undefined).format('YYYY-MM-DD'),
        'employees': [],
    })

    const reload = ref(0)
    const stakeholder = ref(0)
    const showDownload = ref(false)


    let stakeholderPeople = []
    let timesheet = []

    const icons = [
        {name: 'home', text: trnsl('content.home'), icon: 'fa fa-home'},
        {name: 'back', text: trnsl('content.back'), icon: 'fa fa-arrow-left'},    
        {name: 'export', text: trnsl('content.export'), icon: 'fa fa-file-export' },  
    ];

    const headers = [
        {name: 'fullName', type: 'text', text: trnsl('content.name'), align: 'left'},
        {name: 'day', type: 'date', text: trnsl('content.date'), align: 'left'},
        {name: 'checkIn', type: 'text', text: trnsl('content.entry'), align: 'left'},
        {name: 'checkOut', type: 'text', text: trnsl('content.exit'), align: 'left'},
        {name: 'workday', type: 'text', text: trnsl('content.hours'), align: 'left'},
    ];

    const actions = [
        {name: 'edit', type: 'icon', text: trnsl('content.edit'), icon: 'fa fa-pencil', color: 'primary' },
    ];

    const home = () => {
        router.visit(route('dashboard'))
    } 

    const back = () => {
        router.visit(route('people.timesheet.home'))
    } 
  
    const clickIconToolBar = (button) => {
        if (button == 'back') {
            back()
        } else if (button == 'home') {
            home()
        } else if (button == 'export') {
            
        } 
    }

    const getEvent = ( event ) => {
        if (event.status == 1) {
            showDownload.value = false
        }
    }

    const cleanFilter = () => {
        stakeholder.value = 0
        stakeholderPeople.length = 0
        timesheet.length = 0
        filter.employees.length = 0
        filter.since = dayjs(undefined).format('YYYY-MM-DD')
        filter.until = dayjs(undefined).format('YYYY-MM-DD')
        reload.value += 1
    }

    const getStakeholderPeople = () => {
        timesheet.length = 0
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

    const getTimesheet = () => {
        axios.post('/getTimesheet', filter)
            .then(response=>{
                timesheet = response.data
                successMessage(trnsl('messages.successfullOperation'))
                reload.value += 1
            })
            .catch(error=>{
                console.log(error)
                errorMessage(trnsl('content.error') + '\n\r '+ getError(error))
            })
    }
    

</script>