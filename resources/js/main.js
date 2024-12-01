/* eslint-disable vue/component-api-style */
import blankLayout from '@/layouts/Blank.vue';
import defLayout from '@/layouts/Default.vue';
import { registerPlugins } from '@core/utils/plugins';
import { createInertiaApp, Head, Link } from '@inertiajs/vue3';
import { createApp, h } from 'vue';
import './inertia-progress';

// Styles
import '@core-scss/template/index.scss';
import '@layouts/styles/index.scss';
import '@styles/styles.scss';

createInertiaApp({
  title: (title) => `${title}${title ? ' • Bidflow' : 'Bidflow'}`,
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

    // Register additional plugins
    registerPlugins(app);

    // Mount the Vue app
    app.mount(el);

    // Use nextTick to remove the loading background after the app is mounted
    // nextTick(() => {
    //   const loader = document.getElementById('loading-bg')
    //   if (loader) {
    //     loader.style.opacity = '0' // Fade-out effect
    //     setTimeout(() => {
    //       loader.remove()
    //     }, 500) // Wait for the fade-out effect
    //   }
    // })
  },
});
