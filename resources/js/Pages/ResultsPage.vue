<template>
  <AppLayout>
    <!-- Header Section -->
    <div class="bg-gradient-to-br from-primary to-primary-dark py-12">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
          <h1 class="text-4xl font-bold text-white mb-4">
            Resultados de Identificación
          </h1>
          <p class="text-xl text-primary-light">
            Hemos encontrado {{ totalFonts }} fuentes similares
          </p>
        </div>
      </div>
    </div>

    <!-- Results Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
      <!-- Loading State -->
      <div v-if="isLoading" class="text-center py-12">
        <div
          class="inline-block animate-spin rounded-full h-32 w-32 border-b-2 border-primary"
        />
        <p class="mt-4 text-lg text-gray-600">Cargando resultados...</p>
      </div>

      <!-- Error State -->
      <div v-else-if="hasError" class="text-center py-12">
        <div class="bg-red-50 border border-red-200 rounded-lg p-8">
          <div class="text-red-600 text-6xl mb-4">⚠️</div>
          <h2 class="text-2xl font-bold text-red-800 mb-4">
            Error al cargar resultados
          </h2>
          <p class="text-red-600 mb-6">{{ errorMessage }}</p>
          <button
            class="bg-primary hover:bg-primary-hover text-white px-6 py-3 rounded-lg font-semibold transition-colors"
            @click="goBack"
          >
            Volver a intentar
          </button>
        </div>
      </div>

      <!-- No Results State -->
      <div v-else-if="!hasFonts" class="text-center py-12">
        <div class="bg-gray-50 border border-gray-200 rounded-lg p-8">
          <div class="text-gray-400 text-6xl mb-4">🔍</div>
          <h2 class="text-2xl font-bold text-gray-800 mb-4">
            No se encontraron fuentes
          </h2>
          <p class="text-gray-600 mb-6">
            No pudimos identificar fuentes en tu imagen. Intenta con una imagen
            más clara o con texto más legible.
          </p>
          <button
            class="bg-primary hover:bg-primary-hover text-white px-6 py-3 rounded-lg font-semibold transition-colors"
            @click="goBack"
          >
            Subir nueva imagen
          </button>
        </div>
      </div>

      <!-- Results Grid -->
      <div v-else>
        <!-- Action Bar -->
        <div
          class="flex flex-col sm:flex-row justify-between items-center mb-8"
        >
          <button
            class="mb-4 sm:mb-0 flex items-center text-primary hover:text-primary-dark transition-colors cursor-pointer"
            @click="goBack"
          >
            <svg
              class="w-5 h-5 mr-2"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M10 19l-7-7m0 0l7-7m-7 7h18"
              />
            </svg>
            Subir nueva imagen
          </button>

          <div class="flex items-center space-x-4">
            <span class="text-gray-600">{{ totalFonts }} resultados</span>
            <select
              v-model="sortBy"
              class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-primary focus:border-transparent"
              @change="sortFonts"
            >
              <option value="name">Ordenar por nombre</option>
              <option value="similarity">Ordenar por similitud</option>
            </select>
          </div>
        </div>

        <!-- Fonts Grid -->
        <div
          class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6"
        >
          <div
            v-for="(font, index) in sortedFonts"
            :key="index"
            class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow border border-gray-200 overflow-hidden"
          >
            <!-- Font Preview Image -->
            <div class="aspect-w-16 aspect-h-9 bg-gray-100">
              <img
                v-if="font.preview"
                :src="font.preview"
                :alt="font.name"
                class="w-full h-48 object-cover"
                @error="handleImageError"
              />
              <div
                v-else
                class="w-full h-48 bg-gray-200 flex items-center justify-center"
              >
                <div class="text-center text-gray-500">
                  <div class="text-4xl mb-2">Aa</div>
                  <div class="text-sm">Vista previa no disponible</div>
                </div>
              </div>
            </div>

            <!-- Font Details -->
            <div class="p-4">
              <h3
                class="font-bold text-lg text-gray-900 mb-2 truncate"
                :title="font.name"
              >
                {{ font.name }}
              </h3>

              <div class="space-y-2 text-sm text-gray-600">
                <div v-if="font.category" class="flex items-center">
                  <span class="font-medium">Categoría:</span>
                  <span class="ml-2">{{ font.category }}</span>
                </div>

                <div v-if="font.foundry" class="flex items-center">
                  <span class="font-medium">Foundry:</span>
                  <span class="ml-2">{{ font.foundry }}</span>
                </div>

                <div class="flex items-center">
                  <span class="font-medium">Similitud:</span>
                  <span class="ml-2">{{ font.similarity }}%</span>
                </div>
              </div>

              <!-- Action Button -->
              <div class="mt-4">
                <a
                  v-if="font.link"
                  :href="font.link"
                  target="_blank"
                  rel="noopener noreferrer"
                  class="block w-full bg-primary hover:bg-primary-hover text-white text-center py-2 px-4 rounded-lg font-semibold transition-colors"
                >
                  Ver en WhatFontIs
                </a>
                <button
                  v-else
                  disabled
                  class="block w-full bg-gray-300 text-gray-500 text-center py-2 px-4 rounded-lg font-semibold cursor-not-allowed"
                >
                  Enlace no disponible
                </button>
              </div>
            </div>
          </div>
        </div>

        <!-- Back to Top Button -->
        <div class="text-center mt-12">
          <button
            class="bg-white border-2 border-primary text-primary hover:bg-primary hover:text-white px-6 py-3 rounded-lg font-semibold transition-colors shadow-md cursor-pointer"
            @click="scrollToTop"
          >
            Volver arriba
          </button>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { ref, computed, onMounted } from 'vue'
