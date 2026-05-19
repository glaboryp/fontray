/**
 * Fuente de datos compartida para las FAQs.
 * Se usa tanto en FaqSection.vue (display) como en HomePage.vue (Schema.org FAQPage).
 * Añade aquí nuevas preguntas para que aparezcan en ambos sitios automáticamente.
 */
export const faqs = [
  {
    id: 1,
    question: '¿Qué tipos de imagen funcionan mejor?',
    answer:
      'Las imágenes con texto claro, de alta resolución y buen contraste funcionan mejor. Evita imágenes borrosas o con texto muy pequeño.',
  },
  {
    id: 2,
    question: '¿Es completamente gratuito?',
    answer:
      'Sí, Fontray es completamente gratuito. No necesitas registrarte ni pagar nada para identificar fuentes.',
  },
  {
    id: 3,
    question: '¿Qué tan preciso es el sistema?',
    answer:
      'Nuestro sistema tiene una alta precisión, especialmente con fuentes populares. Siempre proporcionamos varias opciones para que puedas elegir la mejor coincidencia.',
  },
]
