import { ref } from 'vue'

export function useFontIdentification() {
  const isProcessing = ref(false)

  const identifyFont = async (image, resizeImageIfNeeded, emit) => {
    if (!image) return

    isProcessing.value = true

    try {
      const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')

      if (!csrfToken) {
        return {
          success: false,
          message: 'No se pudo verificar la sesión. Por favor, recarga la página e inténtalo de nuevo.',
        }
      }

      const processedImage = await resizeImageIfNeeded(image)

      const formData = new FormData()
      formData.append('image', processedImage)

      const response = await fetch('/identify', {
        method: 'POST',
        body: formData,
        headers: {
          'X-CSRF-TOKEN': csrfToken,
        },
      })

      const data = await response.json()

      if (data.success) {
        emit('font-identified', {
          fonts: data.fonts,
          totalFound: data.total_found,
        })
        return { success: true, data }
      } else {
        return { success: false, message: data.message || 'Error al procesar la imagen' }
      }
    } catch {
      return {
        success: false,
        message: 'Error de conexión. Por favor, verifica tu conexión a internet e inténtalo de nuevo.',
      }
    } finally {
      isProcessing.value = false
    }
  }

  return {
    isProcessing,
    identifyFont,
  }
}
