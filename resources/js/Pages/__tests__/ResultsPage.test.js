import { describe, it, expect, vi, beforeEach } from 'vitest'
import { mount, flushPromises } from '@vue/test-utils'
import ResultsPage from '../ResultsPage.vue'

const { routerVisit, pageState } = vi.hoisted(() => ({
  routerVisit: vi.fn(),
  pageState: { props: {} },
}))

vi.mock('@inertiajs/vue3', () => ({
  router: { visit: routerVisit },
  usePage: () => pageState,
  Link: {
    name: 'Link',
    template: '<a><slot /></a>',
  },
}))

describe('ResultsPage', () => {
  beforeEach(() => {
    routerVisit.mockReset()
    pageState.props = {}
    window.history.pushState({}, '', '/results')
  })

  it('shows no results state when fonts array is empty', async () => {
    pageState.props = { fonts: [] }
    const wrapper = mount(ResultsPage, {
      global: {
        stubs: {
          AppLayout: { template: '<div><slot /></div>' },
        },
      },
    })

    await flushPromises()

    expect(wrapper.text()).toContain('No se encontraron fuentes')
  })

  it('renders font cards when fonts are provided', async () => {
    const fonts = [
      {
        name: 'Roboto',
        similarity: 100,
        link: 'https://x',
        preview: null,
        category: 'Sans',
        foundry: null,
      },
      {
        name: 'Lato',
        similarity: 95,
        link: 'https://y',
        preview: null,
        category: 'Sans',
        foundry: null,
      },
    ]
    const encoded = encodeURIComponent(JSON.stringify(fonts))
    window.history.pushState({}, '', `/results?fonts=${encoded}`)

    const wrapper = mount(ResultsPage, {
      global: {
        stubs: {
          AppLayout: { template: '<div><slot /></div>' },
        },
      },
    })

    await flushPromises()

    expect(wrapper.text()).toContain('Roboto')
    expect(wrapper.text()).toContain('Lato')
    expect(wrapper.text()).toContain('2 resultados')
  })

  it('sorts fonts by name when selected', async () => {
    const fonts = [
      {
        name: 'Zebra',
        similarity: 10,
        link: null,
        preview: null,
        category: 'A',
        foundry: null,
      },
      {
        name: 'Alpha',
        similarity: 90,
        link: null,
        preview: null,
        category: 'A',
        foundry: null,
      },
    ]
    const encoded = encodeURIComponent(JSON.stringify(fonts))
    window.history.pushState({}, '', `/results?fonts=${encoded}`)

    const wrapper = mount(ResultsPage, {
      global: {
        stubs: {
          AppLayout: { template: '<div><slot /></div>' },
        },
      },
    })

    await flushPromises()

    const select = wrapper.find('select')
    await select.setValue('name')

    const headings = wrapper.findAll('h3.font-bold')
    expect(headings[0].text()).toBe('Alpha')
  })

  it('sorts fonts by similarity when selected', async () => {
    const fonts = [
      {
        name: 'A',
        similarity: 10,
        link: null,
        preview: null,
        category: 'A',
        foundry: null,
      },
      {
        name: 'B',
        similarity: 90,
        link: null,
        preview: null,
        category: 'A',
        foundry: null,
      },
    ]
    const encoded = encodeURIComponent(JSON.stringify(fonts))
    window.history.pushState({}, '', `/results?fonts=${encoded}`)

    const wrapper = mount(ResultsPage, {
      global: {
        stubs: {
          AppLayout: { template: '<div><slot /></div>' },
        },
      },
    })

    await flushPromises()

    const select = wrapper.find('select')
    await select.setValue('similarity')

    const headings = wrapper.findAll('h3.font-bold')
    expect(headings[0].text()).toBe('B')
  })

  it('shows a friendly API error message from query params', async () => {
    const friendlyError =
      'Has alcanzado temporalmente el límite de solicitudes. Por favor, inténtalo más tarde.'
    window.history.pushState(
      {},
      '',
      `/results?error=${encodeURIComponent(friendlyError)}`
    )

    const wrapper = mount(ResultsPage, {
      global: {
        stubs: {
          AppLayout: { template: '<div><slot /></div>' },
        },
      },
    })

    await flushPromises()

    expect(wrapper.text()).toContain('Error al cargar resultados')
    expect(wrapper.text()).toContain(friendlyError)
  })
})
