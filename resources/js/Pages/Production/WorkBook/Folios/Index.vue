<template>

    <AuthenticatedLayout>

        <Head :title="$trnsl('content.folios')"></Head>

        <template #header>
            {{ $trnsl('content.folios') }}
        </template>

        <template #subheader>
            {{ $trnsl('content.production') }}
        </template>

        <template #content>

            <div class="my-2">
                <ToolBar
                    :icons="icons"
                    @click="clickIconToolBar"
                />
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-8 gap-2 p-2 mb-2 bg-white rounded-lg shadow-md">
               
                <div class="col-span-1 sm:col-span-1" >
                    <InputLabel 
                        for="fromDate" 
                        :value="trnsl('content.from')"
                    ></InputLabel>
                    <TextInput 
                        id="fromDate" 
                        v-model="formFilter.fromDate"
                        type="date"
                    ></TextInput>
                    
                </div>
                <div class="col-span-1 sm:col-span-1">
                    <InputLabel 
                        for="untilDate" 
                        :value="trnsl('content.until')"
                    ></InputLabel>
                    <TextInput 
                        id="untilDate" 
                        v-model="formFilter.untilDate"
                        type="date"
                    ></TextInput>
                   
                </div>
                <div class="col-span-1 sm:col-span-5">
                    <InputLabel 
                        for="location" 
                        :value="trnsl('content.location')"
                        
                    ></InputLabel>
                    <SelectInput 
                        id="location"
                        :options="locations"
                        v-model="formFilter.location_id"
                    ></SelectInput>
                </div>
                <div class="col-span-1 sm:cols-span-1 text-center">
                    <button
                        class="w-full mt-4 py-1 text-xs text-white bg-green-500 rounded-lg"
                        :disabled="formFilter.processing"
                        @click="search"
                    >
                        {{  $trnsl('content.search') }}
                    </button>
                </div>
            </div>

            <DataTable
                :key="reload"
                :headers="headers"
                :actions="actions"
                :dataset="results"
                :title="trnsl('content.folios')"
                fieldSearch="name"
                @action="getAction"
            />

            <Modal
                :showModal="modal"
                @closeModal="closeModal"
                :title="trnsl('content.new')+' '+$trnsl('content.folio')"
            >
               

                <div class="grid grid-cols-1 sm:grid-cols-5 gap-2 px-3 py-3">
                    <div class="col-span-1 sm:col-span-1" >
                        <InputLabel 
                            for="date" 
                            :value="trnsl('content.date')"
                        ></InputLabel>
                        <TextInput 
                            id="date" 
                            v-model="formFolio.date"
                            type="date"
                        ></TextInput>
                        <InputError 
                            :message="formFolio.errors.date"
                        ></InputError>
                    </div>

                    <div class="col-span-1 sm:col-span-4">
                        <InputLabel 
                            for="location" 
                            :value="trnsl('content.location')"
                            
                        ></InputLabel>
                        <SelectInput 
                            id="location"
                            :options="locations"
                            v-model="formFolio.location_id"
                            @change="setFolioNumber"
                        ></SelectInput>
                        <InputError 
                            :message="formFolio.errors.location"
                        ></InputError>
                    </div>
                </div>

                <div class="p-3 mt-2 flex justify-end bg-gray-100">
                    <PrimaryButton
                        :disabled="formFolio.processing"
                        @click="storeFolio"
                    >
                        <i class="fa fa-save"></i>
                        {{  $trnsl('content.save') }}
                    </PrimaryButton>
                    <SecondaryButton
                        class="ml-3"
                        :disabled="formFolio.processing"
                        @click="closeModal"
                    >
                        {{  $trnsl('content.cancel') }}
                    </SecondaryButton>
                </div>
            </Modal>
        </template>
        
        
        
    </AuthenticatedLayout>

</template>

