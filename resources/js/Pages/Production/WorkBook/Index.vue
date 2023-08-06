<template>

    <AuthenticatedLayout>

        <Head :title="$trnsl('content.workbook')"></Head>

        <template #header>
            {{ $trnsl('content.workbook') }}
        </template>

        <template #subheader>
            {{ $trnsl('content.production') }}
        </template>

        <template #content>
            <div class="grid grid-cols-3 sm:grid-cols-6 lg:grid-cols-8 gap-2 mt-2 ">
                <div class="cols-span-1 sm:cols-span-2 bg-white rounded-lg overflow-hidden flex">
                    <button class="m-auto" @click="workbook">
                        <img class="m-auto object-content h-24 w-24" src="http://delta.test/storage/kapatax/images/icons/workbook.jpg" alt="">
                        <p class="text-center px-2 pb-2 text-xs font-bold">{{ $trnsl('content.workbook') }}</p>
                    </button>
                </div>
                <div class="cols-span-1 sm:cols-span-2 bg-white rounded-lg overflow-hidden flex">
                    <button class="m-auto" @click="settings">
                        <img class="m-auto object-content h-24 w-24" src="http://delta.test/storage/kapatax/images/icons/settings.jpg" alt="">
                        <p class="text-center px-2 pb-2 text-xs font-bold">{{ $trnsl('content.setting') }}</p>
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

    const workbook = () => {
        router.visit(route('production.workbook.folios.index'))
    }

    const settings = () => {
        router.visit(route(''))
    }

    
</script>