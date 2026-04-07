import { describe, it, expect, vi } from 'vitest'
import { mount } from '@vue/test-utils'
import ImageCropper from '../ImageCropper.vue'

vi.mock('vue-advanced-cropper', () => ({
  Cropper: {
    name: 'Cropper',
    template: '<div data-test="cropper" />',
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

  it('emits cancelled when apply clicked without valid crop result', async () => {
    const wrapper = mount(ImageCropper, {
      props: {
        imageSrc: 'data:image/png;base64,abc',
      },
    })

    const applyButton = wrapper.findAll('button').find((b) => b.text().includes('Aplicar recorte'))
    await applyButton.trigger('click')

    expect(wrapper.emitted('cancelled')).toBeTruthy()
  })
})
