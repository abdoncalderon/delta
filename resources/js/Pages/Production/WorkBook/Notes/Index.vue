<template>
    <AuthenticatedLayout>
        <Head :title="$trnsl('content.notes')"></Head>

        <template #header>
            {{ $trnsl('content.notes') }}
        </template>

        <template #subheader>
            {{ $trnsl('content.production') }}
        </template>

        <template #content>
            <ToolBar
                :key="reload"
                :icons="icons"
                @click="clickIconToolBar"
            />

           <DataTable
                :key="reload"
                :headers="headers"
                :actions="actions"
                :dataset="notes"
                :title="trnsl('content.notes')+' - '+folio.location.name+' - '+folio.date"
                fieldSearch="name"
                @action="getAction"
            />
        </template>

        <Modal
            :show="modal"
            @close="closeModal"
        >
            <h3 class="px-3 py-3 font-semibold text-sm text-white bg-gray-700">
                {{ title }}
            </h3>

            <Form
                :fields="fields"
                :form="form"
                :routePath="routePath"
                :operation="operation"
                @submit="getEvent"
                :acceptText="trnsl('content.save')"
            />
        </Modal>

        <Modal
            :show="modalShow"
            @close="closeModal"
        >
            <h3 class="px-3 py-3 font-semibold text-sm text-white bg-gray-700">
                {{ title }}
            </h3>

            <Form
                :fields="fieldsShow"
                :form="form"
                :routePath="routePath"
                :operation="operation"
                @submit="getEvent"
                :acceptText="trnsl('content.save')"
            />
        </Modal>

        <Modal
            :show="modalComments"
            @close="modalComments.value=false"
        >
            <h3 class="px-3 py-3 font-semibold text-sm text-white bg-gray-700">
                {{ title }}
            </h3>
            <Comments
                :note="note" 
                :projectUserId="projectUserId"
                :folio="folio"
                @submit="getEvent"
            />
        </Modal>

    </AuthenticatedLayout>
</template>