import { router, usePage } from '@inertiajs/vue3'

// Reactive data
const isLoading = ref(true)
const hasError = ref(false)
const errorMessage = ref('')
const fonts = ref([])
const sortBy = ref('similarity')

// Page props (datos pasados desde la navegación)
const page = usePage()

// Computed properties
const totalFonts = computed(() => fonts.value.length)
const hasFonts = computed(() => fonts.value.length > 0)

const sortedFonts = computed(() => {
  const fontsCopy = [...fonts.value]

  if (sortBy.value === 'name') {
    return fontsCopy.sort((a, b) => a.name.localeCompare(b.name))
  } else if (sortBy.value === 'similarity') {
    return fontsCopy.sort((a, b) => b.similarity - a.similarity)
  }

  return fontsCopy
})

// Methods
const loadResults = () => {
  try {
    // Obtener datos de los query parameters de la URL
    const urlParams = new window.URLSearchParams(window.location.search)
    const fontsParam = urlParams.get('fonts')

    if (fontsParam) {
      const parsedFonts = JSON.parse(decodeURIComponent(fontsParam))
      fonts.value = parsedFonts || []
    } else if (page.props.fonts) {
      // Fallback: usar props de Inertia si están disponibles
      fonts.value = page.props.fonts
    }

    isLoading.value = false
  } catch (error) {
    console.error('Error loading results:', error)
    hasError.value = true
    errorMessage.value =
      'Error al cargar los resultados. Por favor, inténtalo de nuevo.'
    isLoading.value = false
  }
}

const goBack = () => {
  router.visit('/')
}

const scrollToTop = () => {
  window.scrollTo({ top: 0, behavior: 'smooth' })
}

const sortFonts = () => {
  // El computed property se actualizará automáticamente
}

const handleImageError = event => {
  event.target.style.display = 'none'
  const nextElement = event.target.nextElementSibling
  if (nextElement) {
    nextElement.style.display = 'flex'
  }
}

// Lifecycle
onMounted(() => {
  loadResults()
})
</script>

<style scoped>
/* Estilos adicionales si son necesarios */
</style>
