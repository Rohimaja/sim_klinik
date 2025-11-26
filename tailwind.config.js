import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',
    content: [
    './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
    './storage/framework/views/*.php',
    './resources/views/**/*.blade.php',
    './resources/js/**/*.js',
    './resources/js/**/*.vue',
    './resources/js/**/*.jsx',
    './resources/views/**/*.php', // ini tambahan penting
    ],


    theme: {
        extend: {
            fontFamily: {
                sans: ["Figtree", ...defaultTheme.fontFamily.sans],
            },
            backgroundImage: {
                'primary-bg': 'bg-[linear-gradient(to_right,#2088FF_0%,#7134FC_100%)]',
            },
        },
    },

    plugins: [forms],
};
