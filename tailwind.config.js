/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        "./wp-content/themes/mtq-aceh-pidie-jaya/**/*.php",
        "./wp-content/themes/mtq-aceh-pidie-jaya/assets/js/**/*.js",
        "./wp-content/themes/mtq-aceh-pidie-jaya/js/**/*.js"
    ],
    theme: {
        extend: {}
    },
    plugins: [
        require('@tailwindcss/typography')
    ]
};

