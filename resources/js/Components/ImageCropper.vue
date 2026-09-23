<template>
  <div
    class="fixed inset-0 bg-bench-950/85 flex items-center justify-center z-50 p-4"
  >
    <div
      class="texture-steel bg-bench-900 border border-bench-700 rounded-[var(--radius-panel)] max-w-4xl w-full max-h-[90vh] flex flex-col overflow-hidden"
    >
      <!-- Header -->
      <div class="px-6 py-4 border-b border-bench-700 flex-shrink-0">
        <div class="flex justify-between items-center">
          <h3 class="text-lg font-semibold text-bench-50">Recortar imagen</h3>
          <button
            class="text-bench-400 hover:text-bench-100 transition-colors"
            aria-label="Cerrar"
            @click="$emit('cancelled')"
          >
            <svg
              class="w-5 h-5"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="1.5"
                d="M6 18L18 6M6 6l12 12"
              />
            </svg>
          </button>
        </div>
        <p class="text-sm text-bench-400 mt-1">
          Ajusta el área de recorte, rota y mejora el contraste para obtener un
          texto claro.
        </p>
      </div>

      <!-- Cropper Area -->
      <div class="p-6 flex-1 overflow-y-auto">
        <div
          class="relative bg-bench-950 rounded-[var(--radius-panel)] group mb-4"
          style="min-height: 300px"
        >
          <!-- Indicador visual cuando no hay selección activa -->
          <div
            v-if="!hasCropSelection"
            class="absolute inset-4 border border-dashed border-index-500/50 rounded-[var(--radius-panel)] flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-200 pointer-events-none z-10"
          >
            <div
              class="text-index-400 text-sm font-medium bg-bench-900/90 px-3 py-1 rounded-full"
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
            class="absolute inset-0 flex items-center justify-center text-bench-400"
          >
            <div class="text-center">
              <div
                class="animate-spin rounded-full h-6 w-6 border-2 border-bench-700 border-t-index-500 mx-auto mb-2"
              />
              <p class="text-sm">Cargando imagen…</p>
            </div>
          </div>
        </div>

        <!-- Controls Panel -->
        <div
          class="texture-steel bg-bench-800 rounded-[var(--radius-panel)] p-4 grid grid-cols-1 sm:grid-cols-2 gap-4 border border-bench-700"
        >
          <!-- Rotate -->
          <div class="flex flex-col gap-2">
            <span class="text-sm font-medium text-bench-300">Orientación</span>
            <button
              class="px-4 py-2 bg-transparent border border-bench-600 hover:border-bench-400 rounded-[var(--radius-panel)] text-bench-200 font-medium flex items-center justify-center transition-colors text-sm"
              @click="rotateImage"
            >
              Rotar 90°
            </button>
          </div>

          <!-- Contrast -->
          <div class="flex flex-col gap-2">
            <div class="flex justify-between">
              <span class="text-sm font-medium text-bench-300">Contraste</span>
              <span class="text-sm font-mono text-index-400">
                {{ contrast }}%
              </span>
            </div>
            <input
              v-model="contrast"
              type="range"
              min="50"
              max="200"
              class="w-full h-1.5 bg-bench-700 rounded-lg appearance-none cursor-pointer accent-index-500"
            />
            <div class="flex justify-between text-xs text-bench-500 font-mono">
              <span>50%</span>
              <span>200%</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Footer Controls -->
      <div class="px-6 py-4 border-t border-bench-700 flex-shrink-0">
        <div class="flex flex-col sm:flex-row justify-end items-center gap-3">
          <!-- Action Buttons -->
          <button
            class="w-full sm:w-auto px-4 py-2 text-bench-300 hover:text-bench-100 font-medium transition-colors cursor-pointer text-sm"
            @click="resetCrop"
          >
            Restablecer
          </button>
          <button
            class="w-full sm:w-auto px-4 py-2 text-bench-200 bg-transparent border border-bench-600 hover:border-bench-400 rounded-[var(--radius-panel)] font-medium transition-colors cursor-pointer text-sm"
            @click="$emit('cancelled')"
          >
            Cancelar
          </button>
          <button
            class="w-full sm:w-auto px-6 py-2 bg-index-500 hover:bg-index-400 disabled:bg-bench-700 disabled:text-bench-500 text-bench-950 rounded-[var(--radius-panel)] font-medium transition-colors cursor-pointer text-sm"
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
    } catch {
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
  background: #101214;
  width: 100%;
}

:deep(.vue-advanced-cropper) {
  border-radius: 8px;
  cursor: crosshair;
}

:deep(.vue-advanced-cropper__background) {
  background: #101214;
}

:deep(.vue-advanced-cropper__image) {
  max-height: 100%;
  max-width: 100%;
  object-fit: contain;
  /* Aplicar contraste visualmente en el editor */
  filter: contrast(var(--custom-contrast, 100%));
}

:deep(.vue-advanced-cropper__foreground) {
  background: rgba(16, 18, 20, 0.65);
  pointer-events: none;
}

:deep(.vue-advanced-cropper__stencil) {
  border: 2px solid #e8952e;
  box-shadow: 0 0 0 9999px rgba(16, 18, 20, 0.65);
  cursor: move;
}

:deep(.vue-advanced-cropper__handler) {
  background: #e8952e;
  border: 2px solid #101214;
  border-radius: 3px;
  width: 14px;
  height: 14px;
  cursor: pointer;
  transition: all 0.2s ease;
}

:deep(.vue-advanced-cropper__handler):hover {
  background: #f4b969;
  transform: scale(1.1);
}

:deep(.vue-advanced-cropper__line) {
  border-color: #e8952e;
  border-width: 1px;
  opacity: 0.9;
}
</style>