<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
    import DataTable from '@/Components/DataTable.vue'
    import Modal from '@/Components/Modal.vue'
    import Form from '@/Components/Form.vue'
    import ToolBar from '@/Components/ToolBar.vue'
    import Comments from './Comments.vue'
    import dayjs from 'dayjs';
    import { trnsl } from '@/Lang/languages';
    import { useForm, Head, usePage, router } from '@inertiajs/vue3';
    import { successMessage, errorMessage, dialogBox } from '@/Helpers/helper'
    import { ref, reactive, onMounted } from 'vue';

    const props = defineProps({
        notes: Array,
        turns: Array,
        folio: Object,
        projectUserId: Number,
    });

    const form = useForm({
        'id': '',
        'folio_id': '',
        'location': '',
        'turn_id': '',
        'date': '',
        'note': '',
        'project_user_id': '',
        'status': ''
    });

    const modal = ref(false)
    const modalShow = ref(false)
    const modalComments = ref(false)
    const reload = ref(0)
    const title = ref('')
    const operation = ref('')
    const routePath = ref('')
    const note = reactive({})
   

    const headers = [
        {name: 'turn.name', text: trnsl('content.turn'), type: 'text', align: 'left'},
        {name: 'project_user.user.person.fullName', text: trnsl('content.user'), type: 'text', align: 'left'},
        {name: 'status', text: trnsl('content.status'), type: 'list', align: 'center', items: []},
    ];

    const actions = [
        {name: 'show', type: 'icon', text: trnsl('content.show'), icon: 'fa fa-eye', color: 'primary'},
        {name: 'comments', type: 'icon', text: trnsl('content.comments'), icon: 'fa fa-comment', color: 'primary'},
        {name: 'close', type: 'icon', text: trnsl('content.close'), icon: 'fa fa-ban', color: 'danger', disabledField: 'status'},
        
    ];

    const fields = [
        {name: 'location', type: 'text', text: trnsl('content.location'), style: 'sm:col-span-4',length: 255, disabled: true },
        {name: 'turn_id', type: 'select', text: trnsl('content.turn'), style: 'sm:col-span-2',  items:[], disabled: false },
        {name: 'note', type: 'textarea', text: trnsl('content.note'), style: 'sm:col-span-4', rows: 6, disabled: false }, 
    ];

    const fieldsShow = [
        {name: 'location', type: 'text', text: trnsl('content.location'), style: 'sm:col-span-4', length: 255, disabled: true },
        {name: 'date', type: 'text', text: trnsl('content.date'), style: 'sm:col-span-2', length: 255, disabled: true },
        {name: 'turn_id', type: 'select', text: trnsl('content.turn'), style: 'sm:col-span-2',  items:[], disabled: true },
        {name: 'note', type: 'textarea', text: trnsl('content.note'), style: 'sm:col-span-4', rows: 24, disabled: true }, 
    ];

    const icons = [
        {name: 'home', text: trnsl('content.home'), icon: 'fa-solid fa-home', hidden: false },
        {name: 'back', text: trnsl('content.back'), icon: 'fa-solid fa-arrow-left', hidden: false },       
        {name: 'new', text: trnsl('content.new'), icon: 'fa fa-plus', hidden: false },
    ];

    const statuses = [
        {id: 0, name: trnsl('content.opened')},
        {id: 1, name: trnsl('content.closed')}
    ]

    const today = dayjs(undefined).format('YYYY-MM-DD HH:mm:ss')

    const home = () => {
        router.visit(route('dashboard'))
    } 

    const back = () => {
        router.visit(route('production.workbook.folios.index'))
    } 

    const openModal = ( row ) => {
        modal.value = true;
    }

    const closeModal = () => {
        form.reset()
        modal.value = false
        reload.value += 1
        form.clearErrors()
    }

    const clickIconToolBar = (button) => {
        if (button === 'new') {
            form.reset()
            form.folio_id = props.folio.id
            form.project_user_id = props.projectUserId
            form.location = props.folio.location.name
            form.date = today,
            fields[1].items = props.turns
            operation.value = 'store'
            routePath.value = 'production.workbook.notes.store'
            title.value = trnsl('content.create') + ' ' + trnsl('content.note')
            openModal()
        } else if (button == 'back') {
            back()
        } else if (button == 'home') {
            home()
        }
    }

    const deleteRecord = (row) => {
        const dialog = dialogBox( row.name, trnsl('messages.confirmDelete'))
        dialog.fire().then((result) =>{
            if(result.isConfirmed){
                form.delete(route('production.workbook.notes.destroy', row.id),{
                    onSuccess: () => { 
                        successMessage(trnsl('messages.recordDeleted'))
                        reload.value += 1;
                    },
                    onError: () => {
                        errorMessage(trnsl('messages.recordNoDeleted'))
                        console.log('')
                    }
                })
            }
        });
    }

    const getAction = ( action ) => {
        if (action.name==='show') {
            form.location = props.folio.location.name
            fieldsShow[2].items = props.turns
            form.turn_id = action.data.turn_id
            form.note = action.data.note
            form.date = action.data.date.toString()
            title.value = trnsl('content.note')
            operation.value = 'show'
            modalShow.value = true
        } else if (action.name==='comments') {
                    note.value = action.data
                    title.value = trnsl('messages.noteComments')
                    modalComments.value = true
                } else if (action.name==='close') {
                            if ((action.data.project_user_id==props.projectUserId)&&(action.data.status==0)) {
                                closeNote(action.data)
                            } else {
                                errorMessage(trnsl('messages.operationNotAllowed'))
                            }
                        } else if (action.name==='delete') {
                                    deleteRecord(action.data)
                                }
    }

    const getEvent = ( event ) => {
        if (event.action==='store'){
            if (event.status==1){
                closeModal()
            } 
        } else if ((event.action==='update')||(event.action==='updateWithFile')) {
            if (event.status==1){
                closeModal()
            } 
        } else {
            closeModal()
            modalComments.value = false
            modalShow.value = false
        }
    }

    
    const closeNote = ( row ) => {
        const dialog = dialogBox( row.turn.name +  ' - [' + row.project_user.user.person.fullName + ']' )
        dialog.fire().then((result) =>{
            if(result.isConfirmed){
                form.status = 1
                form.patch(route('production.workbook.notes.update', row.id),{
                    onSuccess: () => { 
                        successMessage(trnsl('messages.closedNote'))
                        reload.value += 1;
                    },
                    onError: () => {
                        errorMessage(trnsl('messages.noteNotClosed'))
                        console.log('')
                    }
                })
            }
        });
    }

    onMounted( ()=> {
        headers[2].items = statuses
    })

     

</script>