import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import fs from 'fs';
import path from 'path';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],

    // الدالة التي تُستدعى قبل بدء التشغيل
    server: {
        async serverStart() {
            try {
                // مسار الملف الأصلي
                const sourceFilePath = 'resources/js/notifications.js';
                // مسار المجلد المستهدف
                const targetFolderPath = 'public/js';
                // مسار الملف المستهدف
                const targetFilePath = path.join(targetFolderPath, 'notifications.js');

                // التأكد من وجود المجلد الهدف
                if (!fs.existsSync(targetFolderPath)) {
                    fs.mkdirSync(targetFolderPath, { recursive: true });
                }

                // نسخ الملف
                fs.copyFileSync(sourceFilePath, targetFilePath);
                console.log('File copied successfully!');
            } catch (error) {
                console.error('Error copying file:', error);
            }
        },
    }
});
