import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import fs from "fs";
import path from "path";

function getJsFilesFrom(dir) {
    const fullPath = path.resolve(__dirname, dir);
    if (!fs.existsSync(fullPath)) return [];

    return fs
        .readdirSync(fullPath)
        .filter((file) => file.endsWith(".js"))
        .map((file) => `${dir}/${file}`);
}

const adminPages = getJsFilesFrom("resources/js/pages/admin");
const superadminPages = getJsFilesFrom("resources/js/pages/superadmin");
const petugasPages = getJsFilesFrom("resources/js/pages/petugas");

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/css/app.css",
                "resources/js/app.js",
                ...adminPages,
                ...superadminPages,
                ...petugasPages,
            ],
            refresh: true,
        }),
    ],
});
