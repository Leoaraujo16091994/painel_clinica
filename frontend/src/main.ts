import { createApp } from 'vue'
import { createPinia } from 'pinia'

import App from './App.vue'
import router from './router'

// Vuetify
import 'vuetify/styles'
import { createVuetify } from 'vuetify'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'
import '@mdi/font/css/materialdesignicons.css'


const vuetify = createVuetify({
  components,
  directives,
   icons: {
    defaultSet: 'mdi',
  },
  theme: {
    defaultTheme: 'clinicaTheme',
    themes: {
      clinicaTheme: {
        dark: false,
        colors: {
          primary: '#0D47A1',   // azul escuro
          secondary: '#1565C0', // azul médio
          background: '#F5F7FA', // fundo claro
          surface: '#FFFFFF',   // cards brancos
        },
      },
    },
  },
})

const app = createApp(App)

app.use(createPinia())
app.use(router)
app.use(vuetify)

app.mount('#app')
