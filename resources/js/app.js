import './bootstrap';
import { createApp } from 'vue';
import App from './App.vue';
import router from './router';
import vuetify from './plugins/vuetify';

// Crear la aplicación Vue
const app = createApp(App);

// Usar plugins
app.use(router);
app.use(vuetify);

// Montar la aplicación en el elemento con id "app"
app.mount('#app');
