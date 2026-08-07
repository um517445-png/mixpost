import { defineConfig, loadEnv } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import tailwindcss from "@tailwindcss/vite";
import DefineOptions from 'unplugin-vue-define-options/vite'
import fs from 'fs';
import path from 'path';
import { homedir } from 'os';

export default defineConfig(({command, mode}) => {
    const env = loadEnv(mode, process.cwd(), '');
    let host = env.APP_URL !== undefined ? new URL(env.APP_URL).host : null;
    let homeDir = homedir();
    let serverConfig = {};

    if (command === 'serve' && host && homeDir) {
        const certificatesPath = env.CERTIFICATES_PATH !== undefined ? env.CERTIFICATES_PATH : `.config/valet/Certificates/${host}`;
        const keyPath = path.resolve(homeDir, `${certificatesPath}.key`);
        const certPath = path.resolve(homeDir, `${certificatesPath}.crt`);

        if (fs.existsSync(keyPath) && fs.existsSync(certPath)) {
            serverConfig = {
                https: {
                    key: fs.readFileSync(keyPath),
                    cert: fs.readFileSync(certPath),
                },
                hmr: { host },
                host
            };
        }
    }

    return {
        publicDir: 'vendor/mixpost',
        plugins: [
            laravel({
                input: 'resources/js/app.js',
                publicDirectory: 'resources/dist',
                buildDirectory: 'vendor/mixpost',
                refresh: true
            }),
            vue({
                template: {
                    transformAssetUrls: {
                        base: null,
                        includeAbsolute: false,
                    },
                },
            }),
            tailwindcss(),
            DefineOptions()
        ],
        resolve: {
            alias: {
                '@': path.resolve(__dirname, 'resources/js'),
                '@css': path.resolve(__dirname, 'resources/css'),
                '@img':  path.resolve(__dirname, 'resources/img'),
            },
        },
        server: serverConfig
    }
});
