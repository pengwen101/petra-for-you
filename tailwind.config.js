import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',    
        "./node_modules/flowbite/**/*.js"
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                'light-cream': '#faf7f0',
                'midnight': '#050e2b',
                'dark-blue': '#080055',
                'purple': '#472e97',
                'light-yellow': '#edd69d',
                'summer': '#eeaa44',
            },
        },
    },
    plugins: [
        forms,
        require('flowbite/plugin')
    ],
    darkMode: 'class' 
};
