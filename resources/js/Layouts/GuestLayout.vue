<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
</script>

<template>
  <AppLayout>
    <div
      class="flex flex-col items-center pt-6 sm:justify-center sm:pt-12 pb-12"
    >
      <div
        class="mt-6 w-full overflow-hidden bg-white px-6 py-8 shadow-sm sm:max-w-md sm:rounded-lg border border-gray-200"
      >
        <slot />
      </div>
    </div>
  </AppLayout>
</template>
