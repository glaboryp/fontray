<script setup>
import { onMounted, ref } from 'vue'

const model = defineModel({
  type: String,
  required: true,
})

const input = ref(null)

onMounted(() => {
  if (input.value.hasAttribute('autofocus')) {
    input.value.focus()
  }
})

defineExpose({ focus: () => input.value.focus() })
</script>

<template>
  <input
    ref="input"
    v-model="model"
    class="rounded-[var(--radius-panel)] bg-bench-800 border-bench-600 text-bench-100 placeholder-bench-500 shadow-none focus:border-index-500 focus:ring-index-500"
  />
</template>
