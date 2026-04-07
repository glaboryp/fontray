import { describe, it, expect, vi, beforeEach } from 'vitest'
import { useFontIdentification } from '../useFontIdentification.js'

describe('useFontIdentification', () => {
  beforeEach(() => {
    vi.restoreAllMocks()
  })

  it('identifyFont sends FormData to /identify', async () => {
    const mockFetch = vi.fn().mockResolvedValue({
      json: () => Promise.resolve({ success: true, fonts: [], total_found: 0 }),
    })
    vi.stubGlobal('fetch', mockFetch)

    const { identifyFont } = useFontIdentification()
    const image = new File(['img'], 'test.jpg', { type: 'image/jpeg' })
    const resizeStub = vi.fn().mockResolvedValue(image)
    const emitStub = vi.fn()

    await identifyFont(image, resizeStub, emitStub)

    expect(mockFetch).toHaveBeenCalledWith('/identify', expect.objectContaining({
      method: 'POST',
    }))
  })

  it('identifyFont emits font-identified on success', async () => {
    const fonts = [{ name: 'Roboto' }]
    vi.stubGlobal('fetch', vi.fn().mockResolvedValue({
      json: () => Promise.resolve({ success: true, fonts, total_found: 1 }),
    }))

    const { identifyFont } = useFontIdentification()
    const image = new File(['img'], 'test.jpg', { type: 'image/jpeg' })
    const resizeStub = vi.fn().mockResolvedValue(image)
    const emitStub = vi.fn()

    await identifyFont(image, resizeStub, emitStub)

    expect(emitStub).toHaveBeenCalledWith('font-identified', {
      fonts,
      totalFound: 1,
    })
  })

  it('identifyFont returns error on failure', async () => {
    vi.stubGlobal('fetch', vi.fn().mockResolvedValue({
      json: () => Promise.resolve({ success: false, message: 'No text detected' }),
    }))

    const { identifyFont } = useFontIdentification()
    const image = new File(['img'], 'test.jpg', { type: 'image/jpeg' })
    const resizeStub = vi.fn().mockResolvedValue(image)
    const emitStub = vi.fn()

    const result = await identifyFont(image, resizeStub, emitStub)

    expect(result.success).toBe(false)
    expect(result.message).toBe('No text detected')
    expect(emitStub).not.toHaveBeenCalled()
  })

  it('identifyFont sets isProcessing during request', async () => {
    let resolvePromise
    vi.stubGlobal('fetch', vi.fn().mockImplementation(() => {
      return new Promise((resolve) => {
        resolvePromise = resolve
      })
    }))

    const { identifyFont, isProcessing } = useFontIdentification()
    const image = new File(['img'], 'test.jpg', { type: 'image/jpeg' })
    const resizeStub = vi.fn().mockResolvedValue(image)
    const emitStub = vi.fn()

    expect(isProcessing.value).toBe(false)

    const promise = identifyFont(image, resizeStub, emitStub)
    await vi.waitFor(() => expect(isProcessing.value).toBe(true))

    resolvePromise({ json: () => Promise.resolve({ success: true, fonts: [], total_found: 0 }) })
    await promise

    expect(isProcessing.value).toBe(false)
  })

  it('identifyFont handles network error', async () => {
    vi.stubGlobal('fetch', vi.fn().mockRejectedValue(new Error('Network error')))

    const { identifyFont } = useFontIdentification()
    const image = new File(['img'], 'test.jpg', { type: 'image/jpeg' })
    const resizeStub = vi.fn().mockResolvedValue(image)
    const emitStub = vi.fn()

    const result = await identifyFont(image, resizeStub, emitStub)

    expect(result.success).toBe(false)
    expect(result.message).toContain('Error de conexión')
  })

  it('identifyFont does nothing if no image', async () => {
    const { identifyFont, isProcessing } = useFontIdentification()
    const resizeStub = vi.fn()
    const emitStub = vi.fn()

    await identifyFont(null, resizeStub, emitStub)

    expect(isProcessing.value).toBe(false)
    expect(resizeStub).not.toHaveBeenCalled()
  })
})
