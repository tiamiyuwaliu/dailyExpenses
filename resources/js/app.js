import './bootstrap';
import '../css/app.css';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';
import 'vuetify/styles'
import { createVuetify } from 'vuetify'
import CustomScrollbar from 'custom-vue-scrollbar';
import 'custom-vue-scrollbar/dist/style.css';
import Toast from "vue-toastification";import "vue-toastification/dist/index.css";
import { QuillEditor } from '@vueup/vue-quill'
import '@vueup/vue-quill/dist/vue-quill.snow.css';


const vuetify = createVuetify({
    rtl: true,
    theme: {
        defaultTheme: 'light'
    }
})
import {translations} from "@/Mixins/translations";

const appName = window.document.getElementsByTagName('title')[0]?.getAttribute('name');

const toastOptions =  { };


createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, app, props, plugin }) {
        return createApp({ render: () => {
                return h(app, props)} })
            .use(vuetify)
            .use(plugin)
            .use(Toast, toastOptions)
            .use(ZiggyVue, Ziggy)
            .component(CustomScrollbar.name, CustomScrollbar)
            .component('QuillEditor', QuillEditor)
            .mixin(translations)
            .mount(el);
    },
});

InertiaProgress.init({ color: '#4B5563' });
