import defaultTheme from 'tailwindcss/defaultTheme'
import forms from '@tailwindcss/forms'

/** @type {import('tailwindcss').Config} */
export default {
  content: [
    './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
    './storage/framework/views/*.php',
    './resources/views/**/*.blade.php',
    './resources/js/**/*.vue',
  ],

  theme: {
    extend: {
      colors: {
        primary: {
          50: '#e6f7ff',
          100: '#b3ebff',
          200: '#80dfff',
          300: '#4dd3ff',
          400: '#1ac7ff',
          500: '#00a9e0',
          600: '#0088b8',
          700: '#006690',
          800: '#004468',
          900: '#002240',
          light: '#e8f2ff',
          DEFAULT: '#147dd9',
          dark: '#0f5ba3',
          hover: '#2a8be6',
        },
      },
      fontFamily: {
        sans: [
          '"Instrument Sans"',
          'ui-sans-serif',
          'system-ui',
          'sans-serif',
          '"Apple Color Emoji"',
          '"Segoe UI Emoji"',
          '"Segoe UI Symbol"',
          '"Noto Color Emoji"',
        ],
      },
    },
  },

  plugins: [forms],
}
