import './bootstrap';
import '../css/app.css'; // ★ここ重要：LaravelのCSS(Tailwind)を読み込む

import { createApp } from 'vue';
import App from './App.vue';

// アプリを起動して、<div id="app"> に表示する
createApp(App).mount('#app');


