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
                            class="group flex gap-0  justify-between px-4 py-2 text-gray-300 hover:bg-gray-100 hover:text-gray-700"
                        >
                            <div class="flex items-center gap-2">
                                <i :class="menu.icon" style="padding-right: 5px;"></i>
                                <span class="font-medium"> {{ $trnsl(menu.text) }} </span>
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
                                    <nav-link
                                        class="text-xs text-neutral-400 hover:bg-neutral-600 hover:text-white"
                                        :href="route(submenu.route)" :active="route().current(submenu.route)"
                                    >   
                                        <span class="text-sm marker:font-medium"> 
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