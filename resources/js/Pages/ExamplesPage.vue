<template>
  <AppLayout>
    <!-- Header Section -->
    <div class="bg-gradient-to-br from-primary to-primary-dark py-12">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
          <h1 class="text-4xl font-bold text-white mb-4">
            Ejemplos y Guía de Uso
          </h1>
          <p class="text-xl text-primary-light">
            Aprende qué tipos de imágenes funcionan mejor para identificar
            fuentes
          </p>
        </div>
      </div>
    </div>

    <!-- Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
      <!-- Good Examples Section -->
      <div class="mb-16">
        <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center">
          ✅ Ejemplos Recomendados
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
          <!-- Example 1: Book Text -->
          <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="h-48 bg-gray-100 flex items-center justify-center">
              <div class="text-center p-6">
                <h3 class="text-2xl font-serif mb-2">Capítulo 1</h3>
                <p class="text-sm leading-relaxed">
                  Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed
                  do eiusmod tempor incididunt ut labore.
                </p>
              </div>
            </div>
            <div class="p-4">
              <h4 class="font-semibold text-green-800 mb-2">Texto de Libro</h4>
              <p class="text-sm text-gray-600">
                Fuentes tipográficas claras y legibles. Perfecto para
                identificación.
              </p>
            </div>
          </div>

          <!-- Example 2: Website Header -->
          <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="h-48 bg-blue-50 flex items-center justify-center">
              <div class="text-center">
                <h3 class="text-3xl font-bold text-blue-900 mb-2">
                  TÍTULO PRINCIPAL
                </h3>
                <p class="text-lg text-blue-700">Subtítulo informativo</p>
              </div>
            </div>
            <div class="p-4">
              <h4 class="font-semibold text-green-800 mb-2">Títulos Web</h4>
              <p class="text-sm text-gray-600">
                Headers y títulos con buena legibilidad y contraste.
              </p>
            </div>
          </div>

          <!-- Example 3: Poster Text -->
          <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="h-48 bg-red-100 flex items-center justify-center">
              <div class="text-center p-4">
                <h3 class="text-2xl font-bold text-red-900 mb-2">
                  CONFERENCIA
                </h3>
                <p class="text-lg text-red-700">15 de Octubre</p>
                <p class="text-sm text-red-600">Auditorio Principal</p>
              </div>
            </div>
            <div class="p-4">
              <h4 class="font-semibold text-green-800 mb-2">
                Carteles y Anuncios
              </h4>
              <p class="text-sm text-gray-600">
                Texto promocional con fuentes estándar y buen contraste.
              </p>
            </div>
          </div>
        </div>
      </div>

      <!-- Bad Examples Section -->
      <div class="mb-16">
        <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center">
          ❌ Ejemplos a Evitar
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
          <!-- Bad Example 1: Artistic Logo -->
          <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="h-48 bg-yellow-200 flex items-center justify-center">
              <div
                class="text-6xl font-bold transform -rotate-12 bg-red-500 text-white px-4 py-2 rounded-lg shadow-xl"
              >
                LOGO
              </div>
            </div>
            <div class="p-4">
              <h4 class="font-semibold text-red-800 mb-2">
                Logotipo Artístico
              </h4>
              <p class="text-sm text-gray-600">
                Diseño donde las letras son elementos gráficos, no texto
                legible.
              </p>
            </div>
          </div>

          <!-- Bad Example 2: Stylized Text -->
          <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="h-48 bg-purple-100 flex items-center justify-center">
              <div class="text-center">
                <div
                  class="text-4xl font-bold bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent transform skew-x-12"
                >
                  ESTILO
                </div>
                <div class="text-lg text-purple-600 mt-2 transform -skew-x-6">
                  muy distorsionado
                </div>
              </div>
            </div>
            <div class="p-4">
              <h4 class="font-semibold text-red-800 mb-2">
                Texto Distorsionado
              </h4>
              <p class="text-sm text-gray-600">
                Efectos y distorsiones que dificultan la identificación.
              </p>
            </div>
          </div>

          <!-- Bad Example 3: Decorative Letters -->
          <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="h-48 bg-green-100 flex items-center justify-center">
              <div class="flex space-x-2">
                <div class="w-12 h-16 bg-green-600 rounded-full" />
                <div class="w-8 h-16 bg-green-600 rounded-lg" />
                <div class="w-12 h-16 bg-green-600 rounded-full" />
                <div class="w-10 h-16 bg-green-600 rounded-lg" />
              </div>
            </div>
            <div class="p-4">
              <h4 class="font-semibold text-red-800 mb-2">
                Letras Decorativas
              </h4>
              <p class="text-sm text-gray-600">
                Cuando las letras son formas abstractas o decorativas.
              </p>
            </div>
          </div>
        </div>
      </div>

      <!-- Tips Section -->
      <div class="bg-blue-50 border border-blue-200 rounded-lg p-8 mb-12">
        <h3 class="text-2xl font-bold text-blue-900 mb-6 text-center">
          Consejos Principales
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
          <div>
            <h4 class="font-semibold text-blue-800 mb-4">¿Qué buscar?</h4>
            <ul class="space-y-2 text-blue-700">
              <li class="flex items-start">
                <span class="text-green-500 mr-2">✓</span>
                Texto que puedas leer fácilmente
              </li>
              <li class="flex items-start">
                <span class="text-green-500 mr-2">✓</span>
                Fuentes utilizadas en contenido editorial
              </li>
              <li class="flex items-start">
                <span class="text-green-500 mr-2">✓</span>
                Títulos y subtítulos convencionales
              </li>
              <li class="flex items-start">
                <span class="text-green-500 mr-2">✓</span>
                Buen contraste entre texto y fondo
              </li>
            </ul>
          </div>

          <div>
            <h4 class="font-semibold text-blue-800 mb-4">¿Qué evitar?</h4>
            <ul class="space-y-2 text-blue-700">
              <li class="flex items-start">
                <span class="text-red-500 mr-2">✗</span>
                Logotipos donde las letras son arte
              </li>
              <li class="flex items-start">
                <span class="text-red-500 mr-2">✗</span>
                Texto con efectos extremos
              </li>
              <li class="flex items-start">
                <span class="text-red-500 mr-2">✗</span>
                Lettering manual o caligrafía
              </li>
              <li class="flex items-start">
                <span class="text-red-500 mr-2">✗</span>
                Caracteres muy estilizados
              </li>
            </ul>
          </div>
        </div>
      </div>

      <!-- CTA Section -->
      <div class="text-center">
        <h3 class="text-2xl font-bold text-gray-900 mb-4">
          ¿Listo para identificar una fuente?
        </h3>
        <p class="text-lg text-gray-600 mb-6">
          Ahora que conoces los mejores tipos de imágenes, ¡prueba con tu propia
          imagen!
        </p>
        <button
          class="bg-primary hover:bg-primary-hover text-white px-8 py-3 rounded-lg font-semibold transition-colors shadow-lg cursor-pointer"
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

const goToHome = () => {
  router.visit('/')
}
</script>

<style scoped>
/* Estilos adicionales si son necesarios */
</style>
