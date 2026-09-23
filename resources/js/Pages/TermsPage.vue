<template>
  <AppLayout>
    <div class="bg-bench-950 py-16">
      <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-10">
          <h1 class="text-3xl font-semibold text-bench-50 mb-3">
            Términos de Servicio
          </h1>
          <p class="text-sm text-bench-400">
            Última actualización:
            <span class="font-mono text-bench-300">{{ currentDate }}</span>
          </p>
        </div>

        <!-- Content -->
        <div
          class="texture-steel bg-bench-900 border border-bench-700 rounded-[var(--radius-panel)] p-8 sm:p-10"
        >
          <div class="divide-y divide-bench-800 max-w-[70ch]">
            <section class="pb-8">
              <h2 class="text-xl font-semibold text-bench-50 mb-4">
                1. Aceptación de los términos
              </h2>
              <p class="text-bench-200">
                Al acceder y utilizar Fontray, usted acepta estar sujeto a estos
                Términos de Servicio y todas las leyes y regulaciones
                aplicables. Si no está de acuerdo con alguno de estos términos,
                no utilice este servicio.
              </p>
            </section>

            <section class="py-8">
              <h2 class="text-xl font-semibold text-bench-50 mb-4">
                2. Descripción del servicio
              </h2>
              <p class="text-bench-200 mb-4">
                Fontray es un servicio gratuito de identificación de fuentes
                tipográficas que permite a los usuarios subir imágenes
                conteniendo texto para identificar las fuentes utilizadas.
              </p>
              <h3 class="text-lg font-semibold text-bench-50 mb-3">
                Procesamiento de imágenes
              </h3>
              <p class="text-bench-200 mb-4">
                Las imágenes que suba a nuestro servicio:
              </p>
              <ul class="list-disc ml-6 text-bench-200 space-y-1.5">
                <li>
                  Se utilizan
                  <strong>exclusivamente</strong>
                  para el análisis de identificación de fuentes
                </li>
                <li>
                  <strong>No se almacenan permanentemente</strong>
                  en nuestros servidores
                </li>
                <li>Se eliminan automáticamente después del procesamiento</li>
                <li>
                  Pueden ser procesadas por servicios de terceros (como
                  WhatFontIs) para proporcionar los resultados
                </li>
              </ul>
            </section>

            <section class="py-8">
              <h2 class="text-xl font-semibold text-bench-50 mb-4">
                3. Uso aceptable
              </h2>
              <p class="text-bench-200 mb-4">
                Al utilizar nuestro servicio, acepta:
              </p>
              <ul class="list-disc ml-6 text-bench-200 space-y-1.5">
                <li>
                  Subir únicamente imágenes que contengan texto para
                  identificación de fuentes
                </li>
                <li>
                  No subir contenido ilegal, ofensivo, que viole derechos de
                  autor o sea inapropiado
                </li>
                <li>
                  No intentar interrumpir o dañar el funcionamiento del servicio
                </li>
                <li>
                  No utilizar el servicio para fines comerciales a gran escala
                  sin autorización
                </li>
                <li>
                  Respetar los derechos de propiedad intelectual de terceros
                </li>
              </ul>
            </section>

            <section class="py-8">
              <h2 class="text-xl font-semibold text-bench-50 mb-4">
                4. Limitaciones del servicio
              </h2>
              <p class="text-bench-200 mb-4">
                Nuestro servicio se proporciona "tal como está" y:
              </p>
              <ul class="list-disc ml-6 text-bench-200 space-y-1.5">
                <li>
                  No garantizamos la precisión al 100% de los resultados de
                  identificación
                </li>
                <li>
                  Los resultados dependen de la calidad de la imagen y la
                  disponibilidad en nuestra base de datos
                </li>
                <li>
                  El servicio puede no estar disponible temporalmente por
                  mantenimiento
                </li>
                <li>
                  Nos reservamos el derecho de limitar el uso para prevenir
                  abuso
                </li>
              </ul>
            </section>

            <section class="py-8">
              <h2 class="text-xl font-semibold text-bench-50 mb-4">
                5. Propiedad intelectual
              </h2>
              <p class="text-bench-200">
                Usted conserva todos los derechos sobre las imágenes que suba.
                Fontray no reclama ningún derecho de propiedad sobre su
                contenido. Al subir una imagen, nos otorga una licencia temporal
                limitada para procesarla únicamente con el fin de proporcionar
                el servicio de identificación.
              </p>
            </section>

            <section class="py-8">
              <h2 class="text-xl font-semibold text-bench-50 mb-4">
                6. Servicios de terceros
              </h2>
              <p class="text-bench-200">
                Utilizamos la API de WhatFontIs para el análisis de fuentes. Al
                utilizar nuestro servicio, también acepta los términos de
                servicio de WhatFontIs. No somos responsables por las políticas
                o acciones de servicios de terceros.
              </p>
            </section>

            <section class="py-8">
              <h2 class="text-xl font-semibold text-bench-50 mb-4">
                7. Limitación de responsabilidad
              </h2>
              <p class="text-bench-200">
                En ningún caso Fontray será responsable por daños indirectos,
                incidentales, especiales, consecuentes o punitivos, incluyendo
                pero no limitado a pérdida de beneficios, datos o uso,
                incurridos como resultado del uso o la incapacidad de usar el
                servicio.
              </p>
            </section>

            <section class="py-8">
              <h2 class="text-xl font-semibold text-bench-50 mb-4">
                8. Terminación
              </h2>
              <p class="text-bench-200">
                Nos reservamos el derecho de terminar o suspender el acceso al
                servicio inmediatamente, sin previo aviso, por cualquier motivo,
                incluyendo pero no limitado al incumplimiento de estos Términos
                de Servicio.
              </p>
            </section>

            <section class="py-8">
              <h2 class="text-xl font-semibold text-bench-50 mb-4">
                9. Privacidad y protección de datos
              </h2>
              <p class="text-bench-200">
                Su privacidad es importante para nosotros. Por favor, revise
                nuestra
                <Link
                  href="/privacy"
                  class="text-index-400 hover:text-index-300 transition-colors"
                >
                  Política de Privacidad
                </Link>
                para entender cómo recopilamos, utilizamos y protegemos su
                información.
              </p>
            </section>

            <section class="py-8">
              <h2 class="text-xl font-semibold text-bench-50 mb-4">
                10. Cambios a los términos
              </h2>
              <p class="text-bench-200">
                Nos reservamos el derecho de modificar estos términos en
                cualquier momento. Los cambios entrarán en vigor inmediatamente
                después de su publicación en esta página. Es su responsabilidad
                revisar estos términos periódicamente.
              </p>
            </section>

            <section class="pt-8">
              <h2 class="text-xl font-semibold text-bench-50 mb-4">
                11. Ley aplicable
              </h2>
              <p class="text-bench-200">
                Estos términos se rigen por las leyes de España. Cualquier
                disputa relacionada con estos términos estará sujeta a la
                jurisdicción exclusiva de los tribunales españoles.
              </p>
            </section>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { Link } from '@inertiajs/vue3'
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
