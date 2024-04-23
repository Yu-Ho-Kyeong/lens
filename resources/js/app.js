
import './bootstrap';
import { createApp } from 'vue';
import App from './App.vue';
import MyHome from './components/Home.vue';
import router  from './router.js';
import store  from './store.js';
import axios from 'axios';

const app = createApp(App)
app.config.globalProperties.$axios      = axios;                 // 전역변수로 설정 컴포넌트에서 this.$axios로 사용
app.config.globalProperties.$route      = router;                // 전역변수로 설정 컴포넌트에서 this.$route 사용
app.config.globalProperties.$store      = store;                 // 전역변수로 설정 컴포넌트에서 this.$store 사용
app.config.globalProperties.$serverUrl  = 'localhost:3000'       // api server url
app.config.globalProperties.$apiUrl     = '/api/lensMark'         // api board url

app.component('hello-world', MyHome)
    .use(router)
    .mount('#app');
