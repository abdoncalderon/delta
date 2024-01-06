<template>
    <AuthenticatedLayout>

        <Head :title="$trnsl('content.people')"></Head>
        
        <template #header>
            {{ $trnsl('content.people') }}
        </template>

        <template #subheader>
            {{ $trnsl('content.people') }}
        </template>

        <template #content>
            <div class="my-2">
                <ToolBar
                    :icons="icons"
                    @click="clickIconToolBar"
                />
            </div>
            

            <list
                v-if="showList"
                :projectPeople="projectPeople"
                @event="getEvent"
            />

            <New
                v-if="showNew"
                :stakeholders="stakeholders"
                :sectors="sectors"
                :functions="functions"
                :people="people"
                @event="getEvent"
            />

            <Edit
                v-if="showEdit"
                :person="person"
                :regions="regions"
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
    import { useForm, Head, usePage, router } from '@inertiajs/vue3'
    import { trnsl } from '@/Lang/languages'
    import { ref, reactive } from 'vue'

    const props = defineProps({
        projectPeople: Array,
        regions: Array,
        functions: Array,
        sectors: Array,
        stakeholders: Array,
        people: Array,
    });

    const showNew = ref(false)
    const showEdit = ref(false)
    const showList = ref(true)

    let person = {}

    const icons = [
        {name: 'home', text: trnsl('content.home'), icon: 'fa-solid fa-home'},
        {name: 'new', text: trnsl('content.new'), icon: 'fa fa-plus'},
        {name: 'list', text: trnsl('content.list'), icon: 'fa fa-table'},
    ]

    const home = () => {
        router.visit(route('dashboard'))
    } 

    const clickIconToolBar = (button) => {
        if (button === 'list') {
            showNew.value = false
            showEdit.value = false
            showList.value = true
        } else if (button == 'new') {
                    showList.value = false
                    showEdit.value = false
                    showNew.value = true
                } else if (button == 'home') {
                            home()
                        }
    }

    const getEvent = ( status ) => {
        if (status.source === 'new') {
            showNew.value = false
            showEdit.value = false
            showList.value = true
        } else if (status.source === 'list') {
                    if (status.status == 1) {
                        person = status.data
                        showList.value = false
                        showNew.value = false
                        showEdit.value = true
                    }
                } else if(status.source === 'edit') {
                            showNew.value = false
                            showEdit.value = false
                            showList.value = true
                        }
    }


</script>
    
