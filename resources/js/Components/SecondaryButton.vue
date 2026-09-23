<script setup>
defineProps({
  type: {
    type: String,
    default: 'button',
  },
})
</script>

<template>
  <button
    :type="type"
    class="inline-flex items-center rounded-[var(--radius-panel)] border border-bench-600 bg-transparent px-4 py-2 text-xs font-semibold uppercase tracking-widest text-bench-200 transition duration-150 ease-in-out hover:border-bench-400 focus:outline-none focus:ring-2 focus:ring-index-500 focus:ring-offset-2 focus:ring-offset-bench-900 disabled:opacity-25"
  >
    <slot />
  </button>
</template>
