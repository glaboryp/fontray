import { ref } from 'vue'

export function useImageUpload() {
  const isDragging = ref(false)
  const selectedImage = ref(null)
  const previewUrl = ref('')
  const error = ref('')
  const success = ref('')

  const processFile = (file) => {
    error.value = ''
    success.value = ''

    if (!file.type.startsWith('image/')) {
      error.value = 'Por favor selecciona un archivo de imagen válido.'
      return
    }

    if (file.size > 10 * 1024 * 1024) {
      error.value = 'El archivo es demasiado grande. El tamaño máximo es 10MB.'
      return
    }

    selectedImage.value = file

    const reader = new FileReader()
    reader.onload = (e) => {
      previewUrl.value = e.target.result
    }
    reader.readAsDataURL(file)

    if (file.size > 2 * 1024 * 1024) {
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
  }

  const handleDrop = (event) => {
    event.preventDefault()
    isDragging.value = false
    const files = event.dataTransfer.files
    if (files.length > 0) {
      processFile(files[0])
    }
  }

  const handleFileSelect = (event) => {
    const file = event.target.files[0]
    if (file) {
      processFile(file)
    }
  }

  const formatFileSize = (bytes) => {
    if (bytes === 0) return '0 Bytes'
    const k = 1024
    const sizes = ['Bytes', 'KB', 'MB', 'GB']
    const i = Math.floor(Math.log(bytes) / Math.log(k))
    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i]
  }

  const resizeImageIfNeeded = (file, maxWidth = 1200, maxHeight = 1200, quality = 0.8) => {
    return new Promise((resolve) => {
      const canvas = document.createElement('canvas')
      const ctx = canvas.getContext('2d')
      const img = new Image()

      img.onload = () => {
        let { width, height } = img
        if (width > maxWidth || height > maxHeight) {
          const ratio = Math.min(maxWidth / width, maxHeight / height)
          width *= ratio
          height *= ratio
        }
        canvas.width = width
        canvas.height = height
        ctx.drawImage(img, 0, 0, width, height)
        canvas.toBlob(
          (blob) => {
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
        resolve(file)
      }

      img.src = URL.createObjectURL(file)
    })
  }

  return {
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
  }
}
