<template>
    <DataTable
        
        :headers="headers"
        :actions="actions"
        :dataset="items"
        :title="trnsl('content.stakeholders')"
        fieldSearch="name"
        @action="getAction"
    />
</template>

<script setup>
    import DataTable from '@/Components/DataTable.vue'
    import { trnsl } from '@/Lang/languages';
    import { ref, onMounted, reactive } from 'vue';
    import { dialogBox } from '@/Helpers/helper'

    const props = defineProps({
        items: Array,
        
    });

    const emit = defineEmits([
        'event'   
    ])

    const headers = [
        {name: 'name', type: 'text', text: trnsl('content.name'), align: 'left'},
        {name: 'logofile', type: 'image', text: trnsl('content.logo'), align: 'center', path: 'http://delta.test/storage/kapatax/images/project/stakeholders/'},
        {name: 'stakeholder_type_id', type: 'list', text: trnsl('content.type'), align: 'center', items: []}
    ];

    const actions = [
        {name: 'edit', type: 'icon', text: trnsl('content.edit'), icon: 'fa fa-pencil', color: 'primary'},
        {name: 'delete', type: 'icon', text: trnsl('content.delete'), icon: 'fa fa-trash', color: 'danger' },
    ];

    const stakeholder_types = [
        {id: 1, name: trnsl('content.contractor')},
        {id: 2, name: trnsl('content.client')},
        {id: 3, name: trnsl('content.inspector')},
        {id: 4, name: trnsl('content.supplier')},
    ]

    const event = {
        source: '',
        action: '',
        status: 0,
        data: null,
    }

    const getAction = ( action ) => {
        event.source = 'list'
        event.action = action.name
        event.status = 1
        event.data = action.data
        emit('event', event)
    }

    onMounted(()=>{
        headers[2].items = stakeholder_types
    })


</script>