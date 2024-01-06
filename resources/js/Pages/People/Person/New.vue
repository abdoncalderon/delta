<template>

    <Window
        :title="trnsl('content.create') + ' ' + form.fullName"
        @close="cancel"
    >
        <template #body>

            <div class="m-2">
                <ToolBar
                    :icons="icons"
                    @click="clickIconToolBar"
                />
            </div>
        
            <div class="m-1 px-1 py-1 grid grid-cols-1 sm:grid-cols-12 gap-2">

                <div class="col-span-1 sm:col-span-3" >
                    <InputLabel 
                        for="firstName" 
                        :value="trnsl('content.firstNames')"
                    ></InputLabel>
                    <TextInput 
                        id="firstName" 
                        v-model="form.firstName"
                        type="text"
                        @keyup="fullName"
                    ></TextInput>
                    <InputError 
                        :message="form.errors.firstName"
                    ></InputError>
                </div>

                <div class="col-span-1 sm:col-span-3" >
                    <InputLabel 
                        for="lastName" 
                        :value="trnsl('content.lastNames')"
                    ></InputLabel>
                    <TextInput 
                        id="lastName" 
                        v-model="form.lastName"
                        type="text"
                        @keyup="fullName"
                    ></TextInput>
                    <InputError 
                        :message="form.errors.lastName"
                    ></InputError>
                </div>

                <div class="col-span-1 sm:col-span-6" >
                    <InputLabel 
                        for="fullName" 
                        :value="trnsl('content.fullName')"
                    ></InputLabel>
                    <TextInput 
                        id="fullName" 
                        v-model="form.fullName"
                        type="text"
                        :disabled="true"
                    ></TextInput>
                    <InputError 
                        :message="form.errors.fullName"
                    ></InputError>
                </div>

                <div class="col-span-1 sm:col-span-2" >
                    <InputLabel 
                        for="uid" 
                        :value="trnsl('content.uid')"
                    ></InputLabel>
                    <TextInput 
                        id="uid" 
                        v-model="form.uid"
                        type="text"
                    ></TextInput>
                    <InputError 
                        :message="form.errors.uid"
                    ></InputError>
                </div>

                <div class="col-span-1 sm:col-span-2">
                    <InputLabel 
                        for="gender" 
                        :value="trnsl('content.gender')"
                    ></InputLabel>
                    <SelectInput 
                        id="gender"
                        :options="genders"
                        v-model="form.gender_id"
                    ></SelectInput>
                    <InputError 
                        :message="form.errors.gender_id"
                    ></InputError>
                </div>

                <div class="col-span-1 sm:col-span-2" >
                    <InputLabel 
                        for="bitthDate" 
                        :value="trnsl('content.birthDate')"
                    ></InputLabel>
                    <TextInput 
                        id="birthDate" 
                        v-model="form.birthDate"
                        type="date"
                    ></TextInput>
                    <InputError 
                        :message="form.errors.birthDate"
                    ></InputError>
                </div>

                <div class="col-span-1 sm:col-span-6" >
                    <InputLabel 
                        for="jobTitle" 
                        :value="trnsl('content.jobTitle')"
                    ></InputLabel>
                    <TextInput 
                        id="jobTitle" 
                        v-model="form.jobTitle"
                        type="text"
                    ></TextInput>
                    <InputError 
                        :message="form.errors.jobTitle"
                    ></InputError>
                </div>

                <div class="col-span-1 sm:col-span-4" >
                    <InputLabel 
                        for="email" 
                        :value="trnsl('content.personalEmail')"
                    ></InputLabel>
                    <TextInput 
                        id="jobTitle" 
                        v-model="form.email"
                        type="email"
                    ></TextInput>
                    <InputError 
                        :message="form.errors.email"
                    ></InputError>
                </div>

                <div class="col-span-1 sm:col-span-4" >
                    <InputLabel 
                        for="photo"
                        :value="trnsl('content.photo')"
                    ></InputLabel>
                    <FileInput 
                        id="photo" 
                        type="file"
                        accept="*image/png, .jpg"
                        @input="form.photo = $event.target.files[0]"
                    ></FileInput>
                    <InputError 
                        :message="form.errors.photo"
                    ></InputError>
                </div>

                <div class="col-span-1 sm:col-span-4" >
                    <InputLabel 
                        for="signature"
                        :value="trnsl('content.signature')"
                    ></InputLabel>
                    <FileInput 
                        id="signature" 
                        type="file"
                        accept="image/png, .jpg"
                        @input="form.signature = $event.target.files[0]"
                    ></FileInput>
                    <InputError 
                        :message="form.errors.signature"
                    ></InputError>
                </div>
            </div>

            <div class="m-1 px-1 py-1 grid grid-cols-1 sm:grid-cols-12 gap-2">

                <div class="col-span-1 sm:col-span-6">
                    <InputLabel 
                        for="stakeholder" 
                        :value="trnsl('content.company')"
                    ></InputLabel>
                    <SelectInput 
                        id="stakeholder"
                        :options="stakeholders"
                        v-model="form.stakeholder_id"
                    ></SelectInput>
                    <InputError 
                        :message="form.errors.stakeholder_id"
                    ></InputError>
                </div>
                
                <div class="col-span-1 sm:col-span-2" >
                    <InputLabel 
                        for="admissionDate" 
                        :value="trnsl('content.admissionDate')"
                    ></InputLabel>
                    <TextInput 
                        id="admissionDate" 
                        v-model="form.admissionDate"
                        type="date"
                    ></TextInput>
                    <InputError 
                        :message="form.errors.admissionDate"
                    ></InputError>
                </div>

                <div class="col-span-1 sm:col-span-2" >
                    <InputLabel 
                        for="hiredSince" 
                        :value="trnsl('content.hiredSince')"
                    ></InputLabel>
                    <TextInput 
                        id="hiredSince" 
                        v-model="form.hiredSince"
                        type="date"
                    ></TextInput>
                    <InputError 
                        :message="form.errors.hiredSince"
                    ></InputError>
                </div>

                <div class="col-span-1 sm:col-span-2" >
                    <InputLabel 
                        for="cardNo" 
                        :value="trnsl('content.cardNumber')"
                    ></InputLabel>
                    <TextInput 
                        id="cardNo" 
                        v-model="form.cardNo"
                        type="text"
                    ></TextInput>
                    <InputError 
                        :message="form.errors.cardNo"
                    ></InputError>
                </div>

                <div class="col-span-1 sm:col-span-6">
                    <InputLabel 
                        for="sector" 
                        :value="trnsl('content.sector')"
                    ></InputLabel>
                    <SelectInput 
                        id="sector"
                        :options="sectors"
                        v-model="sector"
                    ></SelectInput>
                </div>

                <div class="col-span-1 sm:col-span-6">
                    <InputLabel 
                        for="department" 
                        :value="trnsl('content.department')"
                    ></InputLabel>
                    <SelectInputDb 
                        :key="sector"
                        id="department"
                        v-model="form.department_id"
                        routeGet="/getDepartments/"
                        :filterId="sector"
                        :withAdd="false"
                    ></SelectInputDb>
                    <InputError 
                        :message="form.errors.department_id"
                    ></InputError>
                </div>

                <div class="col-span-1 sm:col-span-6">
                    <InputLabel 
                        for="function" 
                        :value="trnsl('content.function')"
                    ></InputLabel>
                    <SelectInput 
                        id="function"
                        :options="functions"
                        v-model="funct1on"
                    ></SelectInput>
                </div>

                <div class="col-span-1 sm:col-span-6">
                    <InputLabel 
                        for="position" 
                        :value="trnsl('content.position')"
                    ></InputLabel>
                    <SelectInputDb 
                        :key="funct1on"
                        id="position"
                        v-model="form.position_id"
                        routeGet="/getPositions/"
                        :filterId="funct1on"
                        :withAdd="false"
                    ></SelectInputDb>
                    <InputError 
                        :message="form.errors.position_id"
                    ></InputError>
                </div>

            </div>

            <!-- <div class="p-2 flex justify-end">
                <PrimaryButton
                    :disabled="form.processing"
                    @click="showSearch=true"
                    icon="fa fa-search"
                >
                    {{ $trnsl('content.search') }}
                </PrimaryButton>
                <PrimaryButton
                    class="ml-3"
                    :disabled="form.processing"
                    @click="save"
                    icon="fa fa-save"
                >
                    {{ $trnsl('content.save') }}
                </PrimaryButton>
                <SecondaryButton
                    class="ml-3"
                    :disabled="form.processing"
                    icon="fa-solid fa-circle-xmark"
                    @click="cancel"
                >
                    {{ $trnsl('content.cancel') }}
                </SecondaryButton>
            </div> -->

            
         
        </template>

    </Window>
