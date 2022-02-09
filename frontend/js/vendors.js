import Vue from 'vue';

//# Font Awesome
import { library } from '@fortawesome/fontawesome-svg-core';
import {
  // Buefy
  faCheck,
  faCheckCircle,
  faInfoCircle,
  faExclamationTriangle,
  faExclamationCircle,
  faArrowUp,
  faAngleRight,
  faAngleLeft,
  faAngleDown,
  faEye,
  faEyeSlash,
  faCaretDown,
  faCaretUp,
  faUpload,
  // Custom
  faChevronUp,
  faChevronDown,
  faChevronLeft,
  faChevronRight,
  faUser,
  faHeart,
  faExclamation,
  faQuestion,
  faDownload,
} from '@fortawesome/free-solid-svg-icons';
import { faHeart as farHearth } from '@fortawesome/free-regular-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';

library.add(
  // Buefy
  faCheck,
  faCheckCircle,
  faInfoCircle,
  faExclamationTriangle,
  faExclamationCircle,
  faArrowUp,
  faAngleRight,
  faAngleLeft,
  faAngleDown,
  faEye,
  faEyeSlash,
  faCaretDown,
  faCaretUp,
  faUpload,
  // Custom
  faChevronUp,
  faChevronDown,
  faChevronLeft,
  faChevronRight,
  faHeart,
  faExclamation,
  faUser,
  faQuestion,
  faDownload,
  // Far
  farHearth
);
Vue.component('icon', FontAwesomeIcon);

//# Buefy
import Buefy from 'buefy';
Vue.use(Buefy, {
  defaultIconComponent: 'icon',
  defaultIconPack: 'fas',
});

//# Youtube
import VueYoutube from 'vue-youtube';
Vue.use(VueYoutube);

//# Charts
import VueApexCharts from 'vue-apexcharts';
Vue.use(VueApexCharts);
Vue.component('chart', VueApexCharts);
