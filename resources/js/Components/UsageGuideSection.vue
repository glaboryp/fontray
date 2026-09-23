<template>
  <section class="py-16 md:py-20 bg-bench-950">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
      <h2 class="text-2xl font-semibold text-bench-50 mb-2">
        Qué lee bien el instrumento
      </h2>
      <p class="text-bench-400 mb-10 max-w-2xl">
        La medición es tan precisa como la muestra que le des. Estas referencias
        determinan si una lectura sale limpia o fuera de rango.
      </p>

      <div class="grid md:grid-cols-2 gap-x-12 gap-y-8">
        <div>
          <h3
            class="text-xs font-mono uppercase tracking-wide text-confirm mb-3"
          >
            Lecturas válidas
          </h3>
          <ul class="divide-y divide-bench-800">
            <li
              v-for="item in validReads"
              :key="item.title"
              class="py-3 flex gap-3"
            >
              <svg
                class="w-4 h-4 text-confirm shrink-0 mt-0.5"
                viewBox="0 0 16 16"
                fill="none"
                aria-hidden="true"
              >
                <path
                  d="M3 8.5l3 3 7-7.5"
                  stroke="currentColor"
                  stroke-width="1.5"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                />
              </svg>
              <div>
                <p class="text-sm font-medium text-bench-100">
                  {{ item.title }}
                </p>
                <p class="text-sm text-bench-400">{{ item.detail }}</p>
              </div>
            </li>
          </ul>
        </div>

        <div>
          <h3
            class="text-xs font-mono uppercase tracking-wide text-danger mb-3"
          >
            Fuera de rango
          </h3>
          <ul class="divide-y divide-bench-800">
            <li
              v-for="item in outOfRange"
              :key="item.title"
              class="py-3 flex gap-3"
            >
              <svg
                class="w-4 h-4 text-danger shrink-0 mt-0.5"
                viewBox="0 0 16 16"
                fill="none"
                aria-hidden="true"
              >
                <path
                  d="M4 4l8 8m0-8l-8 8"
                  stroke="currentColor"
                  stroke-width="1.5"
                  stroke-linecap="round"
                />
              </svg>
              <div>
                <p class="text-sm font-medium text-bench-100">
                  {{ item.title }}
                </p>
                <p class="text-sm text-bench-400">{{ item.detail }}</p>
              </div>
            </li>
          </ul>
        </div>
      </div>

      <button
        class="mt-10 text-sm font-medium text-index-400 hover:text-index-300 transition-colors cursor-pointer inline-flex items-center gap-1.5"
        @click="goToExamples"
      >
        Ver guía completa con ejemplos
        <svg
          class="w-3.5 h-3.5"
          fill="none"
          stroke="currentColor"
          viewBox="0 0 24 24"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="1.5"
            d="M9 5l7 7-7 7"
          />
        </svg>
      </button>
    </div>
  </section>
</template>

<script setup>
import { router } from '@inertiajs/vue3'

const validReads = [
  {
    title: 'Texto claro y legible',
    detail: 'Nítido, bien enfocado y de resolución suficiente para leerlo.',
  },
  {
    title: 'Fondo contrastante',
    detail: 'El texto se distingue claramente del fondo.',
  },
  {
    title: 'Texto normal, no logotipos',
    detail: 'Párrafos, titulares o texto convencional, no artes gráficas.',
  },
  {
    title: 'Tamaño adecuado',
    detail: 'Las imágenes grandes se redimensionan automáticamente.',
  },
]

const outOfRange = [
  {
    title: 'Caracteres superpuestos',
    detail: 'Letras que se tocan o se solapan entre sí.',
  },
  {
    title: 'Imágenes borrosas',
    detail: 'La calidad debe bastar para leer el texto con claridad.',
  },
  {
    title: 'Logotipos muy estilizados',
    detail: 'Diseños donde las letras son formas artísticas, no tipografía.',
  },
  {
    title: 'Texto muy pequeño',
    detail: 'Debe ser lo bastante grande para medirse con precisión.',
  },
]

const goToExamples = () => router.visit('/examples')
</script>
