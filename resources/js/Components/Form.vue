<template>

    <div class="grid grid-cols-1 sm:grid-cols-12 gap-2 px-3 py-3">

        <template v-for="(field, i) in fields" :key="i">
            
            <div v-if="field.type==='text'" :class="field.style">
                <InputLabel 
                    :for="field['name']" 
                    :value="field['text']+':'"
                ></InputLabel>
                <TextInput 
                    :id="field['name']" 
                    v-model="form[field['name']]"
                    type="text"
                    :disabled="field.disabled"
                    :size="field.length"
                ></TextInput>
                <InputError 
                    :message="form.errors[field['name']]"
                ></InputError>
            </div>

            <div v-if="field.type==='date'" :class="field.style">
                <InputLabel 
                    :for="field['name']" 
                    :value="field['text']+':'"
                ></InputLabel>
                <TextInput 
                    :id="field['name']" 
                    v-model="form[field['name']]"
                    type="date"
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
                ></InputLabel>
                <TextInput 
                    :id="field['name']" 
                    v-model="form[field['name']]"
                    type="email"
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
                ></InputLabel>
                <TextInput 
                    :id="field['name']" 
                    v-model="form[field['name']]"
                    type="number"
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
                ></InputLabel>
                <TextInput 
                    :id="field['name']" 
                    v-model="form[field['name']]"
                    type="time"
                    class="text-[9px]"
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
                ></InputLabel>
                <FileInput 
                    id="field['name']" 
                    type="file"
                    :accept="field['accept']"
                    @input="form[field['name']] = $event.target.files[0]"
                ></FileInput>
                <InputError 
                    :message="form.errors[field['name']]"
                ></InputError>
            </div>

            <div v-if="field.type==='textarea'" :class="field.style">
                <InputLabel 
                    :for="field['name']" 
                    :value="field['text']+':'"
                ></InputLabel>
                <TextArea 
                    :id="field['name']" 
                    v-model="form[field['name']]"
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
                ></InputLabel>
                <SelectInput 
                    :id="field['name']"
                    :options="field.items"
                    v-model="form[field['name']]"
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
                ></InputLabel>
                <Checkbox 
                    :id="field['name']"
                    v-model:checked="form[field['name']]"
                    :value="form[field['name']]"
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
                ></InputLabel>
                <SelectDynamic
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

            <div v-if="field.type==='selectMultiple'" :class="field.style">
                <InputLabel 
                    :for="field['name']"
                    :value="field['text']+':'"
                ></InputLabel>
                <SelectMultiple
                    :list="field.items"
                    :data="form[field['name']]"
                    :disabled="field.disabled"
                >
                </SelectMultiple>
                <InputError 
                    :message="form.errors[field['name']]"
                ></InputError>
            </div>

            <div v-if="field.type==='switch'" :class="field.style">
                <InputLabel 
                    :for="field['name']" 
                    :value="field['text']+':'"
                ></InputLabel>
                <Switch
                    v-model:status="form[field['name']]"
                    :value="form[field['name']]"
                >
                </Switch>
                <InputError 
                    :message="form.errors[field['name']]"
                ></InputError>
            </div>
        </template>
        
    </div>

    <div class="p-3 mt-2 flex justify-end bg-gray-100">
        <PrimaryButton
            v-if="operation!=='show'"
            :disabled="form.processing"
            @click="submitForm"
            icon="fa fa-save"
        >
            <!-- <i class=""></i> -->
            {{ acceptText }}
        </PrimaryButton>
        <SecondaryButton
            class="ml-3"
            :disabled="form.processing"
            icon="fa-solid fa-circle-xmark"
            @click="cancelForm"
        >
            {{ cancelText }}
        </SecondaryButton>
    </div>
     
</template>

<script setup>
    import PrimaryButton from '@/Components/PrimaryButton.vue' 
    import SecondaryButton from '@/Components/SecondaryButton.vue'
    import InputError from '@/Components/InputError.vue'
    import InputLabel from '@/Components/InputLabel.vue'
    import FileInput from '@/Components/FileInput.vue'
    import TextInput from '@/Components/TextInput.vue'
    import SelectInput from '@/Components/SelectInput.vue'
    import Checkbox from '@/Components/Checkbox.vue'
    import TextArea from '@/Components/TextArea.vue'
    import SelectDynamic from '@/Components/SelectDynamic.vue'
    import SelectMultiple from '@/Components/SelectMultiple.vue'
    import Switch from '@/Components/Switch.vue'
    import { successMessage, errorMessage, getError } from '@/Helpers/helper'
    import { trnsl } from '@/Lang/languages';
    import { ref, onMounted } from 'vue'

    const props = defineProps({
        fields: Array,
        form: Object,
        routePath: String,
        operation: String,
        style: String,
        acceptText: String,
    })

    const emit = defineEmits([
        'submit'
    ])

    const id = ref(0)
    const cancelText = ref('')

    let event = {
        source: '',
        action: '',
        status: 0,
        data: null,
    }
    
    const submitForm = () => {

        //Save Record
        if (props.operation === 'store'){
            props.form.post(route(props.routePath),{
                onSuccess: () => { 
                    successMessage(trnsl('messages.recordSaved'))
                    event.source = 'form'
                    event.action = props.operation
                    event.status = 1
                    emit('submit', event)
                },
                onError: (errors) => {
                    errorMessage(trnsl('messages.recordNoSaved') + '\n\r '+ getError(errors))
                    console.log(errors)
                }
            })

        //Update Record
        } else if (props.operation === 'update') {
            id.value = props.form.id
            props.form.patch(route(props.routePath, id.value), {
                onSuccess: () => { 
                    successMessage(trnsl('messages.recordUpdated')) 
                    event.source = 'form'
                    event.action = props.operation
                    event.status = 1
                    emit('submit', event)
                },
                onError: (errors) => {
                    errorMessage(trnsl('messages.recordNoUpdated') + '\n\r '+ getError(errors))
                    console.log(errors)
                }
            })
        
        //Update Record With File
        } else if (props.operation === 'updateWithFile') {
            id.value = props.form.id
            props.form.post(route(props.routePath, id.value), {
                onSuccess: () => { 
                    successMessage(trnsl('messages.recordUpdated')) 
                    event.source = 'form'
                    event.action = props.operation
                    event.status = 1
                    emit('submit', event)
                },
                onError: (errors) => {
                    errorMessage(trnsl('messages.recordNoUpdated') + '\n\r '+ getError(errors))
                    console.log(errors)
                }
            })
        } 
    }

    const cancelForm = () => {
        event.source = 'form'
        event.action = 'cancel'
        event.status = 1
        emit('submit', event)
    }

    onMounted( () => {
        if (props.operation==='show') {
            cancelText.value = trnsl('content.exit')
        } else {
            cancelText.value = trnsl('content.cancel')
        }
        
    })

</script> 