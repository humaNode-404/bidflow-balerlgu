import './echo';

//import blankLayout from '@/layouts/Blank.vue';
import defLayout from '@/layouts/Default.vue';
import { registerPlugins } from '@core/utils/plugins';
import { createInertiaApp, Head, Link } from '@inertiajs/vue3';
import axios from 'axios';
import { createApp, h } from 'vue';
import ApexCharts from 'vue3-apexcharts';
import { ZiggyVue } from 'ziggy-js';
import './inertia-progress';

import '@core-scss/template/index.scss';
import '@layouts/styles/index.scss';
import '@styles/nprogress.scss';
import '@styles/styles.scss';

const appName = import.meta.env.VITE_APP_NAME || 'Bidflow';
window.axios = axios;
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

createInertiaApp({
  title: (title) => (title ? `${title} - ${appName}` : appName),
  resolve: (name) => {
    const pages = import.meta.glob('./pages/**/*.vue', { eager: true });
    let page = pages[`./pages/${name}.vue`];

    page.default.layout = page.default.layout || defLayout;
    return page;
  },
  setup({ el, App, props, plugin }) {
    // Create the Vue app instance
    const app = createApp({ render: () => h(App, props) })
      .component('Head', Head)
      .component('Link', Link)
      .component('apexchart', ApexCharts)
      .use(plugin)
      .use(ZiggyVue);

    // Register additional plugins
    registerPlugins(app);
    app.mount(el);
  },
});
