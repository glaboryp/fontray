<template>
  <div class="min-h-screen flex flex-col bg-gray-50">
    <!-- Header/Navigation -->
    <header class="bg-white shadow-sm border-b border-gray-200">
      <div
        class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3 flex items-center justify-between"
      >
        <!-- Logo -->
        <div class="flex-shrink-0 flex items-center">
          <Link href="/" class="flex items-center">
            <img
              src="/images/logo_letras.png"
              alt="Fontray"
              class="h-16 w-auto"
            />
          </Link>
        </div>

        <!-- Auth Navigation -->
        <nav class="flex items-center space-x-4">
          <template v-if="$page.props.auth?.user">
            <div class="hidden sm:flex sm:items-center">
              <Dropdown align="right" width="48">
                <template #trigger>
                  <span class="inline-flex rounded-md">
                    <button
                      type="button"
                      class="inline-flex items-center rounded-md border border-transparent bg-white px-3 py-2 text-sm font-medium leading-4 text-gray-700 transition duration-150 ease-in-out hover:text-primary focus:outline-none"
                    >
                      {{ $page.props.auth.user.name }}

                      <svg
                        class="-me-0.5 ms-2 h-4 w-4"
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 20 20"
                        fill="currentColor"
                      >
                        <path
                          fill-rule="evenodd"
                          d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                          clip-rule="evenodd"
                        />
                      </svg>
                    </button>
                  </span>
                </template>

                <template #content>
                  <DropdownLink :href="route('history')">
                    Historial de búsquedas
                  </DropdownLink>
                  <DropdownLink
                    :href="route('logout')"
                    method="post"
                    as="button"
                  >
                    Cerrar sesión
                  </DropdownLink>
                </template>
              </Dropdown>
            </div>

            <div class="flex items-center sm:hidden">
              <button
                class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out"
                :aria-expanded="showingNavigationDropdown"
                aria-label="Toggle navigation menu"
                @click="showingNavigationDropdown = !showingNavigationDropdown"
              >
                <svg
                  class="h-6 w-6"
                  stroke="currentColor"
                  fill="none"
                  viewBox="0 0 24 24"
                >
                  <path
                    :class="{
                      hidden: showingNavigationDropdown,
                      'inline-flex': !showingNavigationDropdown,
                    }"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M4 6h16M4 12h16M4 18h16"
                  />
                  <path
                    :class="{
                      hidden: !showingNavigationDropdown,
                      'inline-flex': showingNavigationDropdown,
                    }"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M6 18L18 6M6 6l12 12"
                  />
                </svg>
              </button>
            </div>
          </template>
          <template v-else>
            <!-- Desktop Links -->
            <div class="hidden sm:flex items-center space-x-4">
              <Link
                :href="route('login')"
                class="text-sm font-medium text-gray-700 hover:text-primary transition-colors"
              >
                Iniciar sesión
              </Link>
              <Link
                :href="route('register')"
                class="text-sm font-medium bg-primary text-white px-4 py-2 rounded-md hover:bg-primary-dark transition-colors shadow-sm"
              >
                Crear cuenta
              </Link>
            </div>

            <!-- Mobile Hamburger Menu Button -->
            <div class="flex items-center sm:hidden">
              <button
                class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out"
                :aria-expanded="showingNavigationDropdown"
                aria-label="Toggle navigation menu"
                @click="showingNavigationDropdown = !showingNavigationDropdown"
              >
                <svg
                  class="h-6 w-6"
                  stroke="currentColor"
                  fill="none"
                  viewBox="0 0 24 24"
                >
                  <path
                    :class="{
                      hidden: showingNavigationDropdown,
                      'inline-flex': !showingNavigationDropdown,
                    }"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M4 6h16M4 12h16M4 18h16"
                  />
                  <path
                    :class="{
                      hidden: !showingNavigationDropdown,
                      'inline-flex': showingNavigationDropdown,
                    }"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M6 18L18 6M6 6l12 12"
                  />
                </svg>
              </button>
            </div>
          </template>
        </nav>
      </div>

      <!-- Mobile menu for auth actions -->
      <div
        v-if="$page.props.auth?.user"
        :class="{
          block: showingNavigationDropdown,
          hidden: !showingNavigationDropdown,
        }"
        class="sm:hidden border-t border-gray-200"
      >
        <div class="pt-2 pb-3 space-y-1">
          <div class="px-4 py-2 text-sm font-semibold text-gray-700">
            {{ $page.props.auth.user.name }}
          </div>
          <Link
            :href="route('history')"
            class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 transition duration-150 ease-in-out"
            @click="showingNavigationDropdown = false"
          >
            Historial de búsquedas
          </Link>
          <Link
            :href="route('logout')"
            method="post"
            as="button"
            class="block w-full text-left pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 transition duration-150 ease-in-out"
            @click="showingNavigationDropdown = false"
          >
            Cerrar sesión
          </Link>
        </div>
      </div>

      <!-- Mobile menu for guest auth actions -->
      <div
        v-if="!$page.props.auth?.user"
        :class="{
          block: showingNavigationDropdown,
          hidden: !showingNavigationDropdown,
        }"
        class="sm:hidden border-t border-gray-200"
      >
        <div class="pt-2 pb-3 space-y-1">
          <Link
            :href="route('login')"
            class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 transition duration-150 ease-in-out"
            @click="showingNavigationDropdown = false"
          >
            Iniciar sesión
          </Link>
          <Link
            :href="route('register')"
            class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-primary hover:text-primary-dark hover:bg-gray-50 transition duration-150 ease-in-out"
            @click="showingNavigationDropdown = false"
          >
            Crear cuenta
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
import { ref, computed, inject } from 'vue'
import { Link } from '@inertiajs/vue3'
import Dropdown from '@/Components/Dropdown.vue'
import DropdownLink from '@/Components/DropdownLink.vue'

const route = inject('route')
const showingNavigationDropdown = ref(false)

// Computed properties
const currentYear = computed(() => new Date().getFullYear())
</script>
