<script setup>
defineProps({
  value: {
    type: String,
    default: '',
  },
})
</script>

<template>
  <label class="block text-sm font-medium text-bench-300">
    <span v-if="value">{{ value }}</span>
    <span v-else><slot /></span>
  </label>
</template>
