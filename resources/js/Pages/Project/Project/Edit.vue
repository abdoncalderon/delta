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
            <ToolBar
                :buttons="buttons"
                @click="clickIconToolBar"
            />
            <div class="w-full  bg-white overflow-hidden rounded-lg shadow">
                <div class="bg-neutral-700 p-2">
                    <h3 class="text-white text-sm text-center">{{ trnsl('messages.projectData')}}</h3>
                </div>
                <Form
                    :fields="fields"
                    :form="form"
                    :table="trnsl('content.project')"
                    routePath="project.project.update"
                    operation="update"
                    @submit="confirmTransaction"
                />
            </div>
        </template>

        
        
    </AuthenticatedLayout>
</template>

<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
    import Form from '@/Components/Form.vue'
    import ToolBar from '@/Components/ToolBar.vue'
    import axios from 'axios'
    import { useForm, Head, usePage, router } from '@inertiajs/vue3'
    import { trnsl } from '@/Lang/languages'
    import { onMounted } from 'vue';
    import { successMessage, errorMessage } from '@/Helpers/helper'

    const props = defineProps({
        subsidiaries: Array,
        cities: Array,
        stakeholders: Array,
    })

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
    
    const fields = [
                    {name: 'id', type: 'hidden'},
                    {name: 'subsidiary_id', type: 'select', text: trnsl('content.subsidiary'), style: 'sm:col-span-4',  items:[], disabled: true},
                    {name: 'name', type: 'text', text: trnsl('content.name'), style: 'sm:col-span-4', lenght: 255, disabled: false },
                    {name: 'code', type: 'text', text: trnsl('content.code'), style: 'sm:col-span-1', lenght: 255, disabled: false },
                    {name: 'taxId', type: 'text', text: trnsl('content.taxId'), style: 'sm:col-span-1', lenght: 255, disabled: false },
                    {name: 'city_id', type: 'select', text: trnsl('content.city'), style: 'sm:col-span-1', items:[], disabled: false },
                    {name: 'address', type: 'text', text: trnsl('content.address'), style: 'sm:col-span-4', lenght: 255, disabled: false },
                    {name: 'zipCode', type: 'text', text: trnsl('content.zipCode'), style: 'sm:col-span-1', lenght: 255, disabled: false },
                    {name: 'phoneNumber', type: 'text', text: trnsl('content.phoneNumber'), style: 'sm:col-span-1', lenght: 255, disabled: false },
                    {name: 'startDate', type: 'date', text: trnsl('content.startDate'), style: 'sm:col-span-1', lenght: 255, disabled: false },
                    {name: 'finishDate', type: 'date', text: trnsl('content.finishDate'), style: 'sm:col-span-1', lenght: 255, disabled: false }, 
                    {name: 'stakeholder1_id', type: 'select', text: trnsl('messages.stakeholderLogo')+' 1', style: 'sm:col-span-1', items:[], disabled: false }, 
                    {name: 'stakeholder2_id', type: 'select', text: trnsl('messages.stakeholderLogo')+' 2', style: 'sm:col-span-1', items:[], disabled: false }, 
                    {name: 'stakeholder3_id', type: 'select', text: trnsl('messages.stakeholderLogo')+' 3', style: 'sm:col-span-1', items:[], disabled: false }, 
                    {name: 'stakeholder4_id', type: 'select', text: trnsl('messages.stakeholderLogo')+' 4', style: 'sm:col-span-1', items:[], disabled: false },  
                ];

    const buttons = [
                    {name: 'exit', text: trnsl('content.exit'), icon: 'fa-solid fa-arrow-up-right-from-square'}
                ];

    const home = () => {
        router.visit(route('dashboard'))
    } 

    const getProject = () => {
        let id = page.props.auth.currentProject[0].id
        axios.get('/api/project/'+id)
            .then(response=>{
                form.id = response.data.id
                form.subsidiary_id = response.data.subsidiary_id
                form.name = response.data.name
                form.code = response.data.code
                form.taxId = response.data.taxId
                form.city_id = response.data.city_id
                form.address = response.data.address
                form.zipCode = response.data.zipCode
                form.phoneNumber = response.data.phoneNumber
                form.startDate = response.data.startDate
                form.finishDate = response.data.finishDate
                form.stakeholder1_id = response.data.stakeholder1_id
                form.stakeholder2_id = response.data.stakeholder2_id
                form.stakeholder3_id = response.data.stakeholder3_id
                form.stakeholder4_id = response.data.stakeholder4_id
            })
            .catch(error=>{
                console.log(error)
            })
    }

    const confirmTransaction = ( params ) => {
        if ((params[1]==='update')) {
            if (params[0]==1){
                successMessage(trnsl('messages.recordUpdated')) 
            } else {
                errorMessage(trnsl('messages.recordNoUpdated'))
            } 
        } else {
            home()
        }
    }

    const clickIconToolBar = (button) => {
        if (button == 'exit') {
            home()
        }
    }

    onMounted(() => {
        getProject()
        fields[1].items = props.subsidiaries;
        fields[5].items = props.cities;
        fields[11].items = props.stakeholders;
        fields[12].items = props.stakeholders;
        fields[13].items = props.stakeholders;
        fields[14].items = props.stakeholders;
    }) 

    

</script>