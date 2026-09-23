<template>
  <AppLayout>
    <!-- Header -->
    <div class="bg-bench-950 border-b border-bench-800 py-12">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-3xl font-semibold text-bench-50 mb-2">
          Ejemplos y guía de uso
        </h1>
        <p class="text-bench-400">
          Qué tipos de imagen dan una lectura limpia, y cuáles quedan fuera de
          rango
        </p>
      </div>
    </div>

    <!-- Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
      <!-- Good Examples Section -->
      <div class="mb-20">
        <h2 class="text-2xl font-semibold text-bench-50 mb-8">
          Ejemplos recomendados
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          <!-- Example 1: Book Text -->
          <div
            class="bg-bench-900 border border-bench-700 rounded-[var(--radius-panel)] overflow-hidden"
          >
            <div
              class="h-44 bg-bench-950 flex items-center justify-center border-b border-bench-800"
            >
              <div class="text-center p-6 text-bench-100">
                <p class="text-xl font-semibold mb-2">Capítulo 1</p>
                <p class="text-sm leading-relaxed text-bench-300">
                  Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed
                  do eiusmod tempor incididunt ut labore.
                </p>
              </div>
            </div>
            <div class="p-4">
              <h3 class="font-semibold text-confirm mb-1">Texto de libro</h3>
              <p class="text-sm text-bench-400">
                Fuentes claras y legibles. Lectura limpia.
              </p>
            </div>
          </div>

          <!-- Example 2: Website Header -->
          <div
            class="bg-bench-900 border border-bench-700 rounded-[var(--radius-panel)] overflow-hidden"
          >
            <div
              class="h-44 bg-bench-950 flex items-center justify-center border-b border-bench-800"
            >
              <div class="text-center">
                <p class="text-2xl font-bold text-bench-50 mb-2">
                  TÍTULO PRINCIPAL
                </p>
                <p class="text-base text-bench-400">Subtítulo informativo</p>
              </div>
            </div>
            <div class="p-4">
              <h3 class="font-semibold text-confirm mb-1">Títulos web</h3>
              <p class="text-sm text-bench-400">
                Headers y titulares con buen contraste.
              </p>
            </div>
          </div>

          <!-- Example 3: Poster Text -->
          <div
            class="bg-bench-900 border border-bench-700 rounded-[var(--radius-panel)] overflow-hidden"
          >
            <div
              class="h-44 bg-bench-950 flex items-center justify-center border-b border-bench-800"
            >
              <div class="text-center p-4">
                <p class="text-xl font-bold text-bench-50 mb-1">CONFERENCIA</p>
                <p class="text-base text-bench-300">15 de octubre</p>
                <p class="text-sm text-bench-400">Auditorio principal</p>
              </div>
            </div>
            <div class="p-4">
              <h3 class="font-semibold text-confirm mb-1">
                Carteles y anuncios
              </h3>
              <p class="text-sm text-bench-400">
                Texto promocional con fuentes estándar.
              </p>
            </div>
          </div>
        </div>
      </div>

      <!-- Bad Examples Section -->
      <div class="mb-20">
        <h2 class="text-2xl font-semibold text-bench-50 mb-8">
          Ejemplos a evitar
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          <!-- Bad Example 1: Artistic Logo -->
          <div
            class="bg-bench-900 border border-bench-700 rounded-[var(--radius-panel)] overflow-hidden"
          >
            <div
              class="h-44 bg-bench-950 flex items-center justify-center border-b border-bench-800"
            >
              <div
                class="text-5xl font-bold transform -rotate-12 bg-danger text-white px-4 py-2 rounded-lg"
              >
                LOGO
              </div>
            </div>
            <div class="p-4">
              <h3 class="font-semibold text-danger mb-1">Logotipo artístico</h3>
              <p class="text-sm text-bench-400">
                Las letras son elementos gráficos, no texto legible.
              </p>
            </div>
          </div>

          <!-- Bad Example 2: Stylized Text -->
          <div
            class="bg-bench-900 border border-bench-700 rounded-[var(--radius-panel)] overflow-hidden"
          >
            <div
              class="h-44 bg-bench-950 flex items-center justify-center border-b border-bench-800"
            >
              <div class="text-center">
                <div
                  class="text-3xl font-bold bg-gradient-to-r from-purple-500 to-pink-500 bg-clip-text text-transparent transform skew-x-12"
                >
                  ESTILO
                </div>
                <div class="text-base text-bench-400 mt-2 transform -skew-x-6">
                  muy distorsionado
                </div>
              </div>
            </div>
            <div class="p-4">
              <h3 class="font-semibold text-danger mb-1">
                Texto distorsionado
              </h3>
              <p class="text-sm text-bench-400">
                Efectos y distorsiones dificultan la medición.
              </p>
            </div>
          </div>

          <!-- Bad Example 3: Decorative Letters -->
          <div
            class="bg-bench-900 border border-bench-700 rounded-[var(--radius-panel)] overflow-hidden"
          >
            <div
              class="h-44 bg-bench-950 flex items-center justify-center border-b border-bench-800"
            >
              <div class="flex gap-2">
                <div class="w-11 h-14 bg-bench-500 rounded-full" />
                <div class="w-7 h-14 bg-bench-500 rounded-lg" />
                <div class="w-11 h-14 bg-bench-500 rounded-full" />
                <div class="w-9 h-14 bg-bench-500 rounded-lg" />
              </div>
            </div>
            <div class="p-4">
              <h3 class="font-semibold text-danger mb-1">Letras decorativas</h3>
              <p class="text-sm text-bench-400">
                Formas abstractas donde no hay tipografía real.
              </p>
            </div>
          </div>
        </div>
      </div>

      <!-- Tips Section -->
      <div
        class="texture-steel bg-bench-900 border border-bench-700 rounded-[var(--radius-panel)] p-8 mb-16"
      >
        <h3 class="text-xl font-semibold text-bench-50 mb-6 text-center">
          Consejos principales
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-6">
          <div>
            <h4 class="font-medium text-bench-200 mb-3">¿Qué buscar?</h4>
            <ul class="space-y-2">
              <li
                v-for="tip in goodTips"
                :key="tip"
                class="flex items-start gap-2 text-sm text-bench-300"
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
                {{ tip }}
              </li>
            </ul>
          </div>

          <div>
            <h4 class="font-medium text-bench-200 mb-3">¿Qué evitar?</h4>
            <ul class="space-y-2">
              <li
                v-for="tip in badTips"
                :key="tip"
                class="flex items-start gap-2 text-sm text-bench-300"
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
                {{ tip }}
              </li>
            </ul>
          </div>
        </div>
      </div>

      <!-- CTA Section -->
      <div class="text-center">
        <h3 class="text-xl font-semibold text-bench-50 mb-3">
          ¿Listo para identificar una fuente?
        </h3>
        <p class="text-bench-400 mb-6">
          Prueba con tu propia imagen ahora que conoces qué funciona mejor.
        </p>
        <button
          class="bg-index-500 hover:bg-index-400 text-bench-950 px-8 py-3 rounded-[var(--radius-panel)] font-medium transition-colors cursor-pointer"
          @click="goToHome"
        >
          Subir mi imagen
        </button>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { router } from '@inertiajs/vue3'

const goodTips = [
  'Texto que puedas leer fácilmente',
  'Fuentes usadas en contenido editorial',
  'Títulos y subtítulos convencionales',
  'Buen contraste entre texto y fondo',
]

const badTips = [
  'Logotipos donde las letras son arte',
  'Texto con efectos extremos',
  'Lettering manual o caligrafía',
  'Caracteres muy estilizados',
]

const goToHome = () => {
  router.visit('/')
}
</script>
