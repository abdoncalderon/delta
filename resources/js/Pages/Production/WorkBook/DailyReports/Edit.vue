<template>
    <Window
        :title="trnsl('content.edit')"
        @close=""
    >
        <template #body>

            <Tabs
                :tabs="tabs"
            >
                <template #report>
                    <Report
                        :dailyReport="dailyReport"
                        :turns="turns"
                        :responsibles="responsibles"
                        @close="closeForm"
                    />
                </template>

                <template #labour>
                    <Labour
                        :dailyReport="dailyReport"
                        :positions="positions"
                        :stakeholders="stakeholders"
                        @close="closeForm"
                    />
                </template>

                <template #equipments>
                    <Equipments
                        :dailyReport="dailyReport"
                        :equipments="equipments"
                        :stakeholders="stakeholders"
                        @close="closeForm"
                    />
                </template>

                <template #events>
                    <Events
                        :dailyReport="dailyReport"
                        @close="closeForm"
                    />
                </template>

                <template #attachments>
                    <Attachments
                        :dailyReport="dailyReport"
                        @close="closeForm"
                    />
                </template>
            </Tabs>  
        </template>
            
    </Window>
</template>

<script setup>
    import Window from '@/Components/Window.vue'
    import Tabs from '@/Components/Tabs.vue'
    import Report from './Partials/Report.vue'
    import Labour from './Partials/Labour.vue'
    import Equipments from './Partials/Equipments.vue'
    import Events from './Partials/Events.vue'
    import Attachments from './Partials/Attachments.vue'
    import { trnsl } from '@/Lang/languages';

    const props = defineProps({
        dailyReport: Object,
        turns: Array,
        responsibles: Array,
        positions: Array,
        stakeholders: Array,
        equipments: Array,
    })

    const emit = defineEmits([
        'close'
    ])

    const tabs = [
        { name: 'report', text: trnsl('content.activities') },   
        { name: 'labour', text: trnsl('content.people') }, 
        { name: 'equipments', text: trnsl('content.equipments') }, 
        { name: 'events', text: trnsl('content.events') }, 
        { name: 'attachments', text: trnsl('content.attachments') }, 
    ]

    const closeForm = ( flag ) => {
        emit ('close', flag )
    }

    
</script>
