const defaultTheme = require('tailwindcss/defaultTheme');

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './vendor/wire-elements/pro/config/wire-elements-pro.php',
        './vendor/wire-elements/pro/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Outfit', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                'arm-blue': {
                    '50': '#f2f8fa',
                    '100': '#e6f0f5',
                    '200': '#bfdae5',
                    '300': '#99c4d6',
                    '400': '#4d98b7',
                    '500': '#006c98',
                    '600': '#006189',
                    '700': '#005172',
                    '800': '#00415b',
                    '900': '#00354a'
                },
                'arm-green': {
                    '50': '#f8faf6',
                    '100': '#f1f5ed',
                    '200': '#dce5d2',
                    '300': '#c6d6b7',
                    '400': '#9cb780',
                    '500': '#71984a',
                    '600': '#668943',
                    '700': '#557238',
                    '800': '#445b2c',
                    '900': '#374a24'
                },
                'arm-orange': {
                    '50': '#fef8f2',
                    '100': '#fdf1e6',
                    '200': '#faddbf',
                    '300': '#f7c999',
                    '400': '#f2a04d',
                    '500': '#ec7700',
                    '600': '#d46b00',
                    '700': '#b15900',
                    '800': '#8e4700',
                    '900': '#743a00'
                }
            }
        },
    },

    plugins: [require('@tailwindcss/forms')],
};
