
import './assets/main.css'
import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'

// Vuetify
import { aliases, mdi } from 'vuetify/iconsets/mdi'
import '@mdi/font/css/materialdesignicons.css'
import 'vuetify/styles'
import { createVuetify } from 'vuetify'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'

import { VCalendar } from 'vuetify/labs/VCalendar'

 


const vuetify = createVuetify({
  components: {
    VCalendar,
    ...  components,

  },
  directives,
  icons: {
    defaultSet: 'mdi',
    aliases,
    sets: {
      mdi,
    },
  },
  // theme: {
  //   defaultTheme: 'myCustomLightTheme',
  //   themes: {
  //     myCustomLightTheme,
  //   },
  // },
})

const app = createApp(App)

app.use(vuetify)
app.use(router)
app.use(store)
app.mount('#app')
