import js from '@eslint/js'
import vue from 'eslint-plugin-vue'

export default [
  // Configuración de archivos ignorados
  {
    ignores: [
      'node_modules/**',
      'vendor/**',
      'public/build/**',
      'storage/**',
      'bootstrap/cache/**',
      '.git/**',
      '**/*.min.js',
      'vite.config.js',
      'tailwind.config.js',
      'composer.lock',
      'package-lock.json',
    ],
  },
  js.configs.recommended,
  ...vue.configs['flat/recommended'],
  {
    rules: {
      // No usar punto y coma
      semi: ['error', 'never'],

      // Espaciado antes y después de llaves
      'object-curly-spacing': ['error', 'always'],

      // Espaciado dentro de paréntesis
      'space-in-parens': ['error', 'never'],

      // Espaciado dentro de corchetes
      'array-bracket-spacing': ['error', 'never'],

      // Espaciado alrededor de operadores
      'space-infix-ops': 'error',

      // Espaciado antes de bloques
      'space-before-blocks': 'error',

      // Espaciado después de palabras clave
      'keyword-spacing': 'error',

      // Coma al final cuando sea apropiado
      'comma-dangle': ['error', 'only-multiline'],

      // Espaciado después de comas
      'comma-spacing': ['error', { before: false, after: true }],

      // Quotes consistentes
      quotes: ['error', 'single'],

      // Reglas específicas para Vue - ajustadas para compatibilidad con Prettier
      'vue/html-self-closing': [
        'error',
        {
          html: {
            void: 'always',
            normal: 'always',
            component: 'always',
          },
          svg: 'always',
          math: 'always',
        },
      ],
      'vue/max-attributes-per-line': [
        'error',
        {
          singleline: { max: 3 },
          multiline: { max: 1 },
        },
      ],
      'vue/html-indent': ['error', 2],
      'vue/script-indent': ['error', 2, { baseIndent: 0 }],
      'vue/no-multi-spaces': 'error',

      // Desactivar reglas que entran en conflicto con Prettier
      'vue/html-closing-bracket-newline': 'off',
      'vue/html-closing-bracket-spacing': 'off',
      'vue/multiline-html-element-content-newline': 'off',
      'vue/singleline-html-element-content-newline': 'off',

      // Reglas de formateo que maneja Prettier
      'space-before-function-paren': 'off',
      'function-paren-newline': 'off',
      'object-curly-newline': 'off',
      'array-bracket-newline': 'off',
    },
    languageOptions: {
      ecmaVersion: 2022,
      sourceType: 'module',
      globals: {
        // Node.js globals
        console: 'readonly',
        process: 'readonly',
        // Browser globals
        window: 'readonly',
        document: 'readonly',
        FormData: 'readonly',
        FileReader: 'readonly',
        setTimeout: 'readonly',
        clearTimeout: 'readonly',
        setInterval: 'readonly',
        clearInterval: 'readonly',
        fetch: 'readonly',
        Promise: 'readonly',
        URL: 'readonly',
        Blob: 'readonly',
        File: 'readonly',
        Image: 'readonly',
        XMLHttpRequest: 'readonly',
        localStorage: 'readonly',
        sessionStorage: 'readonly',
        location: 'readonly',
        navigator: 'readonly',
        history: 'readonly',
      },
    },
  },
]
