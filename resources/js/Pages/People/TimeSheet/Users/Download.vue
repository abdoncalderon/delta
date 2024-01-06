<template>

    <div class="m-2">
        

        <div class="my-2 grid grid-cols-1 sm:grid-cols-12 gap-2">
            
            
            <div class="col-span-1 sm:col-span-12">
                <InputLabel 
                    for="clock" 
                    :value="trnsl('content.clock')"
                ></InputLabel>
                <SelectInput 
                    :options="clocks"
                    v-model="clock"
                    @change="changeClock"
                ></SelectInput>
            </div>

            

            <div class="col-span-1 sm:col-span-12">
                <DataTable
                    :key="reload"
                    :headers="headers"
                    :actions="actions"
                    :dataset="users"
                    :title="trnsl('content.users')"
                    fieldSearch="name"
                    @action="getAction"
                />

            </div>

            
            
        </div>

        <div class="mt-2 flex justify-end">
                <PrimaryButton
                    @click="downloadUsers"
                    icon="fa fa-upload"
                >
                    {{ $trnsl('content.download') }}
                </PrimaryButton>
            </div>

    </div>
        
</template>

<script setup>
    
    import DataTable from '@/Components/DataTable.vue'
    import PrimaryButton from '@/Components/PrimaryButton.vue'
    import SelectInput from '@/Components/SelectInput.vue'
    import InputLabel from '@/Components/InputLabel.vue'
    import { trnsl } from '@/Lang/languages';
    import { Head, router } from '@inertiajs/vue3';
    import { successMessage, errorMessage, getError, dialogBox } from '@/Helpers/helper'
    import { ref, computed } from 'vue';
    import axios from 'axios'
    

    const props = defineProps({
        clocks: Array,
    })
    

    const reload = ref(0)

    const clock = ref(0)

    let users = []

    const icons = [
        {name: 'home', text: trnsl('content.home'), icon: 'fa fa-home'},
        {name: 'back', text: trnsl('content.back'), icon: 'fa fa-arrow-left'},    
        {name: 'download', text: trnsl('content.download'), icon: 'fa fa-download' },     
    ];

    const headers = [
        {name: 'userid', type: 'text', text: trnsl('content.uid'), align: 'left'},
        {name: 'name', type: 'text', text: trnsl('content.name'), align: 'left'},
    ];

    const actions = [
        {name: 'delete', type: 'icon', text: trnsl('content.delete'), icon: 'fa fa-trash', color: 'danger' },
    ];

    const home = () => {
        router.visit(route('dashboard'))
    } 

    const back = () => {
        router.visit(route('people.timesheet.home'))
    } 

    const getAction = ( action ) => {
        if (action.name==='delete') {
            removeUser(action.data)
        }
    }
  
    const clickIconToolBar = (button) => {
        if (button == 'back') {
            back()
        } else if (button == 'home') {
            home()
        } else if (button == 'download') {
            downloadUsers()
        }
    }

    const changeClock = () => {
        users.length = 0
        reload.value += 1
    }

    

    const downloadUsers = () => {
        if (clock.value > 0){
            const dialog = dialogBox( trnsl('content.uploadUsers'), trnsl('messages.confirmUploadUsersToClock'))
            dialog.fire().then((result) =>{
                if(result.isConfirmed){
                    users.length = 0
                    axios.get(route('people.timesheet.clocks.getUsers', clock.value))
                        .then(response=>{
                            for (let user in response.data) {
                                users.push(response.data[user])
                            }
                            reload.value += 1
                            successMessage(trnsl('messages.successfullOperation'))
                        })
                        .catch(error=>{
                            console.log(error)
                            errorMessage(trnsl('content.error') + '\n\r '+ getError(error))
                        })
                }
            })
        }
        
    }

    const removeUser = (user) => {
        if (clock.value > 0){
            const dialog = dialogBox( trnsl('content.uploadUsers'), trnsl('messages.confirmDeleteUserInClock'))
            dialog.fire().then((result) =>{
                if(result.isConfirmed){
                    users.length = 0
                    axios.get(route('people.timesheet.clocks.removeUser',[clock.value, user.uid]))
                        .then(response=>{
                            successMessage(trnsl('messages.successfullOperation'))
                            users.length = 0
                            clock.value = 0
                            reload.value += 1
                        })
                        .catch(error=>{
                            console.log(error)
                        })
                }
            })
        }

        
    }

</script>