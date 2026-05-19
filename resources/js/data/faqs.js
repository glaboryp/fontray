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
  {
    id: 4,
    question: '¿Necesito registrarme para usar Fontray?',
    answer:
      'No para identificar fuentes; sí si quieres guardar el historial de búsquedas.',
  },
  {
    id: 5,
    question: '¿Qué formatos de imagen acepta?',
    answer: 'JPG, PNG, WebP y también PDF (extrae la primera página).',
  },
  {
    id: 6,
    question: '¿Cuántas fuentes devuelve en cada búsqueda?',
    answer: 'Hasta 20 resultados ordenados por similitud.',
  },
  {
    id: 7,
    question: '¿Mis imágenes se guardan en el servidor?',
    answer:
      'Solo si estás registrado (para el historial). Los usuarios anónimos no dejan rastro.',
  },
  {
    id: 8,
    question: '¿Funciona con logos muy estilizados o lettering manual?',
    answer:
      'No bien; está optimizado para tipografías estándar, no para diseños donde las letras son arte.',
  },
  {
    id: 9,
    question: '¿Qué hago si no reconoce la fuente?',
    answer:
      'Consejos: recortar el texto, mejorar el contraste, intentar con una letra grande y aislada.',
  },
]
