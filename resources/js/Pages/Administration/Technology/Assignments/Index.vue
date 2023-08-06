<template>
    <AuthenticatedLayout>

        <Head :title="$trnsl('content.assignments')"/>

        <template #header>
            {{ $trnsl('content.assignments') }}
        </template>

        <template #subheader>
            {{ $trnsl('content.technology') }}
        </template>

        <template #content>
            <ToolBar
                :buttons="buttons"
                @click="clickIconToolBar"
            />
            <DataTable
                :key="reload"
                :headers="headers"
                :actions="actions"
                :dataset="stakeholderPeople"
                :table="trnsl('content.people')"
                fieldSearch="name"
                @select="executeAction"
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
        stakeholderPeople: Array,
    });

    const page = usePage();
    
    const form = useForm({});

    const reload = ref(0)
    const modal = ref(false)
    const title = ref('');
    const operation = ref('');
    const routePath = ref('');

    const headers = [
                    {name: 'person.fullName', text: trnsl('content.person'), type: 'text', align: 'left'},
                    {name: 'stakeholder.name', text: trnsl('content.stakeholder'), type: 'text', align: 'left'},
                ];

    const actions = [
                    {name: 'equipments', type: 'icon', text: trnsl('content.equipments'), icon: 'fa fa-laptop', color: 'secondary'},
                    {name: 'applications', type: 'icon', text: trnsl('content.applications'), icon: 'fa-brands fa-microsoft', color: 'secondary' },
                    {name: 'lines', type: 'icon', text: trnsl('content.applications'), icon: 'fa fa-phone', color: 'secondary' },
                ];

    const buttons = [
                    
                    {name: 'exit', text: trnsl('content.exit'), icon: 'fa-solid fa-arrow-up-right-from-square'}
                ];
    
    const home = () => {
        router.visit(route('dashboard'))
    } 

    const executeAction = ( params ) => {
        if (params[1]==='equipments') {
            form.get(route('administration.technology.assignments.assets', params[0].id))
        } else if (params[1]==='applications') {
                    router.visit(route('dashboard'))
                } else if (params[1]==='lines') {
                            router.visit(route('dashboard'))
                        }
    }

    const clickIconToolBar = (button) => {
        if (button === 'exit') {
            home()
        } 
    }


</script>