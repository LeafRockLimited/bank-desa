import './bootstrap';
import '../css/app.css';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';
import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'

import vSelect from 'vue-select'
import 'vue-select/dist/vue-select.css';
import moment from 'moment';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        const app = createApp({ render: () => h(App, props) });
        app.use(plugin)
            .use(ZiggyVue)
            .component('VueDatePicker', VueDatePicker)
            .component('v-select', vSelect);
        
        // Add moment as a global property
        app.config.globalProperties.$moment = moment;
        
        app.mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
