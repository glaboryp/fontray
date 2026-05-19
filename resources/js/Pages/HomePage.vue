<template>
  <Head title="Identificador de fuentes tipográficas">
    <meta
      name="description"
      content="Sube una imagen con texto y descubre qué fuente tipográfica se está utilizando. Rápido, preciso y completamente gratuito."
    />
    <component :is="'script'" type="application/ld+json">{{
      faqSchemaJson
    }}</component>
  </Head>

  <AppLayout>
    <!-- Hero Section -->
    <HeroSection @scroll-to-uploader="scrollToUploader" />

    <!-- Upload Section -->
    <UploadSection
      ref="uploaderElement"
    />

    <!-- How it works Section -->
    <HowItWorksSection />

    <!-- FAQ Section -->
    <FaqSection />
  </AppLayout>
</template>

<script setup>
import { Head } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'
import { faqs } from '@/data/faqs.js'
import HeroSection from '@/Components/HeroSection.vue'
import UploadSection from '@/Components/UploadSection.vue'
import HowItWorksSection from '@/Components/HowItWorksSection.vue'
import FaqSection from '@/Components/FaqSection.vue'
import { ref, computed } from 'vue'

// Schema.org FAQPage
const faqSchemaJson = computed(() =>
  JSON.stringify({
    '@context': 'https://schema.org',
    '@type': 'FAQPage',
    mainEntity: faqs.map(faq => ({
      '@type': 'Question',
      name: faq.question,
      acceptedAnswer: {
        '@type': 'Answer',
        text: faq.answer,
      },
    })),
  })
)

// Refs
const uploaderElement = ref(null)

// Methods
const scrollToUploader = () => {
  if (uploaderElement.value) {
    uploaderElement.value.$el.scrollIntoView({ behavior: 'smooth' })
  }
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
