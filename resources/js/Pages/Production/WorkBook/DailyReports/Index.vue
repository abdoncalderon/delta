<template>
    <AuthenticatedLayout>
        <Head :title="$trnsl('content.dailyReports')"></Head>

        <template #header>
            {{ $trnsl('content.dailyReports') }}
        </template>

        <template #subheader>
            {{ $trnsl('content.production') }}
        </template>

        <template #content>

            <div class="my-2">
                <ToolBar
                    :key="reload"
                    :icons="icons"
                    @click="clickIconToolBar"
                />
            </div>
            
            <div class="my-2">
                <DataTable
                    :key="reload"
                    :headers="headers"
                    :actions="actions"
                    :dataset="dailyReports"
                    :title="trnsl('content.dailyReports')+' - '+folio.location.name+' - '+folio.date"
                    fieldSearch="name"
                    @action="getAction"
                />
            </div>
            <div>
                <DailyReportNew
                    v-if="showNewForm"
                    :form="form"
                    :turns="turns"
                    :responsibles="responsibles"
                    @event="getEvent"
                />

                <DailyReportEdit
                    v-if="showEditForm"
                    :dailyReport="dailyReport"
                    :turns="turns"
                    :responsibles="responsibles"
                    :positions="positions"
                    :equipments="equipments"
                    :stakeholders="stakeholders"
                    @close="closeFormEdit"
                />
            </div>

           

            

        </template>

    </AuthenticatedLayout>
</template>

<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
    import DataTable from '@/Components/DataTable.vue'
    import DailyReportNew from './New.vue'
    import DailyReportEdit from './Edit.vue'
    import ToolBar from '@/Components/ToolBar.vue'
    import { trnsl } from '@/Lang/languages';
    import { useForm, Head, usePage, router } from '@inertiajs/vue3';
    import { ref, reactive, onMounted } from 'vue';

    const props = defineProps({
        folio: Object,
        dailyReports: Array,
        turns: Array,
        responsibles: Array,
        projectUserId: Number,
        positions: Array,
        equipments: Array,
        stakeholders: Array,
    });

    const page = usePage();
    
    const form = useForm({
        'id': '',
        'folio_id': '',
        'date': '',
        'location': '',
        'location_id': '',
        'turn_id': '',
        'report': '',
        'project_user_id': '',
        'responsible': '',
    });

    const reload = ref(0)
    const showNewForm = ref(false)
    const showEditForm = ref(false)
    const title = ref('');
    
    let dailyReport = {}

    const headers = [
        {name: 'turn.name', text: trnsl('content.turn'), type: 'text', align: 'left'},
    ];

    const actions = [
        {name: 'show', type: 'icon', text: trnsl('content.show'), icon: 'fa fa-eye', color: 'primary'},
        {name: 'edit', type: 'icon', text: trnsl('content.edit'), icon: 'fa fa-pencil', color: 'primary'},
        {name: 'review', type: 'icon', text: trnsl('content.review'), icon: 'fa fa-magnifying-glass', color: 'primary'},
        {name: 'approve', type: 'icon', text: trnsl('content.approve'), icon: 'fa fa-check', color: 'primary'},
    ];

    const icons = [
        {name: 'home', text: trnsl('content.home'), icon: 'fa-solid fa-home', hidden: false },
        {name: 'back', text: trnsl('content.back'), icon: 'fa-solid fa-arrow-left', hidden: false },       
        {name: 'new', text: trnsl('content.new'), icon: 'fa fa-plus', hidden: false },
    ];

    const home = () => {
        router.visit(route('dashboard'))
    } 

    const back = () => {
        router.visit(route('production.workbook.folios.index'))
    } 

    const clickIconToolBar = (button) => {
        if (button === 'new') {
            form.reset()
            form.folio_id = props.folio.id
            form.project_user_id = props.projectUserId
            form.location = props.folio.location.name
            form.date = props.folio.date
            title.value = trnsl('content.create') + ' ' + trnsl('content.dailyReport')
            showNewForm.value = true
        } else if (button == 'back') {
            back()
        } else if (button == 'home') {
            home()
        }
    }
    
    const getAction = ( action ) => {
        if (action.name==='edit') {
            buttons[2].hidden = true
            reload.value += 1;
            dailyReport = action.data
            showEditForm.value = true
        } else if (action.name==='notes') {
                    
                }
    }

    const closeFormNew = () => {
        form.reset()
        showNewForm.value = false
        reload.value += 1;
    }

    const closeFormEdit = ( flag ) => {
        showEditForm.value = !flag
        buttons[2].hidden = false
        reload.value += 1;
    }

    const getEvent = ( event ) => {
        if (event.status == 1) {
            closeFormNew()
            buttons[2].hidden = true
            reload.value += 1;
            props.dailyReports.forEach( ( row ) => {
                if (row.id==event.status.id) {
                    dailyReport = row
                }
            })
            showEditForm.value = true
        } else if (event.status==0) {
            closeFormNew()
        }
    }

    onMounted(() => {
      
    }) 

</script>


