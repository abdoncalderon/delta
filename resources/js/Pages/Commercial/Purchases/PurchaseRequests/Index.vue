<template>
    <AuthenticatedLayout>

        <Head :title="$trnsl('content.purchaseRequests')"></Head>

        <template #header>
            {{ $trnsl('content.purchaseRequests') }}
        </template>

        <template #subheader>
            {{ $trnsl('content.commercial') }}
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
                :purchaseRequests="purchaseRequests"
                @event="getEvent"
            />

            <Send
                v-if="showSend"
                :key="reload"
                :purchaseRequest="purchaseRequest"
                :stakeholders="stakeholders"
                @event="getEvent"
            />

            <Show
                v-if="showShow"
                :purchaseRequest="purchaseRequest"
                @event="getEvent"
            />
            
        </template>
        
    </AuthenticatedLayout>

</template>

<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
    import ToolBar from '@/Components/ToolBar.vue'
    import List from './List.vue'
    import Send from './Send.vue'
    import Show from './Show.vue'
    import dayjs from 'dayjs';
    import { useForm, Head, usePage, router } from '@inertiajs/vue3';
    import { trnsl } from '@/Lang/languages';
    import { onMounted, ref } from 'vue';

    const props = defineProps({
        purchaseRequests: Array,
        stakeholders: Array,
    });
    
    const reload = ref(0)
    const showList = ref(true)
    const showSend = ref(false)
    const showShow = ref(false)
    const showToolBar = ref(true)

    let  purchaseRequest = {}

    const today = dayjs(undefined).format('YYYY-MM-DD')
    
    const icons = [
        {name: 'home', text: trnsl('content.home'), icon: 'fa-solid fa-home'},
        {name: 'back', text: trnsl('content.back'), icon: 'fa-solid fa-arrow-left'},       
        {name: 'list', text: trnsl('content.list'), icon: 'fa fa-table'},
        {name: 'refresh', text: trnsl('content.refresh'), icon: 'fa fa-arrows-rotate'},
    ];
    
    const home = () => {
        router.visit(route('dashboard'))
    } 

    const back = () => {
        router.visit(route('commercial.purchases.home'))
    } 

    const refresh = () => {
        router.visit(route('commercial.purchases.purchaseRequests.index'))
    }

    const clickIconToolBar = ( button ) => {
        if (button === 'list') {
            showSend.value = false
            showList.value = true
        } else if (button == 'back') {
                    back()
                } else if (button == 'home') {
                            home()
                        } else if (button == 'refresh') {
                            refresh()
                        }
    }

    const getEvent = ( event ) => {
        if (event.source === 'list') {
            if (event.action === 'send') {
                purchaseRequest = event.data
                showSend.value = true
            } else if (event.action === 'show') {
                        purchaseRequest = event.data
                        showShow.value = true
                    }
            showList.value = false
        } else if (event.source === 'send') {
                    reload.value += 1
                    showList.value = true
                    showSend.value = false
                } else if (event.source === 'show') {
                            reload.value += 1
                            showList.value = true
                            showShow.value = false
                        }
    }

</script>