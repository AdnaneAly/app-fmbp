import "./bootstrap";

import { createApp, h } from "vue";
import { route, ZiggyVue } from "../../vendor/tightenco/ziggy";
import { createInertiaApp, Link } from "@inertiajs/vue3";
import MainLayout from "./Layouts/MainLayout.vue";

createInertiaApp({
    resolve: (name) => {
        const pages = import.meta.glob("./Pages/**/*.vue", { eager: true });
        let page = pages[`./Pages/${name}.vue`];
        page.default.layout = page.default.layout || MainLayout;
        return page;
    },
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(ZiggyVue)
            .use(plugin)
            .component("Link", Link)
            .mixin({ methods: { route } })
            .mount(el);
    },
});
