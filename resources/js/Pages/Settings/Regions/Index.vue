<template>
    <AuthenticatedLayout>

        <Head :title="$trnsl('content.regions')"></Head>
        
        <template #header>
            {{ $trnsl('content.regions') }}
        </template>

        <template #subheader>
            {{ $trnsl('content.setting') }}
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
                :dataset="regions"
                :title="trnsl('content.regions')"
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
            <!-- <h3 class="px-3 py-3 font-semibold text-sm text-white bg-gray-700">
                {{ title }}
            </h3> -->

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
        regions: {type: Object},
    });

    const page = usePage();

    const form = useForm({
        'id': '',
        'name': '',
    });

    const reload = ref(0)
    const modal = ref(false)
    const title = ref('');
    const operation = ref('');
    const routePath = ref('');

    const headers = [
        {name: 'name', type: 'text', text: trnsl('content.name'), align: 'left'},
    ];
    
    const actions = [
        {name: 'edit', type: 'icon', text: trnsl('content.edit'), icon: 'fa fa-pencil', color: 'primary'},
        {name: 'delete', type: 'icon', text: trnsl('content.delete'), icon: 'fa fa-trash', color: 'danger' },
    ];
    
    const fields = [
        {name: 'id', type: 'hidden'},
        {name: 'name', type: 'text', text: trnsl('content.name'), style: 'sm:col-span-4', length: 255 },
    ];
    
    const icons = [
        {name: 'home', text: trnsl('content.home'), icon: 'fa fa-home'},
        {name: 'new', text: trnsl('content.new'), icon: 'fa fa-plus'},
    ];

    const openModal = ( row ) => {
        modal.value = true;
    }

    const closeModal = () => {
        modal.value = false
        reload.value += 1
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
                form.delete(route('settings.regions.destroy', row.id),{
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
            routePath.value = 'settings.regions.update'
            title.value = trnsl('content.edit') + ' ' + trnsl('content.regions')
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
            routePath.value = 'settings.regions.store'
            title.value = trnsl('content.create') + ' ' + trnsl('content.regions')
            openModal()
        } else if (button == 'home') {
            home()
        }
    }

</script>