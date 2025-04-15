// tailwind.config.js
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
        "./resources/**/*.ts", // If you're using TypeScript
        "./public/**/*.html", // Include public HTML files if needed
    ],
    theme: {
        extend: {
            colors: {
                primary: {
                    DEFAULT: "#003366",
                    light: "#007bff",
                    dark: "#001D3A",
                },
                secondary: {
                    DEFAULT: "#b80c09",
                    light: "#DC2626",
                    dark: "#7F1D1D",
                },
            },
        },
    },
    darkMode: "media", // Enables dark mode based on system preference
    plugins: [],
};
