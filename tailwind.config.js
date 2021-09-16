const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    purge: {
        enabled: false,
        content: [
            './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
            './storage/framework/views/*.php',
            './resources/views/**/*.blade.php'
        ]
    },

    theme: {
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    variants: {
        extend: {
            opacity: ['disabled'],
            textColor: ['visited'],
        },
    },

    plugins: [require('@tailwindcss/forms')],
};
