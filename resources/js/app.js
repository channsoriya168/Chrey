import "./bootstrap";
import "../css/app.css";
import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/vue3";
import { Head } from "@inertiajs/vue3";

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

createInertiaApp({
    resolve: (name) => {
        const pages = import.meta.glob("./Pages/**/*.vue", { eager: true });
        let page = pages[`./Pages/${name}.vue`];
        page.default.layout = page.default.layout || DashboardLayout;
        return page;
    },
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(vuetify)
            .use(ZiggyVue, Ziggy)
            .component("Head", Head)
            .component("Link", Link)
            .mount(el);
    },
});
