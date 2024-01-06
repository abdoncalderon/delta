<template>
    <DataTable
        :key="reload"
        :headers="headers"
        :actions="actions"
        :dataset="projectUsers"
        :title="trnsl('content.users')"
        fieldSearch="name"
        @action="getAction"
    />

</template>
<script setup>
    import DataTable from '@/Components/DataTable.vue'
    import { trnsl } from '@/Lang/languages';
    import { ref } from 'vue';

    const props = defineProps({
        projectUsers: Array,
    })

    const emit = defineEmits([
        'event'   
    ])

    const reload = ref(0)

    const event = {
        source: '',
        status: '',
        data: null
    }

    const headers = [
        {name: 'user.person.fullName', text: trnsl('content.user'), type: 'text', align: 'left'},
        {name: 'role.name', text: trnsl('content.role'), type: 'text', align: 'left'},
    ];

    const actions = [
        {name: 'edit', type: 'icon', text: trnsl('content.edit'), icon: 'fa fa-pencil', color: 'primary'},
    ];

    const getAction = ( action ) => {
        event.source = 'list'
        event.action = action.name
        event.status = 1
        event.data = action.data
        emit('event', event)
    }

</script>