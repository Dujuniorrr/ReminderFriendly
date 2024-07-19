
// Vuetify
import { aliases, mdi } from 'vuetify/iconsets/mdi'
import '@mdi/font/css/materialdesignicons.css'
import 'vuetify/styles'
import { createVuetify } from 'vuetify'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'

import { VCalendar } from 'vuetify/labs/VCalendar'

import colors from 'vuetify/util/colors'


const vuetify = createVuetify({
  components: {
    VCalendar,
    ...components,

  },
  directives,
  icons: {
    defaultSet: 'mdi',
    aliases,
    sets: {
      mdi,
    },
  },
  theme: {
    themes: {
      light: {
        dark: false,
        colors: {
          blue: colors.blue.accent4,
          red: colors.red.accent4,
          green: colors.green.accent4,
          yellow: colors.yellow.accent4,
          // black: colors.black,
          'black-lighten-1': colors.grey.darken4
        }
      },
    },
  },
})

export default vuetify