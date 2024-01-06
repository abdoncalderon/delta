<template>
    <AuthenticatedLayout>

        <Head :title="$trnsl('content.project')"></Head>      

        <template #header>
            {{ $trnsl('content.project') }}
        </template>

        <template #subheader>
            {{ $trnsl('content.project') }}
        </template>

        <template #content>

            <div class="my-2">
                <ToolBar
                    :icons="icons"
                    @click="clickIconToolBar"
                />
            </div>

            <Window
                :title="trnsl('messages.projectData')"
                @close="cancel"
            >
                <template #body>

                    <div class="m-1 grid grid-cols-4 sm:grid-cols-12 gap-2 px-1 py-1">

                        <div class="col-span-4 sm:col-span-12">
                            <InputLabel 
                                for="subsidiary" 
                                :value="trnsl('content.subsidiary')"
                                
                            ></InputLabel>
                            <TextInput 
                                id="subsidiary"
                                v-model="project.subsidiary.name"
                                type="text"
                                
                                :disabled="true"
                            ></TextInput>
                        </div>

                        <div class="col-span-4 sm:col-span-8">
                            <InputLabel 
                                for="name" 
                                :value="trnsl('content.name')"
                                
                            ></InputLabel>
                            <TextInput 
                                id="name"
                                v-model="form.name"
                                type="text"
                                
                                :disabled="true"
                            ></TextInput>
                            <InputError 
                                :message="form.errors.name"
                            ></InputError>
                        </div>

                        <div class="col-span-4 sm:col-span-2">
                            <InputLabel 
                                for="code" 
                                :value="trnsl('content.code')"
                                
                            ></InputLabel>
                            <TextInput 
                                id="code"
                                v-model="form.code"
                                type="text"
                                
                                :disabled="true"
                            ></TextInput>
                            <InputError 
                                :message="form.errors.code"
                            ></InputError>
                        </div>

                        <div class="col-span-4 sm:col-span-2">
                            <InputLabel 
                                for="taxId" 
                                :value="trnsl('content.taxId')"
                                
                            ></InputLabel>
                            <TextInput 
                                id="taxId"
                                v-model="form.taxId"
                                type="text"
                                
                                :disabled="false"
                            ></TextInput>
                            <InputError 
                                :message="form.errors.taxId"
                            ></InputError>
                        </div>

                        <div class="col-span-4 sm:col-span-3">
                            <InputLabel 
                                for="region" 
                                :value="trnsl('content.region')"
                                
                            ></InputLabel>
                            <SelectInput 
                                id="region"
                                :options="regions"
                                v-model="region"
                            ></SelectInput>
                        </div>

                        <div class="col-span-4 sm:col-span-3">
                            <InputLabel 
                                for="country" 
                                :value="trnsl('content.country')"
                                
                            ></InputLabel>
                            <SelectInputDb 
                                :key="region"
                                id="country"
                                v-model="country"
                                routeGet="/getCountries/"
                                :filterId="region"
                                :withAdd="false"
                            ></SelectInputDb>
                        </div>

                        <div class="col-span-4 sm:col-span-3">
                            <InputLabel 
                                for="state" 
                                :value="trnsl('content.state')"
                            ></InputLabel>
                            <SelectInputDb 
                                :key="country"
                                id="state"
                                v-model="state"
                                routeGet="/getStates/"
                                :filterId="country"
                                :withAdd="false"
                                @change="setState"
                            ></SelectInputDb>
                        </div>

                        <div class="col-span-4 sm:col-span-3">
                            <InputLabel 
                                for="city" 
                                :value="trnsl('content.city')"
                            ></InputLabel>
                            
                            <SelectInputDb 
                                :key="state"
                                id="city"
                                v-model="form.city_id"
                                :formAdd="formCity"
                                :fieldsAdd="fieldsCity"
                                routeAdd="settings.cities.store"
                                routeGet="/getCities/"
                                :filterId="state"
                                :withAdd="true"
                            ></SelectInputDb>

                            <InputError 
                                :message="form.errors.city_id"
                            ></InputError>
                        </div>

                        <div class="col-span-4 sm:col-span-12">
                            <InputLabel 
                                for="address" 
                                :value="trnsl('content.address')"
                            ></InputLabel>
                            <TextInput 
                                id="address"
                                v-model="form.address"
                                type="text"
                                
                                :disabled="false"
                            ></TextInput>
                            <InputError 
                                :message="form.errors.address"
                            ></InputError>
                        </div>

                        <div class="col-span-4 sm:col-span-3">
                            <InputLabel 
                                for="zipCode" 
                                :value="trnsl('content.zipCode')"
                            ></InputLabel>
                            <TextInput 
                                id="zipCode"
                                v-model="form.zipCode"
                                type="text"
                                :disabled="false"
                            ></TextInput>
                            <InputError 
                                :message="form.errors.zipCode"
                            ></InputError>
                        </div>

                        <div class="col-span-4 sm:col-span-3">
                            <InputLabel 
                                for="phoneNumber" 
                                :value="trnsl('content.phoneNumber')"
                            ></InputLabel>
                            <TextInput 
                                id="phoneNumber"
                                v-model="form.phoneNumber"
                                type="text"
                                :disabled="false"
                            ></TextInput>
                            <InputError 
                                :message="form.errors.phoneNumber"
                            ></InputError>
                        </div>

                        <div class="col-span-4 sm:col-span-3" >
                            <InputLabel 
                                for="startDate" 
                                :value="trnsl('content.startDate')"
                            ></InputLabel>
                            <TextInput 
                                id="startDate" 
                                v-model="form.startDate"
                                type="date"
                            ></TextInput>
                            <InputError 
                                :message="form.errors.startDate"
                            ></InputError>
                        </div>

                        <div class="col-span-4 sm:col-span-3" >
                            <InputLabel 
                                for="finishDate" 
                                :value="trnsl('content.finishDate')"
                            ></InputLabel>
                            <TextInput 
                                id="finishDate" 
                                v-model="form.finishDate"
                                type="date"
                            ></TextInput>
                            <InputError 
                                :message="form.errors.startDate"
                            ></InputError>
                        </div>

                        <div class="col-span-4 sm:col-span-3">
                            <InputLabel 
                                for="stakeholder1" 
                                :value="trnsl('messages.stakeholderLogo')+' 1'"
                            ></InputLabel>
                            <SelectInput 
                                id="stakeholder1"
                                :options="stakeholders"
                                v-model="form.stakeholder1_id"
                            ></SelectInput>
                            <InputError 
                                :message="form.errors.stakeholder1_id"
                            ></InputError>
                        </div>

                        <div class="col-span-4 sm:col-span-3">
                            <InputLabel 
                                for="stakeholder2" 
                                :value="trnsl('messages.stakeholderLogo')+' 2'"
                            ></InputLabel>
                            <SelectInput 
                                id="stakeholder2"
                                :options="stakeholders"
                                v-model="form.stakeholder2_id"
                            ></SelectInput>
                            <InputError 
                                :message="form.errors.stakeholder2_id"
                            ></InputError>
                        </div>

                        <div class="col-span-4 sm:col-span-3">
                            <InputLabel 
                                for="stakeholder3" 
                                :value="trnsl('messages.stakeholderLogo')+' 3'"
                            ></InputLabel>
                            <SelectInput 
                                id="stakeholder3"
                                :options="stakeholders"
                                v-model="form.stakeholder3_id"
                            ></SelectInput>
                            <InputError 
                                :message="form.errors.stakeholder3_id"
                            ></InputError>
                        </div>

                        <div class="col-span-4 sm:col-span-3">
                            <InputLabel 
                                for="stakeholder4" 
                                :value="trnsl('messages.stakeholderLogo')+' 4'"
                            ></InputLabel>
                            <SelectInput 
                                id="stakeholder4"
                                :options="stakeholders"
                                v-model="form.stakeholder4_id"
                            ></SelectInput>
                            <InputError 
                                :message="form.errors.stakeholder4_id"
                            ></InputError>
                        </div>

                    </div>

                </template>

            </Window>

        </template>
        
    </AuthenticatedLayout>
    
