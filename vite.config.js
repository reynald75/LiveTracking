import {
    defineConfig,
    loadEnv
} from 'vite';
import laravel from 'laravel-vite-plugin';

export default ({
    mode
}) => {
    process.env = {
        ...process.env,
        ...loadEnv(mode, process.cwd())
    };

    return defineConfig({
        define: {
            THUNDERFOREST_API_KEY: JSON.stringify(process.env.VITE_THUNDERFOREST_API_KEY)
        },
        plugins: [
            laravel({
                input: [
                    'resources/sass/app.scss',
                    'resources/sass/map.scss',
                    'resources/sass/interfaces.scss',
                    'node_modules/leaflet/dist/leaflet.css',
                    'resources/js/app.js'
                ],
                refresh: true,
            }),
        ],
    });
}