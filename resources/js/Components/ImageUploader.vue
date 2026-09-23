<template>
  <div class="w-full">
    <!-- Reticle / drop target -->
    <div
      :class="[
        'reticle relative rounded-full aspect-square w-full max-w-sm mx-auto flex flex-col items-center justify-center text-center border transition-all duration-200',
        isDragging
          ? 'border-index-500 shadow-[0_0_0_6px_rgba(232,149,46,0.12)]'
          : 'border-bench-600 hover:border-bench-400',
        justLocked ? 'reticle--locked' : '',
      ]"
      @drop="handleDrop"
      @dragover.prevent
      @dragenter.prevent
      @dragleave="isDragging = false"
      @dragover="isDragging = true"
    >
      <!-- Calibration ticks + processing needle -->
      <svg
        class="absolute inset-0 w-full h-full text-bench-600 pointer-events-none"
        viewBox="0 0 100 100"
        aria-hidden="true"
      >
        <line
          v-for="tick in 12"
          :key="tick"
          :x1="50 + 47 * Math.cos((tick * 30 * Math.PI) / 180)"
          :y1="50 + 47 * Math.sin((tick * 30 * Math.PI) / 180)"
          :x2="
            50 +
            (tick % 3 === 0 ? 42 : 44.5) * Math.cos((tick * 30 * Math.PI) / 180)
          "
          :y2="
            50 +
            (tick % 3 === 0 ? 42 : 44.5) * Math.sin((tick * 30 * Math.PI) / 180)
          "
          stroke="currentColor"
          :stroke-width="tick % 3 === 0 ? 0.8 : 0.5"
        />
        <g v-if="isProcessing" class="needle">
          <line
            x1="50"
            y1="50"
            x2="50"
            y2="16"
            stroke="var(--color-index-500)"
            stroke-width="1"
            stroke-linecap="round"
          />
          <circle cx="50" cy="50" r="2.5" fill="var(--color-index-500)" />
        </g>
      </svg>

      <div v-if="!selectedImage" class="space-y-5 px-8">
        <svg
          class="mx-auto w-10 h-10 text-bench-400"
          fill="none"
          stroke="currentColor"
          viewBox="0 0 24 24"
          aria-hidden="true"
        >
          <circle cx="12" cy="12" r="8" stroke-width="1.5" />
          <circle cx="12" cy="12" r="1.5" fill="currentColor" stroke="none" />
        </svg>

        <div>
          <h2 class="text-lg font-semibold text-bench-50 mb-1">
            Suelta tu imagen o PDF
          </h2>
          <p class="text-sm text-bench-400 mb-5">
            o selecciona un archivo, hasta 10&nbsp;MB
          </p>

          <div class="flex flex-col gap-2.5 items-center">
            <button
              class="w-48 justify-center inline-flex items-center bg-index-500 hover:bg-index-400 text-bench-950 font-medium py-2.5 px-5 rounded-[var(--radius-panel)] transition-colors cursor-pointer"
              @click="triggerFileInput"
            >
              Seleccionar archivo
            </button>

            <button
              class="text-sm text-bench-300 hover:text-bench-50 font-medium py-1.5 transition-colors cursor-pointer underline underline-offset-4 decoration-bench-600 hover:decoration-bench-400"
              @click="openCamera"
            >
              Tomar foto
            </button>
          </div>
        </div>
      </div>

      <!-- Preview state -->
      <div v-else class="space-y-4 px-6 w-full">
        <div class="flex justify-center">
          <div class="relative inline-block max-w-48">
            <img
              v-if="!isPdfSelected"
              :src="previewUrl"
              alt="Imagen seleccionada"
              class="block max-w-48 max-h-32 rounded-[var(--radius-panel)] object-contain"
            />
            <div
              v-else
              class="flex items-center gap-3 rounded-[var(--radius-panel)] border border-bench-600 bg-bench-800 p-4"
            >
              <svg
                class="w-8 h-8 text-bench-400 flex-shrink-0"
                aria-hidden="true"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="1.5"
                  d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                />
              </svg>
              <span class="text-bench-100 font-medium text-sm break-all">
                PDF seleccionado
              </span>
            </div>

            <!-- Remove button -->
            <button
              class="absolute -top-2 -right-2 bg-bench-800 border border-bench-600 hover:border-danger text-bench-300 hover:text-danger rounded-full p-1.5 transition-colors cursor-pointer"
              aria-label="Quitar archivo"
              @click="removeSelectedImage"
            >
              <svg
                class="w-3.5 h-3.5"
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
        </div>

        <p class="text-xs text-bench-400 font-mono truncate">
          {{ selectedImage.name }} · {{ formatFileSize(selectedImage.size) }}
        </p>

        <div class="flex flex-col gap-2 items-center">
          <button
            v-if="!isPdfSelected"
            class="w-48 justify-center inline-flex items-center bg-transparent border border-bench-600 hover:border-bench-400 text-bench-200 font-medium py-2 px-5 rounded-[var(--radius-panel)] transition-colors cursor-pointer text-sm"
            @click="openCropper"
          >
            Recortar imagen
          </button>

          <button
            :disabled="isProcessing"
            :class="[
              'w-48 justify-center inline-flex items-center font-medium py-2.5 px-5 rounded-[var(--radius-panel)] transition-all text-sm',
              isProcessing
                ? 'bg-bench-800 text-bench-300 cursor-not-allowed'
                : 'bg-index-500 hover:bg-index-400 text-bench-950 cursor-pointer',
            ]"
            @click="identifyFont"
          >
            <span v-if="!isProcessing">Identificar fuente</span>
            <span v-else>Midiendo…</span>
          </button>
        </div>
      </div>
    </div>

    <!-- Hidden file input -->
    <input
      ref="fileInput"
      type="file"
      accept="image/*,application/pdf"
      class="hidden"
      @change="handleFileSelect"
    />

    <!-- Status -->
    <div class="max-w-sm mx-auto">
      <p v-if="error" class="mt-4 text-sm text-danger text-left" role="alert">
        {{ error }}
      </p>
      <p
        v-if="success"
        class="mt-4 text-sm text-confirm text-left flex items-start gap-1.5"
        role="status"
      >
        <svg
          class="w-3.5 h-3.5 shrink-0 mt-0.5"
          viewBox="0 0 16 16"
          fill="none"
          aria-hidden="true"
        >
          <path
            d="M3 8.5l3 3 7-7.5"
            stroke="currentColor"
            stroke-width="1.5"
            stroke-linecap="round"
            stroke-linejoin="round"
          />
        </svg>
        <span>{{ success }}</span>
      </p>
    </div>

    <!-- Camera Modal -->
    <div
      v-if="showCamera"
      class="fixed inset-0 bg-bench-950/85 flex items-center justify-center z-50 p-4"
    >
      <div
        class="texture-steel bg-bench-900 border border-bench-700 rounded-[var(--radius-panel)] max-w-lg w-full max-h-[90vh] overflow-hidden"
      >
        <!-- Modal Header -->
        <div class="px-6 py-4 border-b border-bench-700">
          <div class="flex justify-between items-center">
            <h3 class="text-lg font-semibold text-bench-50">Capturar foto</h3>
            <button
              class="text-bench-400 hover:text-bench-100 transition-colors"
              aria-label="Cerrar"
              @click="closeCamera"
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
            Encuadra el texto en el visor y captura la foto
          </p>
        </div>

        <!-- Camera Content -->
        <div class="p-6">
          <div
            class="relative bg-bench-950 rounded-[var(--radius-panel)] overflow-hidden"
            style="aspect-ratio: 4/3"
          >
            <!-- Video Stream -->
            <video
              ref="videoRef"
              class="w-full h-full object-cover"
              autoplay
              playsinline
              :style="{ display: cameraReady ? 'block' : 'none' }"
            />

            <!-- Camera Loading -->
            <div
              v-if="!cameraReady"
              class="absolute inset-0 flex items-center justify-center text-bench-400"
            >
              <div class="text-center">
                <div
                  class="animate-spin rounded-full h-6 w-6 border-2 border-bench-700 border-t-index-500 mx-auto mb-2"
                />
                <p class="text-sm">Iniciando cámara…</p>
              </div>
            </div>

            <!-- Camera Error -->
            <div
              v-if="cameraError"
              class="absolute inset-0 flex items-center justify-center text-danger"
            >
              <div class="text-center px-4">
                <p class="text-sm font-medium">Error al acceder a la cámara</p>
                <p class="text-xs mt-1 text-bench-400">{{ cameraError }}</p>
              </div>
            </div>

            <!-- Capture overlay -->
            <div
              v-if="cameraReady"
              class="absolute inset-4 border border-index-500/60 rounded-[var(--radius-panel)] pointer-events-none"
            />
          </div>

          <!-- Camera Controls -->
          <div class="flex justify-center gap-3 mt-6">
            <button
              class="px-4 py-2 text-bench-300 bg-transparent border border-bench-600 hover:border-bench-400 rounded-[var(--radius-panel)] font-medium transition-colors text-sm"
              @click="closeCamera"
            >
              Cancelar
            </button>
            <button
              :disabled="!cameraReady"
              :class="[
                'px-5 py-2 rounded-[var(--radius-panel)] font-medium transition-colors text-sm',
                cameraReady
                  ? 'bg-index-500 hover:bg-index-400 text-bench-950'
                  : 'bg-bench-800 text-bench-300 cursor-not-allowed',
              ]"
              @click="capturePhoto"
            >
              Capturar
            </button>
          </div>
        </div>
      </div>

      <!-- Hidden canvas for photo capture -->
      <canvas ref="canvasRef" class="hidden" />
    </div>
  </div>

  <!-- Image Cropper Modal -->
  <ImageCropper
    v-if="showCropper"
    :image-src="previewUrl"
    @crop-applied="handleCropApplied"
    @cancelled="showCropper = false"
  />
