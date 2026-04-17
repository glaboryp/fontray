<template>
  <div
    class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50"
  >
    <div
      class="bg-white rounded-lg shadow-xl max-w-4xl w-full mx-4 max-h-[90vh] flex flex-col overflow-hidden"
    >
      <!-- Header -->
      <div class="px-6 py-4 border-b border-gray-200 flex-shrink-0">
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
          Ajusta el área de recorte, rota y mejora el contraste para obtener un
          texto claro.
        </p>
      </div>

      <!-- Cropper Area -->
      <div class="p-6 flex-1 overflow-y-auto">
        <div
          class="relative bg-gray-100 rounded-lg group mb-4"
          style="min-height: 300px"
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
            :default-size="defaultSize"
            :stencil-props="{
              aspectRatio: null,
              movable: true,
              resizable: true,
            }"
            :style="{ '--custom-contrast': contrast + '%' }"
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

        <!-- Controls Panel -->
        <div
          class="bg-gray-50 rounded-lg p-4 grid grid-cols-1 sm:grid-cols-2 gap-4 border border-gray-200"
        >
          <!-- Rotate -->
          <div class="flex flex-col space-y-2">
            <span class="text-sm font-medium text-gray-700">Orientación</span>
            <button
              class="px-4 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 text-gray-700 font-medium flex items-center justify-center transition-colors shadow-sm"
              @click="rotateImage"
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
                  d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"
                />
              </svg>
              Rotar 90°
            </button>
          </div>

          <!-- Contrast -->
          <div class="flex flex-col space-y-2">
            <div class="flex justify-between">
              <span class="text-sm font-medium text-gray-700">Contraste</span>
              <span class="text-sm font-medium text-blue-600">
                {{ contrast }}%
              </span>
            </div>
            <input
              type="range"
              min="50"
              max="200"
              v-model="contrast"
              class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-primary"
            />
            <div class="flex justify-between text-xs text-gray-500">
              <span>Bajo</span>
              <span>Alto</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Footer Controls -->
      <div class="px-6 py-4 border-t border-gray-200 flex-shrink-0">
        <div class="flex flex-col sm:flex-row justify-end items-center gap-4">
          <!-- Action Buttons -->
          <button
            class="w-full sm:w-auto px-4 py-2 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg font-medium transition-colors cursor-pointer"
            @click="resetCrop"
          >
            Restablecer
          </button>
          <button
            class="w-full sm:w-auto px-4 py-2 text-gray-600 bg-white border border-gray-300 hover:bg-gray-50 rounded-lg font-medium transition-colors cursor-pointer"
            @click="$emit('cancelled')"
          >
            Cancelar
          </button>
          <button
            class="w-full sm:w-auto px-6 py-2 bg-primary hover:bg-primary-hover text-white rounded-lg font-medium transition-colors cursor-pointer"
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

const rotation = ref(0)
const contrast = ref(100)

const defaultSize = ({ imageSize }) => {
  return {
    width: imageSize.width || 100,
    height: imageSize.height || 100,
  }
}

// Methods
const onCropChange = () => {
  const result = cropper.value?.getResult?.()
  canCrop.value = result && result.canvas && result.canvas.width > 0

  hasCropSelection.value =
    result &&
    result.coordinates &&
    result.coordinates.width > 10 &&
    result.coordinates.height > 10
}

const resetCrop = () => {
  if (cropper.value) {
    cropper.value.reset()
    rotation.value = 0
    contrast.value = 100
  }
}

const rotateImage = () => {
  if (cropper.value) {
    cropper.value.rotate(90)
    rotation.value = (rotation.value + 90) % 360
  }
}

const applyCrop = () => {
  const result = cropper.value?.getResult?.()

  if (
    result &&
    result.canvas &&
    result.canvas.width > 0 &&
    result.canvas.height > 0
  ) {
    try {
      let finalCanvas = result.canvas

      if (Number(contrast.value) !== 100) {
        finalCanvas = document.createElement('canvas')
        finalCanvas.width = result.canvas.width
        finalCanvas.height = result.canvas.height
        const ctx = finalCanvas.getContext('2d')

        ctx.filter = `contrast(${contrast.value}%)`
        ctx.drawImage(result.canvas, 0, 0)
      }

      finalCanvas.toBlob(
        blob => {
          if (blob) {
            emit('crop-applied', blob)
          } else {
            emit('cancelled')
          }
        },
        'image/jpeg',
        0.9
      )
    } catch (e) {
      emit('cancelled')
    }
  } else {
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
  /* Aplicar contraste visualmente en el editor */
  filter: contrast(var(--custom-contrast, 100%));
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
