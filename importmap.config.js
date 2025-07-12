// Import map configuration for @ aliases
// This ensures the import map is available before any ES modules are processed

const importMap = {
    "imports": {
        "@/": "/src/",
        "@/core/": "/src/core/",
        "@/components/": "/src/components/",
        "@/app/": "/src/app/",
        "@/utils/": "/src/utils/",
        "@/assets/": "/src/assets/"
    }
};

// Inject import map inline during page load
document.write(`<script type="importmap">${JSON.stringify(importMap, null, 4)}<\/script>`); 