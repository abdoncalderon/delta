<template>
    <div v-if="show" class="fixed inset-0 flex items-end justify-center px-4 py-6 pointer-events-none sm:p-6 sm:items-start sm:justify-end">
        <!-- Notification Panel -->
        <div v-if="show" class="bg-white shadow-lg rounded-lg pointer-events-auto ring-1 ring-black ring-opacity-5 overflow-hidden">
            <div class="w-full p-2 bg-black text-white text-xs">
                {{ title }}
            </div>
            <div class="p-2">
                <!-- Content of the Notification -->
                <div class="text-xs">
                  {{ message }}
                </div>
            </div>
            <div class="my-1 flex bg-gray-50 justify-center ">
                <!-- Close button -->
                <button @click="close" type="button" class="px-2 py-1 bg-gray-500 text-white text-xs rounded">
                    OK
                </button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
  props: {
    title: String,
    message: String,
  },
  data() {
    return {
      show: false,
      
    };
  },
  methods: {
    open() {
      this.show = true;
      // Auto-close after 5 seconds (adjust as needed)
      /* setTimeout(() => {
        this.close();
      }, 5000); */
    },
    close() {
      this.show = false;
    }
  }
};
</script>

<style scoped>
/* Add Tailwind CSS classes or your custom styles here */
</style>


