<template>
    <AuthenticatedLayout>

        <Head :title="$trnsl('content.stakeholders')"></Head>
        
        <template #header>
            {{ $trnsl('content.stakeholders') }}
        </template>

        <template #subheader>
            {{ $trnsl('content.project') }}
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
                :dataset="stakeholders"
                :table="trnsl('content.stakeholders')"
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
                :table="trnsl('content.stakeholders')"
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
        stakeholders: Array,
        projects: Array,
        cities: Array,
        stakeholderTypes: Array,
    });

    const page = usePage()
    
    const formNew = useForm({
        'id': '',
        'name': '',
        'project_id': '',
        'code': '',
        'taxId': '',
        'city_id': '',
        'address': '',
        'zipCode': '',
        'email': '',
        'phoneNumber': '',
        'logofile': '',
        'stakeholder_type_id': '',
    });

    const formEdit = useForm({
        'id': '',
        'name': '',
        'project_id': '',
        'code': '',
        'taxId': '',
        'city_id': '',
        'address': '',
        'zipCode': '',
        'email': '',
        'phoneNumber': '',
        'logofile': '',
        'stakeholder_type_id': '',
        _method: 'patch',
    });

    let form = useForm({})

    const reload = ref(0)
    const modal = ref(false)
    const title = ref('');
    const operation = ref('');
    const routePath = ref('');

    const headers = [
                    {name: 'name', type: 'text', text: trnsl('content.name'), align: 'left'},
                    {name: 'logofile', type: 'image', text: trnsl('content.logo'), align: 'center', path: 'http://delta.test/storage/kapatax/images/stakeholders/'},
                ];
    
    const actions = [
                    {name: 'edit', type: 'icon', text: trnsl('content.edit'), icon: 'fa fa-pencil', color: 'primary'},
                    {name: 'delete', type: 'icon', text: trnsl('content.delete'), icon: 'fa fa-trash', color: 'danger' },
                ];
    
    const fields = [
                    {name: 'id', type: 'hidden'},
                    {name: 'project_id', type: 'select', text: trnsl('content.project'),style: 'sm:col-span-4', items:[], disabled: true, preserve: true},
                    {name: 'name', type: 'text', text: trnsl('content.name'), style: 'sm:col-span-4',lenght: 255, disabled: false },
                    {name: 'code', type: 'text', text: trnsl('content.code'), style: 'sm:col-span-2',lenght: 255, disabled: false },
                    {name: 'taxId', type: 'text', text: trnsl('content.taxId'), style: 'sm:col-span-2',lenght: 255, disabled: false},
                    {name: 'city_id', type: 'select', text: trnsl('content.city'), style: 'sm:col-span-2', items:[], disabled: false},
                    {name: 'zipCode', type: 'text', text: trnsl('content.zipCode'), style: 'sm:col-span-2',lenght: 255, disabled: false},
                    {name: 'address', type: 'text', text: trnsl('content.address'), style: 'sm:col-span-4',lenght: 255, disabled: false},
                    {name: 'email', type: 'email', text: trnsl('content.email'), style: 'sm:col-span-2',lenght: 255, disabled: false},
                    {name: 'phoneNumber', type: 'text', text: trnsl('content.phoneNumber'), style: 'sm:col-span-2',lenght: 255, disabled: false},
                    {name: 'logofile', type: 'file', text: trnsl('content.logo'), style: 'sm:col-span-2', accept: 'image/png, .jpg', disabled: false},
                    {name: 'stakeholder_type_id', type: 'select', text: trnsl('content.type'), style: 'sm:col-span-2', items:[], disabled: false}, 
                ];
    
    const buttons = [
                    {name: 'new', text: trnsl('content.new'), icon: 'fa fa-plus'},
                    {name: 'exit', text: trnsl('content.exit'), icon: 'fa-solid fa-arrow-up-right-from-square'}
                ];

    const formReset = () => {
        fields.forEach( (row, i) => {
            if (row['preserve']==null) {
                formNew.reset(row['name'])
                formEdit.reset(row['name'])
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
                form.delete(route('project.stakeholders.destroy', row.id),{
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
            form = formEdit
            operation.value = 'updateWithFile'
            routePath.value = 'project.stakeholders.update'
            title.value = trnsl('content.edit') + ' ' + trnsl('content.stakeholders')
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
            form = formNew
            operation.value = 'store'
            routePath.value = 'project.stakeholders.store'
            title.value = trnsl('content.create') + ' ' + trnsl('content.stakeholders')
            openModal()
        } else if (button == 'exit') {
            home()
        }
    }

    onMounted(() => {
        
        fields[1].items = props.projects;
        fields[5].items = props.cities;
        fields[11].items = props.stakeholderTypes;
        formNew.project_id = page.props.auth.currentProject[0].id
    }) 

    

    

</script>