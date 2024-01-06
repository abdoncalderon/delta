<template>
    <div>
        <select name="year" id="year">
            <option v-for="year in years" :key="option.id" :value="option[idField]">{{ option[showField] }}</option>
        </select>
    </div>

</template>
<script setup>

</script>