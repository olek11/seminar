import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/css/app.css",
                "resources/js/app.js",
                "resources/css/landing.css", // Tambahkan jika ada file khusus landing
            ],
            refresh: true,
        }),
    ],
    build: {
        outDir: "public/build",
        assetsDir: "assets",
    },
});
