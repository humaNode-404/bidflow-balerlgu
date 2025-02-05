// Styles
import '@core-scss/template/libs/vuetify/index.scss';
import 'vuetify/styles';

import { createVuetify } from 'vuetify';
import { VBtn, VDatePicker } from 'vuetify/components';
import { VCalendar } from 'vuetify/labs/VCalendar';
import { VDateInput } from 'vuetify/labs/VDateInput';
import { VSnackbarQueue } from 'vuetify/labs/VSnackbarQueue';
import defaults from './defaults';
import { icons } from './icons';
import { themes } from './theme';

// Import Swiper Vue.js components
import { Swiper, SwiperSlide } from 'swiper/vue';
// Import Swiper styles
import 'swiper/css';

import 'swiper/css/navigation';
import 'swiper/css/pagination';

export default function (app) {
  const vuetify = createVuetify({
    components: {
      VSnackbarQueue,
      VDateInput,
      VDatePicker,
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
