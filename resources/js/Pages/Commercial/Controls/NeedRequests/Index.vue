<template>
    <AuthenticatedLayout>

        <Head :title="$trnsl('content.needRequests')"></Head>

        <template #header>
            {{ $trnsl('content.needRequests') }}
        </template>

        <template #subheader>
            {{ $trnsl('content.controls') }}
        </template>

        <template #content>
            <div class="my-2">
                <ToolBar
                    v-if="showToolBar"
                    :icons="icons"
                    @click="clickIconToolBar"
                />
            </div>
            
            <List
                v-if="showList"
                :key="reload"
                :needRequests="needRequests"
                @event="getEvent"
            />

            <Classify
                v-if="showClassify"
                :needRequest="needRequest"
                @event="getEvent"        
            />
            
        </template>

    </AuthenticatedLayout>

</template>
<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
    import ToolBar from '@/Components/ToolBar.vue'
    import List from './List.vue'
    /* import New from './New.vue'
    import Edit from './Edit.vue'*/
    import Classify from './Classify.vue' 
    import dayjs from 'dayjs';
    import { useForm, Head, usePage, router } from '@inertiajs/vue3';
    import { trnsl } from '@/Lang/languages';
    import { onMounted, ref } from 'vue';

    const props = defineProps({
        needRequests: Array,
        unities: Array,
    });

    const page = usePage()

    const reload = ref(0)
    const showList = ref(true)
    const showClassify = ref(false)
    const showToolBar = ref(true)

    let  needRequest = {}

    const today = dayjs(undefined).format('YYYY-MM-DD')
    
    const icons = [
        {name: 'home', text: trnsl('content.home'), icon: 'fa-solid fa-home'},
        {name: 'back', text: trnsl('content.back'), icon: 'fa-solid fa-arrow-left'},       
        {name: 'list', text: trnsl('content.list'), icon: 'fa fa-table'},
    ];
    
    const home = () => {
        router.visit(route('dashboard'))
    } 

    const back = () => {
        router.visit(route('commercial.controls.home'))
    } 

    const clickIconToolBar = (button) => {
        if (button === 'list') {
            classify.value = false
            list.value = true
        } else if (button == 'back') {
                    back()
                } else if (button == 'home') {
                            home()
                        }
    }

    const getEvent = ( event ) => {
        if (event.source === 'list') {
            if ( (event.action === 'classify') && (event.status == 1) ) {
                needRequest = event.data
            }
            showList.value = false
            showClassify.value = true
        } else if (event.source === 'classify') {
            if ((event.action === 'process') && (event.status == 1)) {
                needRequest = event.data
            } 
            showList.value = true
            showClassify.value = false
        } 
    }

 
    

   



</script>