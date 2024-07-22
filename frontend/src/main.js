
import './assets/main.css'

import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'
import vuetify from './vuetify'

const app = createApp(App)

app.use(vuetify)
app.use(router)
app.use(store)

app.mount('#app')
