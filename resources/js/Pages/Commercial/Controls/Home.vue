<template>

    <AuthenticatedLayout>

        <Head :title="$trnsl('content.controls')"></Head>

        <template #header>
            {{ $trnsl('content.controls') }}
        </template>

        <template #subheader>
            {{ $trnsl('content.commercial') }}
        </template>

        <template #content>
            <div class="grid grid-cols-3 sm:grid-cols-6 lg:grid-cols-8 gap-2 mt-2 ">
                <div class="cols-span-1 sm:cols-span-2 bg-white rounded-lg overflow-hidden flex border border-gray-200">
                    <button class="m-auto" @click="needRequests">
                        <img class="m-auto object-content h-24 w-24" src="http://delta.test/storage/kapatax/images/icons/needRequest.jpg" alt="">
                        <p class="text-center px-2 pb-2 text-xs font-bold">{{ $trnsl('content.needRequests') }}</p>
                    </button>
                </div>
                
            </div>
        </template>
        
    </AuthenticatedLayout>

</template>

<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
    import { trnsl } from '@/Lang/languages';
    import { Head, router } from '@inertiajs/vue3';

    const needRequests = () => {
        router.visit('/commercial/controls/needRequests')
    }

    
</script>