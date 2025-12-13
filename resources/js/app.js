import './bootstrap'
import '../css/app.css'
import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'
import { Head } from '@inertiajs/vue3'

// ziggy
import { ZiggyVue } from 'ziggy-js'
import { Ziggy } from './ziggy'
import { Link } from '@inertiajs/vue3'
import { Form, Field } from 'vee-validate'

// i18n
import i18n from './i18n'

import DashboardLayout from './Layouts/DashboardLayout.vue'
import FrontendLayout from './Layouts/FrontendLayout.vue'

createInertiaApp({
    // Header title management
    title: (title) => (title ? `${title} - Chrey` : 'Chrey'),
    resolve: (name) => {
        const pages = import.meta.glob('./Pages/**/*.vue', { eager: true })

        // Try exact path first
        let page = pages[`./Pages/${name}.vue`]

        // If page not found, try fallback options
        if (!page) {
            // Try to find a fallback page
            page = pages[`./Pages/Frontend/Index.vue`] || pages[`./Pages/Dashboard/Index.vue`]
        }

        // Only set layout if page exists and has a default export
        if (page && page.default) {
            // Check if layout is explicitly set (including null)
            if (!('layout' in page.default)) {
                // Only set default layout if not explicitly defined
                if (name.includes('Dashboard')) {
                    page.default.layout = DashboardLayout
                } else {
                    page.default.layout = FrontendLayout
                }
            }
        }

        return page
    },
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue, Ziggy)
            .use(i18n)
            .component('Head', Head)
            .component('Link', Link)
            .component('vee-form', Form)
            .component('vee-field', Field)
            .mount(el)
    }
})
