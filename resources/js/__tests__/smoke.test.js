import { describe, it, expect } from 'vitest'
import { mount } from '@vue/test-utils'
import { defineComponent, h } from 'vue'

describe('Vitest Setup', () => {
  it('can mount a Vue component', () => {
    const TestComponent = defineComponent({
      render() {
        return h('div', 'Hello Vitest')
      },
    })
    const wrapper = mount(TestComponent)
    expect(wrapper.text()).toBe('Hello Vitest')
  })

  it('has CSRF token meta tag available', () => {
    const meta = document.querySelector('meta[name="csrf-token"]')
    expect(meta).not.toBeNull()
    expect(meta.getAttribute('content')).toBe('test-csrf-token')
  })
})
