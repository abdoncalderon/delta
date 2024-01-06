<template>
    <div>
      <!-- Barra de búsqueda -->
      <div class="mb-4">
        <input v-model="searchTerm" class="p-2 border rounded" placeholder="Buscar..." />
      </div>
  
      <!-- Tabla de datos -->
      <table class="w-full border-collapse border border-gray-300">
        <!-- Encabezado de la tabla -->
        <thead>
          <tr>
            <th v-for="(column, index) in columns" :key="index" @click="sortColumn(column)">
              {{ column.label }} {{ columnSortIcon(column) }}
            </th>
          </tr>
        </thead>
  
        <!-- Cuerpo de la tabla -->
        <tbody>
          <tr v-for="(item, index) in paginatedData" :key="index" @click="selectRow(item)" :class="{ 'bg-gray-200': isSelected(item) }">
            <td v-for="(column, colIndex) in columns" :key="colIndex">{{ item[column.field] }}</td>
          </tr>
        </tbody>
      </table>
  
      <!-- Paginación -->
      <div class="mt-4">
        <span class="mr-2">Resultados por página:</span>
        <select v-model="pageSize" class="p-2 border rounded">
          <option value="10">10</option>
          <option value="20">20</option>
          <option value="30">30</option>
        </select>
  
        <button @click="goToPage(1)" :disabled="currentPage === 1" class="ml-2 p-2 border rounded" :class="{ 'bg-gray-300': currentPage === 1 }">Primera</button>
        <button @click="goToPage(currentPage - 1)" :disabled="currentPage === 1" class="ml-2 p-2 border rounded" :class="{ 'bg-gray-300': currentPage === 1 }">Anterior</button>
        <span class="ml-2 mr-2">{{ currentPage }} / {{ totalPages }}</span>
        <button @click="goToPage(currentPage + 1)" :disabled="currentPage === totalPages" class="ml-2 p-2 border rounded" :class="{ 'bg-gray-300': currentPage === totalPages }">Siguiente</button>
        <button @click="goToPage(totalPages)" :disabled="currentPage === totalPages" class="ml-2 p-2 border rounded" :class="{ 'bg-gray-300': currentPage === totalPages }">Última</button>
      </div>
    </div>
  </template>
  
  <script>
  import { ref, computed, watch } from 'vue';
  
  export default {
    props: {
      data: {
        type: Array,
        required: true,
      },
      columns: {
        type: Array,
        required: true,
      },
    },
    setup(props) {
      const searchTerm = ref('');
      const selectedRows = ref([]);
      const currentPage = ref(1);
      const pageSize = ref(10);
  
      const filteredData = computed(() => {
        const term = searchTerm.value.toLowerCase();
        return props.data.filter(item => {
          return props.columns.some(column => {
            return String(item[column.field]).toLowerCase().includes(term);
          });
        });
      });
  
      const sortedData = computed(() => {
        return filteredData.value.slice().sort((a, b) => {
          if (sortColumn.value.direction === 'asc') {
            return a[sortColumn.value.field] > b[sortColumn.value.field] ? 1 : -1;
          } else {
            return a[sortColumn.value.field] < b[sortColumn.value.field] ? 1 : -1;
          }
        });
      });
  
      const paginatedData = computed(() => {
        const start = (currentPage.value - 1) * pageSize.value;
        const end = start + pageSize.value;
        return sortedData.value.slice(start, end);
      });
  
      const totalPages = computed(() => {
        return Math.ceil(sortedData.value.length / pageSize.value);
      });
  
      const sortColumn = ref({ field: '', direction: '' });
  
      function columnSortIcon(column) {
        if (sortColumn.value.field === column.field) {
          return sortColumn.value.direction === 'asc' ? '▲' : '▼';
        } else {
          return '';
        }
      }
  
      function isSelected(row) {
        return selectedRows.value.includes(row);
      }
  
      function selectRow(row) {
        const index = selectedRows.value.indexOf(row);
        if (index === -1) {
          selectedRows.value.push(row);
        } else {
          selectedRows.value.splice(index, 1);
        }
      }
  
      function goToPage(page) {
        currentPage.value = Math.min(Math.max(page, 1), totalPages.value);
      }
  
      // Actualizar la página actual cuando cambia la cantidad de resultados por página
      watch([pageSize, sortedData], () => {
        currentPage.value = 1;
      });
  
      return {
        searchTerm,
        selectedRows,
        currentPage,
        pageSize,
        filteredData,
        sortedData,
        paginatedData,
        totalPages,
        sortColumn,
        columnSortIcon,
        isSelected,
        selectRow,
        goToPage,
      };
    },
  };
  </script>
  
  <style scoped>
  /* Estilos Tailwind CSS o personalizados para el componente */
  </style>

<!-- const tableData = [
  { id: 1, name: 'John Doe', age: 30, country: 'USA' },
  { id: 2, name: 'Jane Doe', age: 25, country: 'Canada' },
  { id: 3, name: 'Bob Smith', age: 35, country: 'UK' },
  // Agrega más datos según tus necesidades
]

const tableColumns = [
  { label: 'ID', field: 'id' },
  { label: 'Nombre', field: 'name' },
  { label: 'Edad', field: 'age' },
  { label: 'País', field: 'country' },
] -->

