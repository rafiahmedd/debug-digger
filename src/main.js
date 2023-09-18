import {createApp} from 'vue';
import {createRouter, createWebHashHistory} from 'vue-router';
import {routes} from './routes';

import App from './App.vue'; // Import the main app component

const app = createApp(App); // Create the app instance

const router = createRouter({
    routes,
    history: createWebHashHistory()
});

window.debugDigger = app.use(router).mount(
    '#debug-digger-app'
); // Mount the app to the DOM