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

  await page.getByLabel('Name').fill(user.name)
  await page.getByLabel('Email').fill(user.email)
  await page.getByLabel('Password', { exact: true }).fill(user.password)
  await page.getByLabel('Confirm Password').fill(user.password)
  await page.getByRole('button', { name: /register/i }).click()

  await expect(page).toHaveURL(/\/dashboard$/)
  const userMenuButton = page
    .getByRole('button', { name: new RegExp(user.name, 'i') })
    .first()
  await expect(userMenuButton).toBeVisible()

  await userMenuButton.click()
  await page.getByRole('button', { name: /log out/i }).click()

  await expect(page).toHaveURL(/\/$/)

  await page.goto('/login')
  await page.getByLabel('Email').fill(user.email)
  await page.getByLabel('Password').fill(user.password)
  await page.getByRole('button', { name: /log in/i }).click()

  await expect(page).toHaveURL(/\/dashboard$/)
  await page.screenshot({
    path: '.sisyphus/evidence/task-2-breeze-auth.png',
    fullPage: true,
  })
})
