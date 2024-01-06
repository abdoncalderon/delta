<template>
    <div class="m-2">
        <ToolBar
            :icons="icons"
            @click="clickIconToolBar"
        />
    </div>

    <div class="mx-1 mb-2 px-1 py-1 grid grid-cols-1 sm:grid-cols-4 gap-2">

        <div class="col-span-1 sm:col-span-1" >
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

        <div class="col-span-1 sm:col-span-1" >
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

        <div class="col-span-1 sm:col-span-2" >
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

        <div class="col-span-1 sm:col-span-1" >
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

        <div class="col-span-1 sm:col-span-1">
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

        <div class="col-span-1 sm:col-span-1" >
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
    
        <div class="col-span-1 sm:col-span-2" >
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

        <div class="col-span-1 sm:col-span-2" >
            <InputLabel 
                for="email" 
                :value="trnsl('content.email')"
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

        <div class="col-span-1 sm:col-span-2" >
            <InputLabel 
                for="photo"
                :value="trnsl('content.photoFile')"
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

        <div class="col-span-1 sm:col-span-2" >
            <InputLabel 
                for="signature"
                :value="trnsl('content.signatureFile')"
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

        <div class="col-span-1 sm:col-span-2">
            <InputLabel 
                for="photo"
                :value="trnsl('content.photo')"
            ></InputLabel>
            <div class="flex justify-center bg-white rounded-md">
                <img class="m-2 h-48" :src="pathPhoto" alt="">
            </div>
        </div>

        <div class="col-span-1 sm:col-span-2">
            <InputLabel 
                for="signature"
                :value="trnsl('content.signature')"
            ></InputLabel>
            <div class="flex justify-center bg-white rounded-md">
                <img class="m-2 h-48" :src="pathSignature" alt="">
            </div>
        </div>

    </div>
    
</template>

<script setup>
    import ToolBar from '@/Components/ToolBar.vue'
    import InputError from '@/Components/InputError.vue'
    import InputLabel from '@/Components/InputLabel.vue'
    import TextInput from '@/Components/TextInput.vue'
    import FileInput from '@/Components/FileInput.vue'
    import SelectInput from '@/Components/SelectInput.vue'
    import { successMessage, errorMessage, dialogBox, getError } from '@/Helpers/helper'
    import { trnsl } from '@/Lang/languages'
    import { ref, onMounted } from 'vue';

    const props = defineProps({
        form: Object,
    })

    const emit = defineEmits([
        'event'   
    ])

    const pathPhoto = ref('')
    const pathSignature = ref('')

    const event = {
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
        props.form.fullName = props.form.lastName + ' ' + props.form.firstName
    }

    const update = () => {
        props.form.post(route('people.people.update', props.form.id), {
            onSuccess: () => { 
                successMessage(trnsl('messages.recordUpdated'))
                event.source = 'edit'
                event.action = 'update'
                event.status = 1
                emit('event', event)
            },
            onError: (errors) => {
                errorMessage(trnsl('messages.recordNoUpdated') + '\n\r '+ getError(errors))
                console.log(errors)
            }
        })
    }

    const cancel = () => {
        const dialog = dialogBox( '', trnsl('messages.confirmExitWithoutSave'))
        dialog.fire().then((result) =>{
            if(result.isConfirmed){
                event.source = 'edit'
                event.action = 'cancel'
                event.status = 0
                event.data = null
                emit('event', event)
            }
        })
    }

    const clickIconToolBar = (button) => {
        if (button === 'cancel') {
            cancel()
        } else if (button == 'save') {
                    update()
                } 
    }

    onMounted(()=>{
        pathPhoto.value = 'http://delta.test/storage/kapatax/images/people/photos/' + props.form.photo
        pathSignature.value = 'http://delta.test/storage/kapatax/images/people/signatures/' + props.form.signature
    })

</script>