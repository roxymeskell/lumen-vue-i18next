import { createApp } from 'vue'
import './style.css'
import i18n from './i18n'
import App from './App.vue'

i18n(createApp(App)).mount('#app')
