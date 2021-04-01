require('./bootstrap');
require('bootstrap');

// Import modules...
import { createApp, h } from 'vue';
import { App as InertiaApp, plugin as InertiaPlugin } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';
import ElementPlus from 'element-plus';
import 'element-plus/lib/theme-chalk/index.css';
// import Vuetify from 'vuetify';
// import 'vuetify/dist/vuetify.min.css';
// Vue.use(Vuetify)

const el = document.getElementById('app');

const app = createApp({
    render: () =>
        h(InertiaApp, {
            initialPage: JSON.parse(el.dataset.page),
            resolveComponent: (name) => require(`./Pages/${name}`).default,
        }),
})
    .mixin({ methods: { route } })
    .use(InertiaPlugin)
    .use(ElementPlus)
    .mount(el);
InertiaProgress.init({ color: '#4B5563' , includeCSS: true, showSpinner: true });
