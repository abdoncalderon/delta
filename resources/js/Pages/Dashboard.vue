<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <Head :title="$trnsl('content.dashboard')"></Head>
        
        <template #header>
            {{ $trnsl('content.dashboard') }}
        </template>

        <template #subheader>
            {{ $trnsl('content.home') }}
        </template>
    </AuthenticatedLayout>
    
</template>

<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
    import { Head } from '@inertiajs/vue3';
</script>
