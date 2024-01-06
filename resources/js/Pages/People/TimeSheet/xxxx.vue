<template>
    <AuthenticatedLayout>
        <Head :title="$trnsl('content.timesheet')"></Head>
        
        <template #header>
            {{ $trnsl('content.timesheet') }}
        </template>

        <template #subheader>
            {{ $trnsl('content.people') }}
        </template>

        <template #content>
            <div>
                {{ serialNumber }}
                {{ deviceName }}
                {{ firmwareVersion }}
                {{ platform }}

            </div>
            <button class="m-1 p-2 rounded bg-black text-white" @click="getAttendance">Attendande</button>
            <button class="m-1 p-2 rounded bg-black text-white" @click="getUsers">Get Users</button>
            <button class="m-1 p-2 rounded bg-black text-white" @click="clearUsers">Clear Users</button>
            <button class="m-1 p-2 rounded bg-black text-white" @click="addUser">Add User</button>
            <button class="m-1 p-2 rounded bg-black text-white" @click="setTime">Set Time</button>
            <button class="m-1 p-2 rounded bg-black text-white" @click="getTime">Get Time</button>
        </template>

        <hr>
        {{ attendance }}
        <hr>
        {{ users }}
        

    </AuthenticatedLayout>
</template>

<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
    import { Head } from '@inertiajs/vue3'
    import { ref, reactive } from 'vue';
    import axios from 'axios'

    const props = defineProps({
        serialNumber: String,
        deviceName: String,
        firmwareVersion: String,
        platform: String,
    });

    // const attendance = reactive([])
    const attendance = ref(null)
    const users = ref(null)

    const getAttendance = () => {
        attendance.length = 0
        axios.get(route('people.timesheet.getAttendance'))
            .then(response=>{
                attendance.value = response.data
                /* response.data.forEach((row, i) => {
                    attendance[i] = row
                }); */
            })
            .catch(error=>{
                console.log(error)
            })
    }

    const getUsers = () => {
        users.length = 0
        axios.get(route('people.timesheet.getUsers'))
            .then(response=>{
                console.log(response.data)
                users.value = response.data
                /* if (response.data.isArray) {
                    response.data.forEach((row, i) => {
                        users[i] = row
                    });
                } */
                let i = 0
                
                
            })
            .catch(error=>{
                console.log(error)
            })
    }

    const clearUsers = () => {
        axios.get(route('people.timesheet.clearUsers'))
            .then(response=>{
                let result = response.data 
                if (result) {
                    console.log('borrado exito')
                }
            })
            .catch(error=>{
                console.log(error)
            })
    }

    const addUser = () => {
        axios.get(route('people.timesheet.addUser'))
            .then(response=>{
                let result = response.data 
                console.log(result)
                if (result) {
                    console.log('agregado exito')
                }
            })
            .catch(error=>{
                console.log(error)
            })
    }

    const setTime = () => {
        axios.get(route('people.timesheet.setTime'))
            .then(response=>{
                let result = response.data 
                console.log(result)
                if (result) {
                    console.log('acturalizadp exito')
                }
            })
            .catch(error=>{
                console.log(error)
            })
    }

    const getTime = () => {
        axios.get(route('people.timesheet.getTime'))
            .then(response=>{
                let result = response.data 
                console.log(result)
                if (result) {
                    console.log('acturalizadp exito')
                }
            })
            .catch(error=>{
                console.log(error)
            })
    }

</script>