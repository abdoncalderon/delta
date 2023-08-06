<template>
    <header class="flex items-center justify-between border-b-2 border-neutral-700 bg-sky-600 px-6 py-3">
        <div class="flex items-center">
            <button @click="$page.props.showingMobileMenu = !$page.props.showingMobileMenu" class="text-white focus:outline-none lg:hidden">
                <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M4 6H20M4 12H20M4 18H11" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </button>
        </div>

        

        <div class="flex items-center">
             
            <dropdown>
                <template #trigger>
                    <button @click="dropdownOpen = ! dropdownOpen" class="relative block overflow-hidden text-white">
                        <p>{{ $page.props.auth.person.fullName }}</p>
                        <p class="text-xs">{{ $page.props.auth.user.email }}</p>
                    </button>
                </template>

                <template #content>
                    <dropdown-link :href="route('profile.edit')">
                        <i class="fa fa-user"></i>
                        {{ $trnsl('content.profile') }}
                    </dropdown-link>

                    <dropdown-link :href="route('project')">
                        <i class="fa fa-rotate-left"></i>
                        {{ $trnsl('messages.changeProject') }}
                    </dropdown-link>

                    <dropdown-link :href="route('logout')" method="post" as="button">
                        <i class="fa fa-right-from-bracket"></i>
                        {{ $trnsl('content.logout') }}
                    </dropdown-link>
                </template>
            </dropdown>
        </div>
    </header>
</template>
<script setup>

    import Dropdown from '@/Components/Dropdown.vue';
    import DropdownLink from '@/Components/DropdownLink.vue';
  

    

</script>
