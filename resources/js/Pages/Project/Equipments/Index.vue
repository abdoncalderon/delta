<template>
    <AuthenticatedLayout>

        <Head :title="$trnsl('content.equipments')"></Head>
        
        <template #header>
            {{ $trnsl('content.equipments') }}
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
                :dataset="equipments"
                :title="trnsl('content.equipments')"
                fieldSearch="name"
                @action="getAction"
            />
        </template>

        <!-- MODAL -->
        <Modal
            :showModal="modal"
            @closeModal="closeModal"
            :title="title"
            modal-width="300px"
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
    import { useForm, Head, usePage, router } from '@inertiajs/vue3';
    import { trnsl } from '@/Lang/languages';
    import { successMessage, errorMessage, dialogBox } from '@/Helpers/helper'
    import { ref, onMounted } from 'vue';

    const props = defineProps({
        equipments: Array,
        projects: Array,
    });

    const page = usePage();
    
    const form = useForm({
        'id': '',
        'name': '',
        'project_id': '',
    });

    const reload = ref(0)
    const modal = ref(false)
    const title = ref('');
    const operation = ref('');
    const routePath = ref('');

    const headers = [
        {name: 'name', text: trnsl('content.name'), type: 'text', align: 'left'},
    ];

    const actions = [
        {name: 'edit', type: 'icon', text: trnsl('content.edit'), icon: 'fa fa-pencil', color: 'primary'},
        {name: 'delete', type: 'icon', text: trnsl('content.delete'), icon: 'fa fa-trash', color: 'danger' },
    ];
    
    const fields = [
        {name: 'project_id', type: 'select', text: trnsl('content.project'), style: 'sm:col-span-4', items:[], disabled: true }, 
        {name: 'name', type: 'text', text: trnsl('content.name'), style: 'sm:col-span-4',length: 255, disabled: false },
    ];

    const icons = [
        {name: 'home', text: trnsl('content.home'), icon: 'fa fa-home'},
        {name: 'new', text: trnsl('content.new'), icon: 'fa fa-plus'},
        
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

    //Delete Record
    const deleteRecord = (row) => {
        const dialog = dialogBox( row.name, trnsl('messages.confirmDelete'))
        dialog.fire().then((result) =>{
            if(result.isConfirmed){
                form.delete(route('project.equipments.destroy', row.id),{
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
            routePath.value = 'project.equipments.update'
            title.value = trnsl('content.edit') + ' ' + trnsl('content.equipments')
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
        } else {
            closeModal()
        }
    }

    const clickIconToolBar = (button) => {
        if (button === 'new') {
            operation.value = 'store'
            routePath.value = 'project.equipments.store'
            title.value = trnsl('content.create') + ' ' + trnsl('content.equipments')
            form.project_id = page.props.auth.currentProject.id
            openModal()
        } else if (button == 'home') {
            home()
        }
    }

    onMounted(() => {
        fields[0].items = props.projects;
        
    }) 

</script>