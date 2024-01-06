<template>
    <div class="m-2">
        <ToolBar
            :icons="icons"
            @click="clickIconToolBar"
        />
    </div>
    <div class="m-2">
        <table class="min-w-full divide-y divide-gray-300 rounded-lg overflow-auto ">

            <thead class="bg-gray-600">
                <tr class="tracking-wide">
                    <th class="px-4 py-1 text-xs text-white tracking-wider">
                        {{ trnsl('content.filename') }}
                    </th>
                   
                    <th class="px-4 py-1 text-xs text-white tracking-wider">
                        {{ trnsl('content.description') }}
                    </th>
                   
                    <th class="px-4 py-1 text-xs text-white tracking-wider">
                        {{ trnsl('content.actions') }}
                    </th>
                </tr>
            </thead>

            <tbody class="bg-white divide-y divide-gray-300">
                <tr v-for="(attachment, i) in attachmentsDailyReport" :key="i">
                    <td class="whitespace-wrap px-4 py-1 text-xs text-gray-500 text-start">
                        {{ attachment.filename }}
                    </td>
                  
                    <td class="whitespace-wrap px-4 py-1 text-xs text-gray-500 text-start">
                        {{ attachment.description }}
                    </td>
                  
                    <td class="px-4 py-1 text-xs text-gray-500 text-center">
                        <span class="inline-flex overflow-hidden rounded-md border bg-white shadow-sm">
                            <button 
                                class="inline-block border-e px-2 py-1 text-green-600 hover:bg-gray-50 focus:relative"
                                :title="trnsl('content.show')"
                                @click="showAttachment(attachment)"
                            >
                                <i class="fa fa-eye"></i>
                            </button>
                            <button 
                                class="inline-block border-e px-2 py-1 text-red-600 hover:bg-gray-50 focus:relative"
                                :title="trnsl('content.delete')"
                                @click="deleteAttachment(attachment)"
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
        :showModal="modal"
        @closeModal="closeModal"
        :title="title"
    >
       <!--  <h3 class="px-3 py-3 font-semibold text-sm text-white bg-gray-700">
            {{ title }}
        </h3> -->

        <Form
            :form="form"
            :fields="fields"
            operation="store"
            routePath="production.workbook.dailyReports.attachments.store"
            :acceptText="trnsl('content.save')"
            @submit="getEvent"
        />
    </Modal>

    <Modal
        :showModal="showFile"
        @closeModal="closeAttachment"
    >   
        <div class="text-center">
            <img class="object-contain" :src="'http://delta.test/storage/kapatax/images/dailyReports/'+ attachmentFile" alt="">
        </div>
        
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
        'file': '',
        'description': '',
        'project_user_id': '',
    })

    const emit = defineEmits([
        'close'
    ])

    const page = usePage();

    const reload = ref(0)
    const attachmentsDailyReport = reactive([])
    const modal = ref(false)
    const title = ref('')
    const attachmentFile = ref('')
    const showFile = ref(false)

    const fields = [
        {name: 'file', type: 'file', text: trnsl('content.filename'), style: 'sm:col-span-4', accept: 'image/png, .jpg', disabled: false}, 
        {name: 'description', type: 'textarea', text: trnsl('content.description'), style: 'sm:col-span-4', rows: 4, disabled: false}, 
    ];

    const icons = [
        {name: 'new', text: trnsl('content.new'), icon: 'fa fa-plus', hidden: false},
    ];

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
            title.value = trnsl('content.add') + ' ' + trnsl('content.attachment')
            openModal()
        } 
    }

    const getAttachmentsDailyReport = () => {
        attachmentsDailyReport.length = 0
        axios.get('/api/getAttachmentsDailyReport/' + props.dailyReport.id)
            .then(response=>{
                response.data.forEach( (row, i) => {
                    attachmentsDailyReport[i] = row
                })
                reload.value += 1;
            })
            .catch(error=>{
                console.log(error)
            })
    }     

    const showAttachment = ( attachment ) => {
        attachmentFile.value = attachment.filename
        showFile.value = true
    }

    const closeAttachment = ( ) => {
        showFile.value = false
    }

    const deleteAttachment = ( attachment ) => {
        const dialog = dialogBox(attachment.filename, trnsl('messages.confirmDelete'))
        dialog.fire().then((result) =>{
            if(result.isConfirmed){
                form.delete(route('production.workbook.dailyReports.attachments.destroy', attachment.id),{
                    onSuccess: () => { 
                        successMessage(trnsl('messages.recordDeleted'))
                        getAttachmentsDailyReport()
                    },
                    onError: () => {
                        errorMessage(trnsl('messages.recordNoDeleted'))
                    }
                })
            }
        });
    }

    const getEvent = ( event ) => {
        getAttachmentsDailyReport()
        closeModal()
    }

    onMounted(() => {
        getAttachmentsDailyReport()
        form.project_user_id = page.props.auth.currentProjectUser.id
    }) 

</script>

