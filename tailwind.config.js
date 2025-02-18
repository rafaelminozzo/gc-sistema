import defaultTheme from 'tailwindcss/defaultTheme';

// /** @type {import('tailwindcss').Config} */
// export default {
//     content: [
//         './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
//         './storage/framework/views/*.php',
//         './resources/**/*.blade.php',
//         './resources/**/*.js',
//         './resources/**/*.vue',
//     ],
//     theme: {
//         extend: {
//             fontFamily: {
//                 sans: ['Figtree', ...defaultTheme.fontFamily.sans],
//             },
//         },
//     },
//     plugins: [],
// };

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            colors: {
                'gc-blue': '#004AAD',      // Cor principal da GC
                'gc-blue-dark': '#003C8A', // Variação escura
                'gc-gray': '#F3F4F6',      // Fundo neutro
            }
        },
    },
    plugins: [],
}