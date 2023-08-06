<template>
    <AuthenticatedLayout>

        <Head :title="$trnsl('content.companies')"></Head>
        
        <template #header>
            {{ $trnsl('content.companies') }}
        </template>

        <template #subheader>
            {{ $trnsl('content.setting') }}
        </template>

        <template #content>
            <ToolBar
                :buttons="buttons"
                @click="clickIconToolBar"
            />
            <DataTable
                :key="reload"
                :headers="headers"
                :actions="actions"
                :dataset="companies"
                :table="trnsl('content.companies')"
                fieldSearch="name"
                @select="executeAction"
            />
        </template>

        <!-- MODAL -->
        <Modal
            :show="modal"
            @close="closeModal"
        >
            <h3 class="px-5 py-3 font-semibold text-blue-500 bg-gray-100">
                {{ title }}
            </h3>

            <Form
                :fields="fields"
                :form="form"
                :table="trnsl('content.companies')"
                :routePath="routePath"
                :operation="operation"
                @submit="confirmTransaction"
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
    import Swal from 'sweetalert2';
    import { trnsl } from '@/Lang/languages';
    import { successMessage, errorMessage } from '@/Helpers/helper'
    import { ref, onMounted } from 'vue';

    const props = defineProps({
        companies: {type: Object},
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
                    {name: 'name', type: 'text', text: trnsl('content.name'), style: 'sm:col-span-4', lenght: 255 },
                ];
    
    const buttons = [
                    {name: 'new', text: trnsl('content.new'), icon: 'fa fa-plus'},
                    {name: 'exit', text: trnsl('content.exit'), icon: 'fa-solid fa-arrow-up-right-from-square'}
                ];
    
    const formReset = () => {
        fields.forEach( (row, i) => {
            if (row['preserve']==null) {
                form.reset(row['name'])
            }
        })
    }

    const openModal = ( row ) => {
        modal.value = true;
    }

    const closeModal = () => {
        modal.value = false;
        reload.value += 1;
        formReset();
    }
    
    const home = () => {
        router.visit(route('dashboard'))
    } 

    //Delete Record
    const deleteRecord = (row) => {
        const alert = Swal.mixin({
            buttonsStyling:true
        });
        alert.fire({
            toast: true,
            titleText: row.name,
            text: trnsl('messages.confirmDelete'),
            icon: 'question', 
            showCancelButton:true,
            confirmButtonText: '<i class="fa fa-check"></i>' + ' ' + trnsl('content.delete'),
            cancelButtonText: '<i class="fa fa-ban"></i>' + ' ' + trnsl('content.cancel'),
            showClass: {
                popup: '',
                icon: '',
            },
        }).then((result) =>{
            if(result.isConfirmed){
                form.delete(route('settings.companies.destroy', row.id),{
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

    const executeAction = ( params ) => {
        if (params[1]==='edit') {
            operation.value = 'update'
            routePath.value = 'settings.companies.update'
            title.value = trnsl('content.edit') + ' ' + trnsl('content.companies')
            fields.forEach( (field) => {
                form[field.name]=params[0][field.name];
            })
            openModal()
        } else if (params[1]==='delete') {
            deleteRecord(params[0])
        }
    }

    const confirmTransaction = ( params ) => {
        if (params[1]==='store'){
            if (params[0]==1){
                successMessage(trnsl('messages.recordSaved'))
                closeModal()
            } else {
                errorMessage(trnsl('messages.recordNoSaved'))
            } 
        } else if ((params[1]==='update')||(params[1]==='updateWithFile')) {
            if (params[0]==1){
                successMessage(trnsl('messages.recordUpdated')) 
                closeModal()
            } else {
                errorMessage(trnsl('messages.recordNoUpdated'))
            } 
        } else {
            closeModal()
        }
    }

    const clickIconToolBar = (button) => {
        if (button === 'new') {
            operation.value = 'store'
            routePath.value = 'settings.companies.store'
            title.value = trnsl('content.create') + ' ' + trnsl('content.companies')
            openModal()
        } else if (button == 'exit') {
            home()
        }
    }

</script>