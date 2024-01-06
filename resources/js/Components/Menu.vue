<template>
    <!-- Menu -->
    <nav class="mt-1" x-data="{ isMultiLevelMenuOpen: false }">

        <template v-for="menu in menus" :key="menu.id">
            
            <ul>
                <li
                    v-if="(menu.father === null)"
                >
                    <details 
                        v-if="typeof(menu.route) === 'undefined' || menu.route === null"
                        class="group [&_summary::-webkit-details-marker]:hidden"
                    >
                        <summary
                            class="group flex gap-0 justify-between px-4 py-1 text-gray-300 hover:bg-gray-900 hover:text-white"
                        >
                            <div class="flex items-center gap-2 text-sm">
                                <i :class="menu.icon" style="padding-right: 5px;"></i>
                                <span> {{ $trnsl(menu.text) }} </span>
                            </div>

                            <span 
                                v-if="menu.menus"
                                class="shrink-0 transition duration-300 group-open:-rotate-180"
                            >
                                <i class="fa fa-angle-down"></i>
                            </span>
                        </summary>
                        <ul 
                            v-if="menu.menus"
                        >
                            <template v-for="submenu in menu.menus" :key="submenu.id">
                                <li>
                                    <!-- <nav-link
                                        class="text-xs text-white bg-gray-600 hover:bg-gray-700 hover:text-white active:bg-gray-700"
                                        :href="route(submenu.route)" :active="route().current(submenu.route)"
                                    >   -->
                                    <nav-link
                                        class="text-xs text-white bg-gray-700 hover:bg-gray-800 hover:text-white active:bg-gray-700"
                                        :href="route(submenu.route)" 
                                    >  
                                        <span class="text-xs"> 
                                            <i :class="submenu.icon" style="padding-right: 5px;"></i>
                                            {{ $trnsl(submenu.text) }} 
                                        </span>
                                        
                                    </nav-link>
                                </li>
                            </template>
                        </ul>
                    </details>

                </li>
                
            </ul>
            
        </template>

    </nav>

</template>

<script setup>

    import NavLink from '@/Components/NavLink.vue';

    const props = defineProps({
        menus: Array
    })

</script>