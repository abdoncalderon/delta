<template>
    <AuthenticatedLayout>

        <Head :title="$trnsl('content.people')"></Head>
        
        <template #header>
            {{ trnsl('content.people') }}
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
                :stakeholders="stakeholders"
                :sectors="sectors"
                :functions="functions"
                :projectPeople="projectPeople"
                :regions="regions"
                @event="getEvent"
            />

            <Modal
                :showModal="showSearch"
                @closeModal="closeSearch"
                :title="trnsl('messages.searchPerson')"
                modalWidth="400px"
                modalHeight="350px"
            >
                <Search
                    :people="people"
                    @event="getEvent"
                />
                
            </Modal>
            
        </template>

    </AuthenticatedLayout>
</template>

<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
    import Modal from '@/Components/Modal.vue'
    import ToolBar from '@/Components/ToolBar.vue'
    import List from './List.vue'
    import New from './New.vue'
    import Edit from './Edit.vue'
    import Search from './Search.vue'
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
    const showSearch = ref(false)

    let person = {}

    const icons = [
        {name: 'home', text: trnsl('content.home'), icon: 'fa-solid fa-home'},
        {name: 'new', text: trnsl('content.new'), icon: 'fa fa-plus'},
        {name: 'list', text: trnsl('content.list'), icon: 'fa fa-table'},
        {name: 'search', text: trnsl('content.search'), icon: 'fa fa-search'},
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
                        } else if (button === 'search') {
                                    showList.value = true
                                    showEdit.value = false
                                    showNew.value = false
                                    showSearch.value = true
                                }
    }

    const closeSearch = () => {
        showSearch.value = false 
    }

    const getEvent = ( event ) => {
        if (event.source === 'new') {
            showNew.value = false
            showEdit.value = false
            showSearch.value = false
            showList.value = true
        } 

        if (event.source === 'list') {
            if (event.status == 1) {
                person = event.data
                showList.value = false
                showNew.value = false
                showSearch.value = false
                showEdit.value = true
            }
        } 

        if(event.source === 'edit') {
            showNew.value = false
            showSearch.value = false
            showEdit.value = false
            showList.value = true
        } 

        if(event.source === 'search') {
            if (event.status == 1) {
                person = event.data
                showList.value = false
                showNew.value = false
                showSearch.value = false
                showEdit.value = true
            } else {
                showSearch.value = false
            }
        } 
    }


</script>
    
