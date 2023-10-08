import { createApp } from 'vue'
import 'font-awesome/css/font-awesome.min.css';
import 'bootstrap';
import 'bootstrap/dist/css/bootstrap.css';
import App from './App.vue'
import router from './router'
import "./assets/css/index.css"
import store from './store'
import Antd from 'ant-design-vue';
import 'ant-design-vue/dist/reset.css';
import Toast from "vue-toastification";
import "vue-toastification/dist/index.css";
import VueCookies from 'vue-cookies';
const toastOption = {
    transition: "Vue-Toastification__bounce",
    maxToasts: 20,
    newestOnTop: true
}
const cookiesOption = {
    expires: '1d'
}

createApp(App).use(router).use(store).use(Toast, toastOption).use(Antd).use(VueCookies, cookiesOption).mount('#app')
