/** @type {import('tailwindcss').Config} */
let plugin = require('tailwindcss/plugin')

export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
        "./node_modules/flowbite/**/*.js",
    ],
    theme: {
        fontFamily: {
            'heading': ['"Red Hat Display"', 'Arial', 'Calibri', 'Verdana', 'sans-serif'],
            'sans': ['Poppins', 'Verdana', 'sans-serif'],
        },
        extend: {
            colors: {
                'modrinth': {
                    '50': '#eefff6',
                    '100': '#d7ffeb',
                    '200': '#b2ffd9',
                    '300': '#76ffbc',
                    '400': '#33f598',
                    '500': '#09de78',
                    '600': '#00af5c',
                    DEFAULT: '#00af5c',
                    '700': '#04914f',
                    '800': '#0a7141',
                    '900': '#0a5d38',
                    '950': '#00341d',
                },
                'curseforge': {
                    '50': '#fef4ee',
                    '100': '#fde5d7',
                    '200': '#fac7ae',
                    '300': '#f7a07a',
                    '400': '#f16436',
                    DEFAULT: '#f16436',
                    '500': '#ee4b21',
                    '600': '#e03216',
                    '700': '#b92315',
                    '800': '#941e18',
                    '900': '#771b17',
                    '950': '#400b0a',
                },
                'lavender': {
                    '50': '#f8f8fa',
                    '100': '#f3f1f6',
                    '200': '#e8e6ee',
                    '300': '#d6d1e1',
                    '400': '#c0b6cf',
                    '500': '#a494b7',
                    DEFAULT: '#a494b7',
                    '600': '#9480a7',
                    '700': '#826d94',
                    '800': '#6d5b7c',
                    '900': '#5a4c66',
                    '950': '#3b3144',
                },
                'rose': {
                    '50': '#faf6f6',
                    '100': '#f4ecec',
                    '200': '#ecdcdc',
                    '300': '#dec3c3',
                    '400': '#ca9f9f',
                    '500': '#ba8787',
                    DEFAULT: '#ba8787',
                    '600': '#9e6464',
                    '700': '#845151',
                    '800': '#6e4646',
                    '900': '#5e3e3e',
                    '950': '#311e1e',
                },
            },
            screens: {
                '3xl': '1792px',
            },
        },
    },
    plugins: [
        require('flowbite/plugin'),
        plugin(function ({ addVariant }) {
            addVariant('selected', '&.selected')
        })
    ],
}

