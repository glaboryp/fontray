<template>
  <div class="max-w-2xl mx-auto">
    <!-- Upload Area -->
    <div
      :class="[
        'border-2 border-dashed rounded-lg p-8 text-center transition-all duration-200',
        isDragging
          ? 'border-primary bg-primary-light'
          : 'border-gray-300 hover:border-primary-hover hover:bg-gray-50',
      ]"
      @drop="handleDrop"
      @dragover.prevent
      @dragenter.prevent
      @dragleave="isDragging = false"
      @dragover="isDragging = true"
    >
      <div v-if="!selectedImage" class="space-y-4">
        <!-- Upload Icon -->
        <div class="mx-auto w-16 h-16 text-gray-400">
          <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="1.5"
              d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"
            />
          </svg>
        </div>

        <div>
          <h3 class="text-lg font-semibold text-gray-900 mb-2">
            Sube tu imagen
          </h3>
          <p class="text-gray-600 mb-4">
            Arrastra y suelta una imagen aquí, o haz clic para seleccionar
          </p>

          <!-- Upload Buttons -->
          <div class="flex flex-col sm:flex-row gap-3 justify-center">
            <button
              class="bg-primary hover:bg-primary-dark text-white font-medium py-2 px-6 rounded-lg transition-colors cursor-pointer flex items-center justify-center"
              @click="triggerFileInput"
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
                  d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 12l2 2 4-4"
                />
              </svg>
              Seleccionar imagen
            </button>

            <button
              class="bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-6 rounded-lg transition-colors cursor-pointer flex items-center justify-center"
              @click="openCamera"
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
                  d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"
                />
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"
                />
              </svg>
              Tomar foto
            </button>
          </div>

          <p class="text-sm text-gray-500 mt-3">
            Soporta JPG, PNG, WebP hasta 10MB
          </p>
        </div>
      </div>

      <!-- Preview Area -->
      <div v-else class="space-y-4">
        <div class="relative">
          <img
            :src="previewUrl"
            alt="Imagen seleccionada"
            class="max-w-full max-h-64 mx-auto rounded-lg shadow-lg"
          />

          <!-- Remove button -->
          <button
            class="absolute top-0 right-0 bg-red-500 hover:bg-red-600 text-white rounded-full p-2 transition-colors cursor-pointer"
            @click="removeSelectedImage"
          >
            <svg
              class="w-4 h-4"
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

        <div>
          <p class="text-sm text-gray-600 mb-4">
            {{ selectedImage.name }} ({{ formatFileSize(selectedImage.size) }})
          </p>

          <!-- Action Buttons -->
          <div class="flex flex-col sm:flex-row gap-3">
            <!-- Crop Button -->
            <button
              class="bg-primary hover:bg-primary-dark hover:shadow-lg text-white font-medium py-3 px-8 rounded-lg transition-all cursor-pointer"
              @click="openCropper"
            >
              Recortar imagen
            </button>

            <!-- Identify Button -->
            <button
              :disabled="isProcessing"
              :class="[
                'font-medium py-3 px-8 rounded-lg transition-all flex-1',
                isProcessing
                  ? 'bg-gray-400 text-gray-700 cursor-not-allowed'
                  : 'bg-green-600 hover:bg-green-700 text-white hover:shadow-lg cursor-pointer',
              ]"
              @click="identifyFont"
            >
              <span v-if="!isProcessing">
                Identificar fuente
                <svg
                  class="inline-block ml-2 w-4 h-4"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M9 5l7 7-7 7"
                  />
                </svg>
              </span>
              <span v-else class="flex items-center justify-center">
                <div
                  class="animate-spin rounded-full h-4 w-4 border-2 border-white border-t-transparent mr-2"
                />
                Procesando...
              </span>
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Hidden file input -->
    <input
      ref="fileInput"
      type="file"
      accept="image/*"
      class="hidden"
      @change="handleFileSelect"
    />

    <!-- Camera Modal -->
    <div
      v-if="showCamera"
      class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50"
    >
      <div
        class="bg-white rounded-lg shadow-xl max-w-lg w-full mx-4 max-h-[90vh] overflow-hidden"
      >
        <!-- Modal Header -->
        <div class="px-6 py-4 border-b border-gray-200">
          <div class="flex justify-between items-center">
            <h3 class="text-lg font-semibold text-gray-900">Capturar foto</h3>
            <button
              class="text-gray-400 hover:text-gray-600 transition-colors"
              @click="closeCamera"
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
            Posiciona el texto que quieres identificar en el visor y toma la
            foto
          </p>
        </div>

        <!-- Camera Content -->
        <div class="p-6">
          <div
            class="relative bg-gray-100 rounded-lg overflow-hidden"
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
                <p>Iniciando cámara...</p>
              </div>
            </div>

            <!-- Camera Error -->
            <div
              v-if="cameraError"
              class="absolute inset-0 flex items-center justify-center text-red-500"
            >
              <div class="text-center">
                <svg
                  class="w-8 h-8 mx-auto mb-2"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                  />
                </svg>
                <p class="text-sm">Error al acceder a la cámara</p>
                <p class="text-xs mt-1">{{ cameraError }}</p>
              </div>
            </div>

            <!-- Capture overlay -->
            <div
              v-if="cameraReady"
              class="absolute inset-0 border-2 border-dashed border-white border-opacity-50 m-4 rounded-lg pointer-events-none"
            />
          </div>

          <!-- Camera Controls -->
          <div class="flex justify-center gap-4 mt-6">
            <button
              class="px-4 py-2 text-gray-600 bg-white border border-gray-300 hover:bg-gray-50 rounded-lg font-medium transition-colors"
              @click="closeCamera"
            >
              Cancelar
            </button>
            <button
              :disabled="!cameraReady"
              :class="[
                'px-6 py-2 rounded-lg font-medium transition-colors',
                cameraReady
                  ? 'bg-green-600 hover:bg-green-700 text-white'
                  : 'bg-gray-300 text-gray-500 cursor-not-allowed',
              ]"
              @click="capturePhoto"
            >
              <svg
                class="w-5 h-5 inline mr-2"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"
                />
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"
                />
              </svg>
              Capturar
            </button>
          </div>
        </div>
      </div>

      <!-- Hidden canvas for photo capture -->
      <canvas ref="canvasRef" class="hidden" />
    </div>

    <!-- Error message -->
    <div
      v-if="error"
      class="mt-4 p-4 bg-red-50 border border-red-200 rounded-lg"
    >
      <div class="flex items-center">
        <p class="text-red-700">{{ error }}</p>
      </div>
    </div>

    <!-- Success message -->
    <div
      v-if="success"
      class="mt-4 p-4 bg-green-50 border border-green-200 rounded-lg"
    >
      <div class="flex items-center">
        <svg
          class="w-5 h-5 text-green-400 mr-2"
          fill="none"
          stroke="currentColor"
          viewBox="0 0 24 24"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M5 13l4 4L19 7"
          />
        </svg>
        <p class="text-green-700">{{ success }}</p>
      </div>
    </div>

    <!-- Tips Section -->
    <div class="mt-8 p-6 bg-blue-50 border border-blue-200 rounded-lg">
      <h3 class="text-lg font-semibold text-blue-800 mb-4 flex items-center">
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
            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
          />
        </svg>
        Consejos para mejores resultados
      </h3>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="space-y-3">
          <div class="flex items-start">
            <div
              class="bg-green-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-sm font-bold mr-3 mt-0.5 flex-shrink-0"
            >
              ✓
            </div>
            <div>
              <p class="font-medium text-blue-800">Texto claro y legible</p>
              <p class="text-sm text-blue-600">
                Usa imágenes con texto nítido y bien enfocado
              </p>
            </div>
          </div>

          <div class="flex items-start">
            <div
              class="bg-green-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-sm font-bold mr-3 mt-0.5 flex-shrink-0"
            >
              ✓
            </div>
            <div>
              <p class="font-medium text-blue-800">Fondo contrastante</p>
              <p class="text-sm text-blue-600">
                El texto debe destacar claramente del fondo
              </p>
            </div>
          </div>

          <div class="flex items-start">
            <div
              class="bg-green-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-sm font-bold mr-3 mt-0.5 flex-shrink-0"
            >
              ✓
            </div>
            <div>
              <p class="font-medium text-blue-800">
                Texto normal, no logotipos
              </p>
              <p class="text-sm text-blue-600">
                Funciona mejor con párrafos, títulos o texto convencional
              </p>
            </div>
          </div>

          <div class="flex items-start">
            <div
              class="bg-green-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-sm font-bold mr-3 mt-0.5 flex-shrink-0"
            >
              ✓
            </div>
            <div>
              <p class="font-medium text-blue-800">Tamaño adecuado</p>
              <p class="text-sm text-blue-600">
                Las imágenes grandes se redimensionan automáticamente
              </p>
            </div>
          </div>
        </div>

        <div class="space-y-3">
          <div class="flex items-start">
            <div
              class="bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-sm font-bold mr-3 mt-0.5 flex-shrink-0"
            >
              ✗
            </div>
            <div>
              <p class="font-medium text-blue-800">Texto superpuesto</p>
              <p class="text-sm text-blue-600">
                Evita caracteres que se toquen o superpongan
              </p>
            </div>
          </div>

          <div class="flex items-start">
            <div
              class="bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-sm font-bold mr-3 mt-0.5 flex-shrink-0"
            >
              ✗
            </div>
            <div>
              <p class="font-medium text-blue-800">Imágenes borrosas</p>
              <p class="text-sm text-blue-600">
                La calidad debe ser suficiente para leer el texto
              </p>
            </div>
          </div>

          <div class="flex items-start">
            <div
              class="bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-sm font-bold mr-3 mt-0.5 flex-shrink-0"
            >
              ✗
            </div>
            <div>
              <p class="font-medium text-blue-800">Logotipos muy estilizados</p>
              <p class="text-sm text-blue-600">
                Evita diseños gráficos complejos donde las letras son formas
                artísticas
              </p>
            </div>
          </div>

          <div class="flex items-start">
            <div
              class="bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-sm font-bold mr-3 mt-0.5 flex-shrink-0"
            >
              ✗
            </div>
            <div>
              <p class="font-medium text-blue-800">Texto muy pequeño</p>
              <p class="text-sm text-blue-600">
                Asegúrate de que el texto sea lo suficientemente grande
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Examples Section -->
    <div class="mt-6 p-6 bg-amber-50 border border-amber-200 rounded-lg">
      <h4 class="text-lg font-semibold text-amber-800 mb-4 flex items-center">
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
            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C20.832 18.477 19.246 18 17.5 18c-1.746 0-3.332.477-4.5 1.253"
          />
        </svg>
        Ejemplos de imágenes que funcionan mejor
      </h4>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="space-y-4">
          <div class="bg-green-100 border border-green-200 rounded-lg p-4">
            <h5 class="font-semibold text-green-800 mb-2">✅ Recomendado:</h5>
            <ul class="text-sm text-green-700 space-y-1">
              <li>• Texto de libros o revistas</li>
              <li>• Títulos de artículos o páginas web</li>
              <li>• Texto en carteles o anuncios</li>
              <li>• Párrafos de documentos</li>
              <li>• Subtítulos de películas</li>
            </ul>
          </div>
        </div>

        <div class="space-y-4">
          <div class="bg-red-100 border border-red-200 rounded-lg p-4">
            <h5 class="font-semibold text-red-800 mb-2">❌ Evitar:</h5>
            <ul class="text-sm text-red-700 space-y-1">
              <li>• Logotipos artísticos</li>
              <li>• Letras que son formas decorativas</li>
              <li>• Texto muy distorsionado o con efectos</li>
              <li>• Graffitis o lettering manual</li>
              <li>• Diseños donde las letras son objetos</li>
            </ul>
          </div>
        </div>
      </div>

      <div class="mt-4 p-4 bg-amber-100 border border-amber-300 rounded-lg">
        <p class="text-sm text-amber-800 mb-3">
          <strong>💡 Consejo:</strong>
          Esta herramienta está optimizada para identificar fuentes tipográficas
          utilizadas en texto legible, no para analizar diseños gráficos o
          logotipos donde las letras forman parte del arte.
        </p>
        <div class="text-center">
          <button
            class="bg-amber-600 hover:bg-amber-700 text-white px-4 py-2 rounded-lg font-semibold transition-colors text-sm cursor-pointer"
            @click="goToExamples"
          >
            Ver más ejemplos y guía completa
          </button>
        </div>
      </div>
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
import { ref } from 'vue'
import { router } from '@inertiajs/vue3'
import ImageCropper from './ImageCropper.vue'
import { useImageUpload } from '@/composables/useImageUpload'
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
    success.value = `¡${result.data.total_found} fuente(s) identificada(s)! Redirigiendo a los resultados...`
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

    success.value =
      'Imagen recortada correctamente. ¡Ahora puedes identificar la fuente!'
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

        success.value =
          'Foto capturada correctamente. ¡Ahora puedes identificar la fuente!'
      } else {
        error.value = 'Error al capturar la foto. Inténtalo de nuevo.'
      }
    },
    'image/jpeg',
    0.8
  )
}

const goToExamples = () => {
  router.visit('/examples')
}
</script>

<style scoped>
/* Custom drag and drop styles */
</style>
