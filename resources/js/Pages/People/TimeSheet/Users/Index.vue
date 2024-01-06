<template>
    <AuthenticatedLayout>
        <Head :title="$trnsl('content.users')"></Head>
        
        <template #header>
            {{ $trnsl('content.users') }}
        </template>

        <template #subheader>
            {{ $trnsl('content.timesheet') }}
        </template>

        <template #content>

            <div class="my-2">
                <ToolBar
                    :icons="icons"
                    @click="clickIconToolBar"
                />
            </div>

            <Window
                :title="trnsl('content.users')"
                @close="back"
            >
                <template #body>
                    <Tabs
                        :tabs="tabs"
                    >
                        <template #upload>
                            <Upload
                                :clocks="clocks"
                                :stakeholders="stakeholders"
                            />
                        </template>

                        <template #download>
                            <Download
                                :clocks="clocks"
                            />
                        </template>

                    </Tabs>
                </template>
                
            </Window>
            
        </template>
    </AuthenticatedLayout>
</template>
<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
    import Upload from './Upload.vue'
    import Download from './Download.vue'
    import ToolBar from '@/Components/ToolBar.vue'
    import Tabs from '@/Components/Tabs.vue'
    import Window from '@/Components/Window.vue'
    import { trnsl } from '@/Lang/languages';
    import { Head, router } from '@inertiajs/vue3'
  

    const props = defineProps({
        clocks: Array,
        stakeholders: Array,
    })

    const tabs = [
        { name: 'upload', text: trnsl('content.uploadUsers') },  
        { name: 'download', text: trnsl('content.downloadUsers') }, 
    ]

    const icons = [
        {name: 'home', text: trnsl('content.home'), icon: 'fa fa-home'},
        {name: 'back', text: trnsl('content.back'), icon: 'fa fa-arrow-left'},    
           
    ];

    const home = () => {
        router.visit(route('dashboard'))
    } 

    const back = () => {
        router.visit(route('people.timesheet.home'))
    } 
  
    const clickIconToolBar = (button) => {
        if (button == 'back') {
            back()
        } else if (button == 'home') {
            home()
        } 
    }

    


</script>