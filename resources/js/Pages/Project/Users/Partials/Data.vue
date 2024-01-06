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
                for="isActive" 
                :value="trnsl('content.active')"
            ></InputLabel>
            <Switch
                v-model:status="form.isActive"
                :value="form.isActive"
            />
        </div>

        <div class="col-span-1 sm:col-span-12">
            <InputLabel 
                for="project" 
                :value="trnsl('content.project')"
            ></InputLabel>
            <SelectInput 
                id="project"
                :options="projects"
                v-model="form.project_id"
                :disabled="true"
            ></SelectInput>
            <InputError 
                :message="form.errors.project_id"
            ></InputError>
        </div>

        <div class="col-span-1 sm:col-span-12">
            <InputLabel 
                for="user" 
                :value="trnsl('content.person')"
            ></InputLabel>
            <SelectInput 
                id="user"
                :options="users"
                v-model="form.user_id"
                :disabled="true"
            ></SelectInput>
            <InputError 
                :message="form.errors.user_id"
            ></InputError>
        </div>

        <div class="col-span-1 sm:col-span-12">
            <InputLabel 
                for="role" 
                :value="trnsl('content.role')"
            ></InputLabel>
            <SelectInput 
                id="role"
                :options="roles"
                v-model="form.role_id"
            ></SelectInput>
            <InputError 
                :message="form.errors.role_id"
            ></InputError>
        </div>

        <div class="col-span-1 sm:col-span-5" >
            <InputLabel 
                for="user" 
                :value="trnsl('content.user')"
            ></InputLabel>
            <TextInput 
                id="user" 
                v-model="form.user"
                type="text"
            ></TextInput>
            <InputError 
                :message="form.errors.user"
            ></InputError>
        </div>

        <div class="col-span-1 sm:col-span-5" >
            <InputLabel 
                for="email" 
                :value="trnsl('content.email')"
            ></InputLabel>
            <TextInput 
                id="email" 
                v-model="form.email"
                type="email"
            ></TextInput>
            <InputError 
                :message="form.errors.email"
            ></InputError>
        </div>
    </div>

</template>
<script setup>
    import ToolBar from '@/Components/ToolBar.vue'
    import InputError from '@/Components/InputError.vue'
    import InputLabel from '@/Components/InputLabel.vue'
    import TextInput from '@/Components/TextInput.vue'
    import SelectInput from '@/Components/SelectInput.vue'
    import Checkbox from '@/Components/Checkbox.vue'
    import Switch from '@/Components/Switch.vue'
    import PrimaryButton from '@/Components/PrimaryButton.vue' 
    import SecondaryButton from '@/Components/SecondaryButton.vue'
    import { successMessage, errorMessage, dialogBox, getError } from '@/Helpers/helper'
    import { trnsl } from '@/Lang/languages'
    import { ref, onMounted } from 'vue';

    const props = defineProps({
        form: Object,
        projects: Array,
        users: Array,
        roles: Array,
    })

    const emit = defineEmits([
        'event'   
    ])

    const event = {
        source: '',
        action: '',
        status: 0,
        data: null,
    }

    const icons = [
        {name: 'save', text: trnsl('content.save'), icon: 'fa fa-floppy-disk', hidden: false},
    ]

    const update = () => {
        props.form.patch(route('project.projectusers.update', props.form.id), {
            onSuccess: () => { 
                successMessage(trnsl('messages.recordUpdated'))
                event.source = 'data'
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

    const clickIconToolBar = (button) => {
        if (button === 'save') {
            update()
        } 
    }
</script>