</template>

<script setup>
import { ref, computed, watch } from 'vue'
import { router } from '@inertiajs/vue3'
import ImageCropper from './ImageCropper.vue'
import { useImageUpload, PDF_MIME_TYPE } from '@/composables/useImageUpload'
import { useFontIdentification } from '@/composables/useFontIdentification'

// Emits
const emit = defineEmits(['uploaded', 'font-identified'])

// Composables
const {
  isDragging,
  selectedImage,
  previewUrl,
  error,
  success,
  processFile,
  removeImage,
  handleDrop,
  handleFileSelect,
  formatFileSize,
  resizeImageIfNeeded,
} = useImageUpload()

const { isProcessing, identifyFont: identifyFontCore } = useFontIdentification()

// Refs
const fileInput = ref(null)
const showCropper = ref(false)
const justLocked = ref(false)

watch(success, value => {
  if (!value) return
  justLocked.value = true
  setTimeout(() => {
    justLocked.value = false
  }, 900)
})

const isPdfSelected = computed(
  () => selectedImage.value?.type === PDF_MIME_TYPE
)

// Camera related
const showCamera = ref(false)
const cameraReady = ref(false)
const cameraError = ref('')
const videoRef = ref(null)
const canvasRef = ref(null)
const currentStream = ref(null)

