<template>
    <DataTable
        :key="reload"
        :headers="headers"
        :actions="actions"
        :dataset="needRequests"
        :title="trnsl('content.needRequests')"
        fieldSearch="id"
        @action="getAction"
    />
</template>
<script setup>
    import DataTable from '@/Components/DataTable.vue'
    import { successMessage, errorMessage, dialogBox, getError } from '@/Helpers/helper'
    import { trnsl } from '@/Lang/languages';
    import { ref, onMounted } from 'vue';
    import { useForm } from '@inertiajs/vue3';

    const props = defineProps({
        needRequests: Array,
    });

    const emit = defineEmits([
        'event'   
    ])

    const form = useForm({
        'id': ''
    })

    const reload = ref(0)

    const headers = [
        {name: 'id', text: '#', type: 'text', align: 'right'},
        {name: 'date', text: trnsl('content.date'), type: 'date', align: 'left'},
        {name: 'applicant', text: trnsl('content.applicant'), type: 'text', align: 'left'},
        {name: 'location.name', text: trnsl('content.block'), type: 'text', align: 'left'},
        {name: 'status_id', text: trnsl('content.status'), type: 'list', align: 'left', items: []},
    ];

    const actions = [
        {name: 'classify', type: 'icon', text: trnsl('content.classify'), icon: 'fa-solid fa-arrow-right-arrow-left', color: 'primary', disabledField: 'editFlag' },
    ];

    const statuses = [
        {id: 1, name: trnsl('content.draft') },
        {id: 2, name: trnsl('content.sent') },
        {id: 3, name: trnsl('content.rejected') },
        {id: 4, name: trnsl('content.approved') },
        {id: 5, name: trnsl('messages.inProcess') },
        {id: 6, name: trnsl('content.complete') },
    ]

    let event = {
        source: '',
        action: '',
        status: 0,
        data: null
    }

    const getAction = ( action ) => {
        if (action.name==='classify') {
            event.source = 'list',
            event.action = action.name,
            event.status = 1
            event.data = action.data
            emit('event', event)
        } 
    }

    onMounted(()=>{
        headers[4].items = statuses
    })
</script>