import './assets/app.css';
import { createApp } from 'vue';
import PrimeVue from 'primevue/config';
import Aura from '@primevue/themes/aura';
import ToastService from 'primevue/toastservice';
import InputSwitch from 'primevue/inputswitch';
import InputNumber from 'primevue/inputnumber';
import router from './router';
import 'primeicons/primeicons.css';

import App from './App.vue';

const app = createApp(App);

app.use(router);
app.use(PrimeVue, {
    theme: {
        preset: Aura,
    },
});
app.use(ToastService);
app.component('InputSwitch', InputSwitch);
app.component('InputNumber', InputNumber);

app.mount('#app');