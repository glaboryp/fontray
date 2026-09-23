<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { Head, Link, router } from '@inertiajs/vue3'
import { computed, inject } from 'vue'

const route = inject('route')

const props = defineProps({
  histories: {
    type: Object,
    required: true,
  },
})

const hasHistory = computed(
  () =>
    props.histories && props.histories.data && props.histories.data.length > 0
)

const formatDate = dateString => {
  if (!dateString) return ''
  return new Date(dateString).toLocaleDateString(undefined, {
    year: 'numeric',
    month: 'short',
    day: 'numeric',
  })
}

const getTotalFound = fontResults => {
  if (!fontResults) return 0

  if (typeof fontResults.total_found === 'number') {
    return fontResults.total_found
  }

  const fontsArray = Array.isArray(fontResults)
    ? fontResults
    : fontResults.fonts || []

  return fontsArray.length
}

const openHistoryResult = item => {
  const fontsArray = Array.isArray(item.font_results)
    ? item.font_results
    : item.font_results?.fonts || []

  router.visit(route('results'), {
    data: {
      fonts: JSON.stringify(fontsArray),
    },
    preserveState: false,
    preserveScroll: false,
    replace: false,
  })
}
</script>

<template>
  <Head title="Historial de búsquedas" />

  <AppLayout>
    <div class="py-12 bg-bench-950 min-h-full">
      <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="mb-8">
          <h1 class="text-2xl font-semibold text-bench-50">
            Historial de búsquedas
          </h1>
        </div>
        <div>
          <div
            v-if="hasHistory"
            class="grid gap-5 md:grid-cols-2 lg:grid-cols-3"
          >
            <div
              v-for="item in histories.data"
              :key="item.id"
              class="overflow-hidden bg-bench-900 border border-bench-700 rounded-[var(--radius-panel)] flex flex-col cursor-pointer hover:border-bench-500 transition-colors"
              role="button"
              tabindex="0"
              @click="openHistoryResult(item)"
              @keyup.enter="openHistoryResult(item)"
            >
              <div
                class="h-40 w-full bg-bench-950 flex items-center justify-center overflow-hidden p-4 border-b border-bench-800"
              >
                <img
                  v-if="item.image_url"
                  :src="item.image_url"
                  alt="Imagen de búsqueda"
                  class="object-contain w-full h-full"
                />
                <span v-else class="text-bench-300 text-sm">Sin imagen</span>
              </div>
              <div class="p-4 flex-1 flex flex-col justify-between">
                <div>
                  <h3 class="font-semibold text-bench-50 mb-1">
                    {{ getTotalFound(item.font_results) }} fuentes encontradas
                  </h3>
                  <p class="text-sm font-mono text-bench-300">
                    {{ formatDate(item.created_at) }}
                  </p>
                </div>
              </div>
            </div>
          </div>

          <div
            v-else
            class="bg-bench-900 border border-bench-700 rounded-[var(--radius-panel)] overflow-hidden"
          >
            <div class="p-6 text-bench-300">No hay búsquedas registradas.</div>
          </div>

          <!-- Pagination Links -->
          <div
            v-if="histories.links && histories.links.length > 3"
            class="mt-8 flex justify-center gap-2"
          >
            <template v-for="(link, key) in histories.links" :key="key">
              <Link
                v-if="link.url"
                :href="link.url"
                class="px-4 py-2 border rounded-[var(--radius-panel)] text-sm"
                :class="{
                  'bg-index-500 text-bench-950 border-index-500': link.active,
                  'bg-transparent text-bench-300 border-bench-600 hover:border-bench-400':
                    !link.active,
                }"
              >
                <!-- eslint-disable-next-line vue/no-v-html -->
                <span v-html="link.label" />
              </Link>
              <!-- eslint-disable vue/no-v-html -->
              <span
                v-else
                class="px-4 py-2 border rounded-[var(--radius-panel)] text-sm bg-bench-900 text-bench-600 border-bench-800"
                v-html="link.label"
              />
              <!-- eslint-enable vue/no-v-html -->
            </template>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>