// Methods
const triggerFileInput = () => {
  fileInput.value?.click()
}

const identifyFont = async () => {
  if (!selectedImage.value) return

  error.value = ''
  success.value = ''

  const result = await identifyFontCore(
    selectedImage.value,
    resizeImageIfNeeded,
    emit
  )

  if (result?.success) {
    success.value = `${result.data.total_found} fuente(s) identificada(s). Redirigiendo…`
  } else if (result?.message) {
    error.value = result.message
  }
}

const removeSelectedImage = () => {
  removeImage()
  if (fileInput.value) fileInput.value.value = ''
}

const openCropper = () => {
  if (selectedImage.value) {
    showCropper.value = true
  }
}

const handleCropApplied = async croppedBlob => {
  try {
    const croppedFile = new File([croppedBlob], selectedImage.value.name, {
      type: selectedImage.value.type,
      lastModified: Date.now(),
    })

    selectedImage.value = croppedFile
    previewUrl.value = URL.createObjectURL(croppedBlob)
    showCropper.value = false

    success.value = 'Recorte aplicado. Ya puedes identificar la fuente.'
  } catch {
    error.value = 'Error al aplicar el recorte. Inténtalo de nuevo.'
  }
}

// Camera methods
const openCamera = async () => {
  showCamera.value = true
  cameraReady.value = false
  cameraError.value = ''

  try {
    const stream = await navigator.mediaDevices.getUserMedia({
      video: {
        facingMode: 'environment',
        width: { ideal: 1280 },
        height: { ideal: 720 },
      },
    })

    currentStream.value = stream

    if (videoRef.value) {
      videoRef.value.srcObject = stream
      videoRef.value.onloadedmetadata = () => {
        cameraReady.value = true
      }
    }
  } catch {
    cameraError.value = 'No se pudo acceder a la cámara. Verifica los permisos.'
  }
}

