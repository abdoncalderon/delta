<template>
    <DataTable
        :key="reload"
        :headers="headers"
        :actions="actions"
        :dataset="myNeedRequests"
        :title="trnsl('content.myNeedRequests')"
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
        myNeedRequests: Array,
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
        {name: 'location.name', text: trnsl('content.block'), type: 'text', align: 'left'},
        {name: 'status_id', text: trnsl('content.status'), type: 'list', align: 'left', items: []},
    ];

    const actions = [
        {name: 'show', type: 'icon', text: trnsl('content.show'), icon: 'fa fa-eye', color: 'primary', disabledField: 'editFlag' },
        {name: 'edit', type: 'icon', text: trnsl('content.edit'), icon: 'fa fa-pencil', color: 'primary', disabledField: 'noEditFlag' },
        {name: 'delete', type: 'icon', text: trnsl('content.delete'), icon: 'fa fa-trash', color: 'danger', disabledField: 'noEditFlag' },
    ];

    const statuses = [
        {id: 1, name: trnsl('content.draft') },
        {id: 2, name: trnsl('messages.sentToApprove') },
        {id: 3, name: trnsl('content.rejected') },
        {id: 4, name: trnsl('content.approved') },
        {id: 5, name: trnsl('messages.inProcess') },
        {id: 6, name: trnsl('content.completed') },
    ]

    const event = {
        source: '',
        action: '',
        status: 0,
        data: null,
    }

    //Delete Record
    const deleteRecord = (row) => {
        let titleDialogBox = trnsl('content.needRequest') + ' ' + row.id
        const dialog = dialogBox( titleDialogBox, trnsl('messages.confirmDelete'))
        dialog.fire().then((result) =>{
            if(result.isConfirmed){
                form.delete(route('myNeedRequests.destroy', row.id),{
                    onSuccess: () => { 
                        successMessage(trnsl('messages.recordDeleted'))
                        reload.value += 1;
                    },
                    onError: (errors) => {
                        errorMessage(trnsl('messages.recordNoDeleted') + '\n' + getError(errors) )
                    }
                })
            }
        });
    }

    const getAction = ( action ) => {
        if (action.name==='edit') {
            event.source = 'list',
            event.action = action.name
            event.status = 1 
            event.data = action.data
            emit('event', event)
        } else if (action.name==='delete') {
                    deleteRecord(action.data)
                } else if (action.name==='show') {
                            event.source = 'list',
                            event.action = action.name
                            event.status = 1 
                            event.data = action.data
                            emit('event', event)
                        }
    }

    onMounted(()=>{
        headers[3].items = statuses
    })
</script>