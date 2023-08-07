<template>
    <div class="grid grid-cols-1 sm:grid-cols-4 gap-2 px-3 py-3">
        <template v-for="(field, i) in fields" :key="i">
            
            <div v-if="field.type==='text'" :class="field.style">
                <InputLabel 
                    :for="field['name']" 
                    :value="field['text']+':'"
                    class="ml-1 text-xs font-bold"
                ></InputLabel>
                <TextInput 
                    :id="field['name']" 
                    v-model="form[field['name']]"
                    type="text"
                    class="text-xs mt-1"
                    :placeholder="field['text']"
                    :disabled="field.disabled"
                ></TextInput>
                <InputError 
                    :message="form.errors[field['name']]"
                ></InputError>
            </div>
            <div v-if="field.type==='date'" :class="field.style">
                <InputLabel 
                    :for="field['name']" 
                    :value="field['text']+':'"
                    class="ml-1 text-xs font-bold"
                ></InputLabel>
                <TextInput 
                    :id="field['name']" 
                    v-model="form[field['name']]"
                    type="date"
                    class="mt-1 text-xs "
                    :placeholder="field['text']"
                    :disabled="field.disabled"
                ></TextInput>
                <InputError 
                    :message="form.errors[field['name']]"
                ></InputError>
            </div>
            <div v-if="field.type==='email'" :class="field.style">
                <InputLabel 
                    :for="field['name']" 
                    :value="field['text']+':'"
                    class="ml-1 text-xs font-bold"
                ></InputLabel>
                <TextInput 
                    :id="field['name']" 
                    v-model="form[field['name']]"
                    type="email"
                    class="mt-1 text-xs "
                    :placeholder="field['text']"
                    :disabled="field.disabled"
                ></TextInput>
                <InputError 
                    :message="form.errors[field['name']]"
                ></InputError>
            </div>
            <div v-if="field.type==='number'" :class="field.style">
                <InputLabel 
                    :for="field['name']" 
                    :value="field['text']+':'"
                    class="ml-1 text-xs font-bold"
                ></InputLabel>
                <TextInput 
                    :id="field['name']" 
                    v-model="form[field['name']]"
                    type="number"
                    class="mt-1 text-xs "
                    :placeholder="field['text']"
                    :disabled="field.disabled"
                ></TextInput>
                <InputError 
                    :message="form.errors[field['name']]"
                ></InputError>
            </div>
            <div v-if="field.type==='time'" :class="field.style">
                <InputLabel 
                    :for="field['name']" 
                    :value="field['text']+':'"
                    class="ml-1 text-xs font-bold"
                ></InputLabel>
                <TextInput 
                    :id="field['name']" 
                    v-model="form[field['name']]"
                    type="time"
                    class="px-3 py-1.5 text-xs "
                    :disabled="field.disabled"
                ></TextInput>
                <InputError 
                    :message="form.errors[field['name']]"
                ></InputError>
            </div>
            <div v-if="field.type=='file'" :class="field.style">
                <InputLabel 
                    for="field['name']"
                    :value="field['text']+':'"
                    class="ml-1 text-xs font-bold"
                ></InputLabel>
                <TextInput 
                    :id="field['name']" 
                    type="file"
                    class="mt-1 p-1 text-xs "
                    :accept="field['accept']"
                    @input="form[field['name']] = $event.target.files[0]"
                ></TextInput>
                <InputError 
                    :message="form.errors[field['name']]"
                ></InputError>
            </div>
            <div v-if="field.type==='textarea'" :class="field.style">
                <InputLabel 
                    :for="field['name']" 
                    :value="field['text']+':'"
                    class="ml-1 text-xs font-bold"
                ></InputLabel>
                <TextArea 
                    :id="field['name']" 
                    v-model="form[field['name']]"
                    class="text-xs mt-1"
                    :placeholder="field['text']"
                    :disabled="field.disabled"
                    :rows="field.rows"
                ></TextArea>
                <InputError 
                    :message="form.errors[field['name']]"
                ></InputError>
            </div>
            <div v-if="field.type==='select'" :class="field.style">
                <InputLabel 
                    :for="field['name']" 
                    :value="field['text']+':'"
                    class="ml-1 text-xs font-bold"
                ></InputLabel>
                <SelectInput 
                    :id="field['name']"
                    :options="field.items"
                    v-model="form[field['name']]"
                    class="mt-1 text-xs"
                    :disabled="field.disabled"
                ></SelectInput>
                <InputError 
                    :message="form.errors[field['name']]"
                ></InputError>
            </div>
            <div v-if="field.type==='check'" :class="field.style">
                <InputLabel 
                    :for="field['name']" 
                    :value="field['text']+':'"
                    class="ml-1 text-xs font-bold"
                ></InputLabel>
                <Checkbox 
                    :id="field['name']"
                    v-model:checked="form[field['name']]"
                    :value="form[field['name']]"
                    class="mt-1"
                    :disabled="field.disabled"
                ></Checkbox>
                <InputError 
                    :message="form.errors[field['name']]"
                ></InputError>
            </div>
            <div v-if="field.type==='selectDynamic'" :class="field.style">
                <InputLabel 
                    :for="field['name']" 
                    :value="field['text']+':'"
                    class="ml-1 text-xs font-bold"
                ></InputLabel>
                <SelectDynamic
                    :id="field['name']"
                    :options="field.items"
                    v-model="form[field['name']]"
                    :disabled="field.disabled"
                    :show="field.show"
                >
                </SelectDynamic>
                <InputError 
                    :message="form.errors[field['name']]"
                ></InputError>
            </div>
        </template>

        <!-- class="mt-1 p-1 text-xs" -->
        
    </div>

    <div class="p-3 mt-2 flex justify-end bg-gray-100">
        <PrimaryButton
            :disabled="form.processing"
            @click="submitForm"
        >
            <i class="fa fa-save"></i>
            {{  acceptText }}
        </PrimaryButton>
        <SecondaryButton
            class="ml-3"
            :disabled="form.processing"
            @click="cancelForm"
        >
            {{  $trnsl('content.cancel') }}
        </SecondaryButton>
       
    </div>
     