</template>

<script setup>
    import ToolBar from '@/Components/ToolBar.vue'
    import Window from '@/Components/Window.vue'
    import InputError from '@/Components/InputError.vue'
    import InputLabel from '@/Components/InputLabel.vue'
    import TextInput from '@/Components/TextInput.vue'
    import FileInput from '@/Components/FileInput.vue'
    import SelectInput from '@/Components/SelectInput.vue'
    import SelectInputDb from '@/Components/SelectInputDb.vue'
    
    
    import { successMessage, errorMessage, dialogBox, getError } from '@/Helpers/helper'
    import { useForm } from '@inertiajs/vue3'
    import { trnsl } from '@/Lang/languages'
    import { ref } from 'vue'
    import axios from 'axios'

    const props = defineProps({
        stakeholders: Array,
        sectors: Array,
        functions: Array,
        people: Array,
    })

    const emit = defineEmits([
        'event'   
    ])

    const form = useForm({
        'id': '',
        'uid': '',
        'fullName': '',
        'firstName': '',
        'lastName': '',
        'gender_id': '',
        'birthDate': '',
        'jobTitle': '',
        'email': '',
        'photo': '',
        'signature': '',
        'stakeholder_id': '',
        'admissionDate': '',
        'hiredSince': '',
        'position_id': '',
        'department_id': '',
        'cardNo':'',
        'isActive': '',
        'isLocked': '',
    });

    const sector = ref(1)
    const funct1on = ref(1)
    const showSearch = ref(false)
    

    let event = {
        source: '',
        action: '',
        status: 0,
        data: null,
    }

    const icons = [
        
        {name: 'save', text: trnsl('content.save'), icon: 'fa fa-floppy-disk', hidden: false},
    ]

    const genders = [
        {id: 1, name: trnsl('content.male') },
        {id: 2, name: trnsl('content.female') },
    ]

    const fullName = () => {
        form.fullName = form.lastName + ' ' + form.firstName
    }

    

    const save = () => {
        form.post(route('people.people.store'), {
            onSuccess: ( data ) => { 
                successMessage(trnsl('messages.recordSaved'))
                event.source = 'new'
                event.action = 'save'
                event.status = 1
                event.data = data
                emit('event', event)
            },
            onError: (errors) => {
                errorMessage(trnsl('messages.recordNoSaved') + '\n\r '+ getError(errors))
                console.log(errors)
            }
        })
    }

    const cancel = () => {
        const dialog = dialogBox( '', trnsl('messages.confirmExitWithoutSave'))
        dialog.fire().then((result) =>{
            if(result.isConfirmed){
                event.source = 'new'
                event.action = 'cancel'
                event.status = 0
                event.data = null
                emit('event', event)
            }
        })
    }

    const clickIconToolBar = (button) => {
        if (button === 'search') {
            showSearch.value = true
        } else if (button == 'save') {
                    save()
                } 
    }

    

</script>