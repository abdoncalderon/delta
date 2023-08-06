<template> 
    <AuthenticatedLayout>

        <Head :title="$trnsl('content.assignments')"/>

        <template #header>
            {{ $trnsl('messages.equipmentAssignment') }}
        </template>

        <template #subheader>
            {{ $trnsl('content.technology') }}
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
                :dataset="stakeholderPersonAssets"
                :table="trnsl('messages.assignedAssets')+' ['+stakeholderPerson[0].name+']'"
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
                :table="trnsl('messages.equipmentAssignment')"
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
        stakeholderPerson: Array,
        assets: Array,
        stakeholderPersonAssets: Array,
        projectUsers: Array,
    });

    const page = usePage();
    
    const formDelivery = useForm({
        'stakeholder_person_id': '',
        'asset_id': '',
        'deliveryDate': '',
        'deliveredBy': '',
        'comments': '',
    });

    const formReturn = useForm({
        'id': '',
        'stakeholder_person_id': '',
        'asset_id': '',
        'returnDate': '',
        'receivedBy': '',
        'comments': '',
    });

    let form = useForm({})

    const reload = ref(0)
    const modal = ref(false)
    const title = ref('');
    const operation = ref('');
    const routePath = ref('');

    const headers = [
                    {name: 'sn', text: trnsl('content.serialNumber'), type: 'text', align: 'left'},
                    {name: 'delivery', text: trnsl('content.delivery'), type: 'text', align: 'left'},
                    {name: 'return', text: trnsl('content.return'), type: 'text', align: 'left'},
                ];

    const actions = [
                    {name: 'edit', type: 'icon', text: trnsl('content.edit'), icon: 'fa fa-pencil', color: 'primary'},
                    {name: 'delete', type: 'icon', text: trnsl('content.delete'), icon: 'fa fa-trash', color: 'danger' },
                ];
    
    const fieldsDelivery = [
                    {name: 'id', type: 'hidden'},
                    {name: 'stakeholder_person_id', type: 'select', text: trnsl('content.person'), style: 'sm:col-span-4', items:[], disabled: true}, 
                    {name: 'asset_id', type: 'selectDynamic', text: trnsl('content.asset'), style: 'sm:col-span-4', items:[], show: 'name', disabled: false}, 
                    {name: 'deliveryDate', type: 'date', text: trnsl('messages.deliveryDate'), style: 'sm:col-span-2', lenght: 255, disabled: false },
                    {name: 'deliveredBy', type: 'select', text: trnsl('messages.deliveredBy'), style: 'sm:col-span-2', items:[], disabled: false },
                    {name: 'comments', type: 'textarea', text: trnsl('content.comments'), style: 'sm:col-span-4', rows: 6, disabled: false },
                ];
    
    const fieldsReturn = [
                    {name: 'id', type: 'hidden'},
                    {name: 'stakeholder_person_id', type: 'select', text: trnsl('content.person'), style: 'sm:col-span-4', items:[], disabled: true}, 
                    {name: 'asset_id', type: 'selectDynamic', text: trnsl('content.asset'), style: 'sm:col-span-4', items:[], show: 'name', disabled: true}, 
                    {name: 'deliveryDate', type: 'date', text: trnsl('messages.deliveryDate'), style: 'sm:col-span-2', lenght: 255, disabled: true },
                    {name: 'deliveredBy', type: 'text', text: trnsl('messages.deliveredBy'), style: 'sm:col-span-2', items:[], disabled: true },
                    {name: 'returnDate', type: 'date', text: trnsl('messages.returnDate'), style: 'sm:col-span-2', lenght: 255, disabled: false },
                    {name: 'receivedBy', type: 'select', text: trnsl('messages.receivedBy'), style: 'sm:col-span-2', items:[], disabled: true },
                    {name: 'comments', type: 'textarea', text: trnsl('content.comments'), style: 'sm:col-span-4', rows: 6, disabled: false },
    ];

    let fields = []

    const buttons = [
                    {name: 'home', text: trnsl('content.home'), icon: 'fa-solid fa-home'},
                    {name: 'back', text: trnsl('content.back'), icon: 'fa-solid fa-arrow-left'},       
                    {name: 'new', text: trnsl('content.new'), icon: 'fa fa-plus'},
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

    const back = () => {
        router.visit(route('administration.technology.assignments'))
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
                form.delete(route('administration.technology.assignments.assets.destroy', row.id),{
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
            fields = fieldsReturn
            form = formReturn
            form.receivedBy = page.props.auth.user.id
            operation.value = 'update'
            routePath.value = 'administration.technology.assignments.assets.return'
            title.value = trnsl('messages.returnAssets')
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
            fields = fieldsDelivery
            form = formDelivery
            form.stakeholder_person_id = props.stakeholderPerson[0].id
            form.deliveredBy = page.props.auth.user.id
            operation.value = 'store'
            routePath.value = 'administration.technology.assignments.assets.delivery'
            title.value = trnsl('messages.equipmentAssignment')
            openModal()
        } else if (button == 'back') {
            back()
        } else if (button == 'home') {
            home()
        }
    }

    onMounted(() => {
        fieldsDelivery[1].items = props.stakeholderPerson;
        fieldsDelivery[2].items = props.assets;
        fieldsDelivery[4].items = props.projectUsers;
        fieldsReturn[1].items = props.stakeholderPerson;
        fieldsReturn[2].items = props.assets;
        fieldsReturn[4].items = props.projectUsers;
    })
</script>