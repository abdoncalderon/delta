<template>

    <AuthenticatedLayout>

        <Head :title="$trnsl('content.materials')"></Head>

        <template #header>
            {{ $trnsl('content.materials') }}
        </template>

        <template #subheader>
            {{ $trnsl('content.commercial') }}
        </template>

        <template #content>
            <div class="grid grid-cols-3 sm:grid-cols-6 lg:grid-cols-8 gap-2 mt-2 ">
                <div class="cols-span-1 sm:cols-span-2 bg-white rounded-lg overflow-hidden flex border border-gray-200">
                    <button class="m-auto" @click="materials">
                        <img class="m-auto object-content h-24 w-24" src="http://delta.test/storage/kapatax/images/icons/register.jpg" alt="">
                        <p class="text-center px-2 pb-2 text-xs font-bold">{{ $trnsl('content.materials') }}</p>
                    </button>
                </div>
                <div class="cols-span-1 sm:cols-span-2 bg-white rounded-lg overflow-hidden flex border border-gray-200">
                    <button class="m-auto" @click="locations">
                        <img class="m-auto object-content h-24 w-24" src="http://delta.test/storage/kapatax/images/icons/stockingUp.jpg" alt="">
                        <p class="text-center px-2 pb-2 text-xs font-bold">{{ $trnsl('messages.stockingUp') }}</p>
                    </button>
                </div>
               
                <div class="cols-span-1 sm:cols-span-2 bg-white rounded-lg overflow-hidden flex border border-gray-200">
                    <button class="m-auto" @click="access">
                        <img class="m-auto object-content h-24 w-24" src="http://delta.test/storage/kapatax/images/icons/printer.jpg" alt="">
                        <p class="text-center px-2 pb-2 text-xs font-bold">{{ $trnsl('content.reports') }}</p>
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

    const materials = () => {
        router.visit(route('commercial.materials.index'))
    }

    const locations = () => {
        router.visit(route('commercial.materials.index'))
    }

    const access = () => {
        router.visit(route('commercial.materials.index'))
    }

    
</script>