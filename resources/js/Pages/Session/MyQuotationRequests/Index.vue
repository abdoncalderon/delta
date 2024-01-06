<template>

    <AuthenticatedLayout>

        <Head :title="$trnsl('content.quotationRequests')"/>

        <template #header>
            {{ $trnsl('content.quotationRequests') }}
        </template>

        <template #subheader>
            {{ $trnsl('content.session') }}
        </template>

        <template #content>
            
            <div class="my-2">
                <ToolBar
                    :icons="icons"
                    @click="clickIconToolBar"
                />
            </div>
            
            <DataTable
                v-if="showList"
                :key="reload"
                :headers="headers"
                :actions="actions"
                :dataset="myQuotationRequests"
                :title="trnsl('content.quotationRequests')"
                fieldSearch="name"
                @action="getAction"
            />

            <Show
                v-if="showShow"
                :needRequest="needRequest"
                @event="getEvent"  
            />

        </template>

    </AuthenticatedLayout>  
    
</template>

<script setup>

    import Show from './Show.vue'
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
    import DataTable from '@/Components/DataTable.vue'
    import ToolBar from '@/Components/ToolBar.vue'
    import { useForm, Head, usePage, router } from '@inertiajs/vue3';
    import { trnsl } from '@/Lang/languages';
    import { ref } from 'vue';

    const props = defineProps({
        myQuotationRequests: Array,
    });

    const form = useForm({});

    const reload = ref(0)
    const showList = ref(true)
    const showShow = ref(false)

    let  needRequest = {}

    const headers = [
        {name: 'id', text: '#', type: 'text', align: 'right'},
        {name: 'date', text: trnsl('content.date'), type: 'date', align: 'left'},
        {name: 'location.name', text: trnsl('content.company'), type: 'text', align: 'left'},
        {name: 'status', text: trnsl('content.status'), type: 'text', align: 'left'},
    ];

    const actions = [
        {name: 'show', type: 'icon', text: trnsl('content.show'), icon: 'fa fa-eye', color: 'primary' },
    ];

    const icons = [
        {name: 'home', text: trnsl('content.home'), icon: 'fa fa-home'},
        {name: 'refresh', text: trnsl('content.refresh'), icon: 'fa fa-arrows-rotate'},
    ];
    
    const home = () => {
        router.visit(route('dashboard'))
    } 

    const refresh = () => {
        router.visit(route('myQuotationRequests.index'))
    }

    const getAction = ( action ) => {
        if (action.name==='show') {
            needRequest = action.data
            showList.value = false
            showShow.value = true
        } 
    }

    const clickIconToolBar = (button) => {
        if (button === 'home') {
            home()
        } else if (button == 'refresh') {
                    refresh()
                }
    }

    const getEvent = ( status ) => {
        if (status.source === 'show') {
            showShow.value = false
            showList.value = true
        } 
    }


</script>