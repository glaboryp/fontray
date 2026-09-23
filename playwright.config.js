import { defineConfig } from '@playwright/test'
import { fileURLToPath } from 'node:url'
import path from 'node:path'

const __dirname = path.dirname(fileURLToPath(import.meta.url))
const sqlitePath = path.join(__dirname, 'database', 'database.sqlite')

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
    // --no-reload: php artisan serve otherwise only forwards an internal
    // allow-list of env vars (APP_ENV, PATH, ...) to the server process it
    // spawns, silently dropping DB_DATABASE/SESSION_DRIVER/etc. below and
    // falling back to .env.testing's in-memory sqlite (no migrated schema).
    command: `APP_ENV=testing WHATFONTIS_MOCK=true DB_CONNECTION=sqlite DB_DATABASE=${sqlitePath} SESSION_DRIVER=file CACHE_STORE=file QUEUE_CONNECTION=sync php artisan serve --port=8000 --no-reload`,
    url: 'http://localhost:8000',
    reuseExistingServer: false,
    timeout: 30000,
  },
})
