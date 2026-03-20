/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./*.php",
    "./inc/**/*.php",
    "./template-parts/**/*.php",
    "./assets/js/**/*.js"
  ],
  darkMode: "class",
  theme: {
    extend: {
      colors: {
        "primary": "var(--color-primary)",
        "secondary": "var(--color-secondary)",
        "background-light": "var(--bg-light)",
        "background-dark": "var(--bg-dark)",
        "accent-yellow": "#FFD600",
      },
      fontFamily: {
        "display": ["var(--font-heading)", "sans-serif"],
        "body": ["var(--font-body)", "sans-serif"]
      },
      borderRadius: {
        "DEFAULT": "var(--radius-md)",
        "lg": "calc(var(--radius-md) * 1.25)",
        "xl": "calc(var(--radius-md) * 1.75)",
        "2xl": "calc(var(--radius-md) * 2.5)",
        "full": "9999px"
      },
    },
  },
  plugins: [
    require('@tailwindcss/forms'),
    require('@tailwindcss/container-queries'),
  ],
}
