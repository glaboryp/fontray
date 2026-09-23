<script setup>
import { Link } from '@inertiajs/vue3'

defineProps({
  href: {
    type: String,
    required: true,
  },
})
</script>

<template>
  <Link
    :href="href"
    class="block w-full px-4 py-2 text-start text-sm leading-5 text-bench-200 transition duration-150 ease-in-out hover:bg-bench-700 hover:text-bench-50 focus:bg-bench-700 focus:outline-none"
  >
    <slot />
  </Link>
</template>
