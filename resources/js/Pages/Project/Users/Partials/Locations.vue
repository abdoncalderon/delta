<template>

    <div class="m-2">
        <ToolBar
            class="mb-2"
            :icons="icons"
            @click="clickIconToolBar"
        />

        <DataTable
            :key="reload"
            :headers="headers"
            :actions="actions"
            :dataset="locationsProjectUser"
            :title="trnsl('content.locations')"
            fieldSearch="name"
            @action="getAction"
        />
    </div>

    <Modal
        :showModal="showNew"
        @closeModal="cancel"
        :title="trnsl('content.availableLocations')"
        modalWidth="300px"
    >
        

        <div class="my-2 mx-2 grid grid-cols-4 gap-2">
            <div class="col-span-4">
                <SelectMultiple
                    :list="form.locations"
                    :data="availableLocations"
                />
            </div>
        </div>

        <div class="p-3 mt-2 flex justify-end bg-gray-100">
            <PrimaryButton
                :disabled="form.processing"
                icon="fa fa-save"
                @click="saveLocations"
            >
                
                {{ $trnsl('content.save') }}
            </PrimaryButton>
            <SecondaryButton
                class="ml-3"
                :disabled="form.processing"
                icon="fa fa-ban"
                @click="cancel"
            >
                {{ $trnsl('content.cancel') }}
            </SecondaryButton>
        </div>
        
    </Modal>

</template>
<script setup>
    import DataTable from '@/Components/DataTable.vue'
    import ToolBar from '@/Components/ToolBar.vue'
    import Modal from '@/Components/Modal.vue'
    import PrimaryButton from '@/Components/PrimaryButton.vue' 
    import SecondaryButton from '@/Components/SecondaryButton.vue'
    import SelectMultiple from '@/Components/SelectMultiple.vue'
    import { successMessage, errorMessage, dialogBox, getError } from '@/Helpers/helper'
    import { trnsl } from '@/Lang/languages';
    import { useForm, Head, router } from '@inertiajs/vue3';
    import { ref, reactive, onMounted } from 'vue';
    import axios from 'axios';

    const props = defineProps({
        projectUser: Object,
    })

    const form = useForm({
        'id': '',
        'project_user_id': '',
        'locations': [],
    })

    const reload = ref(0)
    const showNew = ref(false)

    let locationsProjectUser = []
    let availableLocations = []

    const headers = [
        {name: 'name', text: trnsl('content.location'), type: 'text', align: 'left'},
    ];

    const actions = [
        {name: 'delete', type: 'icon', text: trnsl('content.delete'), icon: 'fa fa-trash', color: 'danger' },
    ];

    const icons = [
        {name: 'new', text: trnsl('content.new'), icon: 'fa-solid fa-plus'},
    ];


    const getLocationsProjectUser = () => {
        locationsProjectUser.length = 0
        axios.get(route('project.locationProjectUsers.getLocationsProjectUser', props.projectUser.id))
            .then(response=>{
                locationsProjectUser = response.data
                reload.value += 1;
            })
            .catch(error=>{
                console.log(error)
            })
    } 

    const getAvailableLocations = () => {
        availableLocations.length = 0
        axios.get(route('project.locationProjectUsers.getAvailableLocations', props.projectUser.id))
            .then(response=>{
                availableLocations = response.data
            })
            .catch(error=>{
                console.log(error)
            })
    } 

    const saveLocations = () => {
        form.post(route('project.locationProjectUsers.store'),{
            onSuccess: () => { 
                successMessage(trnsl('messages.recordSaved'))
                showNew.value = false
                getLocationsProjectUser()
                getAvailableLocations()
            },
            onError: (errors) => {
                errorMessage(trnsl('messages.recordNoSaved') + '\n\r '+ getError(errors))
                console.log(errors)
            }
        })
    }

    const deleteLocation = (row) => {
        const dialog = dialogBox( row.name, trnsl('messages.confirmDelete'))
        dialog.fire().then((result) =>{
            if(result.isConfirmed){
                form.delete(route('project.locationProjectUsers.destroy', row.id),{
                    onSuccess: () => { 
                        successMessage(trnsl('messages.recordDeleted'))
                        getLocationsProjectUser()
                        getAvailableLocations()
                    },
                    onError: (errors) => {
                        errorMessage(trnsl('messages.recordNoDeleted'))
                        console.log(errors)
                    }
                })
            }
        });
    } 

    const cancel = () => {
        showNew.value = false
        getLocationsProjectUser()
        getAvailableLocations()
    }

    const getAction = ( action ) => {
        if (action.name==='delete') {
            deleteLocation(action.data)
        } 
    }

    const clickIconToolBar = (button) => {
        if (button === 'new') {
            form.project_user_id = props.projectUser.id
            showNew.value = true
        } 
    }

    onMounted(()=>{
        getLocationsProjectUser()
        getAvailableLocations()
    })



</script>