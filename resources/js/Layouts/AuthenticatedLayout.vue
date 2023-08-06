<template>

    <div class="flex h-screen bg-gray-200 font-roboto">

        <Navigation/>

        <div class="flex flex-1 flex-col overflow-hidden">

            <Header/>

            <main class="flex-1 overflow-y-auto overflow-x-hidden bg-gray-200">

                <div class="container mx-auto px-3 py-2">

                    <div class="border-neutral-700 border-b mb-2">

                        <p class="inline-block text-xl font-extrabold text-gray-700 mr-1">
                            <slot name="header" /> 
                        </p>

                        <p class="inline-block text-xs text-gray-700">
                            [<slot name="subheader"/>]
                        </p>
                        
                    </div>
                    
                    <slot name="content"/>
                    <slot/>

                </div>

            </main>

        </div>

    </div> 


</template>

<script setup>

    import Header from '@/Layouts/Header.vue';
    import Navigation from '@/Layouts/Navigation.vue';

</script>
