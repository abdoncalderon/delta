<template>
    <AuthenticatedLayout>

        <Head :title="$trnsl('content.myToools')"/>

        <template #header>
            {{ $trnsl('content.myTools') }}
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
                :key="reload"
                :headers="headers"
                :actions="actions"
                :dataset="stakeholderPersonAssets"
                :title="trnsl('content.myAssignedAssets')"
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
    import { useForm, Head, usePage, router } from '@inertiajs/vue3';
    import { trnsl } from '@/Lang/languages';
    import { ref } from 'vue';

    const props = defineProps({
        stakeholderPerson: Object,
        stakeholderPersonAssets: Array,
    });

    const form = useForm({});

    const reload = ref(0)

    const headers = [
        {name: 'sn', text: trnsl('content.serialNumber'), type: 'text', align: 'left'},
        {name: 'delivery', text: trnsl('content.delivery'), type: 'text', align: 'left'},
        {name: 'return', text: trnsl('content.return'), type: 'text', align: 'left'},
    ];

    const actions = [
        {name: 'equipments', type: 'icon', text: trnsl('content.equipments'), icon: 'fa fa-laptop', color: 'secondary'},
        {name: 'applications', type: 'icon', text: trnsl('content.applications'), icon: 'fa-brands fa-microsoft', color: 'secondary' },
        {name: 'lines', type: 'icon', text: trnsl('content.applications'), icon: 'fa fa-phone', color: 'secondary' },
    ];

    const icons = [
        {name: 'home', text: trnsl('content.home'), icon: 'fa fa-home'},
    ];
    
    const home = () => {
        router.visit(route('dashboard'))
    } 

    const getAction = ( action ) => {
        if (action.name==='equipments') {
            form.get(route('administration.technology.assignments.assets', action.data.id))
        } else if (action.name==='applications') {
                    router.visit(route('dashboard'))
                } else if (action.name==='lines') {
                            router.visit(route('dashboard'))
                        }
    }

    const clickIconToolBar = (button) => {
        if (button === 'home') {
            home()
        } 
    }


</script>