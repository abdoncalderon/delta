<template>

    <div class="m-2" >
        <ToolBar
            :icons="icons"
            @click="clickIconToolBar"
        />
    </div>

    <div class="m-2">
        <div class="grid grid-cols-1 sm:grid-cols-6 gap-2 py-1">

            <div class="col-span-1 sm:col-span-1" >
                <InputLabel 
                    for="date" 
                    :value="trnsl('content.date')"
                    
                ></InputLabel>
                <TextInput 
                    id="date" 
                    v-model="dailyReport.date"
                    type="date"
                    
                    disabled="true"
                ></TextInput>
            </div>

            <div class="col-span-1 sm:col-span-5" >
                <InputLabel 
                    for="location" 
                    :value="trnsl('content.location')"
                    
                ></InputLabel>
                <TextInput 
                    id="location" 
                    v-model="dailyReport.location"
                    type="text"
                    
                    disabled="true"
                ></TextInput>
            </div>

            <div class="col-span-1 sm:col-span-3">
                <InputLabel 
                    for="turn" 
                    :value="trnsl('content.turn')"
                    
                ></InputLabel>
                <SelectInput 
                    id="turn"
                    :options="turns"
                    v-model="form.turn_id"
                ></SelectInput>
                <InputError 
                    :message="form.errors.turn_id"
                ></InputError>
            </div>

            <div class="col-span-1 sm:col-span-3">
                <InputLabel 
                    for="responsible" 
                    :value="trnsl('content.responsible')"
                    
                ></InputLabel>
                <SelectInput 
                    id="turn"
                    :options="responsibles"
                    v-model="form.responsible"
                ></SelectInput>
                <InputError 
                    :message="form.errors.responsible"
                ></InputError>
            </div>

            <div class="col-span-1 sm:col-span-6">
                <InputLabel 
                    for="report" 
                    :value="trnsl('content.detail')"
                    
                ></InputLabel>
                <TextArea 
                    id="report" 
                    v-model="form.report"
                    
                    rows="6"
                ></TextArea>
                <InputError 
                    :message="form.errors.report"
                ></InputError>
            </div>

        </div>
        
    </div>

    
    
</template>
<script setup>
    import InputError from '@/Components/InputError.vue'
    import InputLabel from '@/Components/InputLabel.vue'
    import TextInput from '@/Components/TextInput.vue'
    import TextArea from '@/Components/TextArea.vue'
    import SelectInput from '@/Components/SelectInput.vue'
    import ToolBar from '@/Components/ToolBar.vue'
    import { trnsl } from '@/Lang/languages';
    import { successMessage, errorMessage, dialogBox } from '@/Helpers/helper'
    import { ref, onMounted } from 'vue';
    import { useForm } from '@inertiajs/vue3';

    const props = defineProps({
        dailyReport: Object,
        turns: Array,
        responsibles: Array,
    })

    const form = useForm({
        'id': '',
        'folio_id': '',
        'turn_id': '',
        'project_user_id': '',
        'report': '',
        'responsible': '',
    });

    const emit = defineEmits([
        'close'
    ])

    const id = ref(0)

    const icons = [
        {name: 'save', text: trnsl('content.save'), icon: 'fa fa-floppy-disk', hidden: false},
    ];

    const back = () => {
        emit('close', true )
    } 

    const save = () => {
        id.value = form.id
        form.patch(route('production.workbook.dailyReports.update', id.value), {
            onSuccess: () => { 
                successMessage(trnsl('messages.recordUpdated'))
            },
            onError: (errors) => {
                errorMessage(trnsl('messages.recordNoUpdated'))
                console.log(errors)
            }
        })
    }

    const clickIconToolBar = (button) => {
        if (button === 'save') {
            save()
        } else if (button == 'back') {
                    back()
                } 
    }

    onMounted(() => {
        form.id = props.dailyReport.id
        form.folio_id = props.dailyReport.folio_id
        form.turn_id = props.dailyReport.turn_id
        form.responsible = props.dailyReport.responsible
        form.report = props.dailyReport.report
        form.project_user_id = props.dailyReport.project_user_id
    })

</script>