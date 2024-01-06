<template>
    <div class="grid grid-cols-9 gap-2">
        <ul class="p-2 col-span-4 bg-white rounded-lg">
            <template v-for="dataL in leftDB">
                <li>
                    <input type="checkbox">
                    {{ dataL.name }}
                </li>
            </template>
            
        </ul>
        <div class="col-span-1">
            
        </div>
        <ul class="p-2 col-span-4 bg-white rounded-lg">
            <template v-for="dataR in rightDB">
                <li>
                    <input type="checkbox">
                    {{ dataR.name }}
                </li>
            </template>
            
        </ul>
    </div>
</template>
<script setup>  


    const props = defineProps({
        leftDB: Array,
        rightDB: Array,
    });


</script>