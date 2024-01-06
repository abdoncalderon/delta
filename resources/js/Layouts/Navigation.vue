<template>
    <div :class="$page.props.showingMobileMenu ? 'block' : 'hidden'" @click="$page.props.showingMobileMenu = false"
         class="fixed inset-0 z-20 bg-black opacity-50 transition-opacity lg:hidden">
    </div>

    <div :class="$page.props.showingMobileMenu ? 'translate-x-0 ease-out' : '-translate-x-full ease-in'" class="fixed inset-y-0 left-0 z-30 w-64 bg-gray-800 transition duration-300 transform lg:translate-x-0 lg:static lg:inset-0">
        <!-- Logo -->
        <img class="object-cover h-16 w-full" src="http://delta.test/storage/kapatax/logo.jpg" alt="">

        <hr class="border border-gray-700">

        <div class="grid px-3 text-center h-10 content-center">
            <p class="text-white text-xs">{{ projectName }}</p>
        </div>

        <hr class="border border-gray-700">

        <ul class="my-1 text-white">
            <li class="hover:bg-gray-900">
                <Link class="flex px-4 py-1.5 text-sm " :href="route('myNeedRequests.index')"> 
                    <span class="w-80">
                        <i class="fa fa-shopping-cart"></i> 
                        <span class="mx-3"> 
                            {{ $trnsl('content.myRequests') }} 
                        </span>
                    </span> 
                    <p v-if="myNeedRequests > 0" class="bg-white px-2 text-xs self-center text-black rounded-xl text-right">{{ myNeedRequests }}</p>
                </Link>
            </li>
            <li class="hover:bg-gray-900">
                <Link class="flex px-4 py-1.5 text-sm" :href="route('myApprovals.index')"> 
                    <span class="w-80">
                        <i class="fa fa-check"></i> 
                        <span class="mx-3"> 
                            {{ $trnsl('content.myApprovals') }} 
                        </span>
                    </span> 
                    <p v-if="myApprovals > 0" class="bg-white px-2 text-xs self-center text-black rounded-xl text-right">{{ myApprovals }}</p>
                </Link>
            </li>
            <li class="hover:bg-gray-900">
                <Link class="flex px-4 py-1.5 text-sm" :href="route('myAssignments.index')"> 
                    <span class="w-80">
                        <i class="fa fa-toolbox"></i> 
                        <span class="mx-3"> 
                            {{ $trnsl('content.myTools') }} 
                        </span>
                    </span> 
                </Link>
            </li>

            <li class="hover:bg-gray-900">
                <Link class="flex px-4 py-1.5 text-sm" :href="route('myQuotationRequests.index')"> 
                    <span class="w-80">
                        <i class="fa fa-inbox"></i> 
                        <span class="mx-3"> 
                            {{ $trnsl('content.quotationRequests') }} 
                        </span>
                    </span> 
                    <p v-if="myQuotationRequests > 0" class="bg-white px-2 text-xs self-center text-black rounded-xl text-right">{{ myQuotationRequests }}</p>
                </Link>
            </li>

            <li class="hover:bg-gray-900">
                <Link class="flex px-4 py-1.5 text-sm" :href="route('myQuotations.index')"> 
                    <span class="w-80">
                        <i class="fa fa-circle-dollar-to-slot"></i> 
                        <span class="mx-3"> 
                            {{ $trnsl('content.myQuotations') }} 
                        </span>
                    </span> 
                </Link>
            </li>
            
        </ul>
        
        <hr class="border border-gray-700">

        <!-- Menu -->
        <div class="bg-gray-800">
            <Menu
                
                :menus="menusRole"
            />
        </div>
       
    </div>

</template>

<script setup>

    import Menu from '@/Components/Menu.vue'
    import { usePage, Link } from '@inertiajs/vue3'
    import { ref, onMounted } from 'vue'
    

    const projectName = ref('')
    const myNeedRequests = ref(0)
    const myApprovals = ref(0)
    const myQuotationRequests = ref(0)

    const page = usePage()
    
    let menusRole = []

    onMounted(() => {
        projectName.value = page.props.auth.currentProject.name
        menusRole = page.props.auth.menusRole
        myNeedRequests.value = page.props.auth.myNeedRequests
        myApprovals.value = page.props.auth.myApprovals
        myQuotationRequests.value = page.props.auth.myQuotationRequests
        
    })

</script>


