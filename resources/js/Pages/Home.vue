<template>
  <AppLayout>
    <!-- Hero Section -->
    <section class="bg-gradient-to-br from-primary-50 via-white to-cyan-50">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div class="text-center">
          <h1 class="text-4xl md:text-6xl font-bold text-gray-900 mb-6">
            Identifica cualquier 
            <span class="text-primary-500">fuente</span> 
            al instante
          </h1>
          <p class="text-xl text-gray-600 mb-8 max-w-3xl mx-auto">
            Sube una imagen con texto y descubre qué fuente tipográfica se está utilizando. 
            Rápido, preciso y completamente gratuito.
          </p>
          
          <!-- CTA Button -->
          <div class="mb-12">
            <button 
              @click="scrollToUploader"
              class="bg-primary-500 hover:bg-primary-600 text-white font-semibold py-4 px-8 rounded-lg text-lg transition-colors shadow-lg hover:shadow-xl"
            >
              Comenzar ahora
              <svg class="inline-block ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
              </svg>
            </button>
          </div>

          <!-- Features Preview -->
          <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-4xl mx-auto">
            <div class="text-center">
              <div class="bg-primary-50 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
              </div>
              <h3 class="text-lg font-semibold text-gray-900 mb-2">Sube tu imagen</h3>
              <p class="text-gray-600">Arrastra o selecciona una imagen con el texto que quieres identificar</p>
            </div>
            
            <div class="text-center">
              <div class="bg-primary-50 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                </svg>
              </div>
              <h3 class="text-lg font-semibold text-gray-900 mb-2">IA avanzada</h3>
              <p class="text-gray-600">Nuestro sistema analiza la imagen y compara con miles de fuentes</p>
            </div>
            
            <div class="text-center">
              <div class="bg-primary-50 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
              </div>
              <h3 class="text-lg font-semibold text-gray-900 mb-2">Resultados instantáneos</h3>
              <p class="text-gray-600">Obtén el nombre de la fuente y sugerencias similares en segundos</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Upload Section -->
    <section id="uploader" class="py-20 bg-white">
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
        <ImageUploader @uploaded="handleImageUpload" />
      </div>
    </section>

    <!-- How it works Section -->
    <section class="py-20 bg-gray-50">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
          <h2 class="text-3xl font-bold text-gray-900 mb-4">
            ¿Cómo funciona?
          </h2>
          <p class="text-lg text-gray-600 max-w-2xl mx-auto">
            Nuestro proceso es simple y eficiente. En solo tres pasos obtendrás la información que necesitas.
          </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
          <div class="text-center">
            <div class="bg-primary-500 text-white rounded-full w-12 h-12 flex items-center justify-center mx-auto mb-6 text-xl font-bold">
              1
            </div>
            <h3 class="text-xl font-semibold text-gray-900 mb-4">Sube tu imagen</h3>
            <p class="text-gray-600">
              Selecciona una imagen con texto claro y bien definido. Formatos JPG, PNG y WebP son compatibles.
            </p>
          </div>

          <div class="text-center">
            <div class="bg-primary-500 text-white rounded-full w-12 h-12 flex items-center justify-center mx-auto mb-6 text-xl font-bold">
              2
            </div>
            <h3 class="text-xl font-semibold text-gray-900 mb-4">Procesamos la imagen</h3>
            <p class="text-gray-600">
              Nuestro sistema de IA analiza las características tipográficas y las compara con nuestra base de datos.
            </p>
          </div>

          <div class="text-center">
            <div class="bg-primary-500 text-white rounded-full w-12 h-12 flex items-center justify-center mx-auto mb-6 text-xl font-bold">
              3
            </div>
            <h3 class="text-xl font-semibold text-gray-900 mb-4">Obtén resultados</h3>
            <p class="text-gray-600">
              Recibe el nombre de la fuente, información adicional y sugerencias de fuentes similares.
            </p>
          </div>
        </div>
      </div>
    </section>

    <!-- FAQ Section -->
    <section class="py-20 bg-white">
      <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
          <h2 class="text-3xl font-bold text-gray-900 mb-4">
            Preguntas frecuentes
          </h2>
        </div>

        <div class="space-y-8">
          <div class="border-b border-gray-200 pb-8">
            <h3 class="text-lg font-semibold text-gray-900 mb-3">
              ¿Qué tipos de imagen funcionan mejor?
            </h3>
            <p class="text-gray-600">
              Las imágenes con texto claro, de alta resolución y buen contraste funcionan mejor. 
              Evita imágenes borrosas o con texto muy pequeño.
            </p>
          </div>

          <div class="border-b border-gray-200 pb-8">
            <h3 class="text-lg font-semibold text-gray-900 mb-3">
              ¿Es completamente gratuito?
            </h3>
            <p class="text-gray-600">
              Sí, Fontray es completamente gratuito. No necesitas registrarte ni pagar nada para identificar fuentes.
            </p>
          </div>

          <div class="border-b border-gray-200 pb-8">
            <h3 class="text-lg font-semibold text-gray-900 mb-3">
              ¿Qué tan preciso es el sistema?
            </h3>
            <p class="text-gray-600">
              Nuestro sistema tiene una alta precisión, especialmente con fuentes populares. 
              Siempre proporcionamos varias opciones para que puedas elegir la mejor coincidencia.
            </p>
          </div>
        </div>
      </div>
    </section>
  </AppLayout>
</template>

<script setup>
import { ref } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import ImageUploader from '@/Components/ImageUploader.vue'

// Reactive data
const isLoading = ref(false)

// Methods
const scrollToUploader = () => {
  const element = document.getElementById('uploader')
  if (element) {
    element.scrollIntoView({ behavior: 'smooth' })
  }
}

const handleImageUpload = (imageData) => {
  console.log('Imagen subida:', imageData)
  // Aquí irá la lógica para procesar la imagen
  // Por ahora solo logeamos los datos
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
