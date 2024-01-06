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
            <div class="my-2">
                <ToolBar
                    :icons="icons"
                    @click="clickIconToolBar"
                />
            </div>
           
            <List
                v-if="list"
                :key="reload"
                :items="stakeholders"
                @event="getEvent"
            />
            
            <New
                v-if="new_"
                :form="formNew"
                :regions="regions"
                :project="project"
                @event="getEvent"       
            />

            <Edit
                v-if="edit"
                :form="formEdit"
                :regions="regions"
                :project="project"
                @event="getEvent"       
            />
        </template>
        
    </AuthenticatedLayout>
</template>

<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
    import ToolBar from '@/Components/ToolBar.vue'
    import List from './List.vue'
    import New from './New.vue'
    import Edit from './Edit.vue'
    import { useForm, Head, usePage, router } from '@inertiajs/vue3';
    import { trnsl } from '@/Lang/languages';
    import { successMessage, errorMessage, dialogBox } from '@/Helpers/helper'
    import { ref, onMounted } from 'vue';

    const props = defineProps({
        stakeholders: Array,
        project: Object,
        regions: Array,
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
        'region_id': '',
        'country_id': '',
        'state_id': '',
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

    const new_ = ref(false)
    const edit = ref(false)
    const list = ref(true)
    
    const icons = [
        {name: 'home', text: trnsl('content.home'), icon: 'fa fa-home'},
        {name: 'new', text: trnsl('content.new'), icon: 'fa fa-plus'},
        {name: 'list', text: trnsl('content.list'), icon: 'fa fa-table'},
    ];
    
    const home = () => {
        router.visit(route('dashboard'))
    } 

    const deleteRecord = (row) => {
        const dialog = dialogBox( row.name, trnsl('messages.confirmDelete'))
        dialog.fire().then((result)=>{
            if(result.isConfirmed){
                formNew.delete(route('project.stakeholders.destroy', row.id),{
                    onSuccess: () => { 
                        successMessage(trnsl('messages.recordDeleted'))
                        reload.value += 1
                    },
                    onError: () => {
                        errorMessage(trnsl('messages.recordNoDeleted'))
                    }
                })
            }
        })
    }

    const clickIconToolBar = (button) => {
        if (button === 'list') {
            new_.value = false
            edit.value = false
            list.value = true
        } else if (button == 'new') {
                    formNew.reset()
                    formNew.project_id = page.props.auth.currentProject.id
                    list.value = false
                    edit.value = false
                    new_.value = true
                } else if (button == 'back') {
                            back()
                        } else if (button == 'home') {
                                    home()
                                }
    }

    const getEvent = ( event ) => {
        if (event.status==='edit') {
            formEdit.id = event.action.id
            formEdit.project_id = event.action.project_id
            formEdit.region_id = event.action.region_id
            formEdit.country_id = event.action.country_id
            formEdit.state_id = event.action.state_id
            formEdit.city_id = event.action.city_id
            formEdit.name = event.action.name
            formEdit.code = event.action.code
            formEdit.taxId = event.action.taxId
            formEdit.address = event.action.address
            formEdit.zipCode = event.action.zipCode
            formEdit.phoneNumber = event.action.phoneNumber
            formEdit.email = event.action.email
            formEdit.logofile = event.action.logofile
            formEdit.stakeholder_type_id = event.action.stakeholder_type_id
            new_.value = false
            list.value = false
            edit.value = true
        } else if (event.status==='delete') {
                    deleteRecord(event.action)
                } else {
                    new_.value = false
                    edit.value = false
                    list.value = true
                }
    }

</script>