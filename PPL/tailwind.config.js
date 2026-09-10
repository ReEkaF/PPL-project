import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        "./node_modules/flowbite/**/*.js",
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', 'Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                brand: {
                    50: '#f0f7ff',
                    100: '#e0effe',
                    200: '#bae0fd',
                    300: '#7cc5fb',
                    400: '#36a7f6',
                    500: '#0c8be5',
                    600: '#026aa2',
                    700: '#025380',
                    800: '#06466c',
                    900: '#0b3b5b',
                    950: '#07253b',
                },
                accent: {
                    50: '#fffbeb',
                    100: '#fef3c7',
                    500: '#f59e0b',
                    600: '#d97706',
                    700: '#b45309',
                },
            },
        },
    },

    plugins: [
        forms,
        require('flowbite/plugin')({
            datatables: true,
            charts: true,
            wysiwyg: true,
        }),
        // require('flowbite-typography')
  ],
};
