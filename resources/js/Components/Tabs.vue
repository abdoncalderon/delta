<template>
    <div class="m-2">
        <ul class="flex flex-wrap">
            <template v-for="(tab,i) in tabs" :key="i">
                <li 
                    v-if="actives[i]"
                    class="inline mr-0.5 px-3 py-1 text-xs rounded-tr-lg hover:bg-gray-700 hover:text-white bg-gray-600 text-white"
                    @click="select(tab, i)"
                >{{ tab.text }} </li>
                <li 
                    v-else
                    class="inline mr-0.5 px-3 py-1 text-xs border border-gray-400  rounded-tr-lg hover:bg-gray-600 hover:text-white"
                    @click="select(tab, i)"
                >{{ tab.text }} </li>
            </template>
        </ul>

        <div class="border border-gray-500 rounded-b-lg">
            <slot :name="slot" /> 
        </div>
    </div>
</template>
<script setup>
    import { ref, reactive, onMounted } from 'vue';

    const props = defineProps ({
        tabs: Array,
    })

    const slot = ref('')

    const actives = reactive([])

    const select = (tab, pos) => {
        slot.value = tab.name
        inactiveAll()
        actives[pos] = true
    }

    const inactiveAll = () => {
        actives.length = 0
        props.tabs.forEach( () => {
            actives.push(false)
        })
    }

    onMounted(() => {
        slot.value = props.tabs[0].name
        inactiveAll()
        actives[0] = true
    })

</script>