<template>
    <AuthenticatedLayout>
        <Head :title="$trnsl('content.dailyReports')"></Head>

        <template #header>
            {{ $trnsl('content.dailyReports') }}
        </template>

        <template #subheader>
            {{ $trnsl('content.production') }}
        </template>

        <template #content>
            <ToolBar
                :buttons="buttons"
                @click="clickIconToolBar"
            />


            <!-- <div class="grid grid-cols-1 sm:grid-cols-8 gap-2 p-2 mb-2 bg-neutral-700 rounded-lg shadow-md">
               
                <div class="col-span-1 sm:col-span-1" >
                    <InputLabel 
                        for="date" 
                        :value="trnsl('content.date')"
                        class="ml-1 text-xs font-bold text-white"
                    ></InputLabel>
                    <TextInput 
                        id="date" 
                        v-model="folio.date"
                        type="date"
                        class="text-xs mt-1"
                        disabled="disabled"
                    ></TextInput>
                   
                </div>
                <div class="col-span-1 sm:col-span-7" >
                    <InputLabel 
                        for="location" 
                        :value="trnsl('content.location')"
                        class="ml-1 text-xs font-bold text-white"
                    ></InputLabel>
                    <TextInput 
                        id="location" 
                        v-model="folio.location.name"
                        type="text"
                        class="text-xs mt-1"
                        disabled="disabled"
                    ></TextInput>
                    
                </div>

           </div> -->

           <DataTable
                :key="reload"
                :headers="headers"
                :actions="actions"
                :dataset="dailyReports"
                :table="trnsl('content.dailyReports')+' - '+folio.location.name+' - '+folio.date"
                fieldSearch="name"
                @select="executeAction"
            />

            <!--- Form New Daily Report -->
            

            <!--- Form Edit Daily Report -->

            <!-- <div v-if="showEditForm" class="bg-white rounded-lg shadow-md my-2 overflow-hidden">

                <h3 class="px-3 py-3 text-white bg-neutral-800">
                    {{ $trnsl('content.dailyReport') }}
                </h3>

                <Form
                    :fields="fieldsNew"
                    :form="form"
                    :table="trnsl('content.dailyReport')"
                    :routePath="routePath"
                    :operation="operation"
                    @submit="confirmTransaction"
                />

            </div> -->

            <DailyReportNew
                v-if="showNewForm"
                :form="formNew"
                :fields="fieldsNew"
                @submit="confirmTransaction"
            />
            

        </template>



        <!-- MODAL -->
        <!-- <Modal
            :show="modal"
            @close="closeModal"
        >
            <h3 class="px-5 py-3 font-semibold text-blue-500 bg-gray-100">
                {{ title }}
            </h3>

            <Form
                :fields="fields"
                :form="form"
                :table="trnsl('content.dailyReport')"
                :routePath="routePath"
                :operation="operation"
                @submit="confirmTransaction"
            />
        </Modal> -->

    </AuthenticatedLayout>
</template>

