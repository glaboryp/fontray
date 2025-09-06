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

          <!-- Upload Button -->
          <button
            class="bg-primary hover:bg-primary-dark text-white font-medium py-2 px-6 rounded-lg transition-colors cursor-pointer"
            @click="triggerFileInput"
          >
            Seleccionar imagen
          </button>

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
            @click="removeImage"
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
import { ref, defineEmits } from 'vue'
import { router } from '@inertiajs/vue3'
import ImageCropper from './ImageCropper.vue'

// Emits
const emit = defineEmits(['uploaded', 'font-identified'])

// Reactive data
const isDragging = ref(false)
const selectedImage = ref(null)
const previewUrl = ref('')
const isProcessing = ref(false)
const error = ref('')
const success = ref('')
const fileInput = ref(null)
const showCropper = ref(false)

// Methods
const triggerFileInput = () => {
  fileInput.value.click()
}

const handleFileSelect = event => {
  const file = event.target.files[0]
  if (file) {
    processFile(file)
  }
}

const handleDrop = event => {
  event.preventDefault()
  isDragging.value = false

  const files = event.dataTransfer.files
  if (files.length > 0) {
    processFile(files[0])
  }
}

const processFile = file => {
  // Reset messages
  error.value = ''
  success.value = ''

  // Validate file type
  if (!file.type.startsWith('image/')) {
    error.value = 'Por favor selecciona un archivo de imagen válido.'
    return
  }

  // Validate file size (10MB max)
  if (file.size > 10 * 1024 * 1024) {
    error.value = 'El archivo es demasiado grande. El tamaño máximo es 10MB.'
    return
  }

  selectedImage.value = file

  // Create preview URL
  const reader = new FileReader()
  reader.onload = e => {
    previewUrl.value = e.target.result
  }
  reader.readAsDataURL(file)

  // Mostrar mensaje apropiado según el tamaño
  if (file.size > 2 * 1024 * 1024) {
    // 2MB
    success.value =
      'Imagen cargada correctamente. Nota: La imagen es grande y será redimensionada automáticamente para optimizar el proceso de identificación.'
  } else {
    success.value =
      'Imagen cargada correctamente. ¡Haz clic en "Identificar fuente" para continuar!'
  }
}

const removeImage = () => {
  selectedImage.value = null
  previewUrl.value = ''
  error.value = ''
  success.value = ''

  // Reset file input
  if (fileInput.value) {
    fileInput.value.value = ''
  }
}

// Función para redimensionar imagen si es necesario
const resizeImageIfNeeded = (
  file,
  maxWidth = 1200,
  maxHeight = 1200,
  quality = 0.8
) => {
  return new Promise(resolve => {
    const canvas = document.createElement('canvas')
    const ctx = canvas.getContext('2d')
    const img = new Image()

    img.onload = () => {
      let { width, height } = img

      // Calcular nuevas dimensiones manteniendo la proporción
      if (width > maxWidth || height > maxHeight) {
        const ratio = Math.min(maxWidth / width, maxHeight / height)
        width *= ratio
        height *= ratio
      }

      // Configurar canvas
      canvas.width = width
      canvas.height = height

      // Dibujar imagen redimensionada
      ctx.drawImage(img, 0, 0, width, height)

      // Convertir a blob
      canvas.toBlob(
        blob => {
          // Crear un nuevo File con el mismo nombre pero redimensionado
          const resizedFile = new File([blob], file.name, {
            type: file.type,
            lastModified: Date.now(),
          })
          resolve(resizedFile)
        },
        file.type,
        quality
      )
    }

    img.onerror = () => {
      // Si hay error, devolver archivo original
      resolve(file)
    }

    // Cargar la imagen
    img.src = URL.createObjectURL(file)
  })
}

const identifyFont = async () => {
  if (!selectedImage.value) return

  isProcessing.value = true
  error.value = ''
  success.value = ''

  try {
    // Redimensionar imagen si es necesario para evitar errores de tamaño
    const processedImage = await resizeImageIfNeeded(selectedImage.value)

    const formData = new FormData()
    formData.append('image', processedImage)

    const response = await fetch('/identify', {
      method: 'POST',
      body: formData,
      headers: {
        'X-CSRF-TOKEN': document
          .querySelector('meta[name="csrf-token"]')
          .getAttribute('content'),
      },
    })

    const data = await response.json()

    if (data.success) {
      success.value = `¡${data.total_found} fuente(s) identificada(s)! Redirigiendo a los resultados...`

      // Emitir los resultados al componente padre
      emit('font-identified', {
        fonts: data.fonts,
        totalFound: data.total_found,
      })
    } else {
      error.value = data.message || 'Error al procesar la imagen'
    }
  } catch {
    error.value =
      'Error de conexión. Por favor, verifica tu conexión a internet e inténtalo de nuevo.'
  } finally {
    isProcessing.value = false
  }
}

const openCropper = () => {
  if (selectedImage.value) {
    showCropper.value = true
  }
}

const handleCropApplied = async croppedBlob => {
  try {
    // Crear un nuevo archivo con la imagen recortada
    const croppedFile = new File([croppedBlob], selectedImage.value.name, {
      type: selectedImage.value.type,
      lastModified: Date.now(),
    })

    // Actualizar la imagen seleccionada y la vista previa
    selectedImage.value = croppedFile
    previewUrl.value = URL.createObjectURL(croppedBlob)

    // Cerrar el cropper
    showCropper.value = false

    // Mostrar mensaje de éxito
    success.value =
      'Imagen recortada correctamente. ¡Ahora puedes identificar la fuente!'
  } catch {
    error.value = 'Error al aplicar el recorte. Inténtalo de nuevo.'
  }
}

const formatFileSize = bytes => {
  if (bytes === 0) return '0 Bytes'

  const k = 1024
  const sizes = ['Bytes', 'KB', 'MB', 'GB']
  const i = Math.floor(Math.log(bytes) / Math.log(k))

  return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i]
}

const goToExamples = () => {
  router.visit('/examples')
}
</script>

<style scoped>
/* Custom drag and drop styles */
</style>
