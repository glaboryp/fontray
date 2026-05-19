<template>
  <section class="py-20 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="text-center mb-16">
        <h2 class="text-3xl font-bold text-gray-900 mb-4">
          Preguntas frecuentes
        </h2>
      </div>

      <div class="space-y-8">
        <div
          v-for="faq in faqs"
          :key="faq.id"
          class="border-b border-gray-200 pb-8"
        >
          <h3 class="text-lg font-semibold text-gray-900 mb-3">
            {{ faq.question }}
          </h3>
          <p class="text-gray-600">
            {{ faq.answer }}
          </p>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { faqs } from '@/data/faqs.js'
</script>
