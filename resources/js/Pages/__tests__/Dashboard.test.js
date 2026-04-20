import { describe, it, expect, vi } from 'vitest'
import { mount } from '@vue/test-utils'
import Dashboard from '../Dashboard.vue'

vi.mock('@inertiajs/vue3', () => ({
  Head: { template: '<div><slot /></div>' },
}))

describe('Dashboard', () => {
  it('renders "You\'re logged in"', () => {
    const wrapper = mount(Dashboard, {
      global: {
        stubs: {
          AuthenticatedLayout: {
            template: '<div><slot name="header"></slot><slot></slot></div>',
          },
        },
      },
    })
    expect(wrapper.text()).toContain('You\'re logged in')
    expect(wrapper.text()).toContain('Dashboard')
  })
})
