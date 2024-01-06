<template>
    <div class="relative">
        <!-- Combo Select -->
        <input
            v-model="searchTerm"
            @input="filterOptions"
            @focus="showOptions"
            @blur="hideOptions"
            placeholder="Selecciona una opción"
            class="w-full p-2 border rounded"
        />
    
        <!-- Opciones filtradas -->
        <div v-if="filteredOptions.length > 0 && isOptionsVisible" class="absolute top-full left-0 w-full bg-white shadow mt-1">
            <ul class="border rounded max-h-32 overflow-y-auto">
            <li v-for="(option, index) in filteredOptions" :key="index" @click="selectOption(option)">
                {{ option }}
            </li>
            </ul>
        </div>
        </div>
  </template>
  
  <script>

  import { ref, watch } from 'vue';
  
  export default {
        data() {
        return {
            options: ['Manzana', 'Banana', 'Cereza', 'Dátil', 'Uva'], // Tus opciones
            searchTerm: '',
            filteredOptions: [],
            isOptionsVisible: false,
        };
        },
        methods: {
        filterOptions() {
            this.filteredOptions = this.options.filter(option =>
            option.toLowerCase().includes(this.searchTerm.toLowerCase())
            );
        },
        showOptions() {
            this.isOptionsVisible = true;
        },
        hideOptions() {
            this.isOptionsVisible = false;
        },
        selectOption(option) {
            this.searchTerm = option;
            this.isOptionsVisible = false;
        },
        },
        watch: {
        searchTerm() {
            this.filterOptions();
        },
        },
    };
  </script>
  
  