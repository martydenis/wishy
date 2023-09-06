/** @type {import('tailwindcss').Config} */

export default {
  content: ["./resources/views/app.blade.php", "./resources/**/*.{vue,html,js}"],
  theme: {
    extend: {
      fontSize: {
        '2xs': '0.8rem',
        xs: '0.85rem',
        sm: '0.9125rem',
        md: '1rem',
      },
    },
  },
  plugins: [],
}