<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
    import DataTable from '@/Components/DataTable.vue'
    import Form from '@/Components/Form.vue'
    import DailyReportNew from './Partials/DailyReportNew.vue'
    import Modal from '@/Components/Modal.vue'
    import InputError from '@/Components/InputError.vue'
    import InputLabel from '@/Components/InputLabel.vue'
    import TextInput from '@/Components/TextInput.vue'
    import SelectInput from '@/Components/SelectInput.vue'
    import PrimaryButton from '@/Components/PrimaryButton.vue'
    import SecondaryButton from '@/Components/SecondaryButton.vue'
    import ToolBar from '@/Components/ToolBar.vue'
    import { trnsl } from '@/Lang/languages';
    import { successMessage, errorMessage } from '@/Helpers/helper'
    import { useForm, Head, usePage, router } from '@inertiajs/vue3';
    import { ref, reactive, onMounted } from 'vue';
    import axios from 'axios';
    

    const props = defineProps({
        folio: Object,
        dailyReports: Array,
        turns: Array,
        projectUserId: Number,
        responsibles: Array,
    });

    const page = usePage();
    
    const formNew = useForm({
        'folio_id': '',
        'turn_id': '',
        'report': '',
        'project_user_id': '',
        'responsible': '',
    });

    let form = useForm({})

    const reload = ref(0)
    const results = reactive([])
    const modal = ref(false)
    const showNewForm = ref(false)
    const showEditForm = ref(false)
    const title = ref('');
    const operation = ref('');
    const routePath = ref('');

    const headers = [
                    {name: 'turn.name', text: trnsl('content.turn'), type: 'text', align: 'left'},
                ];

    const actions = [
                    {name: 'show', type: 'icon', text: trnsl('content.show'), icon: 'fa fa-eye', color: 'primary'},
                    {name: 'edit', type: 'icon', text: trnsl('content.edit'), icon: 'fa fa-pencil', color: 'primary'},
                    {name: 'review', type: 'icon', text: trnsl('content.review'), icon: 'fa fa-magnifying-glass', color: 'primary'},
                    {name: 'approve', type: 'icon', text: trnsl('content.approve'), icon: 'fa fa-check', color: 'primary'},
                ];
    
    const fieldsNew = [
                    {name: 'id', type: 'hidden'},
                    {name: 'folio_id', type: 'hidden'},
                    {name: 'turn_id', type: 'select', text: trnsl('content.turn'), style: 'sm:col-span-1', items:[], disabled: false}, 
                    {name: 'responsible', type: 'select', text: trnsl('content.responsible'), style: 'sm:col-span-3', items:[], disabled: false}, 
                    {name: 'report', type: 'textarea', text: trnsl('content.details'), style: 'sm:col-span-4', rows: 8, disabled: false },
                ];

    const fieldsEdit = [
                    {name: 'id', type: 'hidden'},
                    {name: 'folio_id', type: 'hidden'},
                    {name: 'turn_id', type: 'select', text: trnsl('content.turn'), style: 'sm:col-span-1', items:[], disabled: false}, 
                    {name: 'report', type: 'textarea', text: trnsl('content.details'), style: 'sm:col-span-4', rows: 8, disabled: false },
                ];

    const buttons = [
                    {name: 'home', text: trnsl('content.home'), icon: 'fa-solid fa-home'},
                    {name: 'back', text: trnsl('content.back'), icon: 'fa-solid fa-arrow-left'},       
                    {name: 'new', text: trnsl('content.new'), icon: 'fa fa-plus'},
                ];

    const home = () => {
        router.visit(route('dashboard'))
    } 

    const back = () => {
        router.visit(route('production.workbook.folios.index'))
    } 

    /* const openModal = ( row ) => {
        modal.value = true;
    }

    const closeModal = () => {
        modal.value = false;
        reload.value += 1;
        
    } */

    const search = () => {
        let location_id = formFilter.location_id
        let from = formFilter.fromDate
        let until = formFilter.untilDate
        axios.get('/api/getFoliosXLocation/' + location_id + '/' + from + '/' + until)
            .then(response=>{
                response.data.forEach( (row, i) => {
                    results[i] = row
                })
                reload.value += 1;
            })
            .catch(error=>{
                console.log(error)
            })
    }

    const clickIconToolBar = (button) => {
        if (button === 'new') {
            formNew.folio_id = props.folio.id
            formNew.project_user_id = props.projectUserId
            title.value = trnsl('content.create') + ' ' + trnsl('content.dailyReport')
            showNewForm.value = true
        } else if (button == 'back') {
            back()
        } else if (button == 'home') {
            home()
        }
    }
    
    const executeAction = ( params ) => {
        
        if (params[1]==='dailyReports') {
            router.get(route('production.workbook.dailyReports.index',params[0].id))
        } else if (params[1]==='notes') {
                    
                }
    }

    const confirmTransaction = ( params ) => {
        console.log(params)
        if (params[1]==='store'){
            if (params[0]==1){
                successMessage(trnsl('messages.recordSaved'))
            } else {
                errorMessage(trnsl('messages.recordNoSaved'))
            } 
        } else if ((params[1]==='update')||(params[1]==='updateWithFile')) {
            if (params[0]==1){
                successMessage(trnsl('messages.recordUpdated')) 
                showEditForm.value = false
            } else {
                errorMessage(trnsl('messages.recordNoUpdated'))
            } 
        } else {
            showNewForm.value = false
        }
    }

    onMounted(() => {
        fieldsNew[2].items = props.turns
        fieldsNew[3].items = props.responsibles
    }) 

</script>