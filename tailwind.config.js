/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.jsx",
    "./resources/**/*.ts",
    "./resources/**/*.tsx",
  ],
  theme: {
    extend: {},
    screens: {
      'sm': '576px',
      'md': '1200px',
      "lg": '1440px'
    }
  },
  plugins: [],
};
