import typography from '@tailwindcss/typography';

/** @type {import('tailwindcss').Config} */
export default {
  content: [
    // ↓ ここを修正！ Laravelのフォルダを見るように書き換えます
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {},
  },
  plugins: [
    typography, // プラグインはそのまま有効にしておきます
  ],
}
