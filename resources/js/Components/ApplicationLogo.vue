<template>
  <picture>
    <source srcset="/images/logo_letras.webp" type="image/webp" />
    <img
      src="/images/logo_letras.png"
      alt="Fontray"
      class="object-contain"
      width="680"
      height="382"
      v-bind="$attrs"
    />
  </picture>
</template>

<script setup>
// inheritAttrs: false hace que las clases del padre (h-9, w-auto…)
// no se apliquen al <picture> sino al <img> mediante v-bind="$attrs"
defineOptions({ inheritAttrs: false })
</script>
