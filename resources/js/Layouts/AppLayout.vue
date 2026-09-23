<template>
  <div class="min-h-screen flex flex-col bg-bench-900 text-bench-100">
    <!-- Header/Navigation -->
    <header class="texture-steel bg-bench-950 border-b border-bench-700">
      <div
        class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between"
      >
        <Link href="/" class="flex items-center gap-2.5 shrink-0">
          <svg
            class="w-7 h-7 text-index-500"
            viewBox="0 0 28 28"
            fill="none"
            aria-hidden="true"
          >
            <circle
              cx="14"
              cy="14"
              r="10.5"
              stroke="currentColor"
              stroke-width="1.5"
            />
            <path
              d="M14 3.5v3M14 21.5v3M24.5 14h-3M6.5 14h-3"
              stroke="currentColor"
              stroke-width="1.5"
              stroke-linecap="round"
            />
            <circle cx="14" cy="14" r="2.75" fill="currentColor" />
          </svg>
          <span class="font-semibold text-lg tracking-tight text-bench-50">
            Fontray
          </span>
        </Link>

        <!-- Auth Navigation -->
        <nav class="flex items-center gap-4">
          <template v-if="$page.props.auth?.user">
            <div class="hidden sm:flex sm:items-center">
              <Dropdown
                align="right"
                width="48"
                content-classes="py-1 bg-bench-800 border border-bench-600"
              >
                <template #trigger>
                  <span class="inline-flex rounded-md">
                    <button
                      type="button"
                      class="inline-flex items-center rounded-md border border-transparent px-3 py-2 text-sm font-medium leading-4 text-bench-200 transition duration-150 ease-in-out hover:text-index-400 focus:outline-none focus-visible:ring-2 focus-visible:ring-index-500 focus-visible:ring-offset-2 focus-visible:ring-offset-bench-950"
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
                class="inline-flex items-center justify-center p-2 rounded-md text-bench-400 hover:text-bench-100 hover:bg-bench-800 focus:outline-none transition duration-150 ease-in-out"
                :aria-expanded="showingNavigationDropdown"
                aria-label="Abrir menú de navegación"
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
                    stroke-width="1.5"
                    d="M4 6h16M4 12h16M4 18h16"
                  />
                  <path
                    :class="{
                      hidden: !showingNavigationDropdown,
                      'inline-flex': showingNavigationDropdown,
                    }"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="1.5"
                    d="M6 18L18 6M6 6l12 12"
                  />
                </svg>
              </button>
            </div>
          </template>
          <template v-else>
            <!-- Desktop Links -->
            <div class="hidden sm:flex items-center gap-4">
              <Link
                :href="route('login')"
                class="text-sm font-medium text-bench-300 hover:text-bench-50 transition-colors"
              >
                Iniciar sesión
              </Link>
              <Link
                :href="route('register')"
                class="text-sm font-medium bg-index-500 text-bench-950 px-4 py-2 rounded-[var(--radius-panel)] hover:bg-index-400 transition-colors"
              >
                Crear cuenta
              </Link>
            </div>

            <!-- Mobile Hamburger Menu Button -->
            <div class="flex items-center sm:hidden">
              <button
                class="inline-flex items-center justify-center p-2 rounded-md text-bench-400 hover:text-bench-100 hover:bg-bench-800 focus:outline-none transition duration-150 ease-in-out"
                :aria-expanded="showingNavigationDropdown"
                aria-label="Abrir menú de navegación"
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
                    stroke-width="1.5"
                    d="M4 6h16M4 12h16M4 18h16"
                  />
                  <path
                    :class="{
                      hidden: !showingNavigationDropdown,
                      'inline-flex': showingNavigationDropdown,
                    }"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="1.5"
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
        class="sm:hidden border-t border-bench-700"
      >
        <div class="pt-2 pb-3 space-y-1">
          <div class="px-4 py-2 text-sm font-semibold text-bench-200">
            {{ $page.props.auth.user.name }}
          </div>
          <Link
            :href="route('history')"
            class="block pl-4 pr-4 py-2 text-base font-medium text-bench-300 hover:text-bench-50 hover:bg-bench-800 transition duration-150 ease-in-out"
            @click="showingNavigationDropdown = false"
          >
            Historial de búsquedas
          </Link>
          <Link
            :href="route('logout')"
            method="post"
            as="button"
            class="block w-full text-left pl-4 pr-4 py-2 text-base font-medium text-bench-300 hover:text-bench-50 hover:bg-bench-800 transition duration-150 ease-in-out"
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
        class="sm:hidden border-t border-bench-700"
      >
        <div class="pt-2 pb-3 space-y-1">
          <Link
            :href="route('login')"
            class="block pl-4 pr-4 py-2 text-base font-medium text-bench-300 hover:text-bench-50 hover:bg-bench-800 transition duration-150 ease-in-out"
            @click="showingNavigationDropdown = false"
          >
            Iniciar sesión
          </Link>
          <Link
            :href="route('register')"
            class="block pl-4 pr-4 py-2 text-base font-medium text-index-400 hover:text-index-300 hover:bg-bench-800 transition duration-150 ease-in-out"
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
    <footer
      class="texture-steel bg-bench-950 border-t border-bench-700 mt-auto"
    >
      <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <div
          class="flex flex-col md:flex-row justify-between items-center gap-4"
        >
          <div class="flex items-center gap-2">
            <svg
              class="w-5 h-5 text-index-500"
              viewBox="0 0 28 28"
              fill="none"
              aria-hidden="true"
            >
              <circle
                cx="14"
                cy="14"
                r="10.5"
                stroke="currentColor"
                stroke-width="1.5"
              />
              <circle cx="14" cy="14" r="2.75" fill="currentColor" />
            </svg>
            <span class="text-base font-semibold text-bench-50">Fontray</span>
          </div>

          <div class="flex flex-col items-center gap-3">
            <div class="flex flex-col md:flex-row items-center gap-2 md:gap-6">
              <Link
                href="/examples"
                class="text-sm text-bench-300 hover:text-index-400 transition-colors"
              >
                Ejemplos y guía
              </Link>
              <Link
                href="/privacy"
                class="text-sm text-bench-300 hover:text-index-400 transition-colors"
              >
                Política de privacidad
              </Link>
              <Link
                href="/terms"
                class="text-sm text-bench-300 hover:text-index-400 transition-colors"
              >
                Términos de servicio
              </Link>
              <span class="text-sm text-bench-400 font-mono">
                © {{ currentYear }} Fontray
              </span>
            </div>

            <!-- Powered by WhatFontIs -->
            <div class="flex items-center gap-1.5 text-xs text-bench-400">
              <span>Motor de identificación:</span>
              <a
                href="https://www.whatfontis.com/API-identify-fonts-from-image.html"
                target="_blank"
                rel="noopener noreferrer"
                class="text-index-400 hover:text-index-300 transition-colors font-medium"
              >
                WhatFontIs
              </a>
            </div>
          </div>
        </div>
      </div>
    </footer>

    <!-- Loading overlay -->
    <div
      v-if="$page.props.loading"
      class="fixed inset-0 bg-bench-950/80 flex items-center justify-center z-50"
    >
      <div
        class="bg-bench-800 border border-bench-600 rounded-[var(--radius-panel)] p-6 flex items-center gap-3"
      >
        <div
          class="animate-spin rounded-full h-6 w-6 border-2 border-bench-600 border-t-index-500"
        />
        <span class="text-bench-100 text-sm">Cargando…</span>
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
