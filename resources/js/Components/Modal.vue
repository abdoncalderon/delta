<template>
    
    <div v-if="showModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-75">
      <div :style="style" class="m-2 bg-white rounded shadow overflow-hidden">
        <!-- <div :style="{ 'width': modalWidth, 'height': modalHeight }" class="bg-white rounded shadow overflow-hidden"> -->
        <!-- Barra de título -->
        <div class="flex items-center justify-between bg-gray-700 p-2 rounded-t">
            <div class="flex items-center">
                
                <!-- Título de la modal -->
                <div class="font-semibold text-sm text-white">{{ title }}</div>

            </div>
            <!-- Botón de cerrar -->
            <button @click="closeModal" class="text-white hover:text-red-500">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <!-- Contenido de la modal -->
        <slot></slot>
  
        <!-- Botón de cerrar la modal -->
        
      </div>
    </div>
  </template>
  
  <script setup>

    import { ref } from 'vue';

    const props = defineProps({
        showModal: {
            type: Boolean,
            required: true,
        },
        title: {
            type: String,
            default: 'My Window',
        },
        modalWidth: {
            type: String,
            default: 'auto',
        },
        modalHeight: {
            type: String,
            default: 'auto',
        },
    })

    const emit = defineEmits(['closeModal'])

    const closeModal = () => {
        emit('closeModal');
    };

    const style = {
        'width': props.modalWidth,
        'height': props.modalHeight
    }
  
  </script>
  
  