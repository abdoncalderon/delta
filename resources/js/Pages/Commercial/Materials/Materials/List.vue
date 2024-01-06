<template>
    <DataTable
        :key="reload"
        :headers="headers"
        :actions="actions"
        :dataset="materials"
        :title="trnsl('content.materials')"
        fieldSearch="name"
        @action="getAction"
    />
</template>

<script setup>
    import DataTable from '@/Components/DataTable.vue'
    import { trnsl } from '@/Lang/languages';
    import { ref, onMounted, reactive } from 'vue';

    const props = defineProps({
        materials: Array,
    });

    const emit = defineEmits([
        'event'   
    ])

    const reload = ref(0)

    const headers = [
        {name: 'material', text: trnsl('content.material'), type: 'text', align: 'left'},
        {name: 'type_id', text: trnsl('content.type'), type: 'list', align: 'left', items: []},
    ];

    const actions = [
        {name: 'edit', type: 'icon', text: trnsl('content.edit'), icon: 'fa fa-pencil', color: 'primary'},
        {name: 'delete', type: 'icon', text: trnsl('content.delete'), icon: 'fa fa-trash', color: 'danger' },
    ];

    const types = [
        {id: 1, name: trnsl('content.material') },
        {id: 2, name: trnsl('content.product') },
        {id: 3, name: trnsl('content.asset') },
        {id: 4, name: trnsl('messages.assetControlled') },
        {id: 5, name: trnsl('content.services') },
    ]

    const event = {
        source: '',
        action: '',
        status: 0,
        data: null,
    }

    //Delete Record
    const deleteRecord = (row) => {
        const dialog = dialogBox( row.name, trnsl('messages.confirmDelete'))
        dialog.fire().then((result) =>{
            if(result.isConfirmed){
                form.delete(route('project.categories.destroy', row.id),{
                    onSuccess: () => { 
                        successMessage(trnsl('messages.recordDeleted'))
                        reload.value += 1;
                    },
                    onError: () => {
                        errorMessage(trnsl('messages.recordNoDeleted'))
                    }
                })
            }
        })
    }

    const getAction = ( action ) => {
        if (action.name==='edit') {
            event.source = 'list'
            event.action = action.name
            event.status = 1
            event.data = action.data
            emit('event', event)
        } else if (action.name==='delete') {
            deleteRecord(action.data)
        }
    }

    onMounted(()=>{
        headers[1].items = types
    })


</script>