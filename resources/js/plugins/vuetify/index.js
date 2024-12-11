import { createVuetify } from 'vuetify';
import { VBtn } from 'vuetify/components/VBtn';
import { VCalendar } from 'vuetify/labs/VCalendar';
import defaults from './defaults';
import { icons } from './icons';
import { themes } from './theme';

// Import Swiper Vue.js components
import { Swiper, SwiperSlide } from 'swiper/vue';
// Import Swiper styles
import 'swiper/css';

import 'swiper/css/navigation';
import 'swiper/css/pagination';

// import './style.css';

// Styles
import '@core-scss/template/libs/vuetify/index.scss';
import 'vuetify/styles';

export default function (app) {
  const vuetify = createVuetify({
    components: {
      VCalendar,
      Swiper,
      SwiperSlide,
    },
    aliases: {
      IconBtn: VBtn,
    },
    defaults,
    icons,
    theme: {
      defaultTheme: 'light',
      themes,
    },
  });

  app.use(vuetify);
}
