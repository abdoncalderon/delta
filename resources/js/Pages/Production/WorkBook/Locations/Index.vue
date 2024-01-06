<template>
    <AuthenticatedLayout>

        <Head :title="$trnsl('content.locations')"></Head>
        
        <template #header>
            {{ $trnsl('content.locations') }}
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
                :dataset="locations"
                :title="trnsl('content.locations')"
                fieldSearch="name"
                @action="getAction"
            />

            <Turns
                :location="location"
                :turnsLocation="location.location_turns"

            />
        </template>

        <!-- MODAL -->
        <Modal
            :showModal="showModal"
            @closeModal="closeModal"
            :title="title"
            modal-width="400px"
        >
            <Form
                :fields="fields"
                :form="form"
                :routePath="routePath"
                :operation="operation"
                @submit="getEvent"
                :acceptText="trnsl('content.save')"
            />
            
        </Modal>

        
    </AuthenticatedLayout>
</template>
<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
    import DataTable from '@/Components/DataTable.vue'
    import Form from '@/Components/Form.vue'
    import Modal from '@/Components/Modal.vue'
    import ToolBar from '@/Components/ToolBar.vue'
    import Turns from './Turns.vue'
    import { useForm, Head, usePage, router } from '@inertiajs/vue3';
    import { trnsl } from '@/Lang/languages';
    import { successMessage, errorMessage, dialogBox } from '@/Helpers/helper'
    import { ref, onMounted } from 'vue';

    const props = defineProps({
        locations: Array,
        zones: Array,
    });

    const page = usePage();
    
    const form = useForm({
        'id': '',
        'name': '',
        'code': '',
        'zone_id': '',
        'latitude': '',
        'longitude': '',
        'startDate': '',
        'finishDate': '',
    });

    const reload = ref(0)
    const showModal = ref(false)
    const title = ref('');
    const operation = ref('');
    const routePath = ref('');

    const headers = [
                    {name: 'name', text: trnsl('content.location'), type: 'text', align: 'left'},
                    {name: 'zone.name', text: trnsl('content.zone'), type: 'text', align: 'left'},
                ];

    const actions = [
                    {name: 'edit', type: 'icon', text: trnsl('content.edit'), icon: 'fa fa-pencil', color: 'primary'},
                    {name: 'turns', type: 'icon', text: trnsl('content.turns'), icon: 'fa fa-clock', color: 'primary' },
                ];
    
    const fields = [
                    {name: 'id', type: 'hidden'},
                    {name: 'name', type: 'text', text: trnsl('content.name'), style: 'sm:col-span-4',length: 255, disabled: true },
                    {name: 'code', type: 'text', text: trnsl('content.code'), style: 'sm:col-span-1',length: 255, disabled: true },
                    {name: 'zone_id', type: 'select', text: trnsl('content.zone'), style: 'sm:col-span-3', items:[], disabled: true }, 
                    {name: 'latitude', type: 'number', text: trnsl('content.latitude'), style: 'sm:col-span-2',length: 255, disabled: false },
                    {name: 'longitude', type: 'number', text: trnsl('content.longitude'), style: 'sm:col-span-2',length: 255, disabled: false },
                    {name: 'startDate', type: 'date', text: trnsl('content.startDate'), style: 'sm:col-span-2',length: 255, disabled: false },
                    {name: 'finishDate', type: 'date', text: trnsl('content.finishDate'), style: 'sm:col-span-2',length: 255, disabled: false },
                    {name: 'max_time_open_folio', type: 'number', text: trnsl('messages.maxtimeopenfolio'), style: 'sm:col-span-1', disabled: false },
                    {name: 'max_time_create_dailyreport', type: 'number', text: trnsl('messages.maxtimecreatedailyreport'), style: 'sm:col-span-1', disabled: false },
                    {name: 'max_time_create_note', type: 'number', text: trnsl('messages.maxtimecreatenote'), style: 'sm:col-span-1', disabled: false },
                    {name: 'max_time_create_comment', type: 'number', text: trnsl('messages.maxtimecreatecomment'), style: 'sm:col-span-1', disabled: false },
                    {name: 'sequence', type: 'number', text: trnsl('content.sequence'), style: 'sm:col-span-1',length: 255, disabled: false },
                ];

    const icons = [
                    {name: 'home', text: trnsl('content.home'), icon: 'fa fa-home'},
                    {name: 'back', text: trnsl('content.back'), icon: 'fa-solid fa-arrow-left'},
                    {name: 'new', text: trnsl('content.new'), icon: 'fa fa-plus'},
                ];

    

    const openModal = ( row ) => {
        showModal.value = true;
    }

    const closeModal = () => {
        showModal.value = false;
        reload.value += 1;
        form.clearErrors()
        form.reset()
    }
    
    const home = () => {
        router.visit(route('dashboard'))
    } 

    const back = () => {
        router.visit(route('production.workbook.home'))
    }

    //Delete Record
    const deleteRecord = (row) => {
        const dialog = dialogBox( row.name, trnsl('messages.confirmDelete'))
        dialog.fire().then((result) =>{
            if(result.isConfirmed){
                form.delete(route('project.locations.destroy', row.id),{
                    onSuccess: () => { 
                        successMessage(trnsl('messages.recordDeleted'))
                        reload.value += 1;
                    },
                    onError: () => {
                        errorMessage(trnsl('messages.recordNoDeleted'))
                    }
                })
            }
        });
    }

    const getAction = ( action ) => {
        if (action.name==='edit') {
            operation.value = 'update'
            routePath.value = 'project.locations.update'
            title.value = trnsl('content.edit') + ' ' + trnsl('content.locations')
            fields.forEach( (field) => {
                form[field.name]=action.data[field.name];
            })
            openModal()
        } else if (action.name==='turns') {
            router.get(route('production.workbook.locations.turns.index',action.data.id))
        }
    }

    const getEvent = ( event ) => {
        if (event.action==='store'){
            if (event.status==1){
                closeModal()
            } 
        } else if ((event.action==='update')||(event.action==='updateWithFile')) {
            if (event.status==1){
                closeModal()
            } 
        } else {
            closeModal()
        }
    }

    const clickIconToolBar = (button) => {
        if (button === 'new') {
            operation.value = 'store'
            routePath.value = 'project.locations.store'
            title.value = trnsl('content.create') + ' ' + trnsl('content.locations')
            openModal()
        } else if (button == 'back') {
                    back()
                } else if (button == 'home') {
                            home()      
                        }
    }

    onMounted(() => {
        fields[3].items = props.zones;
        form.project_id = page.props.auth.currentProject.id
    }) 

</script>