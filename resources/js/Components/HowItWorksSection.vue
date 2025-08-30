<template>
  <section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="text-center mb-16">
        <h2 class="text-3xl font-bold text-gray-900 mb-4">¿Cómo funciona?</h2>
        <p class="text-lg text-gray-600 max-w-2xl mx-auto">
          Nuestro proceso es simple y eficiente. En solo tres pasos obtendrás la
          información que necesitas.
        </p>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
        <div v-for="step in steps" :key="step.number" class="text-center">
          <div
            class="bg-primary text-white rounded-full w-12 h-12 flex items-center justify-center mx-auto mb-6 text-xl font-bold"
          >
            {{ step.number }}
          </div>
          <h3 class="text-xl font-semibold text-gray-900 mb-4">
            {{ step.title }}
          </h3>
          <p class="text-gray-600">
            {{ step.description }}
          </p>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref } from 'vue'

// Data
const steps = ref([
  {
    number: 1,
    title: 'Sube tu imagen',
    description:
      'Selecciona una imagen con texto claro y bien definido. Formatos JPG, PNG y WebP son compatibles.',
  },
  {
    number: 2,
    title: 'Procesamos la imagen',
    description:
      'Nuestro sistema de IA analiza las características tipográficas y las compara con nuestra base de datos.',
  },
  {
    number: 3,
    title: 'Obtén resultados',
    description:
      'Recibe el nombre de la fuente, información adicional y sugerencias de fuentes similares.',
  },
])
</script>
