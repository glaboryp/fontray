<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
</script>

<template>
  <AppLayout>
    <div
      class="bg-bench-950 flex flex-col items-center pt-6 sm:justify-center sm:pt-12 pb-12 min-h-[70vh]"
    >
      <div
        class="texture-steel mt-6 w-full overflow-hidden bg-bench-900 px-6 py-8 sm:max-w-md rounded-[var(--radius-panel)] border border-bench-700"
      >
        <slot />
      </div>
    </div>
  </AppLayout>
</template>
