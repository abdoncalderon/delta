<template>

    <AuthenticatedLayout>

        <Head :table="$trnsl('content.parameters')"></Head>

        <template #header>
            {{ $trnsl('content.parameters') }}
        </template>

        <template #subheader>
            {{ $trnsl('content.setting') }}
        </template>

        <template #content>
            <div class="w-full mt-2 overflow-hidden rounded-lg shadow">
                <div class="bg-gray-800 p-2">
                    <h3 class="text-white text-sm text-center">{{ trnsl('messages.importFromExcel')}}</h3>
                </div>
                <div class="flex flex-wrap p-2 sm:px-10 bg-white gap-2">
                    <FormImport
                        :table="trnsl('content.regions')"   
                        routeImport="settings.regions.import"                 
                    />
                    <FormImport
                        :table="trnsl('content.countries')"   
                        routeImport="settings.countries.import"                    
                    />
                    <FormImport
                        :table="trnsl('content.states')"      
                        routeImport="settings.states.import"                 
                    />
                    <FormImport
                        :table="trnsl('content.cities')"  
                        routeImport="settings.cities.import"                     
                    />
                    <FormImport
                        :table="trnsl('content.brands')"   
                        routeImport="settings.brands.import"                    
                    />
                    <FormImport
                        :table="trnsl('content.models')"    
                        routeImport="settings.models.import"                   
                    />
                    <FormImport
                        :table="trnsl('content.unities')"    
                        routeImport="settings.unities.import"                   
                    />
                </div>
            </div>

        </template>

        
    </AuthenticatedLayout>

</template>

<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
    import FormImport from '@/Components/FormImport.vue'
    import { trnsl } from '@/Lang/languages';
    import { Head } from '@inertiajs/vue3';
    
</script>