<template>
  <AppLayout>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
      <!-- Header -->
      <div class="text-center mb-12">
        <h1 class="text-4xl font-bold text-gray-900 mb-4">
          Política de Privacidad
        </h1>
        <p class="text-lg text-gray-600">
          Última actualización: {{ currentDate }}
        </p>
      </div>

      <!-- Content -->
      <div class="prose prose-lg max-w-none">
        <section class="mb-8">
          <h2 class="text-2xl font-semibold text-gray-900 mb-4">
            1. Información que recopilamos
          </h2>
          <p class="text-gray-700 mb-4">
            En Fontray, respetamos su privacidad y nos comprometemos a proteger
            su información personal. Esta política describe qué información
            recopilamos y cómo la utilizamos.
          </p>
          <h3 class="text-xl font-semibold text-gray-900 mb-3">
            Imágenes subidas
          </h3>
          <p class="text-gray-700 mb-4">
            Las imágenes que sube a nuestro servicio se utilizan
            <strong>
              únicamente para el análisis de identificación de fuentes
            </strong>
            . Estas imágenes:
          </p>
          <ul class="list-disc ml-6 text-gray-700 mb-4">
            <li>Se procesan temporalmente en nuestros servidores</li>
            <li>
              <strong>No se almacenan de forma permanente</strong>
              en nuestros sistemas
            </li>
            <li>Se eliminan automáticamente después del análisis</li>
            <li>No se comparten con terceros para otros fines</li>
          </ul>
        </section>

        <section class="mb-8">
          <h2 class="text-2xl font-semibold text-gray-900 mb-4">
            2. Uso de la información
          </h2>
          <p class="text-gray-700 mb-4">
            La información que recopilamos se utiliza exclusivamente para:
          </p>
          <ul class="list-disc ml-6 text-gray-700 mb-4">
            <li>Proporcionar el servicio de identificación de fuentes</li>
            <li>Mejorar la precisión de nuestros algoritmos</li>
            <li>Mantener la funcionalidad del sitio web</li>
            <li>Cumplir con requisitos legales cuando sea necesario</li>
          </ul>
        </section>

        <section class="mb-8">
          <h2 class="text-2xl font-semibold text-gray-900 mb-4">
            3. Servicios de terceros
          </h2>
          <p class="text-gray-700 mb-4">
            Utilizamos la API de WhatFontIs para el análisis de fuentes. Sus
            imágenes pueden ser procesadas por este servicio siguiendo sus
            propias políticas de privacidad. Recomendamos revisar la
            <a
              href="https://www.whatfontis.com/cookie-information.html"
              target="_blank"
              rel="noopener noreferrer"
              class="text-primary hover:text-primary-dark transition-colors"
            >
              política de privacidad de WhatFontIs
            </a>
            para más detalles.
          </p>
        </section>

        <section class="mb-8">
          <h2 class="text-2xl font-semibold text-gray-900 mb-4">
            4. Retención de datos
          </h2>
          <p class="text-gray-700 mb-4">
            <strong>No almacenamos sus imágenes a largo plazo.</strong>
            Las imágenes subidas se procesan inmediatamente y se eliminan de
            nuestros servidores una vez completado el análisis. Este proceso
            generalmente toma menos de 60 segundos.
          </p>
        </section>

        <section class="mb-8">
          <h2 class="text-2xl font-semibold text-gray-900 mb-4">
            5. Cookies y tecnologías de seguimiento
          </h2>
          <p class="text-gray-700 mb-4">
            Utilizamos cookies esenciales para el funcionamiento del sitio web,
            como mantener su sesión activa. No utilizamos cookies de seguimiento
            publicitario ni compartimos datos con redes publicitarias.
          </p>
        </section>

        <section class="mb-8">
          <h2 class="text-2xl font-semibold text-gray-900 mb-4">
            6. Seguridad
          </h2>
          <p class="text-gray-700 mb-4">
            Implementamos medidas de seguridad técnicas y organizativas
            apropiadas para proteger su información contra acceso no autorizado,
            alteración, divulgación o destrucción.
          </p>
        </section>

        <section class="mb-8">
          <h2 class="text-2xl font-semibold text-gray-900 mb-4">
            7. Sus derechos
          </h2>
          <p class="text-gray-700 mb-4">Usted tiene derecho a:</p>
          <ul class="list-disc ml-6 text-gray-700 mb-4">
            <li>Conocer qué información personal tenemos sobre usted</li>
            <li>Solicitar la corrección de información inexacta</li>
            <li>Solicitar la eliminación de su información personal</li>
            <li>Retirar su consentimiento en cualquier momento</li>
          </ul>
        </section>

        <section class="mb-8">
          <h2 class="text-2xl font-semibold text-gray-900 mb-4">
            8. Cambios a esta política
          </h2>
          <p class="text-gray-700 mb-4">
            Nos reservamos el derecho de actualizar esta política de privacidad
            en cualquier momento. Los cambios se publicarán en esta página con
            una nueva fecha de "última actualización".
          </p>
        </section>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { computed } from 'vue'

// Computed properties
const currentDate = computed(() => {
  return new Date().toLocaleDateString('es-ES', {
    year: 'numeric',
    month: 'long',
    day: 'numeric',
  })
})
</script>

<style scoped>
.prose a {
  text-decoration: underline;
}

.prose ul {
  margin-bottom: 1rem;
}

.prose li {
  margin-bottom: 0.5rem;
}
</style>
