<template>
    <AuthenticatedLayout>

        <Head :title="$trnsl('content.clocks')"></Head>
        
        <template #header>
            {{ $trnsl('content.clocks') }}
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
                :key="reload"
                :headers="headers"
                :actions="actions"
                :dataset="clocks"
                :title="trnsl('content.clocks')"
                fieldSearch="name"
                @action="getAction"
            />

        </template>

        <Modal
            :showModal="showNew"
            @closeModal="closeNew"
            :title="title"
            modal-width="400px"
        >
            <New 
                :project_id="project_id"
                @event="getEvent"
            />

        </Modal>

        <Modal
            :showModal="showEdit"
            @closeModal="closeEdit"
            :title="title"
            modal-width="400px"
        >
            <Edit 
                :clock="clock"
                @event="getEvent"
            />

        </Modal>
        
    </AuthenticatedLayout>
</template>

<script setup>
    import Modal from '@/Components/Modal.vue'
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
    import DataTable from '@/Components/DataTable.vue'
    import ToolBar from '@/Components/ToolBar.vue'
    import New from './New.vue'
    import Edit from './Edit.vue'
    import { useForm, Head, usePage, router } from '@inertiajs/vue3';
    import { trnsl } from '@/Lang/languages';
    import { successMessage, errorMessage, dialogBox } from '@/Helpers/helper'
    import { onMounted, ref } from 'vue';

    const props = defineProps({
        clocks: Array,
        result: Object,
    });

    const form = useForm({
        'name': '',
        'ipAddress': '',
        'port': '4370',
        'project_id': '',
    })

    const page = usePage();

    const reload = ref(0)
    const showNew = ref(false)
    const showEdit = ref(false)
    const project_id = ref(0)
    const title = ref('')

    let clock = null

    const headers = [
        {name: 'name', type: 'text', text: trnsl('content.name'), align: 'left'},
        {name: 'ipAddress', type: 'text', text: trnsl('content.ipAddress'), align: 'left'},
    ];

    const actions = [
        {name: 'edit', type: 'icon', text: trnsl('content.edit'), icon: 'fa fa-pencil', color: 'primary'},
        {name: 'delete', type: 'icon', text: trnsl('content.delete'), icon: 'fa fa-trash', color: 'danger' },
    ];

    const icons = [
        {name: 'home', text: trnsl('content.home'), icon: 'fa fa-home'},
        {name: 'back', text: trnsl('content.back'), icon: 'fa fa-arrow-left'},
        {name: 'new', text: trnsl('content.new'), icon: 'fa fa-plus'},
   
    ];

    const home = () => {
        router.visit(route('dashboard'))
    } 

    const back = () => {
        router.visit(route('people.timesheet.home'))
    } 

    const closeNew = () => {
        showNew.value = false
    }

    const closeEdit = () => {
        showEdit.value = false
    }

    //Delete Record
    const deleteRecord = (row) => {
        const dialog = dialogBox( row.name, trnsl('messages.confirmDelete'))
        dialog.fire().then((result) =>{
            if(result.isConfirmed){
                form.delete(route('people.timesheet.clocks.destroy', row.id),{
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
            title.value = trnsl('content.edit') + ' ' + trnsl('content.clock')
            clock = action.data
            showEdit.value = true
        } else if (action.name==='delete') {
            deleteRecord(action.data)
        }
    }

    const getEvent = ( event ) => {
        if (event.status == 1) {
            showNew.value = false
            showEdit.value = false
            reload.value += 1
        }
    }

    const clickIconToolBar = (button) => {
        if (button === 'new') {
            title.value = trnsl('content.create') + ' ' + trnsl('content.clock')
            showNew.value = true
        } else if (button == 'back') {
            back()
        } else if (button == 'home') {
            home()
        } 
    }

    onMounted(()=>{
        project_id.value = page.props.auth.currentProject.id
    })



</script>