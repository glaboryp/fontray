<template>
  <section class="py-16 md:py-20 bg-bench-950">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
      <h2 class="text-2xl font-semibold text-bench-50 mb-8">
        Preguntas frecuentes
      </h2>

      <div class="border-t border-bench-800">
        <div
          v-for="faq in faqs"
          :key="faq.id"
          class="border-b border-bench-800"
        >
          <button
            class="w-full flex items-center justify-between gap-4 py-5 text-left cursor-pointer"
            :aria-expanded="openId === faq.id"
            @click="toggle(faq.id)"
          >
            <span class="text-base font-medium text-bench-100">
              {{ faq.question }}
            </span>
            <svg
              class="w-4 h-4 text-bench-400 shrink-0 transition-transform duration-200"
              :class="{ 'rotate-45': openId === faq.id }"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
              aria-hidden="true"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="1.5"
                d="M12 4.5v15m7.5-7.5h-15"
              />
            </svg>
          </button>
          <div
            v-show="openId === faq.id"
            class="pb-5 pr-8 text-sm text-bench-400 leading-relaxed"
          >
            {{ faq.answer }}
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref } from 'vue'

const faqs = ref([
  {
    id: 1,
    question: '¿Qué tipos de imagen funcionan mejor?',
    answer:
      'Las imágenes con texto claro, de alta resolución y buen contraste dan las lecturas más precisas. Evita imágenes borrosas o con texto muy pequeño.',
  },
  {
    id: 2,
    question: '¿Es gratuito?',
    answer:
      'Sí, Fontray es gratuito. No necesitas registrarte para identificar una fuente; crear una cuenta solo te permite guardar tu historial de búsquedas.',
  },
  {
    id: 3,
    question: '¿Qué pasa con las imágenes que subo?',
    answer:
      'Se usan únicamente para la medición y no se almacenan de forma permanente en nuestros sistemas.',
  },
  {
    id: 4,
    question: '¿Qué tan preciso es el resultado?',
    answer:
      'La precisión es alta con fuentes populares. Siempre se devuelven varias coincidencias ordenadas por confianza, para que puedas elegir la más adecuada.',
  },
])

const openId = ref(1)

const toggle = id => {
  openId.value = openId.value === id ? null : id
}
</script>
