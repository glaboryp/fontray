<template>
  <section class="bg-gradient-to-br from-primary-light via-white to-cyan-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
      <div class="text-center">
        <h1 class="text-4xl md:text-6xl font-bold text-gray-900 mb-6">
          Identifica cualquier
          <span class="text-primary">fuente</span>
          al instante
        </h1>
        <p class="text-xl text-gray-600 mb-8 max-w-3xl mx-auto">
          Sube una imagen con texto y descubre qué fuente tipográfica se está
          utilizando. Rápido, preciso y completamente gratuito.
        </p>

        <!-- CTA Button -->
        <div class="mb-12">
          <button
            class="bg-primary hover:bg-primary-dark text-white font-semibold py-4 px-8 rounded-lg text-lg transition-colors shadow-lg hover:shadow-xl cursor-pointer"
            @click="$emit('scrollToUploader')"
          >
            Comenzar ahora
            <svg
              class="inline-block ml-2 w-5 h-5"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M19 14l-7 7m0 0l-7-7m7 7V3"
              />
            </svg>
          </button>
        </div>

        <FeaturesGrid />
      </div>
    </div>
  </section>
</template>

<script setup>
import FeaturesGrid from './FeaturesGrid.vue'

// Emits
defineEmits(['scrollToUploader'])
</script>
