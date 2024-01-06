<template>
    <div class="border border-neutral-700 rounded-lg overflow-auto">
        
        <h3 class="px-3 py-3 font-semibold text-sm text-white bg-gray-700">
            {{ $trnsl('messages.editMaterial') }}
        </h3>

        <div class="m-1 grid grid-cols-1 sm:grid-cols-6 gap-2 px-1 py-1">

            <div class="col-span-1 sm:col-span-6">
                <InputLabel 
                    for="family" 
                    :value="trnsl('content.family')"
                ></InputLabel>
                <SelectInput
                    id="family"
                    :options="families"
                    v-model="family"
                    :disabled="true"
                    
                ></SelectInput>
            </div>

            <div class="col-span-4 sm:col-span-3">
                <InputLabel 
                    for="category" 
                    :value="trnsl('content.category')"
                ></InputLabel>
                <SelectInputDb 
                    :key="family"
                    id="category"
                    v-model="category"
                    routeGet="/getCategories/"
                    :filterId="family"
                    :withAdd="false"
                    @change="setCategory"
                ></SelectInputDb>
            </div>

            <div class="col-span-4 sm:col-span-3">
                <InputLabel 
                    for="subcategory" 
                    :value="trnsl('content.subcategory')"
                ></InputLabel>
                <SelectInputDb 
                    :key="category"
                    id="subcategory"
                    v-model="form.subcategory_id"
                    :formAdd="formSubcategory"
                    :fieldsAdd="fieldsSubcategory"
                    routeAdd="project.subcategories.store"
                    routeGet="/getSubcategories/"
                    :filterId="category"
                    :withAdd="true"
                ></SelectInputDb>
                <InputError 
                    :message="form.errors.subcategory_id"
                ></InputError>
            </div>

            <div class="col-span-1 sm:col-span-3">
                <InputLabel 
                    for="brand" 
                    :value="trnsl('content.brand')"
                    
                ></InputLabel>
                <SelectInput 
                    id="brand"
                    :options="brands"
                    v-model="brand"
                    @change="setBrand"
                ></SelectInput>
            </div>

            <div class="col-span-4 sm:col-span-3">
                <InputLabel 
                    for="model" 
                    :value="trnsl('content.model')"
                    
                ></InputLabel>
                
                <SelectInputDb 
                    :key="brand"
                    id="model"
                    v-model="form.model_id"
                    :formAdd="formModel"
                    :fieldsAdd="fieldsModel"
                    routeAdd="project.models.store"
                    routeGet="/getModels/"
                    :filterId="brand"
                    :withAdd="true"
                ></SelectInputDb>

                <InputError 
                    :message="form.errors.model_id"
                ></InputError>
            </div>

            <div class="col-span-1 sm:col-span-6">
                <InputLabel 
                    for="partOf" 
                    :value="trnsl('content.father')"
                    
                ></InputLabel>
                <SelectDynamic
                    :options="materials"
                    v-model="form.partOf"
                    show="name"
                    :disabled="false"
                ></SelectDynamic>
                <InputError 
                    :message="form.errors.partOf"
                ></InputError>
            </div>

            <div class="col-span-1 sm:col-span-1">
                <InputLabel 
                    for="type" 
                    :value="trnsl('content.type')"
                    
                ></InputLabel>
                <SelectInput 
                    id="type"
                    :options="types"
                    v-model="form.type_id"
                ></SelectInput>
                <InputError 
                    :message="form.errors.type_id"
                ></InputError>
            </div>

            <div class="col-span-1 sm:col-span-5" >
                <InputLabel 
                    for="name" 
                    :value="trnsl('content.name')"
                    
                ></InputLabel>
                <TextInput 
                    id="name" 
                    v-model="form.name"
                    type="text"
                    
                    
                ></TextInput>
                <InputError 
                    :message="form.errors.name"
                ></InputError>
            </div>

            <div class="col-span-1 sm:col-span-6">
                <InputLabel 
                    for="description" 
                    :value="trnsl('content.description')"
                    
                ></InputLabel>
                <TextArea 
                    id="description" 
                    v-model="form.description"
                    
                    rows="4"
                ></TextArea>
                <InputError 
                    :message="form.errors.description"
                ></InputError>
            </div>

            <div class="col-span-4 sm:col-span-2" >
                    <InputLabel 
                        for="internalCode" 
                        :value="trnsl('content.internalCode')"
                    ></InputLabel>
                    <TextInput 
                        id="internalCode" 
                        v-model="form.internalCode"
                        type="text"
                    ></TextInput>
                    <InputError 
                        :message="form.errors.internalCode"
                    ></InputError>
                </div>

            <div class="col-span-1 sm:col-span-2" >
                <InputLabel 
                    for="sku" 
                    value="SKU"
                    
                ></InputLabel>
                <TextInput 
                    id="sku" 
                    v-model="form.sku"
                    type="text"
                    
                    
                ></TextInput>
                <InputError 
                    :message="form.errors.sku"
                ></InputError>
            </div>
            <div class="col-span-1 sm:col-span-2" >
                <InputLabel 
                    for="upc" 
                    value="UPC"
                    
                ></InputLabel>
                <TextInput 
                    id="upc" 
                    v-model="form.upc"
                    type="text"
                    
                
                ></TextInput>
                <InputError 
                    :message="form.errors.upc"
                ></InputError>
            </div>

            <div class="col-span-1 sm:col-span-2">
                <InputLabel 
                    for="unity" 
                    :value="trnsl('content.measurement')"
                    
                ></InputLabel>
                <SelectInput 
                    id="unity"
                    :options="unities"
                    v-model="form.unity_id"
                ></SelectInput>
                <InputError 
                    :message="form.errors.untiy_id"
                ></InputError>
            </div>

            <div class="col-span-1 sm:col-span-2" >
                <InputLabel 
                    for="weight" 
                    :value="trnsl('content.weight')"
                    
                ></InputLabel>
                <TextInput 
                    id="weight" 
                    v-model="form.weight"
                    type="number"
                    
                    
                ></TextInput>
                <InputError 
                    :message="form.errors.weight"
                ></InputError>
            </div>

            <div class="col-span-1 sm:col-span-2" >
                <InputLabel 
                    for="volume" 
                    :value="trnsl('content.volume')"
                    
                ></InputLabel>
                <TextInput 
                    id="volume" 
                    v-model="form.volume"
                    type="number"
                    
                    
                ></TextInput>
                <InputError 
                    :message="form.errors.volume"
                ></InputError>
            </div>

        </div>

        <div class="p-3 mt-2 flex justify-end bg-gray-100">
            <PrimaryButton
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
    import PrimaryButton from '@/Components/PrimaryButton.vue' 
    import SecondaryButton from '@/Components/SecondaryButton.vue'
    import InputError from '@/Components/InputError.vue'
    import InputLabel from '@/Components/InputLabel.vue'
    import TextInput from '@/Components/TextInput.vue'
    import SelectInput from '@/Components/SelectInput.vue'
    import SelectInputDb from '@/Components/SelectInputDb.vue'
    import SelectDynamic from '@/Components/SelectDynamic.vue'
    import TextArea from '@/Components/TextArea.vue'
    import { useForm } from '@inertiajs/vue3';
    import { successMessage, errorMessage, dialogBox, getError } from '@/Helpers/helper'
    import { trnsl } from '@/Lang/languages';
    import { ref, onMounted, reactive } from 'vue';
    import axios from 'axios'

    const props = defineProps({
        form: Object,
        materials: Array,
        families: Array,
        brands: Array,
        models: Array,
        unities: Array,
    });

    const emit = defineEmits([
        'event'   
    ])

    const formSubcategory = useForm({
        'id': '',
        'name': '',
        'category_id': '',
    });

    const formModel = useForm({
        'id': '',
        'name': '',
        'brand_id': '',
    });

    const family = ref(0)
    const category = ref(0)
    const brand = ref(0)

    const categories = reactive([])
    const subcategories = reactive([])
    const models = reactive([])

    const fieldsSubcategory = [
        {name: 'name', type: 'text', text: trnsl('content.name'), style: 'sm:col-span-4', length: 255, disabled: false },
    ];

    const fieldsModel = [
        {name: 'name', type: 'text', text: trnsl('content.name'), style: 'sm:col-span-4', length: 255, disabled: false },
    ];

    const types = [
        {id: 1, name: trnsl('content.material') },
        {id: 2, name: trnsl('content.product') },
        {id: 3, name: trnsl('content.asset') },
        {id: 4, name: trnsl('messages.assetControlled') },
        {id: 5, name: trnsl('content.services') },
    ]

    const event = {
        source: '',
        action: '',
        status: 0,
        data: null,
    }

    const save = () => {
        props.form.patch(route('commercial.materials.materials.update', props.form.id ), {
            onSuccess: () => { 
                successMessage(trnsl('messages.recordSaved'))
                event.source = 'edit'
                event.action = 'update'
                event.status = 1
                emit('event', event)
            },
            onError: (errors) => {
                errorMessage(trnsl('messages.recordNoSaved') + '\n\r '+ getError(errors))
                console.log(errors)
            }
        })
    }

    const cancel = () => {
        event.source = 'edit'
        event.action = 'cancel'
        event.status = 1
        emit('event', event)
    }

    const setCategory = ( value ) => {
        formSubcategory.category_id = value
    }

    const setBrand = ( value ) => {
        formModel.brand_id = value
    }

    onMounted(()=>{
        family.value = props.form.family_id
        category.value = props.form.category_id
        setCategory( category.value )
        brand.value = props.form.brand_id
        setBrand( brand.value )
    })

    

</script>