const closeCamera = () => {
  if (currentStream.value) {
    currentStream.value.getTracks().forEach(track => track.stop())
    currentStream.value = null
  }

  showCamera.value = false
  cameraReady.value = false
  cameraError.value = ''
}

const capturePhoto = () => {
  if (!videoRef.value || !canvasRef.value || !cameraReady.value) {
    return
  }

  const video = videoRef.value
  const canvas = canvasRef.value
  const context = canvas.getContext('2d')

  canvas.width = video.videoWidth
  canvas.height = video.videoHeight

  context.drawImage(video, 0, 0, canvas.width, canvas.height)

  canvas.toBlob(
    blob => {
      if (blob) {
        const timestamp = new Date().toISOString().replace(/[:.]/g, '-')
        const capturedFile = new File(
          [blob],
          `camera-capture-${timestamp}.jpg`,
          {
            type: 'image/jpeg',
            lastModified: Date.now(),
          }
        )

        processFile(capturedFile)
        closeCamera()

        success.value = 'Foto capturada. Ya puedes identificar la fuente.'
      } else {
        error.value = 'Error al capturar la foto. Inténtalo de nuevo.'
      }
    },
    'image/jpeg',
    0.8
  )
}

defineExpose({ goToExamples: () => router.visit('/examples') })
</script>

<style scoped>
.needle {
  animation: needle-sweep 1.1s cubic-bezier(0.65, 0, 0.35, 1) infinite;
  /* transform-box: view-box + a percentage transform-origin is the only
     combination that pivots on the SVG's actual 0-100 viewBox center.
     fill-box (or a unitless "50 50" origin) resolves against the needle's
     own tiny bounding box instead, which is why the sweep orbited a point
     off to the side rather than spinning in place. */
  transform-box: view-box;
  transform-origin: 50% 50%;
}

@keyframes needle-sweep {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}

.reticle--locked {
  animation: lock-pulse 0.9s ease-out;
}

@keyframes lock-pulse {
  0% {
    box-shadow: 0 0 0 0 rgba(232, 149, 46, 0.45);
  }
  70% {
    box-shadow: 0 0 0 16px rgba(232, 149, 46, 0);
  }
  100% {
    box-shadow: 0 0 0 0 rgba(232, 149, 46, 0);
  }
}

@media (prefers-reduced-motion: reduce) {
  .needle {
    animation: none;
  }
  .reticle--locked {
    animation: none;
  }
}
</style>
