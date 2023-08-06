<template>

    <AuthenticatedLayout>

        <Head :title="$trnsl('content.permits')"></Head>

        <template #header>
            {{ $trnsl('content.parameters') }}
        </template>

        <template #subheader>
            {{ $trnsl('content.project') }}
        </template>

        <template #content>
            <div class="w-full overflow-hidden rounded-lg shadow">
                <div class="bg-neutral-700 p-2">
                    <h3 class="text-white text-sm text-center">{{ trnsl('messages.importFromExcel')}}</h3>
                </div>
                <div class="flex flex-wrap p-2 sm:px-10 bg-white gap-2">
                    <FormImport
                        :table="trnsl('content.functions')"   
                        routeImport="project.functions.import"                 
                    />
                    <FormImport
                        :table="trnsl('content.positions')"   
                        routeImport="project.positions.import"                    
                    />
                    <FormImport
                        :table="trnsl('content.sectors')"      
                        routeImport="project.sectors.import"                 
                    />
                    <FormImport
                        :table="trnsl('content.departments')"  
                        routeImport="project.departments.import"                     
                    />
                    <FormImport
                        :table="trnsl('content.zones')"   
                        routeImport="project.zones.import"                    
                    />
                    <FormImport
                        :table="trnsl('content.locations')"    
                        routeImport="project.locations.import"                   
                    />
                    <FormImport
                        :table="trnsl('content.families')"    
                        routeImport="project.families.import"                   
                    />
                    <FormImport
                        :table="trnsl('content.categories')"    
                        routeImport="project.categories.import"                   
                    />
                    <FormImport
                        :table="trnsl('content.turns')"    
                        routeImport="project.turns.import"                   
                    />
                    <FormImport
                        :table="trnsl('content.equipments')"    
                        routeImport="project.equipments.import"                   
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