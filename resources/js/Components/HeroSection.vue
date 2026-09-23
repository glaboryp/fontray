<template>
  <section class="bg-bench-900 border-b border-bench-800">
    <div
      class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-14 pb-16 md:pt-20 md:pb-20"
    >
      <div
        class="grid lg:grid-cols-[minmax(0,22rem)_1fr] gap-10 lg:gap-16 items-center"
      >
        <div>
          <h1
            class="text-3xl md:text-4xl font-semibold tracking-tight text-bench-50 mb-4 leading-tight"
          >
            Sube una imagen. Lee la fuente exacta.
          </h1>
          <p class="text-base text-bench-300 leading-relaxed max-w-md">
            Fontray mide tipografías en fotos, capturas y PDFs, y devuelve
            coincidencias ordenadas por confianza, sin guardar tus archivos.
          </p>
        </div>

        <ImageUploader
          @uploaded="$emit('imageUploaded', $event)"
          @font-identified="$emit('fontIdentified', $event)"
        />
      </div>
    </div>
  </section>
</template>

<script setup>
import ImageUploader from './ImageUploader.vue'

defineEmits(['imageUploaded', 'fontIdentified'])
</script>
