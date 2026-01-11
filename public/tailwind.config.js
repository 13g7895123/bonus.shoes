/** @type {import('tailwindcss').Config} */
module.exports = {
  mode: 'jit',
  content: [
    "./index.php",
    "../app/Views/**/*.php",
    "../app/Views/**/*.html"
  ],
  theme: {
    extend: {},
  },
  plugins: [],
}
