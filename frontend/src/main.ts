import { createApp } from 'vue'
import './assets/styles/main.scss'
import App from './App.vue'
import router from "@/router.ts";
import {createPinia} from "pinia";
import VueSweetalert2 from 'vue-sweetalert2';

import 'sweetalert2/dist/sweetalert2.min.css';
const app = createApp(App)

const pinia = createPinia()

app.use(pinia)
app.use(router)
app.use(VueSweetalert2);
app.mount('#app')