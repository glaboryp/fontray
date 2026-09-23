<template>
  <AppLayout>
    <!-- Header -->
    <div class="bg-bench-950 border-b border-bench-800 py-12">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-3xl font-semibold text-bench-50 mb-2">
          Resultados de la medición
        </h1>
        <p class="text-bench-400">
          {{ totalFonts }} fuente(s) candidata(s), ordenadas por confianza
        </p>
      </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
      <!-- Loading State -->
      <div v-if="isLoading" class="text-center py-20">
        <div
          class="inline-block animate-spin rounded-full h-10 w-10 border-2 border-bench-700 border-t-index-500"
        />
        <p class="mt-4 text-bench-400">Cargando resultados…</p>
      </div>

      <!-- Error State -->
      <div v-else-if="hasError" class="text-center py-12">
        <div
          class="texture-steel bg-bench-900 border border-bench-700 rounded-[var(--radius-panel)] p-8 max-w-lg mx-auto"
        >
          <svg
            class="w-10 h-10 text-danger mx-auto mb-4"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
            aria-hidden="true"
          >
            <circle cx="12" cy="12" r="9" stroke-width="1.5" />
            <path
              d="M12 8v5M12 16h.01"
              stroke-width="1.5"
              stroke-linecap="round"
            />
          </svg>
          <h2 class="text-xl font-semibold text-bench-50 mb-3">
            Error al cargar resultados
          </h2>
          <p class="text-bench-300 mb-6">{{ errorMessage }}</p>
          <button
            class="bg-index-500 hover:bg-index-400 text-bench-950 px-6 py-2.5 rounded-[var(--radius-panel)] font-medium transition-colors cursor-pointer"
            @click="goBack"
          >
            Volver a intentar
          </button>
        </div>
      </div>

      <!-- No Results State -->
      <div v-else-if="!hasFonts" class="text-center py-12">
        <div
          class="texture-steel bg-bench-900 border border-bench-700 rounded-[var(--radius-panel)] p-8 max-w-lg mx-auto"
        >
          <svg
            class="w-10 h-10 text-bench-400 mx-auto mb-4"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
            aria-hidden="true"
          >
            <circle cx="11" cy="11" r="7" stroke-width="1.5" />
            <path
              d="M21 21l-4.3-4.3"
              stroke-width="1.5"
              stroke-linecap="round"
            />
          </svg>
          <h2 class="text-xl font-semibold text-bench-50 mb-3">
            No se encontraron fuentes
          </h2>
          <p class="text-bench-300 mb-6">
            No pudimos identificar fuentes en tu imagen. Intenta con una imagen
            más clara o con texto más legible.
          </p>
          <button
            class="bg-index-500 hover:bg-index-400 text-bench-950 px-6 py-2.5 rounded-[var(--radius-panel)] font-medium transition-colors cursor-pointer"
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
          class="flex flex-col sm:flex-row justify-between items-center gap-4 mb-8"
        >
          <button
            class="flex items-center gap-2 text-bench-300 hover:text-bench-50 transition-colors cursor-pointer text-sm"
            @click="goBack"
          >
            <svg
              class="w-4 h-4"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="1.5"
                d="M10 19l-7-7m0 0l7-7m-7 7h18"
              />
            </svg>
            Subir nueva imagen
          </button>

          <div class="flex items-center gap-3">
            <span class="text-sm font-mono text-bench-400">
              {{ totalFonts }} resultados
            </span>
            <select
              v-model="sortBy"
              class="bg-bench-900 border border-bench-600 rounded-[var(--radius-panel)] px-3 py-1.5 text-sm text-bench-100 focus:outline-none focus:border-index-500"
              @change="sortFonts"
            >
              <option value="name">Ordenar por nombre</option>
              <option value="similarity">Ordenar por confianza</option>
            </select>
          </div>
        </div>

        <!-- Fonts Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
          <div
            v-for="(font, index) in sortedFonts"
            :key="index"
            class="bg-bench-900 rounded-[var(--radius-panel)] border border-bench-700 overflow-hidden flex flex-col"
          >
            <!-- Font Preview Image -->
            <div class="bg-bench-950 border-b border-bench-800">
              <img
                v-if="font.preview"
                :src="font.preview"
                :alt="font.name"
                class="w-full h-40 object-contain"
                @error="handleImageError"
              />
              <div v-else class="w-full h-40 flex items-center justify-center">
                <div class="text-center text-bench-300">
                  <div class="text-3xl font-semibold mb-1">Aa</div>
                  <div class="text-xs">Vista previa no disponible</div>
                </div>
              </div>
            </div>

            <!-- Font Details -->
            <div class="p-4 flex-1 flex flex-col">
              <h2
                class="font-semibold text-bench-50 mb-2 truncate"
                :title="font.name"
              >
                {{ font.name }}
              </h2>

              <div class="space-y-1.5 text-sm text-bench-400 mb-3">
                <div v-if="font.category" class="flex items-center gap-1.5">
                  <span class="text-bench-300">Categoría:</span>
                  <span>{{ font.category }}</span>
                </div>
                <div v-if="font.foundry" class="flex items-center gap-1.5">
                  <span class="text-bench-300">Foundry:</span>
                  <span>{{ font.foundry }}</span>
                </div>
              </div>

              <!-- Confidence readout -->
              <div class="mb-4">
                <div class="flex items-center justify-between mb-1">
                  <span class="text-xs text-bench-300">Confianza</span>
                  <span class="text-xs font-mono text-index-400">
                    {{ font.similarity }}%
                  </span>
                </div>
                <div class="h-1 bg-bench-800 rounded-full overflow-hidden">
                  <div
                    class="h-full bg-index-500 rounded-full"
                    :style="{ width: `${font.similarity}%` }"
                  />
                </div>
              </div>

              <!-- Action Button -->
              <div class="mt-auto">
                <a
                  v-if="font.link"
                  :href="font.link"
                  target="_blank"
                  rel="noopener noreferrer"
                  class="block w-full bg-index-500 hover:bg-index-400 text-bench-950 text-center py-2 px-4 rounded-[var(--radius-panel)] font-medium transition-colors text-sm"
                >
                  Ver en WhatFontIs
                </a>
                <button
                  v-else
                  disabled
                  class="block w-full bg-bench-800 text-bench-300 text-center py-2 px-4 rounded-[var(--radius-panel)] font-medium cursor-not-allowed text-sm"
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
            class="bg-transparent border border-bench-600 hover:border-bench-400 text-bench-200 px-6 py-2.5 rounded-[var(--radius-panel)] font-medium transition-colors cursor-pointer text-sm"
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
    const errorParam = urlParams.get('error')
    const fontsParam = urlParams.get('fonts')

    if (errorParam) {
      hasError.value = true
      errorMessage.value = decodeURIComponent(errorParam)
      isLoading.value = false
      return
    }

    if (fontsParam) {
      const parsedFonts = JSON.parse(decodeURIComponent(fontsParam))
      fonts.value = parsedFonts || []
    } else if (window.history?.state?.fonts) {
      const historyStateFonts = window.history.state.fonts
      fonts.value = Array.isArray(historyStateFonts)
        ? historyStateFonts
        : JSON.parse(historyStateFonts)
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
