import { describe, it, expect, vi } from 'vitest'
import { mount } from '@vue/test-utils'
import ImageCropper from '../ImageCropper.vue'

HTMLCanvasElement.prototype.toBlob = function (callback) {
  callback(new Blob(['mock-blob'], { type: 'image/jpeg' }))
}

vi.mock('vue-advanced-cropper', () => ({
  Cropper: {
    name: 'Cropper',
    template: '<div data-test="cropper" />',
    methods: {
      getResult() {
        const canvas = document.createElement('canvas')
        canvas.width = 100
        canvas.height = 100
        return {
          canvas,
          coordinates: { width: 100, height: 100 }
        }
      },
      rotate: vi.fn()
    }
  },
}))

describe('ImageCropper', () => {
  it('renders cropper with image source', () => {
    const wrapper = mount(ImageCropper, {
      props: {
        imageSrc: 'data:image/png;base64,abc',
      },
    })

    expect(wrapper.find('[data-test="cropper"]').exists()).toBe(true)
    expect(wrapper.text()).toContain('Recortar imagen')
  })

  it('emits cancelled when cancel button clicked', async () => {
    const wrapper = mount(ImageCropper, {
      props: {
        imageSrc: 'data:image/png;base64,abc',
      },
    })

    const cancelButton = wrapper.findAll('button').find((b) => b.text().includes('Cancelar'))
    await cancelButton.trigger('click')

    expect(wrapper.emitted('cancelled')).toBeTruthy()
  })

  it('has controls to rotate the image', async () => {
    const wrapper = mount(ImageCropper, {
      props: {
        imageSrc: 'data:image/png;base64,abc',
      },
    })

    const rotateButton = wrapper.findAll('button').find((b) => b.text().includes('Rotar'))
    expect(rotateButton).toBeDefined()
    expect(rotateButton.exists()).toBe(true)

    expect(wrapper.vm.rotation).toBe(0)
    
    await rotateButton.trigger('click')
    expect(wrapper.vm.rotation).toBe(90)
  })

  it('has a slider to adjust contrast', async () => {
    const wrapper = mount(ImageCropper, {
      props: {
        imageSrc: 'data:image/png;base64,abc',
      },
    })

    const slider = wrapper.find('input[type="range"]')
    expect(slider.exists()).toBe(true)

    expect(wrapper.vm.contrast).toBe(100)
    
    await slider.setValue(150)
    expect(Number(wrapper.vm.contrast)).toBe(150)
  })
})

describe('ImageCropper - emit applied', () => {
  it('emits crop-applied with blob when apply clicked and result is valid', async () => {
    const wrapper = mount(ImageCropper, {
      props: {
        imageSrc: 'data:image/png;base64,abc',
      },
    })
    
    // We mocked vue-advanced-cropper to return a valid canvas by default
    // so we just trigger click
    const applyButton = wrapper.findAll('button').find((b) => b.text().includes('Aplicar recorte'))
    await applyButton.trigger('click')

    expect(wrapper.emitted('crop-applied')).toBeTruthy()
    expect(wrapper.emitted('crop-applied')[0][0]).toBeInstanceOf(Blob)
  })
})
