<template>

    <Windows
        :title="trnsl('content.edit') + ' - ' + form.fullName"
        @close="closeEdit"
    >
        <template #body>

            <Tabs
                :tabs="tabs"
            >
                <template #personalData>
                    <PersonalData
                        :form="form"
                        @event="getEvent"
                    />
                </template>

                <template #addresses>
                    <Addresses
                        :person="person"
                        
                    />
                </template>

                <template #phones>
                    <Phones 
                        :person="person"
                        :regions="regions"
                    />
                </template>

                <template #contracts>
                    <Contracts 
                        :person="person"
                        :projectPeople="projectPeople"
                        :stakeholders="stakeholders"
                        :sectors="sectors"
                        :functions="functions"
                    />
                </template>

            </Tabs>

        </template>
        
    </Windows>

    
</template>

<script setup>
    import PersonalData from './Partials/PersonalData.vue'
    import Addresses from './Partials/Addresses.vue'
    import Phones from './Partials/Phones.vue'
    import Contracts from './Partials/Contracts.vue'
    import Windows from '@/Components/Window.vue'
    import Tabs from '@/Components/Tabs.vue'
    import { useForm } from '@inertiajs/vue3'
    import { trnsl } from '@/Lang/languages'
    import { onMounted } from 'vue'
    
    const props = defineProps({
        person: Object,
        regions: Array,
        projectPeople: Array,
        stakeholders: Array,
        functions: Array,
        sectors: Array,
    })

    const emit = defineEmits([
        'event'   
    ])

    const form = useForm({
        'id': '',
        'uid': '',
        'fullName': '',
        'firstName': '',
        'lastName': '',
        'gender_id': '',
        'birthDate': '',
        'jobTitle': '',
        'email': '',
        'photo': '',
        'signature': '',
        'isActive': '',
        'isLocked': '',
        _method: 'patch',
    })

    const tabs = [
        { name: 'personalData', text: trnsl('content.personal') },  
        { name: 'addresses', text: trnsl('content.addresses') }, 
        { name: 'phones', text: trnsl('content.phones') }, 
        { name: 'contracts', text: trnsl('content.contracts') }, 
    ]

    const event = {
        source: '',
        action: '',
        status: 0,
        data: null,
    }

    const closeEdit = () => {
        event.source = 'edit'
        event.status = 0
        event.action = 'close'
        emit('event', event)
    }

    const getEvent = ( event ) => {
        emit('event', event)
    }

    onMounted(()=>{
        form.id = props.person.id
        form.uid = props.person.uid
        form.fullName = props.person.fullName
        form.firstName = props.person.firstName
        form.lastName = props.person.lastName
        form.gender_id = props.person.gender_id
        form.birthDate = props.person.birthDate
        form.jobTitle = props.person.jobTitle
        form.email = props.person.email
        form.photo = props.person.photo
        form.signature = props.person.signature
    })

</script>