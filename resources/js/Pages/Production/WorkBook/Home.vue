<template>

    <AuthenticatedLayout>

        <Head :title="trnsl('content.workbook')"></Head>

        <template #header>
            {{ trnsl('content.workbook') }}
        </template>

        <template #subheader>
            {{ trnsl('content.production') }}
        </template>

        <template #content>
            <div class="grid grid-cols-3 sm:grid-cols-6 lg:grid-cols-8 gap-2 mt-2 ">
                <div class="cols-span-1 sm:cols-span-2 bg-white rounded-lg overflow-hidden flex border border-gray-200 ">
                    <button class="m-auto" @click="workbook">
                        <img class="m-auto object-content h-24 w-24" src="http://delta.test/storage/kapatax/images/icons/folios.jpg" alt="">
                        <p class="text-center px-2 pb-2 text-xs font-bold">{{ trnsl('content.folios') }}</p>
                    </button>
                </div>
                <div class="cols-span-1 sm:cols-span-2 bg-white rounded-lg overflow-hidden flex border border-gray-200">
                    <button class="m-auto" @click="locations">
                        <img class="m-auto object-content h-24 w-24" src="http://delta.test/storage/kapatax/images/icons/locations.jpg" alt="">
                        <p class="text-center px-2 pb-2 text-xs font-bold">{{ trnsl('content.locations') }}</p>
                    </button>
                </div>
                <div class="cols-span-1 sm:cols-span-2 bg-white rounded-lg overflow-hidden flex border border-gray-200">
                    <button class="m-auto" @click="access">
                        <img class="m-auto object-content h-24 w-24" src="http://delta.test/storage/kapatax/images/icons/access.jpg" alt="">
                        <p class="text-center px-2 pb-2 text-xs font-bold">{{ trnsl('content.users') }}</p>
                    </button>
                </div>
                <div class="cols-span-1 sm:cols-span-2 bg-white rounded-lg overflow-hidden flex border border-gray-200">
                    <button class="m-auto" @click="access">
                        <img class="m-auto object-content h-24 w-24" src="http://delta.test/storage/kapatax/images/icons/printer.jpg" alt="">
                        <p class="text-center px-2 pb-2 text-xs font-bold">{{ trnsl('content.reports') }}</p>
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

    const locations = () => {
        router.visit(route('production.workbook.locations.index'))
    }

    const access = () => {
        router.visit(route('production.workbook.users.index'))
    }

    
</script>