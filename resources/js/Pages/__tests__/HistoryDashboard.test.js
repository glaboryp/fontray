import { describe, it, expect, vi } from 'vitest'
import { mount } from '@vue/test-utils'
import HistoryDashboard from '../HistoryDashboard.vue'

vi.mock('@inertiajs/vue3', () => ({
  Head: { template: '<div><slot /></div>' },
  Link: { template: '<a><slot /></a>', props: ['href', 'class'] },
}))

describe('HistoryDashboard (Search History UI)', () => {
  it('renders history entries when histories prop is provided', () => {
    const histories = {
      data: [
        {
          id: 1,
          image_reference: 'test.jpg',
          image_url: '/storage/images/test.jpg',
          font_results: { success: true, total_found: 2, fonts: [] },
          created_at: '2023-10-01T12:00:00Z',
        },
        {
          id: 2,
          image_reference: null,
          image_url: null,
          font_results: { success: true, total_found: 0, fonts: [] },
          created_at: '2023-10-02T12:00:00Z',
        },
      ],
      links: [],
    }

    const wrapper = mount(HistoryDashboard, {
      props: {
        histories,
      },
      global: {
        stubs: {
          AppLayout: {
            template: '<div><slot /></div>',
          },
        },
      },
    })

    expect(wrapper.text()).toContain('Historial de búsquedas')
    expect(wrapper.text()).toContain('2 fuentes encontradas')

    const imgs = wrapper.findAll('img')
    expect(imgs.length).toBeGreaterThanOrEqual(1)
    expect(imgs[0].attributes('src')).toBe('/storage/images/test.jpg')
  })

  it('does not render image tag when image_url is missing', () => {
    const histories = {
      data: [
        {
          id: 1,
          image_reference: 'raw-file-name.jpg',
          image_url: null,
          font_results: { success: true, total_found: 1, fonts: [] },
          created_at: '2023-10-01T12:00:00Z',
        },
      ],
      links: [],
    }

    const wrapper = mount(HistoryDashboard, {
      props: { histories },
      global: {
        stubs: {
          AppLayout: {
            template: '<div><slot /></div>',
          },
        },
      },
    })

    expect(wrapper.findAll('img')).toHaveLength(0)
    expect(wrapper.text()).toContain('Sin imagen')
    expect(wrapper.text()).toContain('1 fuentes encontradas')
  })
})
