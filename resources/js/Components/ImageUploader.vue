<template>
  <div class="max-w-2xl mx-auto">
    <!-- Upload Area -->
    <div
      :class="[
        'border-2 border-dashed rounded-lg p-8 text-center transition-all duration-200',
        isDragging
          ? 'border-primary-500 bg-primary-50'
          : 'border-gray-300 hover:border-primary-400 hover:bg-gray-50',
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
            class="bg-primary-500 hover:bg-primary-600 text-white font-medium py-2 px-6 rounded-lg transition-colors"
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
            class="absolute top-2 right-2 bg-red-500 hover:bg-red-600 text-white rounded-full p-2 transition-colors"
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

          <!-- Identify Button -->
          <button
            :disabled="isProcessing"
            :class="[
              'font-medium py-3 px-8 rounded-lg transition-all',
              isProcessing
                ? 'bg-gray-400 text-gray-700 cursor-not-allowed'
                : 'bg-green-600 hover:bg-green-700 text-white hover:shadow-lg',
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
        <svg
          class="w-5 h-5 text-red-400 mr-2"
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
  </div>
</template>

<script setup>
import { ref, defineEmits } from 'vue'

// Emits
const emit = defineEmits(['uploaded'])

// Reactive data
const isDragging = ref(false)
const selectedImage = ref(null)
const previewUrl = ref('')
const isProcessing = ref(false)
const error = ref('')
const success = ref('')
const fileInput = ref(null)

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

  success.value =
    'Imagen cargada correctamente. ¡Haz clic en "Identificar fuente" para continuar!'
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

const identifyFont = async () => {
  if (!selectedImage.value) return

  isProcessing.value = true
  error.value = ''

  try {
    // Create FormData for the API call
    const formData = new FormData()
    formData.append('image', selectedImage.value)

    // Emit the uploaded event with the file data
    emit('uploaded', {
      file: selectedImage.value,
      formData: formData,
      preview: previewUrl.value,
    })

    // For now, simulate processing
    await new Promise(resolve => setTimeout(resolve, 2000))

    success.value = '¡Imagen procesada! Redirigiendo a los resultados...'
  } catch (err) {
    error.value =
      'Hubo un error al procesar la imagen. Por favor, inténtalo de nuevo.'
    console.error('Error identifying font:', err)
  } finally {
    isProcessing.value = false
  }
}

const formatFileSize = bytes => {
  if (bytes === 0) return '0 Bytes'

  const k = 1024
  const sizes = ['Bytes', 'KB', 'MB', 'GB']
  const i = Math.floor(Math.log(bytes) / Math.log(k))

  return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i]
}
</script>

<style scoped>
/* Custom drag and drop styles */
</style>
