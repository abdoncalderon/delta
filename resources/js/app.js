import './bootstrap';
import '../css/app.css';
import '@fortawesome/fontawesome-free/css/all.min.css'
import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';
import { trnsl } from './Lang/languages.js';


const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {

        const myApp = createApp({ render: () => h(App, props) })
            .use(trnsl)
            .use(plugin)
            .use(ZiggyVue, Ziggy)
            
        myApp.config.globalProperties.$trnsl = trnsl;
        
        myApp.mount(el);
        return myApp;
    },
    progress: {
        color: '#4B5563',
    },
});

/* return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue, Ziggy)
            .mount(el); */