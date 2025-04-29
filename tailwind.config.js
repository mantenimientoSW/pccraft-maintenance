import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        "./resources/**/*.js",
        "./node_modules/flowbite/**/*.js"
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
                roboto: ['Roboto', 'sans-serif'], 
                poppins: ["Poppins", 'system-ui'],
                montserrat: ["Montserrat", 'sans-serif'],
            },
            colors:{
                azul: '#0075FF',
                negro: '#272727',
                verde: '#11743E'
            },
            spacing:{
                carrusel: '550px'
            }
        },
    },

    plugins: [forms, require('flowbite/plugin')],
};
