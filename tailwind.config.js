/** @type {import('tailwindcss').Config} */
export default {
  darkMode: 'class',
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  safelist: [
    // --- WARNA TEKS ---
    'text-blue-500', 'text-blue-400', 'text-purple-500', 'text-purple-400', 'text-green-500', 'text-green-400', 'text-red-500', 'text-red-400', 'text-yellow-500', 'text-yellow-400',
    'text-blue-300', 'text-purple-300', 'text-green-300', 'text-red-300', 'text-yellow-300',

    // --- BACKGROUND BULATAN (DOT) ---
    'bg-blue-600', 'bg-purple-600', 'bg-green-600', 'bg-red-600', 'bg-yellow-600',

    // --- BACKGROUND TRANSPARAN (CARD) ---
    'bg-blue-500/10', 'bg-purple-500/10', 'bg-green-500/10', 'bg-red-500/10', 'bg-yellow-500/10',

    // --- BORDER GARIS KIRI (Experience) ---
    {
        pattern: /border-l-(blue|purple|green|red|yellow|indigo|teal)-(500|600)/,
        variants: ['hover'],
    },
    'border-l-blue-500',
    'border-l-blue-500/30',
    'border-l-purple-500',
    'border-l-purple-500/30',
    'border-l-green-500',
    'border-l-green-500/30',
    'border-l-red-500',
    'border-l-red-500/30',
    'border-l-yellow-500',
    'border-l-yellow-500/30',
    'border-l-indigo-500',
    'border-l-indigo-500/30',
    'border-l-teal-500',
    'border-l-teal-500/30',
    'border-blue-500',
    'border-blue-500/30',
    'border-purple-500',
    'border-purple-500/30',
    'border-green-500',
    'border-green-500/30',
    'border-red-500',
    'border-red-500/30',
    'border-yellow-500',
    'border-yellow-500/30',
    'border-indigo-500',
    'border-indigo-500/30',
    'border-teal-500',
    'border-teal-500/30',

    // Jika Anda menggunakan border width selain default (misal border-l-4)
    'hover:shadow-lg',
    'border-l-4',

    // --- BORDER TRANSPARAN (Card Project) ---
    'border-blue-500/20', 'border-purple-500/20', 'border-green-500/20', 'border-red-500/20', 'border-yellow-500/20',
    'border-blue-500/50', 'border-purple-500/50', 'border-green-500/50', 'border-red-500/50', 'border-yellow-500/50',

    // --- SHADOW GLOW ---
    'shadow-blue-500/50', 'shadow-purple-500/50', 'shadow-green-500/50', 'shadow-red-500/50', 'shadow-yellow-500/50',
    'shadow-blue-900',
    'shadow-blue-900/20',
    'shadow-purple-900',
    'shadow-purple-900/20',
    'shadow-green-900',
    'shadow-green-900/20',
    'shadow-red-900',
    'shadow-red-900/20',
    'shadow-yellow-900',
    'shadow-yellow-900/20',
    'shadow-indigo-900',
    'shadow-indigo-900/20',
    'shadow-teal-900',
    'shadow-teal-900/20',
  ],
  theme: {
    extend: {},
  },
  plugins: [],
}
