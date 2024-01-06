<template>
    <DataTable
        :key="reload"
        :headers="headers"
        :actions="actions"
        :dataset="projectPeople"
        :title="trnsl('content.people')"
        fieldSearch="name"
        @action="getAction"
    />

</template>
<script setup>
    import DataTable from '@/Components/DataTable.vue'
    import { trnsl } from '@/Lang/languages';
   
    import { ref, onMounted, reactive } from 'vue';

    const props = defineProps({
        projectPeople: Array,
    })

    const emit = defineEmits([
        'event'   
    ])

    const reload = ref(0)

    const event = {
        source: '',
        action: '',
        status: 0,
        data: null
    }

    const headers = [
        {name: 'fullName', text: trnsl('content.person'), type: 'text', align: 'left'},
        {name: 'stakeholder', text: trnsl('content.company'), type: 'text', align: 'left'},
    ];

    const actions = [
        {name: 'edit', type: 'icon', text: trnsl('content.edit'), icon: 'fa fa-pencil', color: 'primary'},
    ];

    const getAction = ( action ) => {
        if (action.name==='edit') {
            event.source = 'list',
            event.action = action.name
            event.status = 1
            event.data = action.data
            emit('event', event)
        } 
    }



</script>