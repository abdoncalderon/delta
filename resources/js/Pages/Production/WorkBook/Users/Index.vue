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
                :headers="headers"
                :actions="actions"
                :dataset="projectUsers"
                :title="trnsl('content.users')"
                fieldSearch="name"
                @action="getAction"
            />
        </template>
    </AuthenticatedLayout>
</template>

<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
    import DataTable from '@/Components/DataTable.vue'
    import ToolBar from '@/Components/ToolBar.vue'
    import { trnsl } from '@/Lang/languages';
    import { Head, router } from '@inertiajs/vue3';

    const props = defineProps({
        projectUsers: Array,
    });

    const headers = [
        {name: 'name', text: trnsl('content.user'), type: 'text', align: 'left'},
        {name: 'stakeholder', text: trnsl('content.company'), type: 'text', align: 'left'},
    ];

    const actions = [
        {name: 'locations', type: 'icon', text: trnsl('content.locations'), icon: 'fa-solid fa-location-dot', color: 'primary'},
    ];

    const icons = [
        {name: 'home', text: trnsl('content.exit'), icon: 'fa-solid fa-home'},
        {name: 'back', text: trnsl('content.back'), icon: 'fa-solid fa-arrow-left'},
    ];

    const home = () => {
        router.visit(route('dashboard'))
    } 

    const back = () => {
        router.visit(route('production.workbook.home'))
    }

    const clickIconToolBar = (button) => {
        if (button == 'back') {
            back()
        } else if (button == 'home') {
                    home()      
                }
    }

    const getAction = ( action ) => {
        if (action.name==='locations') {
            router.visit(route('production.workbook.users.locations.index',action.data.id))
        } 
    }

</script>
