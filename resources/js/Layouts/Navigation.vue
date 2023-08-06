<template>
    <div :class="$page.props.showingMobileMenu ? 'block' : 'hidden'" @click="$page.props.showingMobileMenu = false"
         class="fixed inset-0 z-20 bg-black opacity-50 transition-opacity lg:hidden"></div>

    <div :class="$page.props.showingMobileMenu ? 'translate-x-0 ease-out' : '-translate-x-full ease-in'"
         class="overflow-y-auto fixed inset-y-0 left-0 z-30 w-64 bg-neutral-800 transition duration-300 transform lg:translate-x-0 lg:static lg:inset-0">
        <!-- Logo -->
        <img src="http://delta.test/storage/kapatax/logo.png" alt="">

        <hr class="bg-neutral-200">

        <div class="grid px-3 text-center h-10 content-center">
            <p class="text-white text-xs">{{ projectName }}</p>
        </div>

        <hr class="bg-neutral-500">

        <Menu
            :key="reload"
            :menus="menusRole"
        />
       
    </div>

</template>

<script setup>

    import Menu from '@/Components/Menu.vue'
    import { usePage } from '@inertiajs/vue3';
    import { ref, reactive, onMounted } from 'vue';
    import axios from 'axios';

    const menusRole = reactive([])
    const reload = ref(0)
    const projectName = ref('')

    const page = usePage()

    const loadMenus = () => {
        axios.get('/api/menusRole')
            .then(response=>{
                response.data.forEach( (row, i) => {
                    menusRole[i] = row
                });
            })
            .catch(error=>{
                console.log(error)
            })
    }

    onMounted(() => {
        projectName.value = page.props.auth.currentProject[0].name
        loadMenus();
    })


</script>


