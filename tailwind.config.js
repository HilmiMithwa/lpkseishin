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
                sans: ['Karla', ...defaultTheme.fontFamily.sans],
                karla: ['Karla', ...defaultTheme.fontFamily.sans],
                ibm: ['IBM Plex Sans', ...defaultTheme.fontFamily.sans],
                'google-sans': ['Google Sans Flex', ...defaultTheme.fontFamily.sans],
            },

        },
    },

    plugins: [forms],
};
