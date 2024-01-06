<template>
    <div class="m-2">
        <ToolBar
            :icons="icons"
            @click="clickIconToolBar"
        /></div>
    <div class="m-2">
        <table class="min-w-full divide-y divide-gray-300 rounded-lg overflow-auto">

            <thead class="bg-gray-600">
                <tr class="tracking-wide">
                    <th class="px-4 py-1 text-xs text-white tracking-wider">
                        {{ trnsl('content.cause') }}
                    </th>
                    <th class="px-4 py-1 text-xs text-white tracking-wider">
                        {{ trnsl('content.duration') }}
                    </th>
                    <th class="px-4 py-1 text-xs text-white tracking-wider">
                        {{ trnsl('content.description') }}
                    </th>
                    <th class="px-4 py-1 text-xs text-white tracking-wider">
                        {{ trnsl('content.impact') }}
                    </th>
                    <th class="px-4 py-1 text-xs text-white tracking-wider">
                        {{ trnsl('content.actions') }}
                    </th>
                </tr>
            </thead>

            <tbody class="bg-white divide-y divide-gray-300">
                <tr v-for="(event, i) in eventsDailyReport" :key="i">
                    <td class="whitespace-wrap px-4 py-1 text-xs text-gray-500 text-start">
                        {{ causes[event.cause].name }}
                    </td>
                    <td class="whitespace-wrap px-4 py-1 text-xs text-gray-500 text-start">
                        {{ event.start+' '+event.finish }}
                    </td>
                    <td class="whitespace-wrap px-4 py-1 text-xs text-gray-500 text-start">
                        {{ event.description }}
                    </td>
                    <td class="whitespace-wrap px-4 py-1 text-xs text-gray-500 text-center">
                        {{ event.haveImpact ? trnsl('content.yes') : trnsl('content.no') }}
                    </td>
                    <td class="px-4 py-1 text-xs text-gray-500 text-center">
                        <span class="inline-flex overflow-hidden rounded-md border bg-white shadow-sm">
                            <button 
                                class="inline-block border-e px-2 py-1 text-red-600 hover:bg-gray-50 focus:relative"
                                :title="trnsl('content.delete')"
                                @click="deleteEvent(event)"
                            >
                                <i class="fa fa-trash"></i>
                            </button>
                        </span>
                        
                    </td>
                </tr>
            </tbody>

        </table>
    </div>
    <Modal
        :show="modal"
        @close="closeModal"
    >
        <h3 class="px-3 py-3 font-semibold text-sm text-white bg-gray-700">
            {{ title }}
        </h3>

        <Form
            :form="form"
            :fields="fields"
            operation="store"
            routePath="production.workbook.dailyReports.events.store"
            :acceptText="trnsl('content.save')"
            @submit="getEvent"
        />
    </Modal>
</template>
<script setup>

    import ToolBar from '@/Components/ToolBar.vue'
    import Modal from '@/Components/Modal.vue'
    import Form from '@/Components/Form.vue'
    import { trnsl } from '@/Lang/languages';
    import { useForm,  usePage } from '@inertiajs/vue3';
    import { ref, reactive, onMounted } from 'vue';
    import { successMessage, errorMessage, dialogBox } from '@/Helpers/helper'
    import axios from 'axios';

    const props = defineProps({
        dailyReport: Object,
    })

    const form = useForm({
        'id': '',
        'daily_report_id': '',
        'cause': '',
        'start': '',
        'finish': '',
        'description': '',
        'haveImpact': false,
        'project_user_id': '',
    })

    const emit = defineEmits([
        'close'
    ])

    const page = usePage();

    const reload = ref(0)
    const eventsDailyReport = reactive([])
    const modal = ref(false)
    const title = ref('')

    const fields = [
        {name: 'id', type: 'hidden'},
        {name: 'daily_report_id', type: 'hidden'},
        {name: 'cause', type: 'select', text: trnsl('content.cause'), style: 'sm:col-span-1', items:[], disabled: false}, 
        {name: 'start', type: 'time', text: trnsl('content.start'), style: 'sm:col-span-1', disabled: false },
        {name: 'finish', type: 'time', text: trnsl('content.finish'), style: 'sm:col-span-1', disabled: false },
        {name: 'haveImpact', type: 'check', text: trnsl('content.impact'), style: 'sm:col-span-1', disabled: false}, 
        {name: 'description', type: 'textarea', text: trnsl('content.description'), style: 'sm:col-span-4', rows: 8, disabled: false}, 
    ];

    const icons = [
        {name: 'new', text: trnsl('content.new'), icon: 'fa fa-plus', hidden: false},
    ];

    const causes = [
        {id: 0, name: trnsl('content.internal') },
        {id: 1, name: trnsl('content.external') },
        {id: 2, name: trnsl('content.climate') },
    ]

    const openModal = () => {
        modal.value = true;
    }

    const closeModal = () => {
        modal.value = false;
        reload.value += 1;
        form.reset()
        form.clearErrors()
    }

    const clickIconToolBar = (button) => {
        if (button === 'new') {
            form.daily_report_id = props.dailyReport.id
            title.value = trnsl('content.add') + ' ' + trnsl('content.event')
           openModal()
        } 
    }

    const getEventsDailyReport = () => {
        eventsDailyReport.length = 0
        axios.get('/api/getEventsDailyReport/' + props.dailyReport.id)
            .then(response=>{
                response.data.forEach( (row, i) => {
                    eventsDailyReport[i] = row
                })
                reload.value += 1;
            })
            .catch(error=>{
                console.log(error)
            })
    }     

    const deleteEvent = ( event ) => {
        const dialog = dialogBox(event.description, trnsl('messages.confirmDelete'))
        dialog.fire().then((result) =>{
            if(result.isConfirmed){
                form.delete(route('production.workbook.dailyReports.events.destroy', event.id),{
                    onSuccess: () => { 
                        successMessage(trnsl('messages.recordDeleted'))
                        getEventsDailyReport()
                    },
                    onError: () => {
                        errorMessage(trnsl('messages.recordNoDeleted'))
                    }
                })
            }
        });
    }

    const getEvent = ( event ) => {
        getEventsDailyReport()
        closeModal()
    }
    
    onMounted(() => {
        getEventsDailyReport()
        fields[2].items = causes
        form.project_user_id = page.props.auth.currentProjectUser.id
    }) 
</script>