<template>
    <div>
        
        <div class="m-1 px-1 py-1 grid grid-cols-1 sm:grid-cols-4 gap-2">
            <div class="col-span-1 sm:col-span-4">
                <InputLabel 
                    for="person" 
                    :value="$trnsl('content.person')"
                ></InputLabel>
                <SelectDynamic 
                    :options="people"
                    v-model="person"
                    show="name"
                    :disabled="false"
                    :fixed="true"
                ></SelectDynamic>
            </div>
        </div>
        <div class="p-2 flex justify-end">
            <PrimaryButton
                class="ml-3"
                @click="loadPerson"
                icon="fa fa-save"
            >
                {{ $trnsl('content.search') }}
            </PrimaryButton>
            <SecondaryButton
                class="ml-3"
                icon="fa-solid fa-circle-xmark"
                @click="cancel"
            >
                {{ $trnsl('content.cancel') }}
            </SecondaryButton>
        </div>

        
    </div>
</template>
<script setup>
    import SelectDynamic from '@/Components/SelectDynamic.vue'
    import PrimaryButton from '@/Components/PrimaryButton.vue' 
    import SecondaryButton from '@/Components/SecondaryButton.vue'
    import InputLabel from '@/Components/InputLabel.vue'
    import { trnsl } from '@/Lang/languages'
    import { ref } from 'vue'
    import axios from 'axios'

    const props = defineProps({
        people: Array,
    })

    const emit = defineEmits([
        'event',
    ])

    const person = ref(0)

    let event = {
        source: '',
        action: '',
        status: 0,
        data: null,
    }

    const loadPerson = () => {
        axios.get('/getPerson/' + person.value)
            .then(response=>{
                /* form.fullName = response.data.fullName
                form.firstName = response.data.firstName
                form.lastName = response.data.firstName
                form.uid = response.data.uid
                form.gender_id = response.data.gender_id
                form.birthDate = response.data.birthDate
                form.jobTitle = response.data.jobTitle
                form.email = response.data.email
                form.photo = response.data.photo
                form.signature = response.data.signature */
                event.source = 'search'
                event.action = 'search'
                event.status = 1
                event.data = response.data
                emit('event', event)
            })
            .catch(error=>{
                errorMessage(trnsl('messages.personNoExist') + '\n\r '+ getError(error))
                console.log(error)
            })
    }

    const cancel = () => {
        event.source = 'search'
        event.action = 'cancel'
        event.status = 0
        event.data = null
        emit('event', event)
    }
</script>