</template>

<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
    import Window from '@/Components/Window.vue'
    import ToolBar from '@/Components/ToolBar.vue'
    import PrimaryButton from '@/Components/PrimaryButton.vue' 
    import SecondaryButton from '@/Components/SecondaryButton.vue'
    import InputError from '@/Components/InputError.vue'
    import InputLabel from '@/Components/InputLabel.vue'
    import TextInput from '@/Components/TextInput.vue'
    import SelectInput from '@/Components/SelectInput.vue'
    import SelectInputDb from '@/Components/SelectInputDb.vue'
    import SelectDynamic from '@/Components/SelectDynamic.vue'
    import TextArea from '@/Components/TextArea.vue'
    import { useForm, Head, usePage, router } from '@inertiajs/vue3'
    import { trnsl } from '@/Lang/languages'
    import { ref, onMounted } from 'vue';
    import { successMessage, errorMessage, dialogBox } from '@/Helpers/helper'

    const props = defineProps({
        project: Object,
        regions: Array,
        stakeholders: Array,
    })

    const formCity = useForm({
        'id': '',
        'name': '',
        'state_id': '',
    });

    const region = ref(0)
    const country = ref(0)
    const state = ref(0)

    const form = useForm({
        'id':'',
        'subsidiary_id': '',
        'name': '',
        'code': '',
        'taxId': '',
        'city_id': '',
        'address': '',
        'zipCode': '',
        'phoneNumber': '',
        'startDate': '',
        'finishDate': '', 
        'stakeholder1_id': '',
        'stakeholder2_id': '',
        'stakeholder3_id': '',
        'stakeholder4_id': '',
    });

    const page = usePage()
    
    const fieldsCity = [
        {name: 'name', type: 'text', text: trnsl('content.name'), style: 'sm:col-span-4', length: 255, disabled: false },
    ];

    const icons = [
        {name: 'home', text: trnsl('content.home'), icon: 'fa fa-home'},
        {name: 'save', text: trnsl('content.save'), icon: 'fa fa-save'},
    ];

    const home = () => {
        router.visit(route('dashboard'))
    } 

    const save = () => {
        let id = form.id
        form.patch(route('project.project.update', id ), {
            onSuccess: () => { 
                successMessage(trnsl('messages.recordSaved'))
                
            },
            onError: (errors) => {
                successMessage(trnsl('messages.recordNoSaved'))
                console.log(errors)
            }
        })
    }

    const cancel = () => {
        home()
    }

    const clickIconToolBar = (button) => {
        if (button == 'home') {
            home()
        } else if(button == 'save') {
            save()
        }
    }

    const setState = ( value ) => {
        formCity.state_id = value
    }

    const getProject = () => {
        region.value = props.project.region_id
        country.value = props.project.country_id
        state.value = props.project.state_id
        form.id = props.project.id
        form.subsidiary_id = props.project.subsidiary_id
        form.name = props.project.name
        form.code = props.project.code
        form.taxId = props.project.taxId
        form.city_id = props.project.city_id
        form.address = props.project.address
        form.zipCode = props.project.zipCode
        form.phoneNumber = props.project.phoneNumber
        form.startDate = props.project.startDate
        form.finishDate = props.project.finishDate
        form.stakeholder1_id = props.project.stakeholder1_id
        form.stakeholder2_id = props.project.stakeholder2_id
        form.stakeholder3_id = props.project.stakeholder3_id
        form.stakeholder4_id = props.project.stakeholder4_id
    }

    onMounted(() => {
        getProject()
    }) 

    

</script>