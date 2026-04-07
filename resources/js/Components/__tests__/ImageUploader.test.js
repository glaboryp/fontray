import { describe, it, expect, vi, beforeEach } from 'vitest'
import { mount } from '@vue/test-utils'
import { nextTick, ref } from 'vue'
import ImageUploader from '../ImageUploader.vue'

const identifyFontMock = vi.fn()

const state = {
  isDragging: ref(false),
  selectedImage: ref(null),
  previewUrl: ref(''),
  error: ref(''),
  success: ref(''),
  processFile: vi.fn(),
  removeImage: vi.fn(),
  handleDrop: vi.fn(),
  handleFileSelect: vi.fn(),
  formatFileSize: vi.fn().mockReturnValue('10 KB'),
  resizeImageIfNeeded: vi.fn().mockResolvedValue(new File(['x'], 'x.jpg', { type: 'image/jpeg' })),
}

vi.mock('../../composables/useImageUpload', () => ({
  useImageUpload: () => state,
}))

vi.mock('../../composables/useFontIdentification', () => ({
  useFontIdentification: () => ({
    isProcessing: ref(false),
    identifyFont: identifyFontMock,
  }),
}))

vi.mock('@inertiajs/vue3', () => ({
  router: {
    visit: vi.fn(),
  },
  Link: {
    name: 'Link',
    template: '<a><slot /></a>',
  },
}))

describe('ImageUploader', () => {
  beforeEach(() => {
    state.selectedImage.value = null
    state.previewUrl.value = ''
    state.error.value = ''
    state.success.value = ''
    identifyFontMock.mockReset()
  })

  it('renders upload area when no image selected', () => {
    const wrapper = mount(ImageUploader, {
      global: {
        stubs: {
          ImageCropper: true,
        },
      },
    })

    expect(wrapper.text()).toContain('Sube tu imagen')
    expect(wrapper.text()).toContain('Seleccionar imagen')
  })

  it('shows preview when image is selected', async () => {
    state.selectedImage.value = { name: 'test.jpg', size: 10000 }
    state.previewUrl.value = 'blob:mock-url'

    const wrapper = mount(ImageUploader, {
      global: {
        stubs: {
          ImageCropper: true,
        },
      },
    })

    await nextTick()

    expect(wrapper.find('img[alt="Imagen seleccionada"]').exists()).toBe(true)
    expect(wrapper.text()).toContain('test.jpg')
  })

  it('shows error message on invalid file type', async () => {
    state.error.value = 'Por favor selecciona un archivo de imagen válido.'

    const wrapper = mount(ImageUploader, {
      global: {
        stubs: {
          ImageCropper: true,
        },
      },
    })

    await nextTick()

    expect(wrapper.text()).toContain('Por favor selecciona un archivo de imagen válido.')
  })

  it('calls identifyFont when button clicked', async () => {
    state.selectedImage.value = { name: 'test.jpg', size: 10000 }
    state.previewUrl.value = 'blob:mock-url'

    const wrapper = mount(ImageUploader, {
      global: {
        stubs: {
          ImageCropper: true,
        },
      },
    })

    await nextTick()

    const identifyButton = wrapper.findAll('button').find((btn) => btn.text().includes('Identificar fuente'))
    expect(identifyButton).toBeTruthy()

    await identifyButton.trigger('click')

    expect(identifyFontMock).toHaveBeenCalled()
  })
})
