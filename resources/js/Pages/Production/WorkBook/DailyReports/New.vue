<template>

    <div class="bg-white rounded-lg shadow-md my-2 overflow-hidden">

        <h3 class="px-3 py-2 text-sm text-white bg-gray-700">
            {{ $trnsl('content.create') + ' ' + $trnsl('content.dailyReport') }}
        </h3>

        <div class="pb-3">

            <Tabs
                :tabs="tabs"
            >
                <template #report>
                    
                    <div class="p-2">
                        <ToolBar
                            :icons="icons"
                            @click="clickIconToolBar"
                        />
                        <div class="grid grid-cols-1 sm:grid-cols-6 gap-2 py-1">

                            <div class="col-span-1 sm:col-span-1" >
                                <InputLabel 
                                    for="date" 
                                    :value="trnsl('content.date')"
                                    
                                ></InputLabel>
                                <TextInput 
                                    id="date" 
                                    v-model="form.date"
                                    type="date"
                                    
                                    disabled="true"
                                ></TextInput>
                                <InputError 
                                    :message="form.errors.date"
                                ></InputError>
                            </div>

                            <div class="col-span-1 sm:col-span-5" >
                                <InputLabel 
                                    for="location" 
                                    :value="trnsl('content.location')"
                                    
                                ></InputLabel>
                                <TextInput 
                                    id="location" 
                                    v-model="form.location"
                                    type="text"
                                    disabled="true"
                                ></TextInput>
                                <InputError 
                                    :message="form.errors.location"
                                ></InputError>
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

                
                
            </Tabs>    
        </div>

        <!-- <Form
            :form="form"
            :fields="fields"
            :title="trnsl('content.dailyReport')"
            operation="store"
            routePath="production.workbook.dailyReports.store"
            :acceptText="trnsl('content.create')"
            @submit="getEvent"
        />  --> 

    </div>
</template>
<script setup>
    import InputError from '@/Components/InputError.vue'
    import InputLabel from '@/Components/InputLabel.vue'
    import TextInput from '@/Components/TextInput.vue'
    import TextArea from '@/Components/TextArea.vue'
    import SelectInput from '@/Components/SelectInput.vue'
    import ToolBar from '@/Components/ToolBar.vue'
    import Tabs from '@/Components/Tabs.vue'
    import { successMessage, errorMessage, dialogBox } from '@/Helpers/helper'
    import { trnsl } from '@/Lang/languages';
    import { ref, reactive, onMounted } from 'vue';
    import { useForm, Head, usePage, router } from '@inertiajs/vue3';

    const props = defineProps({
        form: Object,
        turns: Array,
        responsibles: Array,
    })

    const emit = defineEmits([
        'event'
    ])

    const icons = [
        {name: 'back', text: trnsl('content.back'), icon: 'fa-solid fa-xmark', hidden: false}, 
        {name: 'save', text: trnsl('content.save'), icon: 'fa fa-floppy-disk', hidden: false},
        
    ];

    const tabs = [
        { name: 'report', text: trnsl('content.activities') },   
    ]

    const event = {
        source: '',
        action: '',
        status: 0,
        data: null
    }

    const getError = (errors) => {
        var result = '';
        if (typeof errors === 'object') {
            for (var prop in errors) {
                if (errors.hasOwnProperty(prop)) {
                    result += errors[prop] + '\n'
                }
            }
            return result
        } else {
            return result
        }
    }

    const save = () => {
        
        props.form.post(route('production.workbook.dailyReports.store'), {
            onSuccess: () => { 
                successMessage(trnsl('messages.recordSaved'))
                event.source = 'new'
                event.action = 'save'
                event.status = 1
                event.data = props.form
                emit ('event', event)
            },
            onError: (errors) => {
                errorMessage(trnsl('messages.recordNoSaved') + '\n\r '+ getError(errors))
                console.log(errors)
            }
        })
    }

    const clickIconToolBar = (button) => {
        if (button === 'save') {
            save()
        } else if (button == 'back') {
                    emit ('event', event)
                } 
    }
    

    onMounted(() => {
        
    })

</script>