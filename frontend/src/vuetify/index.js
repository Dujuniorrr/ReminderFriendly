
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
          green: colors.green.darken1,
          yellow: colors.yellow.accent4,
          orange: colors.orange.accent4,
          pink: colors.pink.accent4,
          purple: colors.purple.accent4,
          indigo: colors.indigo.accent4,
          teal: colors.teal.accent4,
          cyan: colors.cyan.accent4,
          lime: colors.lime.accent4,
          'black-darken-2': colors.grey.darken4
        }
      },
    },
  },
})

export default vuetify