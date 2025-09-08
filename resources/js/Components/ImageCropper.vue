<template>
  <div
    class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50"
  >
    <div
      class="bg-white rounded-lg shadow-xl max-w-4xl w-full mx-4 max-h-[90vh] overflow-hidden"
    >
      <!-- Header -->
      <div class="px-6 py-4 border-b border-gray-200">
        <div class="flex justify-between items-center">
          <h3 class="text-lg font-semibold text-gray-900">Recortar imagen</h3>
          <button
            class="text-gray-400 hover:text-gray-600 transition-colors"
            @click="$emit('cancelled')"
          >
            <svg
              class="w-6 h-6"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M6 18L18 6M6 6l12 12"
              />
            </svg>
          </button>
        </div>
        <p class="text-sm text-gray-600 mt-1">
          Arrastra las esquinas para ajustar el área de recorte
        </p>
      </div>

      <!-- Cropper Area -->
      <div class="p-6">
        <div
          class="relative bg-gray-100 rounded-lg group"
          style="min-height: 400px"
        >
          <!-- Indicador visual cuando no hay selección activa -->
          <div
            v-if="!hasCropSelection"
            class="absolute inset-4 border-2 border-dashed border-blue-300 rounded-lg flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-200 pointer-events-none z-10"
          >
            <div
              class="text-blue-500 text-sm font-medium bg-white bg-opacity-90 px-3 py-1 rounded-full shadow-sm"
            >
              Haz clic y arrastra para seleccionar el texto
            </div>
          </div>

          <Cropper
            ref="cropper"
            class="cropper"
            :src="imageSrc"
            :stencil-props="{
              aspectRatio: null,
              movable: true,
              resizable: true,
            }"
            @change="onCropChange"
          />

          <!-- Loading state -->
          <div
            v-if="!imageSrc"
            class="absolute inset-0 flex items-center justify-center text-gray-500"
          >
            <div class="text-center">
              <svg
                class="w-8 h-8 mx-auto mb-2 animate-spin"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"
                />
              </svg>
              <p>Cargando imagen...</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Controls -->
      <div class="px-6 py-4 border-t border-gray-200">
        <div class="flex flex-col sm:flex-row justify-end items-center gap-4">
          <!-- Action Buttons -->
          <button
            class="px-4 py-2 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg font-medium transition-colors cursor-pointer"
            @click="resetCrop"
          >
            Restablecer
          </button>
          <button
            class="px-4 py-2 text-gray-600 bg-white border border-gray-300 hover:bg-gray-50 rounded-lg font-medium transition-colors cursor-pointer"
            @click="$emit('cancelled')"
          >
            Cancelar
          </button>
          <button
            class="px-6 py-2 bg-primary hover:bg-primary-hover text-white rounded-lg font-medium transition-colors cursor-pointer"
            :disabled="!canCrop"
            @click="applyCrop"
          >
            Aplicar recorte
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { Cropper } from 'vue-advanced-cropper'
import 'vue-advanced-cropper/dist/style.css'

defineProps({
  imageSrc: {
    type: String,
    required: true,
  },
})

const emit = defineEmits(['crop-applied', 'cancelled'])

// Refs
const cropper = ref(null)
const canCrop = ref(true)
const hasCropSelection = ref(false)

// Methods
const onCropChange = () => {
  // Se ejecuta cuando cambia el área de recorte
  const result = cropper.value?.getResult()
  canCrop.value = result ? true : false

  // Detectar si hay una selección válida para mostrar/ocultar el indicador
  hasCropSelection.value =
    result &&
    result.coordinates &&
    result.coordinates.width > 10 &&
    result.coordinates.height > 10
}

const resetCrop = () => {
  if (cropper.value) {
    cropper.value.reset()
  }
}

const applyCrop = () => {
  const result = cropper.value?.getResult()

  if (
    result &&
    result.canvas &&
    result.canvas.width > 0 &&
    result.canvas.height > 0
  ) {
    result.canvas.toBlob(
      blob => {
        if (blob) {
          emit('crop-applied', blob)
        } else {
          // Fallback: cerrar modal sin recortar
          emit('cancelled')
        }
      },
      'image/jpeg',
      0.9
    )
  } else {
    // Fallback: cerrar modal sin recortar
    emit('cancelled')
  }
}
</script>

<style scoped>
.cropper {
  min-height: 400px;
  max-height: 60vh;
  background: #f8f9fa;
  width: 100%;
}

/* Personalizar estilos del cropper */
:deep(.vue-advanced-cropper) {
  border-radius: 8px;
  cursor: crosshair;
}

:deep(.vue-advanced-cropper__background) {
  background: #f8f9fa;
}

:deep(.vue-advanced-cropper__image) {
  max-height: 100%;
  max-width: 100%;
  object-fit: contain;
}

:deep(.vue-advanced-cropper__foreground) {
  background: rgba(0, 0, 0, 0.4);
  pointer-events: none;
}

:deep(.vue-advanced-cropper__stencil) {
  border: 3px solid #147dd9;
  box-shadow: 0 0 0 9999px rgba(0, 0, 0, 0.5);
  cursor: move;
}

:deep(.vue-advanced-cropper__handler) {
  background: #147dd9;
  border: 3px solid #ffffff;
  border-radius: 6px;
  width: 16px;
  height: 16px;
  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
  cursor: pointer;
  transition: all 0.2s ease;
}

:deep(.vue-advanced-cropper__handler):hover {
  background: #0f5aa8;
  transform: scale(1.1);
}

:deep(.vue-advanced-cropper__line) {
  border-color: #147dd9;
  border-width: 2px;
  opacity: 0.8;
}
</style>
