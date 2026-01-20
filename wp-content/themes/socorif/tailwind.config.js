/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./**/*.php",
    "./assets/src/**/*.{js,css}",
    "./template-parts/**/*.php",
  ],
  theme: {
    extend: {
      colors: {
        primary: "var(--beka-primary)",
        "primary-dark": "var(--beka-primary-dark)",
        secondary: "var(--beka-secondary)",
        "secondary-dark": "var(--beka-secondary-dark)",
        accent: "var(--beka-accent)",
      },
    },
  },
  plugins: [],
};
