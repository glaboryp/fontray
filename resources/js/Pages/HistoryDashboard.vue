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
    <div class="py-12 bg-gray-50 min-h-full">
      <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="mb-8">
          <h1 class="text-3xl font-bold text-gray-900">
            Historial de búsquedas
          </h1>
        </div>
        <div>
          <div
            v-if="hasHistory"
            class="grid gap-6 md:grid-cols-2 lg:grid-cols-3"
          >
            <div
              v-for="item in histories.data"
              :key="item.id"
              class="overflow-hidden bg-white shadow-sm sm:rounded-lg flex flex-col cursor-pointer hover:shadow-md transition-shadow"
              role="button"
              tabindex="0"
              @click="openHistoryResult(item)"
              @keyup.enter="openHistoryResult(item)"
            >
              <div
                class="h-48 w-full bg-gray-50 flex items-center justify-center overflow-hidden p-4 border-b border-gray-100"
              >
                <img
                  v-if="item.image_url"
                  :src="item.image_url"
                  alt="Imagen de búsqueda"
                  class="object-contain w-full h-full"
                />
                <span v-else class="text-gray-400">Sin imagen</span>
              </div>
              <div
                class="p-4 text-gray-900 flex-1 flex flex-col justify-between"
              >
                <div>
                  <h3 class="font-bold text-lg mb-1">
                    {{ getTotalFound(item.font_results) }} fuentes encontradas
                  </h3>
                  <p class="text-sm text-gray-500">
                    {{ formatDate(item.created_at) }}
                  </p>
                </div>
              </div>
            </div>
          </div>

          <div v-else class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">No hay búsquedas registradas.</div>
          </div>

          <!-- Pagination Links -->
          <div
            v-if="histories.links && histories.links.length > 3"
            class="mt-8 flex justify-center space-x-2"
          >
            <template v-for="(link, key) in histories.links" :key="key">
              <Link
                v-if="link.url"
                :href="link.url"
                class="px-4 py-2 border rounded text-sm"
                :class="{
                  'bg-indigo-600 text-white border-indigo-600': link.active,
                  'bg-white text-gray-700 border-gray-300 hover:bg-gray-50':
                    !link.active,
                }"
              >
                <!-- eslint-disable-next-line vue/no-v-html -->
                <span v-html="link.label" />
              </Link>
              <!-- eslint-disable vue/no-v-html -->
              <span
                v-else
                class="px-4 py-2 border rounded text-sm bg-gray-100 text-gray-400 border-gray-200"
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
