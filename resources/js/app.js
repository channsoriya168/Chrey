import "./bootstrap";
import "../css/app.css";
import { createApp, h } from "vue";
import { renderApp } from "@inertiaui/modal-vue";
import { createInertiaApp } from "@inertiajs/vue3";
import { Head } from "@inertiajs/vue3";
import DataTabeServer from "./Components/DataTabeServer.vue";

import "vuetify/styles";
import { createVuetify } from "vuetify";
import * as components from "vuetify/components";
import * as directives from "vuetify/directives";
import "@mdi/font/css/materialdesignicons.css";
import "vuetify/styles";
const vuetify = createVuetify({
    components,
    directives,
});

// ziggy
import { ZiggyVue } from "ziggy-js";
import { Ziggy } from "./ziggy";
import { Link } from "@inertiajs/vue3";

import DashboardLayout from "./Layouts/DashboardLayout.vue";
import FrontendLayout from "./Layouts/FrontendLayout.vue";

import { Modal, putConfig } from "@inertiaui/modal-vue"; // Ensure correct import for Vue 3
putConfig({
    type: "modal",
    navigate: false,
    modal: {
        closeButton: true,
        closeExplicitly: false,
        maxWidth: "2xl",
        paddingClasses: "p-4 sm:p-6",
        panelClasses: "bg-white rounded",
        position: "center",
    },
    slideover: {
        closeButton: true,
        closeExplicitly: false,
        maxWidth: "md",
        paddingClasses: "p-4 sm:p-6",
        panelClasses: "bg-white min-h-screen",
        position: "right",
    },
});

createInertiaApp({
    resolve: (name) => {
        const pages = import.meta.glob("./Pages/**/*.vue", { eager: true });

        // Try exact path first
        let page = pages[`./Pages/${name}.vue`];

        // If page not found, try fallback options
        if (!page) {
            // Try to find a fallback page
            page =
                pages[`./Pages/Frontend/Index.vue`] ||
                pages[`./Pages/Dashboard/Index.vue`];
        }

        // Only set layout if page exists and has a default export
        if (page && page.default) {
            if (name.includes("Dashboard")) {
                page.default.layout = DashboardLayout;
            } else {
                page.default.layout = page.default.layout || FrontendLayout;
            }
        }

        return page;
    },
    setup({ el, App, props, plugin }) {
        createApp({ render: renderApp(App, props) })
            .use(plugin)
            .use(vuetify)
            .use(ZiggyVue, Ziggy)
            .component("Head", Head)
            .component("Link", Link)
            .component("Modal", Modal)
            .component("DataTabeServer", DataTabeServer)
            .mount(el);
    },
});
