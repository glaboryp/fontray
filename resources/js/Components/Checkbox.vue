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
    class="rounded border-gray-300 text-primary shadow-sm focus:ring-primary"
  />
</template>