</template>

<script setup>
    import PrimaryButton from '@/Components/PrimaryButton.vue' 
    import SecondaryButton from '@/Components/SecondaryButton.vue'
    import InputError from '@/Components/InputError.vue'
    import InputLabel from '@/Components/InputLabel.vue'
    import TextInput from '@/Components/TextInput.vue'
    import SelectInput from '@/Components/SelectInput.vue'
    import Checkbox from '@/Components/Checkbox.vue'
    import TextArea from '@/Components/TextArea.vue'
    import SelectDynamic from '@/Components/SelectDynamic.vue'
    import { successMessage, errorMessage } from '@/Helpers/helper'
    import { trnsl } from '@/Lang/languages';
    import { ref } from 'vue'

    const props = defineProps({
        fields: Array,
        form: Object,
        table: String,
        routePath: String,
        operation: String,
        style: String,
        acceptText: String,
    })

    const emit = defineEmits([
        'submit'
    ])

    let status = -1
    const id = ref(0)
    
    const submitForm = () => {

        //Save Record
        if (props.operation === 'store'){
            props.form.post(route(props.routePath),{
                onSuccess: () => { 
                    status = 1
                    successMessage(trnsl('messages.recordSaved'))
                    emit('submit',[status, props.operation])
                },
                onError: (errors) => {
                    status = 0
                    errorMessage(trnsl('messages.recordNoSaved')+'\n\r '+ errors)
                    emit('submit',[status, props.operation])
                    console.log(errors)
                }
            })

        //Update Record
        } else if (props.operation === 'update') {
            id.value = props.form.id
            props.form.patch(route(props.routePath, id.value), {
                onSuccess: () => { 
                    status = 1
                    successMessage(trnsl('messages.recordUpdated')) 
                    emit('submit',[status, props.operation])
                },
                onError: (errors) => {
                    status = 0
                    errorMessage(trnsl('messages.recordNoUpdated')+'\n\r '+errors)
                    emit('submit',[status, props.operation])
                    console.log(errors)
                }
            })
        
        //Update Record With File
        } else if (props.operation === 'updateWithFile') {
            id.value = props.form.id
            props.form.post(route(props.routePath, id.value), {
                onSuccess: () => { 
                    status = 1
                    successMessage(trnsl('messages.recordUpdated')) 
                    emit('submit',[status, props.operation])
                },
                onError: (errors) => {
                    status = 0
                    errorMessage(trnsl('messages.recordNoUpdated')+'\n\r '+errors)
                    emit('submit',[status, props.operation])
                    console.log(errors)
                }
            })
        } 
    }

    const cancelForm = () => {
        status = -1
        emit('submit',[status, 'cancel'])
    }

</script> 