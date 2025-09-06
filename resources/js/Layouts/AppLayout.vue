<template>
  <div class="min-h-screen bg-gray-50">
    <!-- Header/Navigation -->
    <header class="bg-white shadow-sm border-b border-gray-200">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Logo -->
        <div class="flex-shrink-0">
          <Link href="/" class="flex items-center">
            <img
              src="/images/logo_letras.png"
              alt="Fontray"
              class="h-16 w-auto"
            />
          </Link>
        </div>
      </div>
    </header>

    <!-- Main content -->
    <main class="flex-1">
      <slot />
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 mt-auto">
      <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row justify-between items-center">
          <div class="flex items-center mb-4 md:mb-0">
            <img src="/images/logo.png" alt="Fontray" class="h-6 w-auto mr-2" />
            <span class="text-lg font-semibold text-gray-900">Fontray</span>
          </div>

          <div class="flex flex-col items-center space-y-3">
            <div
              class="flex flex-col md:flex-row items-center space-y-2 md:space-y-0 md:space-x-6"
            >
              <Link
                href="/examples"
                class="text-sm text-gray-600 hover:text-primary transition-colors"
              >
                Ejemplos y Guía
              </Link>
              <Link
                href="/privacy"
                class="text-sm text-gray-600 hover:text-primary transition-colors"
              >
                Política de Privacidad
              </Link>
              <Link
                href="/terms"
                class="text-sm text-gray-600 hover:text-primary transition-colors"
              >
                Términos de Servicio
              </Link>
              <span class="text-sm text-gray-500">
                © {{ currentYear }} Fontray. Todos los derechos reservados.
              </span>
            </div>

            <!-- Powered by WhatFontIs -->
            <div class="flex items-center space-x-1 text-xs text-gray-500">
              <span>Powered by</span>
              <a
                href="https://www.whatfontis.com/API-identify-fonts-from-image.html"
                target="_blank"
                rel="noopener noreferrer"
                class="text-primary hover:text-primary-dark transition-colors font-medium"
              >
                WhatFontIs
              </a>
              <svg
                class="w-3 h-3 text-gray-400"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"
                />
              </svg>
            </div>
          </div>
        </div>
      </div>
    </footer>

    <!-- Loading overlay -->
    <div
      v-if="$page.props.loading"
      class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
    >
      <div class="bg-white rounded-lg p-6 flex items-center space-x-3">
        <div
          class="animate-spin rounded-full h-6 w-6 border-b-2 border-primary"
        />
        <span class="text-gray-700">Cargando...</span>
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue'
import { Link } from '@inertiajs/vue3'

// Computed properties
const currentYear = computed(() => new Date().getFullYear())
</script>
