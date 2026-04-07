import { test, expect } from '@playwright/test'

test('full flow: upload image -> identify -> see results', async ({ page }) => {
  await page.goto('/')

  await expect(page.locator('h1')).toContainText('Identifica cualquier')

  const fileInput = page.locator('input[type="file"][accept="image/*"]')
  await fileInput.setInputFiles('tests/Fixtures/test_image.jpg')

  await expect(page.locator('img[alt="Imagen seleccionada"]')).toBeVisible()

  const identifyButton = page.getByRole('button', { name: /Identificar fuente/i })
  await identifyButton.click()

  await expect(page.getByRole('heading', { name: /Resultados de Identificación/i })).toBeVisible({ timeout: 15000 })
  await expect(page.getByText('Roboto Regular')).toBeVisible({ timeout: 15000 })
  await expect(page.getByText('Open Sans')).toBeVisible()
})

test('upload validation: rejects non-image file', async ({ page }) => {
  await page.goto('/')

  const fileInput = page.locator('input[type="file"][accept="image/*"]')
  await fileInput.setInputFiles({
    name: 'not-image.txt',
    mimeType: 'text/plain',
    buffer: Buffer.from('hello world'),
  })

  await expect(page.getByText('Por favor selecciona un archivo de imagen válido.')).toBeVisible()
})

test('navigation: examples/privacy/terms/home all load correctly', async ({ page }) => {
  await page.goto('/examples')
  await expect(page.getByRole('heading', { name: /Ejemplos y Guía de Uso/i })).toBeVisible()

  await page.goto('/privacy')
  await expect(page.getByRole('heading', { name: /Política de Privacidad/i })).toBeVisible()

  await page.goto('/terms')
  await expect(page.getByRole('heading', { name: /Términos de Servicio/i })).toBeVisible()

  await page.goto('/')
  await expect(page.getByRole('heading', { name: /Identifica cualquier/i })).toBeVisible()
})
