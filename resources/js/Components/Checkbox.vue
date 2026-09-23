<script setup>
import { computed } from 'vue'

defineOptions({ name: 'BaseCheckbox' })

const emit = defineEmits(['update:checked'])

const props = defineProps({
  checked: {
    type: [Array, Boolean],
    required: true,
  },
  value: {
    type: [String, Number, Boolean, Object, Array],
    default: null,
  },
})

const proxyChecked = computed({
  get() {
    return props.checked
  },

  set(val) {
    emit('update:checked', val)
  },
})
</script>

<template>
  <input
    v-model="proxyChecked"
    type="checkbox"
    :value="value"
    class="rounded-[var(--radius-panel)] bg-bench-800 border-bench-600 text-index-500 shadow-none focus:ring-index-500"
  />
</template>
