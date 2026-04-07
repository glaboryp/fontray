import { defineConfig } from '@playwright/test'

export default defineConfig({
  testDir: './e2e',
  timeout: 60000,
  retries: 0,
  use: {
    baseURL: 'http://localhost:8000',
    trace: 'on-first-retry',
    screenshot: 'only-on-failure',
  },
  projects: [
    {
      name: 'chromium',
      use: { browserName: 'chromium' },
    },
  ],
  webServer: {
    command: 'APP_ENV=testing WHATFONTIS_MOCK=true DB_CONNECTION=sqlite DB_DATABASE=/home/glabory/p/fontray/database/database.sqlite SESSION_DRIVER=file CACHE_STORE=file QUEUE_CONNECTION=sync php artisan serve --port=8000',
    url: 'http://localhost:8000',
    reuseExistingServer: false,
    timeout: 30000,
  },
})
