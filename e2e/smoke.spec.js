import { test, expect } from '@playwright/test'

test('homepage loads successfully', async ({ page }) => {
  await page.goto('/')
  await expect(page.locator('#app')).toHaveAttribute('data-page', /.+/, { timeout: 10000 })
  await expect(page.getByRole('heading', { name: /Identifica cualquier/i })).toBeVisible({ timeout: 15000 })
})
