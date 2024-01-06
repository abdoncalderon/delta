<template>
    <Windows
        :title="trnsl('content.edit') + ' - ' + form.user"
        @close="closeEdit"
    >
        <template #body>

            <Tabs
            :tabs="tabs"
            >
                <template #data>
                    <Data
                        :form="form"
                        :projects="projects"
                        :users="users"
                        :roles="roles"
                        @event="getEvent"
                    />
                </template>

                <template #locations>
                    <Locations
                        :projectUser="projectUser"
                    />
                </template>
               
            </Tabs>

        </template>
        
    </Windows>

    <!-- <div class="border border-gray-500 bg-gray-200 rounded-lg overflow-auto">

        <h3 class="px-3 py-2 text-sm text-white bg-gray-700">
            {{ $trnsl('messages.editProjectUser') }}
        </h3>

        <div class="m-1 px-1 py-1 grid grid-cols-1 sm:grid-cols-12 gap-2">
            

        </div>

        <div class="p-2 flex justify-end">
            <PrimaryButton
                class="ml-3"
                :disabled="form.processing"
                @click="save"
                icon="fa fa-save"
            >
                {{ $trnsl('content.save') }}
            </PrimaryButton>
            <SecondaryButton
                class="ml-3"
                :disabled="form.processing"
                icon="fa-solid fa-circle-xmark"
                @click="cancel"
            >
                {{ $trnsl('content.cancel') }}
            </SecondaryButton>
        </div>

    </div> -->
</template>
<script setup>

    import Data from './Partials/Data.vue'
    import Locations from './Partials/Locations.vue'
    import Windows from '@/Components/Window.vue'
    import Tabs from '@/Components/Tabs.vue'
    import { useForm, usePage } from '@inertiajs/vue3';
    import { trnsl } from '@/Lang/languages';
    import { onMounted } from 'vue';

    const props = defineProps({
        projectUser: Object,
        projects: Array,
        users: Array,
        roles: Array,
    })

    const form = useForm({
        'id': '',
        'user_id': '',
        'project_id': '',
        'role_id': '',
        'user': '',
        'email': '',
        'isActive': '',
    });

    const page = usePage();

    const emit = defineEmits([
        'event'   
    ])

    const event = {
        source: '',
        action: '',
        status: 0,
        data: null,
    }

    const tabs = [
        { name: 'data', text: trnsl('content.data') },  
        { name: 'locations', text: trnsl('content.locations') }, 
    ]

    const closeEdit = () => {
        event.source = 'edit'
        event.action = 'close'
        event.status = 1
        emit('event', event)
    }

    const getEvent = ( event ) => {
        emit('event', event)
    }

    onMounted(()=>{
        form.id = props.projectUser.id
        form.project_id = props.projectUser.project_id
        form.user_id = props.projectUser.user_id
        form.role_id = props.projectUser.role_id
        form.project_id = props.projectUser.project_id
        form.user = props.projectUser.user.user
        form.email = props.projectUser.user.email
        form.isActive = props.projectUser.isActive
    })

</script>