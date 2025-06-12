import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import vue from "@vitejs/plugin-vue";
import tailwindcss from "@tailwindcss/vite";

export default defineConfig({
    server: {
        cors: true,
        // https: true,
        // hmr: {
        //     host: "19d5-217-61-226-160.ngrok-free.app", // <-- AQUÍ: SOLO EL HOSTNAME de tu URL de Ngrok (sin https://)
        //     clientPort: 443, // <-- PUERTO HTTPS
        // },
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
            "@/lib": "/resources/js/lib", // Or wherever your shadcn-vue lib directory will be
            "@/utils": "/resources/js/lib/utils", // Common alias for utilities
            // You might also need:
            "@/components/ui": "/resources/js/components/ui",
            vue: "vue/dist/vue.esm-bundler.js",
        },
    },
});
