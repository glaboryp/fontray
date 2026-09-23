<template>
  <AppLayout>
    <!-- Hero / measurement bench -->
    <HeroSection @font-identified="handleFontIdentification" />

    <!-- Usage guide -->
    <UsageGuideSection />

    <!-- How it works -->
    <HowItWorksSection />

    <!-- FAQ -->
    <FaqSection />
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import HeroSection from '@/Components/HeroSection.vue'
import UsageGuideSection from '@/Components/UsageGuideSection.vue'
import HowItWorksSection from '@/Components/HowItWorksSection.vue'
import FaqSection from '@/Components/FaqSection.vue'
import { router } from '@inertiajs/vue3'

const handleFontIdentification = fontData => {
  const queryString = new window.URLSearchParams({
    fonts: JSON.stringify(fontData.fonts || []),
    total: fontData.total_found || 0,
    success: fontData.success || false,
  }).toString()

  router.visit(`/results?${queryString}`)
}
</script>
