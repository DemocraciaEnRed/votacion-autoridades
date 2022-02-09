import Vue from 'vue';

import '@/js/axios';
import '@/js/vendors';

import router from '@/js/router';
import store from '@/js/store';
import App from '@/App.vue';

Vue.config.productionTip = false;

async function init() {
  await store.dispatch('logged');
  await store.dispatch('getData');
}

init().then(() => {
  new Vue({
    router,
    store,
    render: (h) => h(App),
  }).$mount('#app');
});
