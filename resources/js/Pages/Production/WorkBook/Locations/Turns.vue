<template>
    <AuthenticatedLayout>
        <Head :title="$trnsl('content.locations')"></Head>
        
        <template #header>
            {{ $trnsl('messages.turnsAssigment') }}
        </template>

        <template #subheader>
            {{ $trnsl('content.project') }}
        </template>

        <template #content>

            <div class="my-2">
                <ToolBar
                    :icons="icons"
                    @click="clickIconToolBar"
                />
            </div>

            <DataTable
                :key="reload"
                :headers="headers"
                :actions="actions"
                :dataset="turnsLocation"
                :title="trnsl('messages.assignedTurns') + ' [' + location.name + ']'"
                fieldSearch="name"
                @action="getAction"
            />
            
        </template>

        <Modal
            :showModal="showModalNew"
            @closeModal="closeModalNew"
            :title="title"
            modal-width="400px"
        >
            <div class="my-2 mx-2 grid grid-cols-4 gap-2">

                <div class="col-span-4">
                    <SelectMultiple
                        :list="form.turns"
                        :data="availableTurns"
                    />
                </div>

                <div class="col-span-2" >
                    <InputLabel 
                        for="dateFrom" 
                        :value="trnsl('content.from')"
                    ></InputLabel>
                    <TextInput 
                        id="dateFrom" 
                        v-model="form.dateFrom"
                        type="date"
                    ></TextInput>
                    <InputError 
                        :message="form.errors.fromDate"
                    ></InputError>
                </div>

                <div class="col-span-2" >
                    <InputLabel 
                        for="dateTo" 
                        :value="trnsl('content.until')"
                    ></InputLabel>
                    <TextInput 
                        id="dateTo" 
                        v-model="form.dateTo"
                        type="date"
                    ></TextInput>
                    <InputError 
                        :message="form.errors.startDate"
                    ></InputError>
                </div>
                
            </div>

            <div class="p-3 mt-2 flex justify-end bg-gray-100">
                <PrimaryButton
                    :disabled="form.processing"
                    icon="fa fa-save"
                    @click="saveRecord"
                >
                    {{ $trnsl('content.save') }}
                </PrimaryButton>
                <SecondaryButton
                    class="ml-3"
                    :disabled="form.processing"
                    icon="fa fa-ban"
                    @click="closeModalNew"
                >
                    {{ $trnsl('content.cancel') }}
                </SecondaryButton>
            </div>

        </Modal>

        <Modal
            :showModal="showModalEdit"
            @closeModal="closeModalEdit"
            :title="title"
            modal-width="400px"
        >
            <Form
                :fields="fieldsEdit"
                :form="form"
                :routePath="routePath"
                operation="update"
                @submit="getEvent"
                :acceptText="trnsl('content.save')"
            />
        </Modal>

    </AuthenticatedLayout>

</template>

