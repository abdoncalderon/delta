<template>
    <div class="m-2">
        <ToolBar
            :icons="icons"
            @click="clickIconToolBar"
        />
    </div>

    <div class="m-2">
        <table class="min-w-full divide-y divide-gray-300 rounded-lg overscrool-x-auto">
            <thead class="bg-gray-600">
                <tr class="tracking-wide">
                    <th class="px-4 py-1 text-xs text-white ">
                        {{ trnsl('content.company') }}
                    </th>
                    <th class="px-4 py-1 text-xs text-white ">
                        {{ trnsl('content.equipment') }}
                    </th>
                    <th class="px-4 py-1 text-xs text-white ">
                        {{ trnsl('content.quantity') }}
                    </th>
                    <th class="px-4 py-1 text-xs text-white ">
                        {{ trnsl('content.actions') }}
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-300">
                <tr v-for="(equipment, i) in equipmentsDailyReport" :key="i">
                    <td class=" px-4 py-1 text-xs text-gray-500 text-start">
                        {{ equipment.stakeholder.name }}
                    </td>
                    <td class="px-4 py-1 text-xs text-gray-500 text-start">
                        {{ equipment.equipment.name }}
                    </td>
                    <td class=" px-4 py-1 text-xs text-gray-500 text-end">
                        {{ equipment.quantity }}
                    </td>
                    <td class="px-4 py-1 text-xs text-gray-500 text-center">
                        <span class="inline-flex overflow-hidden rounded-md border bg-white shadow-sm">
                            <button 
                                class="inline-block border-e px-2 py-1 text-red-600 hover:bg-gray-50 focus:relative"
                                :title="trnsl('content.delete')"
                                @click="deleteEquipment(equipment)"
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
        :show="newModal"
        @close="closeModals"
    >
        <h3 class="px-3 py-3 font-semibold text-sm text-white bg-gray-700">
            {{ title }}
        </h3>

        <Form
            :form="newForm"
            :fields="newFields"
            operation="store"
            routePath="production.workbook.dailyReports.equipments.store"
            :acceptText="trnsl('content.save')"
            @submit="getEvent"
        />
    </Modal>

    

    <Modal
        :show="cloneModal"
        @close="closeModals"
    >
        <h3 class="px-3 py-3 font-semibold text-sm text-white bg-gray-700">
            {{ title }}
        </h3>

        <Form
            :form="cloneForm"
            :fields="cloneFields"
            operation="store"
            routePath="production.workbook.dailyReports.equipments.clone"
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
    import { useForm } from '@inertiajs/vue3';
    import { ref, reactive, onMounted } from 'vue';
    import { successMessage, errorMessage, dialogBox } from '@/Helpers/helper'
    import axios from 'axios';

    const props = defineProps({
        dailyReport: Object,
        stakeholders: Array,
        equipments: Array,
    })

    const newForm = useForm({
        'id': '',
        'daily_report_id': '',
        'stakeholder_id': '',
        'equipment_id': '',
        'quantity': 1,
    })

    const cloneForm = useForm({
        'old_daily_report_id': '',
        'daily_report_id': '',
    })

    const emit = defineEmits([
        'close',
    ])

    const reload = ref(0)
    const equipmentsDailyReport = reactive([])
    const oldDailyReports = reactive([])
    const newModal = ref(false)
    const cloneModal = ref(false)
    const title = ref('')

    const newFields = [
        {name: 'stakeholder_id', type: 'select', text: trnsl('content.company'), style: 'sm:col-span-4', items:[], disabled: false}, 
        {name: 'equipment_id', type: 'select', text: trnsl('content.equipment'), style: 'sm:col-span-3', items:[], disabled: false}, 
        {name: 'quantity', type: 'number', text: trnsl('content.quantity'), style: 'sm:col-span-1', disabled: false}, 
    ];

    const cloneFields = [
        {name: 'old_daily_report_id', type: 'select', text: trnsl('messages.oldDailyReports'), style: 'sm:col-span-4', items:[], disabled: false}, 
    ];

    const icons = [
        
        {name: 'clone', text: trnsl('content.clone'), icon: 'fa fa-clone', hidden: false}, 
        {name: 'new', text: trnsl('content.new'), icon: 'fa fa-plus', hidden: false},
    ];
    
    const closeModals = () => {
        newModal.value = false;
        cloneModal.value = false
        newForm.clearErrors()
        cloneForm.clearErrors()
        newForm.reset()
        cloneForm.reset()
        reload.value += 1;
    }

    const clickIconToolBar = (button) => {
        if (button === 'new') {
            newForm.daily_report_id = props.dailyReport.id
            title.value = trnsl('content.add') + ' ' + trnsl('content.equipment')
            newModal.value = true
        } else if (button == 'clone') {
            getOldDailyReport()
                    cloneFields[0].items = oldDailyReports
                    cloneForm.daily_report_id = props.dailyReport.id
                    title.value = trnsl('messages.cloneEquipments')
                    cloneModal.value = true
                } 
        }

    const getEquipmentsDailyReport = () => {
        equipmentsDailyReport.length = 0
        axios.get('/api/getEquipmentsDailyReport/' + props.dailyReport.id)
            .then(response=>{
                response.data.forEach( (row, i) => {
                    equipmentsDailyReport[i] = row
                })
                reload.value += 1;
            })
            .catch(error=>{
                console.log(error)
            })
    }     

    const getOldDailyReport = () => {
        oldDailyReports.length = 0
        axios.get('/api/getOldDailyReports/' + props.dailyReport.location_id + '/' + props.dailyReport.id)
            .then(response=>{
                response.data.forEach( (row, i) => {
                    oldDailyReports[i] = row
                })
                reload.value += 1;
            })
            .catch(error=>{
                console.log(error)
            })
    }

    const deleteEquipment = ( equipment ) => {
        const dialog = dialogBox(equipment.equipment.name, trnsl('messages.confirmDelete'))
        dialog.fire().then((result) =>{
            if(result.isConfirmed){
                newForm.delete(route('production.workbook.dailyReports.equipments.destroy', equipment.id),{
                    onSuccess: () => { 
                        successMessage(trnsl('messages.recordDeleted'))
                        getEquipmentsDailyReport()
                    },
                    onError: () => {
                        errorMessage(trnsl('messages.recordNoDeleted'))
                    }
                })
            }
        });
    }

    const getEvent = ( event ) => {
        getEquipmentsDailyReport()
        closeModals()
    }
    
    onMounted(() => {
        getEquipmentsDailyReport()
        newFields[0].items = props.stakeholders
        newFields[1].items = props.equipments
    }) 
</script>