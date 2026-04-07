import { describe, it, expect, vi } from 'vitest'
import { useImageUpload } from '../useImageUpload.js'

describe('useImageUpload', () => {
  it('processFile validates file type', () => {
    const { processFile, error, selectedImage } = useImageUpload()

    const textFile = new File(['hello'], 'doc.txt', { type: 'text/plain' })
    processFile(textFile)

    expect(error.value).toContain('imagen válido')
    expect(selectedImage.value).toBeNull()
  })

  it('processFile validates file size (max 10MB)', () => {
    const { processFile, error, selectedImage } = useImageUpload()

    const bigFile = new File([new ArrayBuffer(11 * 1024 * 1024)], 'big.jpg', { type: 'image/jpeg' })
    processFile(bigFile)

    expect(error.value).toContain('demasiado grande')
    expect(selectedImage.value).toBeNull()
  })

  it('processFile sets selectedImage for valid file', () => {
    const { processFile, selectedImage, success } = useImageUpload()

    const file = new File(['fake-image'], 'photo.jpg', { type: 'image/jpeg' })
    processFile(file)

    expect(selectedImage.value.name).toBe(file.name)
    expect(success.value).toContain('Imagen cargada correctamente')
  })

  it('processFile shows large file warning for >2MB', () => {
    const { processFile, success } = useImageUpload()

    const bigFile = new File([new ArrayBuffer(3 * 1024 * 1024)], 'big.jpg', { type: 'image/jpeg' })
    processFile(bigFile)

    expect(success.value).toContain('redimensionada automáticamente')
  })

  it('removeImage resets state', () => {
    const { processFile, removeImage, selectedImage, previewUrl, error, success } = useImageUpload()

    const file = new File(['fake'], 'photo.jpg', { type: 'image/jpeg' })
    processFile(file)

    removeImage()

    expect(selectedImage.value).toBeNull()
    expect(previewUrl.value).toBe('')
    expect(error.value).toBe('')
    expect(success.value).toBe('')
  })

  it('formatFileSize formats correctly', () => {
    const { formatFileSize } = useImageUpload()

    expect(formatFileSize(0)).toBe('0 Bytes')
    expect(formatFileSize(1024)).toBe('1 KB')
    expect(formatFileSize(1048576)).toBe('1 MB')
    expect(formatFileSize(1500)).toBe('1.46 KB')
  })

  it('handleDrop processes dropped file', () => {
    const { handleDrop, selectedImage } = useImageUpload()
    const file = new File(['img'], 'dropped.jpg', { type: 'image/jpeg' })
    const event = {
      preventDefault: vi.fn(),
      dataTransfer: { files: [file] },
    }

    handleDrop(event)

    expect(event.preventDefault).toHaveBeenCalled()
    expect(selectedImage.value.name).toBe(file.name)
  })

  it('handleFileSelect processes selected file', () => {
    const { handleFileSelect, selectedImage } = useImageUpload()
    const file = new File(['img'], 'selected.jpg', { type: 'image/jpeg' })
    const event = { target: { files: [file] } }

    handleFileSelect(event)

    expect(selectedImage.value.name).toBe(file.name)
  })
})
