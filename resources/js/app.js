import '../css/app.css';

import blankLayout from '@/layouts/Blank.vue';
import defLayout from '@/layouts/Default.vue';
import { registerPlugins } from '@core/utils/plugins';
import { createInertiaApp, Head, Link } from '@inertiajs/vue3';
import { createApp, h } from 'vue';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';
import './inertia-progress';

import '@core-scss/template/index.scss';
import '@layouts/styles/index.scss';
import '@styles/styles.scss';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
  title: (title) => `${title} - ${appName}`,
  resolve: (name) => {
    const pages = import.meta.glob('./pages/**/*.vue', { eager: true });
    let page = pages[`./pages/${name}.vue`];

    page.default.layout =
      page.default.layout === null || page.default.layout === blankLayout
        ? blankLayout
        : defLayout;

    return page;
  },
  setup({ el, App, props, plugin }) {
    // Create the Vue app instance
    const app = createApp({ render: () => h(App, props) })
      .component('Head', Head)
      .component('Link', Link);

    // Use the Inertia plugin
    app.use(plugin);

    app.use(ZiggyVue);

    // Register additional plugins
    registerPlugins(app);

    // Mount the Vue app
    app.mount(el);
  },
});
