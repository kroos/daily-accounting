import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { path  } from 'path';

export default defineConfig({
	plugins: [
		laravel({
			input: [
				'resources/scss/app.scss',
				'resources/css/app.css',
				'resources/js/app.js'
			],
			refresh: true,
		}),
	],
	build: {
			chunkSizeWarningLimit: 3000,
			// rollupOptions: {
			// 	output: {
			// 		manualChunks(id) {
			// 			if (id.includes('node_modules')) {
			// 				return 'vendor'; // Moves external libraries into a separate file
			// 			}
			// 		},
			// 	},
			// },
		},
});
