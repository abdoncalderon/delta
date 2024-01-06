<template>
    <AuthenticatedLayout>

        <Head :title="$trnsl('content.myNeedRequests')"></Head>

        <template #header>
            {{ $trnsl('content.myNeedRequests') }}
        </template>

        <template #subheader>
            {{ $trnsl('content.home') }}
        </template>

        <template #content>
            <div class="my-2">
                <ToolBar
                    v-if="toolBar"
                    :icons="icons"
                    @click="clickIconToolBar"
                />
            </div>
            
            <List
                v-if="showList"
                :key="reload"
                :myNeedRequests="myNeedRequests"
                @event="getEvent"
            />
            
            <New
                v-if="showNew"
                :form="form"
                :zones="zones"
                :cost_accounts="cost_accounts"
                :approvers="approvers"
                @event="getEvent"       
            />

            <Edit
                v-if="showEdit"
                :form="form"
                :zones="zones"
                :cost_accounts="cost_accounts"
                :approvers="approvers"
                :unities="unities"
                :needRequestItems="needRequestItems"
                @event="getEvent"       
            />

            <Show
                v-if="showShow"
                :form="form"
                :zones="zones"
                :cost_accounts="cost_accounts"
                :approvers="approvers"
                :unities="unities"
                :needRequestItems="needRequestItems"
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
    import Show from './Show.vue'
    import dayjs from 'dayjs';
    import { useForm, Head, usePage, router } from '@inertiajs/vue3';
    import { trnsl } from '@/Lang/languages';
    import { onMounted, ref } from 'vue';

    const props = defineProps({
        myNeedRequests: Array,
        zones: Array,
        cost_accounts: Array,
        approvers: Array,
        unities: Array,
    });

    const page = usePage()

    const form = useForm({
        'id': '',
        'date': '',
        'project_user_id': '',
        'zone': '',
        'zone_id': '',
        'location': '',
        'location_id': '',
        'cost_account': '',
        'cost_account_id': '',
        'description': '',
        'expectedCost': '',
        'approver': '',
        'approver_id': '',
        'status_id': '',
    });

    const reload = ref(0)
    const showNew = ref(false)
    const showEdit = ref(false)
    const showList = ref(true)
    const showShow = ref(false)
    const toolBar = ref(true)

    let  needRequestItems = []

    const today = dayjs(undefined).format('YYYY-MM-DD')
    
    const icons = [
        {name: 'home', text: trnsl('content.home'), icon: 'fa fa-home'},
        {name: 'new', text: trnsl('content.new'), icon: 'fa fa-plus'},
        {name: 'list', text: trnsl('content.list'), icon: 'fa fa-table'},
        {name: 'refresh', text: trnsl('content.refresh'), icon: 'fa fa-arrows-rotate'},
    ];
    
    const home = () => {
        router.visit(route('dashboard'))
    } 

    const refresh = () => {
        router.visit(route('myNeedRequests.index'))
    }

    const clickIconToolBar = (button) => {
        if (button === 'list') {
            showNew.value = false
            showEdit.value = false
            showList.value = true
        } else if (button == 'new') {
                    form.reset()
                    form.project_user_id = page.props.auth.currentProjectUser.id
                    form.status_id = 1
                    form.date = today
                    showList.value = false
                    showEdit.value = false
                    showNew.value = true
                } else if (button == 'refresh') {
                            refresh()
                        } else if (button == 'home') {
                                    home()
                                }
    }

    const getEvent = ( event ) => {
        if (event.source === 'list') {
            if (event.action === 'edit') {
                needRequestItems = event.data.need_request_items
                form.id = event.data.id
                form.project_user_id = event.data.project_user_id
                form.date = event.data.date
                form.zone_id = event.data.location.zone_id 
                form.location_id = event.data.location_id
                form.cost_acoount_id = event.data.cost_account_id
                form.description = event.data.description
                form.expectedCost = event.data.expectedCost
                form.approver_id = event.data.approver_id
                form.status_id = event.data.status_id
                showNew.value = false
                showList.value = false
                showEdit.value = true
                showShow.value = false
                toolBar.value = false
            } else if (event.action === 'show') {
                        needRequestItems = event.data.need_request_items
                        form.id = event.data.id
                        form.project_user_id = event.data.project_user_id
                        form.date = event.data.date
                        form.zone_id = event.data.location.zone_id 
                        form.location = event.data.location.name
                        if (event.data.cost_account_id!==null) { form.cost_acoount = event.data.cost_account.name }
                        form.description = event.data.description
                        form.expectedCost = event.data.expectedCost
                        form.approver_id = event.data.approver_id
                        form.status_id = event.data.status_id
                        showNew.value = false
                        showEdit.value = false
                        showList.value = false
                        showShow.value = true
                        toolBar.value = false
                    } 
        } else {
            showNew.value = false
            showEdit.value = false
            showList.value = true
            showShow.value = false
            toolBar.value = true
        }
    }

   



</script>