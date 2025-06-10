import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import vue from "@vitejs/plugin-vue";
import tailwindcss from "@tailwindcss/vite";

export default defineConfig({
    server: {
        cors: true,
    },
    plugins: [
        laravel({
            input: ["resources/css/app.css", "resources/js/app.js"],
            refresh: true,
        }),
        tailwindcss(),
        vue(),
    ],
    resolve: {
        alias: {
            "@": "/resources/js",
            "@components": "/resources/js/components",
            "@svg": "/resources/js/assets/svg",
            "@img": "/resources/js/assets/images",

            vue: "vue/dist/vue.esm-bundler.js",
        },
    },
});
