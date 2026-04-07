// Global test setup
// Mock CSRF token meta tag (used by ImageUploader.vue for fetch requests)
const meta = document.createElement('meta')
meta.setAttribute('name', 'csrf-token')
meta.setAttribute('content', 'test-csrf-token')
document.head.appendChild(meta)

// Mock URL.createObjectURL (used for image previews)
if (typeof URL.createObjectURL === 'undefined') {
  URL.createObjectURL = () => 'blob:mock-url'
}
if (typeof URL.revokeObjectURL === 'undefined') {
  URL.revokeObjectURL = () => {}
}
