/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
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

            },
            screens: {
                '3xl': '1792px',
            },
        },
    },
    plugins: [],
}

