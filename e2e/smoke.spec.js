import { test, expect } from '@playwright/test'

test('homepage loads successfully', async ({ page }) => {
  await page.goto('/')
  // Verify the page HTML is served (Inertia data-page attribute proves Laravel+Inertia works)
  await expect(page.locator('#app')).toHaveAttribute('data-page', /.+/, { timeout: 10000 })
  // Check title
  await expect(page).toHaveTitle(/Fontray/)
})
