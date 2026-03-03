import cssInjectedByJsPlugin from "vite-plugin-css-injected-by-js";
import tailwindcss from "@tailwindcss/vite";
import react from "@vitejs/plugin-react";
import path from "node:path";
import { defineConfig } from "vite";
import { vitePluginManusRuntime } from "vite-plugin-manus-runtime"; // Keep if needed by other components

const plugins = [
  react(),
  tailwindcss(),
  vitePluginManusRuntime(),
  cssInjectedByJsPlugin(),
];

export default defineConfig({
  plugins,
  resolve: {
    alias: {
      "@": path.resolve(import.meta.dirname, "client", "src"),
      "@shared": path.resolve(import.meta.dirname, "shared"),
      "@assets": path.resolve(import.meta.dirname, "attached_assets"),
    },
  },
  envDir: path.resolve(import.meta.dirname),
  css: {
    devSourcemap: false,
  },
  build: {
    sourcemap: false,
    outDir: path.resolve(import.meta.dirname, "dist-widget"), // Ensure different output dir
    emptyOutDir: true,
    lib: {
      entry: path.resolve(__dirname, "client/src/widget.tsx"),
      name: "BengkelCalendar",
      formats: ["iife"],
      fileName: () => "bengkel-calendar.js",
    },
    rollupOptions: {
      // define to prevent react/react-dom from being externalized in the browser bundle
    },
  },
  define: {
    "process.env.NODE_ENV": '"production"', // Mute React production warnings
  }
});
