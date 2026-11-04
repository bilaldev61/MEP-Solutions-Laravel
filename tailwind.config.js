import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            colors: {
                // Deep industrial slate-teal — primary brand
                brand: {
                    50:  '#eef5f6',
                    100: '#d8e7ea',
                    200: '#b2cfd5',
                    300: '#82adba',
                    400: '#518799',
                    500: '#356a7c',
                    600: '#285465',
                    700: '#214452',
                    800: '#1d3843',
                    900: '#112430',
                    950: '#0a161e',
                },
                // Safety orange — welding / electrical energy accent
                ember: {
                    50:  '#fff5ed',
                    100: '#ffe6d0',
                    200: '#ffcaa1',
                    300: '#ffa566',
                    400: '#ff7a2e',
                    500: '#f95810',
                    600: '#ea3f06',
                    700: '#c22c07',
                    800: '#9a250e',
                    900: '#7c210f',
                },
                // Water teal — plumbing / cleaning accent
                aqua: {
                    50:  '#ecfeff',
                    100: '#cff9fd',
                    200: '#a4f1fa',
                    300: '#6be4f4',
                    400: '#2cd0e8',
                    500: '#0eb0cb',
                    600: '#0a8dad',
                    700: '#0e708c',
                    800: '#155b73',
                    900: '#164c62',
                },
            },
            fontFamily: {
                sans: ['Inter', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                display: ['Poppins', 'Inter', 'ui-sans-serif', 'sans-serif'],
            },
            boxShadow: {
                card: '0 4px 24px -8px rgba(17, 36, 48, 0.18)',
                lift: '0 20px 40px -20px rgba(17, 36, 48, 0.35)',
            },
            borderRadius: {
                '4xl': '2rem',
            },
        },
    },
    plugins: [forms],
}
