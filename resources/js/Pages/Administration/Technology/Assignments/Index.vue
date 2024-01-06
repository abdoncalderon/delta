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
                :dataset="stakeholderPeople"
                :title="trnsl('content.people')"
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
        stakeholderPeople: Array,
    });

    const form = useForm({});

    const reload = ref(0)

    const headers = [
        {name: 'person.fullName', text: trnsl('content.person'), type: 'text', align: 'left'},
        {name: 'stakeholder.name', text: trnsl('content.stakeholder'), type: 'text', align: 'left'},
    ];

    const actions = [
        {name: 'equipments', type: 'icon', text: trnsl('content.equipments'), icon: 'fa fa-laptop', color: 'secondary'},
        {name: 'applications', type: 'icon', text: trnsl('content.applications'), icon: 'fa-brands fa-microsoft', color: 'secondary' },
        {name: 'lines', type: 'icon', text: trnsl('content.applications'), icon: 'fa fa-phone', color: 'secondary' },
    ];

    const icons = [
        {name: 'home', text: trnsl('content.home'), icon: 'fa fa-home'},
        {name: 'back', text: trnsl('content.back'), icon: 'fa fa-arrow-left'},
    ];
    
    const home = () => {
        router.visit(route('dashboard'))
    } 

    const back = () => {
        router.visit(route('administration.technology.home'))
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
        } else if (button === 'back') {
                    back()
                }
    }


</script>