<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
    import DataTable from '@/Components/DataTable.vue'
    import Modal from '@/Components/Modal.vue'
    import InputError from '@/Components/InputError.vue'
    import InputLabel from '@/Components/InputLabel.vue'
    import TextInput from '@/Components/TextInput.vue'
    import SelectInput from '@/Components/SelectInput.vue'
    import PrimaryButton from '@/Components/PrimaryButton.vue'
    import SecondaryButton from '@/Components/SecondaryButton.vue'
    import ToolBar from '@/Components/ToolBar.vue'
    import { trnsl } from '@/Lang/languages';
    import { successMessage, errorMessage, dialogBox, getError } from '@/Helpers/helper'
    import { useForm, Head, usePage, router } from '@inertiajs/vue3';
    import { ref, reactive, onMounted } from 'vue';
    import axios from 'axios';
    import dayjs from 'dayjs';

    const props = defineProps({
        locations: Array,
        projectUserId: Number,
        errors: Object,
    });

    const page = usePage();

    const formFilter = {
        'fromDate': dayjs(undefined).format('YYYY-MM-DD'),
        'untilDate': dayjs(undefined).format('YYYY-MM-DD'),
        'location_id': '',
    }

    const formFolio = useForm({
        'date': '',
        'location_id': '',
        'project_user_id': '',
        'number':'',
    });

    

    const reload = ref(0)
    const results = reactive([])
    const modal = ref(false)

    const headers = [
                    {name: 'date', text: trnsl('content.date'), type: 'date', align: 'left'},
                    {name: 'location.name', text: trnsl('content.location'), type: 'text', align: 'left'},
                    {name: 'number', text: trnsl('content.number'), type: 'text', align: 'left'},
                ];

    const actions = [
                    {name: 'dailyReports', type: 'badge', text: trnsl('content.dailyReports'), color: 'primary'},
                    {name: 'notes', type: 'badge', text: trnsl('content.notes'),  color: 'primary' },
                    {name: 'print', type: 'badge', text: trnsl('content.print'),  color: 'primary' },
                ];

    const icons = [
                    {name: 'home', text: trnsl('content.home'), icon: 'fa-solid fa-home'},
                    {name: 'back', text: trnsl('content.back'), icon: 'fa-solid fa-arrow-left'},       
                    {name: 'new', text: trnsl('content.new'), icon: 'fa fa-plus'},
                ];

    const home = () => {
        router.visit(route('dashboard'))
    } 

    const back = () => {
        router.visit(route('production.workbook.home'))
    } 

    const openModal = ( row ) => {
        modal.value = true;
    }

    const closeModal = () => {
        modal.value = false;
        reload.value += 1;
        formFolio.clearErrors()
    }

    const search = () => {
        let location_id = formFilter.location_id
        let from = formFilter.fromDate
        let until = formFilter.untilDate
        axios.get('/api/getFoliosXLocation/' + location_id + '/' + from + '/' + until)
            .then(response=>{
                response.data.forEach( (row, i) => {
                    results[i] = row
                })
                reload.value += 1;
            })
            .catch(error=>{
                console.log(error)
            })
    }
    
    const getAction = ( action ) => {
        if (action.name==='dailyReports') {
            router.get(route('production.workbook.dailyReports.index',action.data.id))
        } else if (action.name==='notes') {
                    router.get(route('production.workbook.notes.index',action.data.id))
                }
    }
    
    const clickIconToolBar = (button) => {
        if (button === 'new') {
            formFolio.project_user_id = props.projectUserId
            openModal()
        } else if (button == 'back') {
            back()
        } else if (button == 'home') {
            home()
        }
    }

    const setFolioNumber = () => {
        axios.get('/api/getFolioNumber/'+formFolio.location_id)
            .then(response=>{
                formFolio.number = response.data.sequence
            })
            .catch(error=>{
                console.log(error)
            })
    }

    

    const storeFolio = () => {
        formFolio.post(route('production.workbook.folios.store'),{
            onSuccess: () => { 
                successMessage(trnsl('messages.recordSaved'))
                closeModal()
                search()
            },
            onError: (errors) => {
                errorMessage(trnsl('messages.recordNoSaved') + '\n\r '+ getError(errors))
                console.log(errors)
            }
        })
    }

    onMounted(() => {

    })

    
</script>