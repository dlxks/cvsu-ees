const defaultTheme = require("tailwindcss/defaultTheme");
const svgToDataUri = require("mini-svg-data-uri");

module.exports = {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./vendor/laravel/jetstream/**/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./resources/js/**/*.vue",
        "./src/**/*.{html,js}",
        "./node_modules/tw-elements/dist/js/**/*.js",
    ],

    theme: {
        extend: {
            backgroundImage: (theme) => ({
                "multiselect-caret": `url("${svgToDataUri(
                    `<svg viewBox="0 0 320 512" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path d="M31.3 192h257.3c17.8 0 26.7 21.5 14.1 34.1L174.1 354.8c-7.8 7.8-20.5 7.8-28.3 0L17.2 226.1C4.6 213.5 13.5 192 31.3 192z"></path></svg>`
                )}")`,
                "multiselect-spinner": `url("${svgToDataUri(
                    `<svg viewBox="0 0 512 512" fill="${theme(
                        "colors.green.500"
                    )}" xmlns="http://www.w3.org/2000/svg"><path d="M456.433 371.72l-27.79-16.045c-7.192-4.152-10.052-13.136-6.487-20.636 25.82-54.328 23.566-118.602-6.768-171.03-30.265-52.529-84.802-86.621-144.76-91.424C262.35 71.922 256 64.953 256 56.649V24.56c0-9.31 7.916-16.609 17.204-15.96 81.795 5.717 156.412 51.902 197.611 123.408 41.301 71.385 43.99 159.096 8.042 232.792-4.082 8.369-14.361 11.575-22.424 6.92z"></path></svg>`
                )}")`,
                "multiselect-remove": `url("${svgToDataUri(
                    `<svg viewBox="0 0 320 512" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path d="M207.6 256l107.72-107.72c6.23-6.23 6.23-16.34 0-22.58l-25.03-25.03c-6.23-6.23-16.34-6.23-22.58 0L160 208.4 52.28 100.68c-6.23-6.23-16.34-6.23-22.58 0L4.68 125.7c-6.23 6.23-6.23 16.34 0 22.58L112.4 256 4.68 363.72c-6.23 6.23-6.23 16.34 0 22.58l25.03 25.03c6.23 6.23 16.34 6.23 22.58 0L160 303.6l107.72 107.72c6.23 6.23 16.34 6.23 22.58 0l25.03-25.03c6.23-6.23 6.23-16.34 0-22.58L207.6 256z"></path></svg>`
                )}")`,
            }),
            fontFamily: {
                sans: ["Nunito", ...defaultTheme.fontFamily.sans],
            },
        },

        dropShadow: {
            "3xl": "0 35px 35px rgba(0, 0, 0, 0.25)",
            "4xl": [
                "0 35px 35px rgba(0, 0, 0, 0.25)",
                "0 45px 65px rgba(0, 0, 0, 0.15)",
            ],
        },
    },

    plugins: [
        require("@tailwindcss/forms"),
        require("@tailwindcss/typography"),
        require("tw-elements/dist/plugin"),
    ],
};
