<template>
    <table class="min-w-full divide-y divide-gray-300 rounded-lg">

        <thead class="bg-gray-600">
            <tr class="tracking-wide">
                <th class="px-2 py-1 text-xs text-white tracking-wider">
                    {{ trnsl('content.quantity') }}
                </th>
                <th class="px-2 py-1 text-xs text-white tracking-wider">
                    {{ trnsl('content.measurement') }}
                </th>
                <th class="px-2 py-1 text-xs text-white tracking-wider">
                    {{ trnsl('content.reference') }}
                </th>
                <th class="px-2 py-1 text-xs text-white tracking-wider">
                    {{ trnsl('content.attachment') }}
                </th> 
            </tr>
        </thead>

        <tbody class="bg-white divide-y divide-gray-300">

            <tr v-for="(item, i) in purchaseRequestItems" :key="i">
                <td class="whitespace-wrap px-2 py-1 text-xs text-gray-500 text-start">
                    {{ item.quantity }}
                </td>
                <td class="whitespace-wrap px-2 py-1 text-xs text-gray-500 text-start">
                    {{ item.unity.code }}
                </td>
                <td class="whitespace-wrap px-2 py-1 text-xs text-gray-500 text-start">
                    {{ item.reference }}
                </td>
                <td class="whitespace-wrap px-2 py-1 text-xs text-gray-500 text-center">
                    <span class="inline-flex overflow-hidden rounded-md border bg-white shadow-sm">
                        <button 
                            class="inline-block border-e px-2 py-1 text-green-600 hover:bg-gray-50 focus:relative disabled:opacity-25"
                            :title="trnsl('content.attachment')"
                            @click="openAttachment(item)"
                            :disabled="!item.attachment"
                        >
                            <i class="fa fa-paperclip"></i>
                        </button>
                    </span>
                </td> 
                
            </tr>

        </tbody>

    </table>

    <Modal
        :showModal="showAttachment"
        @closeModal="closeAttachment"
        :title="trnsl('content.attachment')"
        modal-width="400px"
    >
        <embed class="w-full h-screen" :src="file" />
    </Modal>
</template>

<script setup>
    import Modal from '@/Components/Modal.vue'
    import { trnsl } from '@/Lang/languages'
    import { onMounted, ref } from 'vue'

    const props = defineProps({
        purchaseRequestItems: Array,
    })

    const showAttachment = ref(false)

    const openAttachment = (item) => {
        file.value = 'http://delta.test/storage/kapatax/documents/commercial/needRequests/' + item.attachment 
        showAttachment.value = true
    }

    const closeAttachment = () => {
        showAttachment.value = false
    }
</script>