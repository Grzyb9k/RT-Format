const path = require('path');
const colors = require('tailwindcss/colors');

module.exports = {
    content: [
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
        path.resolve(__dirname, './node_modules/litepie-datepicker/**/*.js'),
    ],
    darkMode: 'class', // or 'media' or 'class'
    theme: {
        extend: {
                colors: {
                    // Change with you want it
                    'litepie-primary': colors.sky, // color system for light mode
                }
        },
    },
    plugins: [
        require('daisyui'),
    ],
    variants: {
        extend: {
            cursor: ['disabled'],
            textOpacity: ['disabled'],
            textColor: ['disabled']
        }
    },
}
