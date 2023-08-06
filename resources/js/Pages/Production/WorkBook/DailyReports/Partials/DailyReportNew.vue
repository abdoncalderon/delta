<template>
    <div class="bg-white rounded-lg shadow-md my-2 overflow-hidden">

        <h3 class="px-3 py-3 text-white bg-neutral-800">
            {{ $trnsl('content.create') + ' ' + $trnsl('content.dailyReport') }}
        </h3>

        <Form
            :form="form"
            :fields="fields"
            :table="trnsl('content.dailyReport')"
            operation="store"
            routePath="production.workbook.dailyReports.store"
            :acceptText="trnsl('content.create')"
            @submit="confirmTransaction"
        />  

    </div>
</template>
<script setup>
    import Form from '@/Components/Form.vue'
    import { trnsl } from '@/Lang/languages';
    import { ref, reactive, onMounted } from 'vue';
    import { useForm, Head, usePage, router } from '@inertiajs/vue3';

    const props = defineProps({
        turns: Array,
        form: Object,
        fields: Array,
    })

    const emit = defineEmits([
        'submit'
    ])

    


    

    const confirmTransaction = ( params ) => {
        emit('submit', params )
     }


    /* const confirmTransaction = ( params ) => {
        if (params[1]==='store'){
            if (params[0]==1){
                successMessage(trnsl('messages.recordSaved'))
            } else {
                errorMessage(trnsl('messages.recordNoSaved'))
            } 
        } else if ((params[1]==='update')||(params[1]==='updateWithFile')) {
            if (params[0]==1){
                successMessage(trnsl('messages.recordUpdated')) 
                closeModal()
            } else {
                errorMessage(trnsl('messages.recordNoUpdated'))
            } 
        } else {
            showNewForm.value = false
        }
    } */
    
    

</script>