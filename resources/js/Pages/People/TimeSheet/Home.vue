<template>

    <AuthenticatedLayout>

        <Head :title="$trnsl('content.timesheet')"></Head>

        <template #header>
            {{ $trnsl('content.timesheet') }}
        </template>

        <template #subheader>
            {{ $trnsl('content.people') }}
        </template>

        <template #content>
            <div class="grid grid-cols-3 sm:grid-cols-6 lg:grid-cols-8 gap-2 mt-2 ">
                <div class="cols-span-1 sm:cols-span-2 bg-white rounded-lg overflow-hidden flex border border-gray-200">
                    <button class="m-auto" @click="attendance">
                        <img class="m-auto object-content h-24 w-24" src="http://delta.test/storage/kapatax/images/icons/attendance.jpg" alt="">
                        <p class="text-center px-2 pb-2 text-xs font-bold">{{ $trnsl('content.attendance') }}</p>
                    </button>
                </div>

                <div class="cols-span-1 sm:cols-span-2 bg-white rounded-lg overflow-hidden flex border border-gray-200">
                    <button class="m-auto" @click="clocks">
                        <img class="m-auto object-content h-24 w-24" src="http://delta.test/storage/kapatax/images/icons/clocks.jpg" alt="">
                        <p class="text-center px-2 pb-2 text-xs font-bold">{{ $trnsl('content.clocks') }}</p>
                    </button>
                </div>

                <!-- <div class="cols-span-1 sm:cols-span-2 bg-white rounded-lg overflow-hidden flex border border-gray-200">
                    <button class="m-auto" @click="upload">
                        <img class="m-auto object-content h-24 w-24" src="http://delta.test/storage/kapatax/images/icons/upload.jpg" alt="">
                        <p class="text-center px-2 pb-2 text-xs font-bold">{{ $trnsl('content.uploadUsers') }}</p>
                    </button>
                </div>

                <div class="cols-span-1 sm:cols-span-2 bg-white rounded-lg overflow-hidden flex border border-gray-200">
                    <button class="m-auto" @click="download">
                        <img class="m-auto object-content h-24 w-24" src="http://delta.test/storage/kapatax/images/icons/download.jpg" alt="">
                        <p class="text-center px-2 pb-2 text-xs font-bold">{{ $trnsl('content.downloadUsers') }}</p>
                    </button>
                </div> -->

                <div class="cols-span-1 sm:cols-span-2 bg-white rounded-lg overflow-hidden flex border border-gray-200">
                    <button class="m-auto" @click="users">
                        <img class="m-auto object-content h-24 w-24" src="http://delta.test/storage/kapatax/images/icons/users.jpg" alt="">
                        <p class="text-center px-2 pb-2 text-xs font-bold">{{ $trnsl('content.users') }}</p>
                    </button>
                </div>

                <div class="cols-span-1 sm:cols-span-2 bg-white rounded-lg overflow-hidden flex border border-gray-200">
                    <button class="m-auto" @click="shifts">
                        <img class="m-auto object-content h-24 w-24" src="http://delta.test/storage/kapatax/images/icons/shifts.jpg" alt="">
                        <p class="text-center px-2 pb-2 text-xs font-bold">{{ $trnsl('content.shifts') }}</p>
                    </button>
                </div>

                <div class="cols-span-1 sm:cols-span-2 bg-white rounded-lg overflow-hidden flex border border-gray-200">
                    <button class="m-auto" @click="reports">
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
    import { Head, router } from '@inertiajs/vue3';

    const attendance = () => {
        router.visit('/people/timesheet/attendance')
    }

    const clocks = () => {
        router.visit('/people/timesheet/clocks')
    }

    const users = () => {
        router.visit('/people/timesheet/users')
    }

    const shifts = () => {
        router.visit('/people/timesheet/shifts')
    }

    const reports = () => {
        router.visit('/people/timesheet/reports')
    }

   
</script>