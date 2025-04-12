import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Poppins', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                'tableready-green': '#28a745',
                'tableready-orange': '#ff7f00',
                'tableready-yellow': '#ffcc00',
            },
            boxShadow: {
                'apple-sm': '0 2px 5px rgba(0, 0, 0, 0.05)',
                'apple-md': '0 4px 10px rgba(0, 0, 0, 0.08)',
                'apple-lg': '0 10px 25px rgba(0, 0, 0, 0.1)',
                'apple-xl': '0 20px 40px rgba(0, 0, 0, 0.12)',
            },
            borderRadius: {
                'apple': '0.85rem',
            },
        },
    },

    plugins: [forms],
};