<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
    import DataTable from '@/Components/DataTable.vue'
    import Modal from '@/Components/Modal.vue'
    import ToolBar from '@/Components/ToolBar.vue'
    import Form from '@/Components/Form.vue'
    import PrimaryButton from '@/Components/PrimaryButton.vue' 
    import SecondaryButton from '@/Components/SecondaryButton.vue'
    import InputError from '@/Components/InputError.vue'
    import InputLabel from '@/Components/InputLabel.vue'
    import TextInput from '@/Components/TextInput.vue'
    import SelectMultiple from '@/Components/SelectMultiple.vue'
    import { useForm, Head, router } from '@inertiajs/vue3';
    import { trnsl } from '@/Lang/languages';
    import { successMessage, errorMessage, dialogBox, getError } from '@/Helpers/helper'
    import { ref, onMounted } from 'vue';
    import axios from 'axios'

    const props = defineProps({
        location: Object,
        turnsLocation: Array,
        availableTurns: Array,
    });

    const form = useForm({
        'id': '',
        'turn_id': '',
        'turn': '',
        'location_id': '',
        'turns': [],
        'dateFrom': '',
        'dateTo': '',
    })

    const reload = ref(0)
    const showModalNew = ref(false)
    const showModalEdit = ref(false)
    const title = ref('');
    const routePath = ref('');

    const headers = [
        {name: 'turn.name', text: trnsl('content.turn'), type: 'text', align: 'left'},
        {name: 'dateFrom', text: trnsl('content.from'), type: 'date', align: 'left'},
        {name: 'dateTo', text: trnsl('content.until'), type: 'date', align: 'left'},
    ];

    const actions = [
        {name: 'edit', type: 'icon', text: trnsl('content.edit'), icon: 'fa fa-pencil', color: 'primary'},
        {name: 'delete', type: 'icon', text: trnsl('content.delete'), icon: 'fa fa-trash', color: 'danger' },
    ];

    const fieldsEdit = [
        {name: 'id', type: 'hidden'},
        {name: 'location_id', type: 'hidden'}, 
        {name: 'turn_id', type: 'hidden'}, 
        {name: 'turn', type: 'text', text: trnsl('content.turn'), style: 'sm:col-span-4',  disabled: true },
        {name: 'dateFrom', type: 'date', text: trnsl('content.from'), style: 'sm:col-span-2', length: 255, disabled: false },
        {name: 'dateTo', type: 'date', text: trnsl('content.until'), style: 'sm:col-span-2', length: 255, disabled: false }, 
    ];

    const icons = [
        {name: 'home', text: trnsl('content.home'), icon: 'fa-solid fa-home'},
        {name: 'back', text: trnsl('content.back'), icon: 'fa-solid fa-arrow-left'},       
        {name: 'new', text: trnsl('content.new'), icon: 'fa fa-plus'}, 
    ];

    const availableTurns = []

    const home = () => {
        router.visit(route('dashboard'))
    } 

    const back = () => {
        router.visit(route('production.workbook.locations.index'))
    }
    
    const closeModalNew = () => {
        showModalNew.value = false
        reload.value += 1
        form.reset()
        form.clearErrors()
    }

    const closeModalEdit = () => {
        showModalEdit.value = false
        reload.value += 1
        form.reset()
        form.clearErrors()
    }

    const deleteRecord = (row) => {
        const dialog = dialogBox( row.name, trnsl('messages.confirmDelete'))
        dialog.fire().then((result) =>{
            if(result.isConfirmed){
                form.delete(route('production.workbook.locations.turns.destroy', row.id),{
                    onSuccess: () => { 
                        successMessage(trnsl('messages.recordDeleted'))
                        reload.value += 1;
                    },
                    onError: () => {
                        errorMessage(trnsl('messages.recordNoDeleted'))
                        console.log('')
                    }
                })
            }
        });
    }

    const saveRecord = () => {
        form.post(route('production.workbook.locations.turns.store'),{
            onSuccess: () => { 
                successMessage(trnsl('messages.recordSaved'))
                closeModalNew()
            },
            onError: (errors) => {
                errorMessage(trnsl('messages.recordNoSaved') + '\n\r '+ getError(errors))
                console.log(errors)
            }
        })
    }

    const getLocationTurns = () => {
        eventsDailyReport.length = 0
        axios.get('/getLocationTurns/' + props.location.id)
            .then(response=>{
                response.data.forEach( (row, i) => {
                    locationTurns[i] = row
                })
                reload.value += 1;
            })
            .catch(error=>{
                console.log(error)
            })
    } 

    const clickIconToolBar = (button) => {
        if (button === 'new') {
            form.reset()
            form.location_id = props.location.id
            routePath.value = 'production.workbook.locations.turns.store'
            title.value = trnsl('messages.turnsAssigment')
            showModalNew.value = true
        } else if (button == 'back') {
                    back()
                } else if (button == 'home') {
                            home()
                        }
    }

    const getAction = ( action ) => {
        if (action.name==='edit') {
            form.location_id = props.location.id
            form.turn_id = action.data.turn_id
            form.turn = action.data.turn.name
            form.dateFrom = action.data.dateFrom
            form.dateTo = action.data.dateTo
            routePath.value = 'production.workbook.locations.turns.update'
            title.value = trnsl('content.edit') + ' ' + trnsl('content.turn')
            showModalEdit.value = true
        } else if (action.name==='delete') {
                    deleteRecord(action.data)
                }
    }

    const getEvent = ( event ) => {
        if (event.action==='store'){
            if (event.status==1){
                showModalNew.value = false
            } 
        } else if ((event.action==='update')||(event.action==='updateWithFile')) {
                    if (event.status==1){
                        showModalEdit.value = false
                    }
                } else if ((event.action==='cancel')) {
                            showModalNew.value = false
                            showModalEdit.value = false
                        }
        reload.value += 1
    }

    onMounted(()=>{
        
    })

    

    

</script>