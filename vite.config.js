import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/css/app.css",
                "resources/js/app.js", // opsional, kalau JS nggak dipakai bisa dihapus
            ],
            refresh: true,
        }),
    ],
});
