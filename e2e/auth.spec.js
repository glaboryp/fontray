import { test, expect } from '@playwright/test'

test('auth flow: register, logout, and login with same credentials', async ({
  page,
}) => {
  const timestamp = Date.now()
  const user = {
    name: 'Fontray E2E User',
    email: `auth-${timestamp}@example.com`,
    password: 'password123',
  }

  await page.goto('/register')

  await page.getByLabel('Nombre').fill(user.name)
  await page.getByLabel('Correo electrónico').fill(user.email)
  await page.getByLabel('Contraseña', { exact: true }).fill(user.password)
  await page.getByLabel('Confirmar contraseña').fill(user.password)
  await page.getByRole('button', { name: /crear cuenta/i }).click()

  await expect(page).toHaveURL(/\/$/)
  const userMenuButton = page
    .getByRole('button', { name: new RegExp(user.name, 'i') })
    .first()
  await expect(userMenuButton).toBeVisible()

  await userMenuButton.click()
  await expect(
    page.getByRole('link', { name: 'Historial de búsquedas', exact: true })
  ).toBeVisible()
  await page.getByRole('button', { name: /cerrar sesi/i }).click()

  await expect(page).toHaveURL(/\/$/)

  await page.goto('/login')
  await page.getByLabel('Correo electrónico').fill(user.email)
  await page.getByLabel('Contraseña').fill(user.password)
  await page.getByRole('button', { name: /iniciar sesi/i }).click()

  await expect(page).toHaveURL(/\/$/)
  await page.screenshot({
    path: '.sisyphus/evidence/task-2-breeze-auth.png',
    fullPage: true,
  })
})
