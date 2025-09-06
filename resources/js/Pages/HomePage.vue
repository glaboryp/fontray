<template>
  <AppLayout>
    <!-- Hero Section -->
    <HeroSection @scroll-to-uploader="scrollToUploader" />

    <!-- Upload Section -->
    <UploadSection
      ref="uploaderElement"
      @font-identified="handleFontIdentification"
    />

    <!-- How it works Section -->
    <HowItWorksSection />

    <!-- FAQ Section -->
    <FaqSection />
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import HeroSection from '@/Components/HeroSection.vue'
import UploadSection from '@/Components/UploadSection.vue'
import HowItWorksSection from '@/Components/HowItWorksSection.vue'
import FaqSection from '@/Components/FaqSection.vue'
import { router } from '@inertiajs/vue3'

import { ref } from 'vue'

// Refs
const uploaderElement = ref(null)

// Methods
const scrollToUploader = () => {
  if (uploaderElement.value) {
    uploaderElement.value.$el.scrollIntoView({ behavior: 'smooth' })
  }
}

const handleFontIdentification = fontData => {
  const queryString = new window.URLSearchParams({
    fonts: JSON.stringify(fontData.fonts || []),
    total: fontData.total_found || 0,
    success: fontData.success || false,
  }).toString()

  router.visit(`/results?${queryString}`)
}
</script>

<style scoped>
/* Custom animations and styles */
@keyframes fadeInUp {
  from {
    opacity: 0;
    transform: translateY(30px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.fade-in-up {
  animation: fadeInUp 0.6s ease-out;
}
</style>
