<template>
    <div class="w-full sm:w-48 bg-white shadow-lg rounded-lg overflow-hidden border border-neutral-400">
        <div class="bg-gray-100 border-b">
            <h3 class="text-sm p-1 font-bold text-center">{{ table }}</h3>
        </div>
        <div class="text-center">
            <PrimaryButton
                class="m-2 text-xs"
                @click="openModalImport"
            >
                {{  $trnsl('messages.importFromExcel') }}
            </PrimaryButton>
        </div>
    </div>

    <Modal
        :showModal="modalImport"
        @closeModal="closeModalImport"
        :title="title"
    >
        <!-- <h3 class="p-3 font-semibold text-blue-500 bg-gray-100">
            {{ title }}
        </h3> -->

        <!-- Name -->
        
        <div class="p-3">
            <InputLabel 
                for="file" 
                :value="$trnsl('content.select')+' '+$trnsl('content.file')"
                class="ml-1"
            ></InputLabel>
            <TextInput 
                id="file" 
                type="file"
                class="text-xs mt-1 p-1 block w-3/4"
                accept=".xlsx, .xls, .csv"
                @input="formImport.file = $event.target.files[0]"
            ></TextInput>
            <InputError 
                :message="formImport.errors.file"
            ></InputError>
            
        </div>

        <!-- Buttons -->
        
        <div class="p-3 mt-6 flex justify-end bg-gray-100">
            <PrimaryButton
                :disabled="formImport.processing"
                @click="importRecord"
            >
                <i class="fa fa-save"></i>
                {{  $trnsl('content.import') }}
            </PrimaryButton>
            <SecondaryButton
                class="ml-3"
                :disabled="formImport.processing"
                @click="closeModalImport"
            >
                {{  $trnsl('content.cancel') }}
            </SecondaryButton>
        </div>
    </Modal>

</template>

<script setup>
    import PrimaryButton from '@/Components/PrimaryButton.vue'
    import SecondaryButton from '@/Components/SecondaryButton.vue'  
    import InputError from '@/Components/InputError.vue'
    import InputLabel from '@/Components/InputLabel.vue'
    import TextInput from '@/Components/TextInput.vue'
    import Modal from '@/Components/Modal.vue';
    import { successMessage, errorMessage, dialogBox } from '@/Helpers/helper'
    import { trnsl } from '@/Lang/languages';
    import { useForm } from '@inertiajs/vue3';
    import { ref } from 'vue';


    const props = defineProps ({
        table: String,
        routeImport: String,
    })

    const modalImport = ref(false)
    const title = ref('')

    //Form Import
    const formImport = useForm({
        'file': '',
    })

    //Open Modal Import Form
    const openModalImport = () => {
        modalImport.value = true;
        title.value = trnsl('content.import') + ' ' + props.table;
    }

    //Close Modal Import Form
    const closeModalImport = () => {
        modalImport.value = false;
        formImport.reset();
    }

    //Import Records
    const importRecord = () => {
        formImport.post(route(props.routeImport),{
            onSuccess: () => { 
                successMessage(trnsl('messages.successfullImport')) 
                closeModalImport()
            },
            onError: () => { errorMessage(trnsl('messages.errorsInImport')) }
        });
    }




</script>