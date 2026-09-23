<script setup>
defineOptions({ name: 'AppDashboard' })
import AppLayout from '@/Layouts/AppLayout.vue'
import { Head } from '@inertiajs/vue3'
</script>

<template>
  <Head title="Dashboard" />

  <AppLayout>
    <div class="bg-bench-950 border-b border-bench-800 py-10">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-2xl font-semibold text-bench-50">Dashboard</h1>
      </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
      <div
        class="bg-bench-900 border border-bench-700 rounded-[var(--radius-panel)] p-6 text-bench-200"
      >
        You're logged in!
      </div>
    </div>
  </AppLayout>
</template>
