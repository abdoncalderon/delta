<template>
    <AuthenticatedLayout>
        <Head :title="$trnsl('content.attendance')"></Head>
        
        <template #header>
            {{ $trnsl('content.attendance') }}
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

            <Window
                :title="trnsl('content.attendance')"
                @close="back"
            >
                <template #body>

                    <div class="m-2 grid grid-cols-1 sm:grid-cols-12 gap-2">
                        
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
                                        @click="getEvents"
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
                                :dataset="events"
                                :title="trnsl('content.events')"
                                fieldSearch="name"
                                @action="getAction"
                            />
                        </div>

                    </div>

                </template>

            </Window>
           
        </template>

        <Modal
            :showModal="showDownload"
            @closeModal="closeDownload"
            :title="trnsl('content.downloadEvents')"
            modal-width="400px"
        >
            <Download 
                :clocks="clocks"
                @event="getEvent"
            />
        </Modal>
        
    </AuthenticatedLayout>
</template>

<script setup>
    
    import Modal from '@/Components/Modal.vue'
    import Download from './Download.vue'
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
    import DataTable from '@/Components/DataTable.vue'
    import Window from '@/Components/Window.vue'
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

    let events = []

    let stakeholderPeople = []

    let timesheet = []


    const icons = [
        {name: 'home', text: trnsl('content.home'), icon: 'fa fa-home'},
        {name: 'back', text: trnsl('content.back'), icon: 'fa fa-arrow-left'},    
        {name: 'download', text: trnsl('content.download'), icon: 'fa fa-download' },     
    ];

    const headers = [
        
        {name: 'stakeholder_person.person.fullName', type: 'text', text: trnsl('content.name'), align: 'left'},
        {name: 'record', type: 'date', text: trnsl('content.date'), align: 'left'},
        {name: 'record', type: 'time', text: trnsl('content.hour'), align: 'left'},
        {name: 'clock.name', type: 'text', text: trnsl('content.clock'), align: 'left'},
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

    const closeDownload = () => {
        showDownload.value = false
    }
  
    const clickIconToolBar = (button) => {
        if (button == 'back') {
            back()
        } else if (button == 'home') {
            home()
        } else if (button == 'download') {
            showDownload.value = true
        } 
    }

    const cleanFilter = () => {
        stakeholder.value = 0
        stakeholderPeople.length = 0
        filter.employees.length = 0
        filter.since = dayjs(undefined).format('YYYY-MM-DD')
        filter.until = dayjs(undefined).format('YYYY-MM-DD')
        events.length = 0
        reload.value +=  1
    }

    const getAction = ( action ) => {
        if (action.name==='edit') {
            editEvent(action.data)
        }
    }

    const getEvent = ( event ) => {
        if (event.status == 1) {
            showDownload.value = false
        }
    }

    const getStakeholderPeople = () => {
        events.length = 0
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

    const getEvents = () => {
        events.length = 0
        axios.post('/getEvents', filter)
            .then(response=>{
                events = response.data
                successMessage(trnsl('messages.successfullOperation'))
                reload.value += 1
            })
            .catch(error=>{
                console.log(error)
                errorMessage(trnsl('content.error') + '\n\r '+ getError(error))
            })
    }

    
    

</script>