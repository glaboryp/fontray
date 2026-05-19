import { ref } from 'vue'
import { router } from '@inertiajs/vue3'

export function useFontIdentification() {
  const isProcessing = ref(false)

  const identifyFont = async (image, resizeImageIfNeeded) => {
    if (!image) return

    isProcessing.value = true

    try {
      const processedImage = await resizeImageIfNeeded(image)
      const formData = new FormData()
      formData.append('image', processedImage)

      router.post('/identify', formData, {
        onFinish: () => {
          isProcessing.value = false
        },
      })
    } catch {
      isProcessing.value = false
    }
  }

  return {
    isProcessing,
    identifyFont,
  }
}
