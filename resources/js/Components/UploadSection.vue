<template>
  <section id="uploader" ref="uploaderElement" class="py-20 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="text-center mb-12">
        <h2 class="text-3xl font-bold text-gray-900 mb-4">
          Identifica tu fuente
        </h2>
        <p class="text-lg text-gray-600">
          Sube una imagen clara con el texto que quieres identificar
        </p>
      </div>

      <!-- Image Uploader Component -->
      <ImageUploader
        @uploaded="$emit('imageUploaded', $event)"
        @font-identified="$emit('fontIdentified', $event)"
      />
    </div>
  </section>
</template>

<script setup>
import ImageUploader from './ImageUploader.vue'

// Emits
defineEmits(['imageUploaded', 'fontIdentified'])
</script>
