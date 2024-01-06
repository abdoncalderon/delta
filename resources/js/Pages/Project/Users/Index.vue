<template>
    <AuthenticatedLayout>

        <Head :title="$trnsl('content.users')"></Head>
        
        <template #header>
            {{ $trnsl('content.users') }}
        </template>

        <template #subheader>
            {{ $trnsl('content.project') }}
        </template>

        <template #content>
            <div class="my-2">
                <ToolBar
                    :icons="icons"
                    @click="clickIconToolBar"
                />
            </div>

            <List
                v-if="showList"
                :projectUsers="projectUsers"
                @event="getEvent"
            />

            <New
                v-if="showNew"
                :users="users"
                :projects="projects"
                :roles="roles"
                @event="getEvent"
            />

            <Edit
                v-if="showEdit"
                :projectUser="projectUser"
                :users="users"
                :projects="projects"
                :roles="roles"
                @event="getEvent"
            />
            
        </template>

        

        <!-- MODAL -->
        <!-- <Modal
            :show="modal"
            @close="closeModal"
        >
            <h3 class="px-3 py-3 font-semibold text-sm text-white bg-gray-700">
                {{ title }}
            </h3>

            <Form
                :fields="fields"
                :form="form"
                :routePath="routePath"
                :operation="operation"
                @submit="getEvent"
                :acceptText="trnsl('content.save')"
            />
        </Modal> -->
        
    </AuthenticatedLayout>
</template>

<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
    
    import New from './New.vue'
    import List from './List.vue'
    import Edit from './Edit.vue'
    import ToolBar from '@/Components/ToolBar.vue'
    import { useForm, Head, usePage, router } from '@inertiajs/vue3';
    import { trnsl } from '@/Lang/languages';
    import { ref } from 'vue';

    const props = defineProps({
        projectUsers: Array,
        projects: Array,
        users: Array,
        roles: Array,
    });

    const page = usePage();
    
    const form = useForm({
        'id': '',
        'user_id': '',
        'project_id': '',
        'role_id': '',
        'user': '',
        'password': '',
        'email': '',
    });

    const showList = ref(true)
    const showNew = ref(false)
    const showEdit = ref(false)

    let projectUser = null

    const icons = [
        {name: 'home', text: trnsl('content.home'), icon: 'fa fa-home'},
        {name: 'new', text: trnsl('content.new'), icon: 'fa fa-plus'},
        {name: 'list', text: trnsl('content.list'), icon: 'fa fa-table'},
    ];

    const openModal = ( row ) => {
        modal.value = true;
    }

    const closeModal = () => {
        modal.value = false;
        reload.value += 1;
        form.reset()
        form.clearErrors()
    }
    
    const home = () => {
        router.visit(route('dashboard'))
    } 

    /* const getAction = ( action ) => {
        if (action.name==='edit') {
            operation.value = 'update'
            routePath.value = 'project.users.update'
            title.value = trnsl('content.edit') + ' ' + trnsl('messages.projectUser')
            form.id = action.data.id
            fields.forEach( (field) => {
                form[field.name]=action.data[field.name];
            })
            openModal()
        } else if (action.name==='delete') {
            deleteRecord(action.data)
        }
    } */

    /* const getEvent = ( event ) => {
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
    } */

    const clickIconToolBar = (button) => {
        if (button === 'new') {
            showList.value = false
            showNew.value = true
            showEdit.value = false
        } else if (button == 'list') {
                    showList.value = true
                    showNew.value = false
                    showEdit.value = false
                } else if (button == 'home') {
                            home()
                        }
    }

    const getEvent = ( status ) => {
        if (status.source === 'new') {
            showList.value = true
            showNew.value = false
            showEdit.value = false
        } else if (status.source === 'list') {
                    if (status.status == 1) {
                        projectUser = status.data
                        showList.value = false
                        showNew.value = false
                        showEdit.value = true
                    }
                } else if(status.source === 'edit') {
                            showList.value = true
                            showNew.value = false
                            showEdit.value = false
                           
                        }
    }

</script>