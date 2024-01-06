<template>
    <div class="border border-gray-500 bg-gray-200 rounded-lg overflow-auto">

        <h3 class="px-3 py-2 text-sm text-white bg-gray-700">
            {{ $trnsl('messages.assignUserToProject') }}
        </h3>

        <div class="m-1 px-1 py-1 grid grid-cols-1 sm:grid-cols-12 gap-2">

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
                <SelectDynamic 
                    :options="users"
                    v-model="form.user_id"
                    show="name"
                    :disabled="false"
                ></SelectDynamic>
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
        </div>

        <div class="p-2 flex justify-end">
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
        </div>
    </div>

</template>
<script setup>
    import InputError from '@/Components/InputError.vue'
    import InputLabel from '@/Components/InputLabel.vue'
    import SelectInput from '@/Components/SelectInput.vue'
    import SelectDynamic from '@/Components/SelectDynamic.vue'
    import PrimaryButton from '@/Components/PrimaryButton.vue' 
    import SecondaryButton from '@/Components/SecondaryButton.vue'
    import { useForm, usePage } from '@inertiajs/vue3';
    import { trnsl } from '@/Lang/languages';
    import { successMessage, errorMessage, dialogBox } from '@/Helpers/helper'
    import { onMounted } from 'vue';

    const props = defineProps({
        projects: Array,
        users: Array,
        roles: Array,
    })

    const form = useForm({
        'id': '',
        'user_id': '',
        'project_id': '',
        'role_id': '',
    });

    const page = usePage();

    const emit = defineEmits([
        'event'   
    ])

    const event = {
        source: '',
        action: '',
        status: 0,
        data: null,
    }

    const save = () => {
        form.post(route('project.projectUsers.store'), {
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

    onMounted(()=>{
        form.project_id = page.props.auth.currentProject.id
    })

</script>