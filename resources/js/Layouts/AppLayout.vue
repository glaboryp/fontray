<template>
  <div class="min-h-screen bg-gray-50">
    <!-- Header/Navigation -->
    <header class="bg-white shadow-sm border-b border-gray-200">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
          <!-- Logo -->
          <div class="flex-shrink-0">
            <Link href="/" class="flex items-center">
              <span class="text-2xl font-bold text-indigo-600">Fontray</span>
              <span class="ml-2 text-gray-500 text-sm">🔤</span>
            </Link>
          </div>

          <!-- Navigation -->
          <nav class="hidden md:flex space-x-8">
            <Link 
              href="/" 
              class="text-gray-700 hover:text-indigo-600 px-3 py-2 rounded-md text-sm font-medium transition-colors"
              :class="{ 'text-indigo-600 bg-indigo-50': $page.component === 'Home' }"
            >
              Inicio
            </Link>
            <Link 
              href="/about" 
              class="text-gray-700 hover:text-indigo-600 px-3 py-2 rounded-md text-sm font-medium transition-colors"
            >
              Acerca de
            </Link>
          </nav>

          <!-- Mobile menu button -->
          <div class="md:hidden">
            <button
              @click="mobileMenuOpen = !mobileMenuOpen"
              class="text-gray-700 hover:text-indigo-600 focus:outline-none focus:text-indigo-600"
            >
              <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path v-if="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                <path v-else stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>
          </div>
        </div>

        <!-- Mobile menu -->
        <div v-show="mobileMenuOpen" class="md:hidden">
          <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3 border-t border-gray-200">
            <Link 
              href="/" 
              class="block text-gray-700 hover:text-indigo-600 px-3 py-2 rounded-md text-base font-medium"
              :class="{ 'text-indigo-600 bg-indigo-50': $page.component === 'Home' }"
            >
              Inicio
            </Link>
            <Link 
              href="/about" 
              class="block text-gray-700 hover:text-indigo-600 px-3 py-2 rounded-md text-base font-medium"
            >
              Acerca de
            </Link>
          </div>
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
            <span class="text-lg font-semibold text-gray-900">Fontray</span>
            <span class="ml-2 text-gray-500">🔤</span>
          </div>
          
          <div class="flex flex-col md:flex-row items-center space-y-2 md:space-y-0 md:space-x-6">
            <Link href="/privacy" class="text-sm text-gray-600 hover:text-indigo-600 transition-colors">
              Política de Privacidad
            </Link>
            <Link href="/terms" class="text-sm text-gray-600 hover:text-indigo-600 transition-colors">
              Términos de Servicio
            </Link>
            <span class="text-sm text-gray-500">
              © {{ currentYear }} Fontray. Todos los derechos reservados.
            </span>
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
        <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-indigo-600"></div>
        <span class="text-gray-700">Cargando...</span>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { Link } from '@inertiajs/vue3'

// Reactive data
const mobileMenuOpen = ref(false)

// Computed properties
const currentYear = computed(() => new Date().getFullYear())
</script>

<style scoped>
/* Custom styles if needed */
</style>
