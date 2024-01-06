<template>
    <AuthenticatedLayout>

        <Head :title="$trnsl('content.shifts')"></Head>
        
        <template #header>
            {{ $trnsl('content.shifts') }}
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
            <DataTable
                v-if="showDatatable"
                :key="reload"
                :headers="headers"
                :actions="actions"
                :dataset="shifts"
                :title="trnsl('content.shifts')"
                fieldSearch="name"
                @action="getAction"
            />

            <Assign
                v-if="showAssign"
                :shifts="shifts"
                :stakeholders="stakeholders"
                @event="getEvent"
            />
        </template>

        <!-- MODAL -->
        <Modal
            :showModal="modal"
            @closeModal="closeModal"
            :title="title"
            modal-width="600px"
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
    import Assign from './Assign.vue'
    import { useForm, Head, usePage, router } from '@inertiajs/vue3';
    import { trnsl } from '@/Lang/languages';
    import { successMessage, errorMessage, dialogBox } from '@/Helpers/helper'
    import { ref, onMounted } from 'vue';

    const props = defineProps({
        shifts: Array,
        projects: Array,
        stakeholders: Array,
    });

    const page = usePage();
    
    const form = useForm({
        'id': '',
        'name': '',
        'start': '',
        'finish': '',
        'nextday': false,
        'breaktime': '01:00',
        'earlyCheckin': '00:15',
        'lateCheckout': '00:15',
        'overtime': true,
        'project_id': '',
    });

    const reload = ref(0)
    const modal = ref(false)
    const title = ref('');
    const operation = ref('');
    const routePath = ref('');
    const showDatatable = ref(true)
    const showAssign = ref(false)

    const headers = [
        {name: 'name', type: 'text', text: trnsl('content.name'), align: 'left'},
        {name: 'start', type: 'text', text: trnsl('content.start'), align: 'left'},
        {name: 'finish', type: 'text', text: trnsl('content.finish'), align: 'left'},
    ];

    const actions = [
        {name: 'edit', type: 'icon', text: trnsl('content.edit'), icon: 'fa fa-pencil', color: 'primary'},
        {name: 'delete', type: 'icon', text: trnsl('content.delete'), icon: 'fa fa-trash', color: 'danger' },
    ];
    
    const fields = [
        {name: 'project_id', type: 'select', text: trnsl('content.project'), style: 'sm:col-span-12', items:[], disabled: true }, 
        {name: 'name', type: 'text', text: trnsl('content.name'), style: 'sm:col-span-12',length: 255, disabled: false },
        {name: 'start', type: 'time', text: trnsl('content.start'), style: 'sm:col-span-3', disabled: false },
        {name: 'finish', type: 'time', text: trnsl('content.finish'), style: 'sm:col-span-3', disabled: false },
        {name: 'nextday', type: 'check', text: trnsl('content.nextday'), style: 'sm:col-span-3', disabled: false },
        {name: 'breaktime', type: 'time', text: trnsl('content.breaktime'), style: 'sm:col-span-3', disabled: false },
        {name: 'earlyCheckin', type: 'time', text: trnsl('content.earlyCheckin'), style: 'sm:col-span-3', disabled: false },
        {name: 'lateCheckout', type: 'time', text: trnsl('content.lateCheckout'), style: 'sm:col-span-3', disabled: false },
        {name: 'overtime', type: 'check', text: trnsl('content.overtime'), style: 'sm:col-span-3', disabled: false },

    ];

    const icons = [
        {name: 'home', text: trnsl('content.home'), icon: 'fa fa-home'},
        {name: 'back', text: trnsl('content.back'), icon: 'fa fa-arrow-left'},
        {name: 'new', text: trnsl('content.new'), icon: 'fa fa-plus'},
        {name: 'assign', text: trnsl('content.assign'), icon: 'fa fa-user'},
    ];

    const openModal = ( row ) => {
        modal.value = true;
    }

    const closeModal = () => {
        modal.value = false;
        reload.value += 1;
        form.reset()
        form.clearErrors()
    }
    
    const home = () => {
        router.visit(route('dashboard'))
    } 

    const back = () => {
        router.visit(route('people.timesheet.home'))
    }

    //Delete Record
    const deleteRecord = (row) => {
        const dialog = dialogBox( row.name, trnsl('messages.confirmDelete'))
        dialog.fire().then((result) =>{
            if(result.isConfirmed){
                form.delete(route('people.timesheet.shifts.destroy', row.id),{
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
            routePath.value = 'people.timesheet.shifts.update'
            title.value = trnsl('content.edit') + ' ' + trnsl('content.shifts')
            form.id = action.data.id
            fields.forEach( (field) => {
                form[field.name]=action.data[field.name];
            })
            openModal()
        } else if (action.name==='delete') {
            deleteRecord(action.data)
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
        } else if (event.source==='assign') {
            if (event.action==='cancel') {
                showAssign.value = false
                showDatatable.value = true
            }
        } else {
            closeModal()
        }
    }

    const clickIconToolBar = (button) => {
        if (button === 'new') {
            showDatatable.value = true
            showAssign.value = false
            operation.value = 'store'
            routePath.value = 'people.timesheet.shifts.store'
            title.value = trnsl('content.create') + ' ' + trnsl('content.shifts')
            form.project_id = page.props.auth.currentProject.id
            openModal()
        } else if (button == 'home') {
            home()
        } else if (button == 'back') {
            back()
        } else if (button == 'assign') {
            showDatatable.value = false
            showAssign.value = true
        }
    }

    

    onMounted(() => {
        fields[0].items = props.projects;
        
    }) 

</script>