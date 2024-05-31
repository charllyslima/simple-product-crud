/** @type {import('tailwindcss').Config} */
export default {
  content: [
    './index.html',
    './src/**/*.{vue,js,ts,jsx,tsx}',
  ],
  theme: {
    extend: {
      colors: {
        "sky-blue": '#8ECAE6',
        "blue-green": '#219EBC',
        "prussian-blue": '#023047',
        "selective-yellow": '#FFB703',
        "ut-orange": '#FB8500',
      },
    },
  },
  plugins: [],
}

