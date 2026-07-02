import { copyFileSync, mkdirSync } from 'node:fs';
import { dirname, join } from 'node:path';
import { fileURLToPath } from 'node:url';

const root = join(dirname(fileURLToPath(import.meta.url)), '..');
const targetDir = join(root, 'public', 'js', 'vendor');

mkdirSync(targetDir, { recursive: true });

copyFileSync(
    join(root, 'node_modules', 'alpinejs', 'dist', 'cdn.min.js'),
    join(targetDir, 'alpine.min.js'),
);

console.log('Copied alpine.min.js to public/js/vendor/');
