<template>
    <p class="m-2 p-2 uppercase bg-neutral-800 text-white text-xs rounded-md">{{ title }}</p>
    <div :key="reload" class="m-2 bg-white rounded-lg h-96 border border-neutral-700 overflow-auto">
        <template v-for="comment in comments">
            <div class="m-2 p-2 bg-green-100 rounded-md">
                <button v-if="comment.project_user_id==projectUserId" class="pr-2 align-top inline text-neutral-400" @click="deleteComment(comment)">
                    <i class="fa fa-circle-xmark"></i>
                </button>
                <div class="inline">
                    <p class="inline text-xs text-neutral-400">{{ comment.date + ' - [' + comment.fullName + ']' }}</p>
                    <p class="pl-6 text-sm">{{ comment.comment }}</p>
                </div>
            </div>
        </template>
    </div>
    <div v-if="note.status==0" class="p-2">
        <InputLabel 
            for="comment" 
            :value="trnsl('content.comment')"
            
        ></InputLabel>
        <TextArea 
            id="comment" 
            v-model="form.comment"
            rows="4"
        ></TextArea>
        <InputError 
            :message="form.errors.comment"
        ></InputError>
    </div>
    <div class="p-3 mt-2 flex justify-end bg-gray-100">
        <PrimaryButton
            v-if="note.status==0"
            :disabled="form.processing"
            @click="save"
            icon="fa fa-save"
        >
            
            {{ $trnsl('content.toComment') }}
        </PrimaryButton>
        <SecondaryButton
            class="ml-3"
            :disabled="form.processing"
            icon="fa fa-ban"
            @click="cancel"
        >
            {{  $trnsl('content.exit') }}
        </SecondaryButton>
    </div>

</template>

<script setup>
    import PrimaryButton from '@/Components/PrimaryButton.vue' 
    import SecondaryButton from '@/Components/SecondaryButton.vue'
    import InputError from '@/Components/InputError.vue'
    import InputLabel from '@/Components/InputLabel.vue'
    import TextArea from '@/Components/TextArea.vue'
    import { successMessage, errorMessage } from '@/Helpers/helper'
    import { trnsl } from '@/Lang/languages';
    import { useForm } from '@inertiajs/vue3';
    import { ref, reactive, onMounted } from 'vue';
    import dayjs from 'dayjs';

    const props = defineProps({
        note: Object,
        projectUserId: Number,
        folio: Object,
    });

    const form = useForm({
        'id': '',
        'date': dayjs(undefined).format('YYYY-MM-DD HH:mm:ss'),
        'comment': '',
        'project_user_id': props.projectUserId,
        'note_id': props.note.value.id,
    });

    const comments = reactive([])
    const reload = ref(0)
    const title = ref('')

    const emit = defineEmits([
        'submit'
    ])

    const save = () => {
        form.post(route('production.workbook.notes.comments.store'), {
            onSuccess: () => { 
                getCommentsNote(props.note.value.id)
                form.comment = ''
            },
            onError: (errors) => {
                console.log(errors)
            }
        })
    }

    const deleteComment = ( comment ) => {
        const dialog = dialogBox( comment.date + ' - [' + comment.fullName + ']' )
        dialog.fire().then((result) =>{
            if(result.isConfirmed){
                form.delete(route('production.workbook.notes.comments.destroy', comment.id),{
                    onSuccess: () => { 
                        successMessage(trnsl('messages.recordDeleted'))
                        getCommentsNote(props.note.value.id)
                    },
                    onError: () => {
                        errorMessage(trnsl('messages.recordNoDeleted'))
                    }
                })
            }
        });
    }

    const cancel = () => {
        emit ('submit', [0])
    }

    const getCommentsNote = ( id ) => {
        comments.length = 0
        axios.get('/api/getCommentsNote/' + id)
            .then(response=>{
                response.data.forEach( (row, i) => {
                    comments[i] = row
                })
                reload.value += 1
            })
            .catch(error=>{
                console.log(error)
            })
    }

    function formatDate(dateString, format) {
        const date = dayjs(dateString);
        return date.format(format);
    }

    onMounted(() => {
        getCommentsNote(props.note.value.id)
        title.value = props.folio.location.name + ' - ' + formatDate(props.note.value.date, 'YYYY/MMM/DD') + ' - ' + props.note.value.turn.name
    })

     
</script>