<template>
    <AuthenticatedLayout>

        <Head :title="$trnsl('messages.assignmentLocation')"></Head>

        <template #header>
            {{ $trnsl('messages.assignmentLocationToUser') }}
        </template>

        <template #subheader>
            {{ $trnsl('content.production') }}
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
                :dataset="locationProjectUsers"
                :title="trnsl('messages.locationsAssignedTo') + ' ' + person.fullName "
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
                        :list="form.locations"
                        :data="availableLocations"
                    />
                </div>
                <div class="col-span-3">
                    <InputLabel 
                        for="profile" 
                        :value="trnsl('content.profile')"
                        
                    ></InputLabel>
                    <SelectInput 
                        id="profile"
                        :options="profiles"
                        v-model="form.profile"
                    ></SelectInput>
                    <InputError 
                        :message="form.errors.profile"
                    ></InputError>
                </div>
                <div class="col-span-1">
                    <InputLabel 
                        for="notifications" 
                        :value="trnsl('content.notifications')"
                        
                    ></InputLabel>
                    <Checkbox 
                        id="notifications"
                        v-model:checked="form.receive_notification"
                        :value="form.receive_notification"
                    ></Checkbox>
                    <InputError 
                        :message="form.errors.notifications"
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
                :fields="fields"
                :form="formEdit"
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
    import Modal from '@/Components/Modal.vue'
    import Form from '@/Components/Form.vue'
    import ToolBar from '@/Components/ToolBar.vue'
    import PrimaryButton from '@/Components/PrimaryButton.vue' 
    import SecondaryButton from '@/Components/SecondaryButton.vue'
    import InputError from '@/Components/InputError.vue'
    import InputLabel from '@/Components/InputLabel.vue'
    import SelectInput from '@/Components/SelectInput.vue'
    import Checkbox from '@/Components/Checkbox.vue'
    import SelectMultiple from '@/Components/SelectMultiple.vue'
    import { successMessage, errorMessage, dialogBox, getError } from '@/Helpers/helper'
    import { trnsl } from '@/Lang/languages';
    import { useForm, Head, router } from '@inertiajs/vue3';
    import { ref, reactive, onMounted } from 'vue';

    const props = defineProps({
        projectUser: Object,
        person: Object,
        locationProjectUsers: Array,
        availableLocations: Array,
    });

    const form = useForm({
        'id': '',
        'project_user_id': '',
        'locations': [],
        'profile': '',
        'receive_notification': false,
    })

    const formEdit = useForm({
        'id': '',
        'location_id': '',
        'location': '',
        'project_user_id': '',
        'profile': '',
        'receive_notification': false,
    })

    const reload = ref(0)
    const showModalNew = ref(false)
    const showModalEdit = ref(false)
    const title = ref('')
    const operation = ref('')
    const routePath = ref('')
    

    const headers = [
        {name: 'location.name', text: trnsl('content.location'), type: 'text', align: 'left'},
        {name: 'profile', text: trnsl('content.profile'), type: 'list', align: 'left', items: []},
        
    ];

    const actions = [
        {name: 'edit', type: 'icon', text: trnsl('content.edit'), icon: 'fa fa-pencil', color: 'primary'},
        {name: 'delete', type: 'icon', text: trnsl('content.delete'), icon: 'fa fa-trash', color: 'danger' },
    ];

    const fields = [
        {name: 'location', type: 'text', text: trnsl('content.location'), style: 'sm:col-span-4',  length: 255, disabled: true },
        {name: 'profile', type: 'select', text: trnsl('content.profile'), style: 'sm:col-span-2', items:[], disabled: false },
        {name: 'receive_notification', type: 'switch', text: trnsl('content.notifications'), style: 'sm:col-span-1', disabled: false }, 
    ];

    const icons = [
        {name: 'home', text: trnsl('content.exit'), icon: 'fa-solid fa-home'},
        {name: 'back', text: trnsl('content.back'), icon: 'fa-solid fa-arrow-left'},
        {name: 'new', text: trnsl('content.new'), icon: 'fa-solid fa-plus'},
    ];

    const profiles = [
        {id: 1, name: trnsl('content.collaborator')},
        {id: 2, name: trnsl('content.reviewer')},
        {id: 3, name: trnsl('content.approver')},
    ]

    const home = () => {
        router.visit(route('dashboard'))
    } 

    const back = () => {
        router.visit(route('production.workbook.users.index'))
    }

    const openModalNew = (row) => {
        showModalNew.value = true;
    }

    const openModalEdit = (row) => {
        showModalEdit.value = true;
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
        formEdit.reset()
        formEdit.clearErrors()
    }

    const deleteRecord = (row) => {
        const dialog = dialogBox( row.name, trnsl('messages.confirmDelete'))
        dialog.fire().then((result) =>{
            if(result.isConfirmed){
                form.delete(route('production.workbook.users.locations.destroy', row.id),{
                    onSuccess: () => { 
                        successMessage(trnsl('messages.recordDeleted'))
                        reload.value += 1;
                    },
                    onError: (errors) => {
                        errorMessage(trnsl('messages.recordNoDeleted'))
                        console.log(errors)
                    }
                })
            }
        });
    }

    const saveRecord = () => {
        form.post(route('production.workbook.users.locations.store'),{
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

    const getAction = ( action ) => {
        if (action.name==='edit') {
            fields[1].items = profiles
            operation.value = 'update'
            routePath.value = 'production.workbook.users.locations.update'
            title.value = trnsl('content.edit') + ' ' + trnsl('content.locations')
            formEdit.id = action.data.id
            formEdit.project_user_id = props.projectUser.id
            formEdit.location_id = action.data.location.id
            formEdit.location = action.data.location.name
            formEdit.profile = action.data.profile
            formEdit.receive_notification = action.data.receive_notification
            openModalEdit(action.data)
        } else if (action.name==='delete') {
                    deleteRecord(action.data)
                }
    }

    const clickIconToolBar = (button) => {
        if (button === 'new') {
            form.project_user_id = props.projectUser.id
            operation.value = 'store'
            routePath.value = 'production.workbook.users.locations.store'
            title.value = trnsl('messages.locationsAssignment')
            openModalNew()
        } else if (button == 'back') {
                    back()
                } else if (button == 'home') {
                            home()
                        }
    }

    const getEvent = ( event ) => {
        if (event.action==='store'){
            if (event.status==1){
                closeModalNew()
            } 
        } else if ((event.action==='update')||(event.action==='updateWithFile')) {
            if (event.status==1){
                closeModalEdit()
            } 
        } else {
            closeModalNew()
            closeModalEdit()
        }
    }

    onMounted(()=>{
        headers[1].items = profiles
    })
    
</script>
