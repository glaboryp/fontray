import { describe, it, expect, vi } from 'vitest'
import { mount } from '@vue/test-utils'
import HomePage from '../HomePage.vue'

vi.mock('@inertiajs/vue3', () => ({
  router: { visit: vi.fn() },
  Link: {
    name: 'Link',
    template: '<a><slot /></a>',
  },
}))

describe('HomePage', () => {
  it('renders all sections (hero, upload, how-it-works, faq)', () => {
    const wrapper = mount(HomePage, {
      global: {
        stubs: {
          AppLayout: { template: '<div data-test="layout"><slot /></div>' },
          HeroSection: { template: '<div data-test="hero" />' },
          UploadSection: { template: '<div data-test="upload" />' },
          HowItWorksSection: { template: '<div data-test="how" />' },
          FaqSection: { template: '<div data-test="faq" />' },
        },
      },
    })

    expect(wrapper.find('[data-test="layout"]').exists()).toBe(true)
    expect(wrapper.find('[data-test="hero"]').exists()).toBe(true)
    expect(wrapper.find('[data-test="upload"]').exists()).toBe(true)
    expect(wrapper.find('[data-test="how"]').exists()).toBe(true)
    expect(wrapper.find('[data-test="faq"]').exists()).toBe(true)
  })
})
