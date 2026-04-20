import { test, expect } from '@playwright/test'

test('user can view search history dashboard', async ({ page }) => {
  const timestamp = Date.now()
  const user = {
    name: 'History User',
    email: `history-${timestamp}@example.com`,
    password: 'password123',
  }

  // Crear cuenta user first
  await page.goto('/register')
  await page.getByLabel('Nombre').fill(user.name)
  await page.getByLabel('Correo electrónico').fill(user.email)
  await page.getByLabel('Contraseña', { exact: true }).fill(user.password)
  await page.getByLabel('Confirmar contraseña').fill(user.password)
  await page.getByRole('button', { name: /crear cuenta/i }).click()

  await expect(page).toHaveURL(/\/$/)

  // Navigate to history using authenticated dropdown
  const userMenuButton = page
    .getByRole('button', { name: new RegExp(user.name, 'i') })
    .first()
  await expect(userMenuButton).toBeVisible()
  await userMenuButton.click()
  await page
    .getByRole('link', { name: 'Historial de búsquedas', exact: true })
    .click()

  // Wait for history page to load
  await expect(page).toHaveURL(/\/history$/)

  // Verify heading
  await expect(
    page.getByRole('heading', { name: 'Historial de búsquedas' })
  ).toBeVisible()

  // By default, a new user has no history
  await expect(page.getByText('No hay búsquedas registradas.')).toBeVisible()
})

test('authenticated user sees search history after identification', async ({
  page,
}) => {
  const timestamp = Date.now()
  const user = {
    name: 'History Tester',
    email: `historytest-${timestamp}@example.com`,
    password: 'password123',
  }

  // Crear cuenta user first
  await page.goto('/register')
  await page.getByLabel('Nombre').fill(user.name)
  await page.getByLabel('Correo electrónico').fill(user.email)
  await page.getByLabel('Contraseña', { exact: true }).fill(user.password)
  await page.getByLabel('Confirmar contraseña').fill(user.password)
  await page.getByRole('button', { name: /crear cuenta/i }).click()

  await expect(page).toHaveURL(/\/$/)

  // Navigate to home and upload an image
  await page.goto('/')
  const fileInput = page.locator('input[type="file"][accept="image/*"]')
  await fileInput.setInputFiles('tests/Fixtures/test_image.jpg')
  await expect(page.locator('img[alt="Imagen seleccionada"]')).toBeVisible()

  // Identify
  const identifyButton = page.getByRole('button', {
    name: /Identificar fuente/i,
  })
  await identifyButton.click()
  await expect(page).toHaveURL(/\/results/)

  // Go to History
  await page.goto('/history')

  // Should have at least one history card
  await expect(
    page.getByText('No hay búsquedas registradas.')
  ).not.toBeVisible()

  // Contract check: UI must not guess /storage/<raw-filename> from image_reference
  const images = page.locator('img[alt="Imagen de búsqueda"]')
  const imageCount = await images.count()

  if (imageCount > 0) {
    const firstImageSrc = await images.first().getAttribute('src')
    expect(firstImageSrc).toMatch(/\/history\/\d+\/image/)
  } else {
    await expect(page.getByText('Sin imagen').first()).toBeVisible()
  }

  // History cards show found-fonts title and navigate to replay results
  await expect(
    page.getByRole('heading', { name: /\d+\s+fuentes encontradas/i }).first()
  ).toBeVisible()
  await page.locator('[role="button"]').first().click()
  await expect(page).toHaveURL(/\/results/)
  await expect(page.getByText(/resultados/i).first()).toBeVisible()
})
