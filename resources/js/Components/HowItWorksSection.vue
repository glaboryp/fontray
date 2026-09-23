<template>
  <section class="py-16 md:py-20 bg-bench-900">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
      <h2 class="text-2xl font-semibold text-bench-50 mb-12">
        Cómo funciona la medición
      </h2>

      <div class="grid grid-cols-1 md:grid-cols-3 gap-10 md:gap-8">
        <div
          v-for="step in steps"
          :key="step.number"
          class="relative pt-5 border-t border-bench-700"
        >
          <span
            class="absolute -top-px left-0 h-2.5 w-px bg-index-500"
            aria-hidden="true"
          />
          <span class="font-mono text-sm text-index-500 mb-2 block">
            {{ String(step.number).padStart(2, '0') }}
          </span>
          <h3 class="text-lg font-semibold text-bench-50 mb-2">
            {{ step.title }}
          </h3>
          <p class="text-sm text-bench-400 leading-relaxed">
            {{ step.description }}
          </p>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref } from 'vue'

const steps = ref([
  {
    number: 1,
    title: 'Carga la muestra',
    description:
      'Sube una imagen o PDF, o tómale una foto. JPG, PNG, WebP y PDF hasta 10 MB.',
  },
  {
    number: 2,
    title: 'Ajusta el encuadre',
    description:
      'Recorta y ajusta el contraste para aislar el texto antes de medir.',
  },
  {
    number: 3,
    title: 'Lee el resultado',
    description:
      'Recibe las fuentes candidatas ordenadas por confianza, con alternativas.',
  },
])
</script>
