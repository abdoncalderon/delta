<template>
    <AuthenticatedLayout>

        <Head :title="$trnsl('content.materials')"></Head>
        
        <template #header>
            {{ $trnsl('content.materials') }}
        </template>

        <template #subheader>
            {{ $trnsl('content.commercial') }}
        </template>

        <template #content>
            
            <div class="my-2">
                <ToolBar
                    :icons="icons"
                    @click="clickIconToolBar"
                />
            </div>
            <List
                v-if="list"
                :materials="materials"
                @event="getEvent"
            />
            
            <New
                v-if="new_"
                :form="form"
                :materials="materials"
                :families="families"
                :brands="brands"
                :models="models"
                :unities="unities" 
                @event="getEvent"       
            />

            <Edit
                v-if="edit"
                :form="form"
                :materials="materials"
                :families="families"
                :brands="brands"
                :models="models"
                :unities="unities" 
                @event="getEvent"       
            />

        </template>

    </AuthenticatedLayout>
</template>

<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
    import ToolBar from '@/Components/ToolBar.vue'
    import New from './New.vue'
    import List from './List.vue'
    import Edit from './Edit.vue'
    import { useForm, Head, usePage, router } from '@inertiajs/vue3';
    import { trnsl } from '@/Lang/languages';
    import { ref } from 'vue';

    const props = defineProps({
        materials: Array,
        families: Array,
        brands: Array,
        models: Array,
        unities: Array,
    });
    
    const form = useForm({
        'id': '',
        'project_id': '',
        'family_id': '',
        'category_id': '',
        'subcategory_id': '',
        'brand_id': '',
        'model_id': '',
        'type_id': '',
        'partOf': '',
        'name': '',
        'description': '',
        'internalCode': '',
        'sku': '',
        'upc': '',
        'unity_id': '',
        'weight': '',
        'volume': '',
    });

    const page = usePage();
    
    const new_ = ref(false)
    const edit = ref(false)
    const list = ref(true)
    
    const icons = [
        {name: 'home', text: trnsl('content.home'), icon: 'fa-solid fa-home'},
        {name: 'back', text: trnsl('content.back'), icon: 'fa-solid fa-arrow-left'},       
        {name: 'new', text: trnsl('content.new'), icon: 'fa fa-plus'},
        {name: 'list', text: trnsl('content.list'), icon: 'fa fa-table'},
    ];
    
    const home = () => {
        router.visit(route('dashboard'))
    } 

    const back = () => {
        router.visit(route('commercial.materials.home'))
    } 

    const clickIconToolBar = (button) => {
        if (button === 'list') {
            new_.value = false
            edit.value = false
            list.value = true
        } else if (button == 'new') {
                    form.reset()
                    form.project_id = page.props.auth.currentProject.id
                    list.value = false
                    edit.value = false
                    new_.value = true
                } else if (button == 'back') {
                            back()
                        } else if (button == 'home') {
                                    home()
                                }
    }

    const getEvent = ( event ) => {
        if (event.status==='edit') {
            form.id = event.action.id
            form.project_id = event.action.project_id
            form.family_id = event.action.family_id
            form.category_id = event.action.category_id
            form.subcategory_id = event.action.subcategory_id
            form.type_id = event.action.type_id
            form.brand_id = event.action.brand_id
            form.model_id = event.action.model_id
            form.unity_id = event.action.unity_id
            form.name = event.action.name
            form.description = event.action.description
            form.sku = event.action.sku
            form.upc = event.action.upc
            form.partOf = event.action.partOf
            form.weight = event.action.weight
            form.volume = event.action.volume
            new_.value = false
            list.value = false
            edit.value = true
        } else {
            new_.value = false
            edit.value = false
            list.value = true
        }

    }

</script>