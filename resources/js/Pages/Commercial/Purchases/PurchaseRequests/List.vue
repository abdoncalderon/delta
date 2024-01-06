<template>
    <DataTable
        :key="reload"
        :headers="headers"
        :actions="actions"
        :dataset="purchaseRequests"
        :title="trnsl('content.purchaseRequests')"
        fieldSearch="id"
        @action="getAction"
    />
</template>
<script setup>
    import DataTable from '@/Components/DataTable.vue'
    import { trnsl } from '@/Lang/languages';
    import { ref, onMounted } from 'vue';
    import { useForm } from '@inertiajs/vue3';

    const props = defineProps({
        purchaseRequests: Array,
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
        {name: 'need_request.project_user.user.person.fullName', text: trnsl('content.applicant'), type: 'text', align: 'left'},
        {name: 'sorter.user.person.fullName', text: trnsl('content.classifiedBy'), type: 'text', align: 'left'},
        {name: 'status_id', text: trnsl('content.status'), type: 'list', align: 'left', items: []},
    ];

    const actions = [
        {name: 'send', type: 'icon', text: trnsl('content.send'), icon: 'fa-solid fa-paper-plane', color: 'primary', disabledField: 'sendFlag' },
        {name: 'show', type: 'icon', text: trnsl('content.show'), icon: 'fa-solid fa-eye', color: 'primary' },
    ];

    const statuses = [
        {id: 1, name: trnsl('content.pending') },
        {id: 2, name: trnsl('content.sent') },
    ]

    let event = {
        source: '',
        action: '',
        status: 0,
        data: null
    }

    const getAction = ( action ) => {
        event.source = 'list',
        event.action = action.name
        event.status = 1
        event.data = action.data
        emit('event', event)
    }

    onMounted(()=>{
        headers[4].items = statuses
    })
</script>