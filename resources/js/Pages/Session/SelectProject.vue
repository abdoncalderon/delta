<template>

    <div class="flex h-screen bg-gray-200 items-center justify-center font-roboto">

        <!-- <div class="w-10/12 sm:w-4/12 md:2/12"> -->
        <div class="w-11/12 md:w-80">
            <div class="bg-white rounded-lg mt-5 w-full overflow-hidden">

                <!-- Logo -->
                <img class="" src="http://delta.test/storage/kapatax/logo.jpg" alt="">

                <!-- Form -->
                <div class="py-3">

                    <!-- Select Project -->
                    <div class="px-5 py-2">
                        <InputLabel 
                            for="user" 
                            :value="$trnsl('content.user')+':'"
                            class="ml-1 font-bold text-xs"
                        ></InputLabel>
                        <TextInput
                            id="location" 
                            v-model="$page.props.auth.currentPerson.fullName"
                            type="text"
                            
                            disabled="true"
                        ></TextInput>
                    </div>

                    <div class="px-5 py-2">
                        <InputLabel 
                            for="projectUser" 
                            :value="$trnsl('content.project')+':'"
                            class="ml-1 font-bold text-xs"
                        ></InputLabel>
                        <SelectInput 
                            id="projectUser" 
                            :options="$page.props.auth.projectsUser"
                            v-model="form.project_id"
                            class="text-xs mt-1 block w-3/4"
                        ></SelectInput>
                        <InputError 
                            :message="form.errors.projectUser"
                        ></InputError>
                    </div>

                </div>

                

                <!-- Buttons -->

                <div class="my-3 flex justify-center">
                    <button
                        class="w-24 mx-2 p-1 bg-gray-700 text-white rounded-lg"
                        @click="submit"
                        :disabled="form.processing"
                    >
                        {{  $trnsl('content.accept') }}
                    </button>
                    <button
                        class="w-24 mx-2 p-2 bg-red-700 text-white rounded-lg"
                        @click="logout"
                        :disabled="form.processing"
                    >
                        {{  $trnsl('content.exit') }}
                    </button>
                </div>
                
            </div>
            
        </div>
        
    </div>

</template>

<script setup>
    import InputLabel from '@/Components/InputLabel.vue';
    import TextInput from '@/Components/TextInput.vue'
    import SelectInput from '@/Components/SelectInput.vue';
    import InputError from '@/Components/InputError.vue';
    import { useForm, router } from '@inertiajs/vue3';

    const form = useForm({
        project_id: '',
    })

    const logout = () => {
        router.post(route('logout'))
    }

    const submit = () => {
        form.post(route('setCurrentProject'), {
            onSuccess: () => { 
            },
            onError: (errors) => {
                console.log(errors)
            }
        })
    }

   

</script>