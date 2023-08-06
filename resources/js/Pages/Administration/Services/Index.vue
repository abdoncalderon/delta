<template>

    <AuthenticatedLayout>

        <Head :title="$trnsl('content.technology')"></Head>

        <template #header>
            {{ $trnsl('content.technology') }}
        </template>

        <template #subheader>
            {{ $trnsl('content.administration') }}
        </template>

        <template #content>
            <div class="flex my-2 gap-2">
                <button class="rounded-lg overflow-hidden bg-white" @click="">
                    <img class="m-auto object-content h-24 w-24" src="http://delta.test/storage/kapatax/images/icons/assignments.jpg" alt="">
                    <p class="text-center px-2 pb-2 text-xs font-bold">{{ $trnsl('content.assignments') }}</p>
                </button>
                <button class="rounded-lg overflow-hidden bg-white" @click="">
                    <img class="m-auto object-content h-24 w-24" src="http://delta.test/storage/kapatax/images/icons/services.jpg" alt="">
                    <p class="text-center px-2 pb-2 text-xs font-bold">{{ $trnsl('content.services') }}</p>
                </button>
            </div>
        </template>

        
    </AuthenticatedLayout>

</template>

<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
    import { trnsl } from '@/Lang/languages';
    import { Head } from '@inertiajs/vue3';

    

    
</script>