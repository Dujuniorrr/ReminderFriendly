// tests/test-utils.ts
import { createVuetify } from 'vuetify';
import { mount, createLocalVue } from '@vue/test-utils';
import { createApp } from 'vue';
import Vuetify from 'vuetify/lib';

const vuetify = createVuetify();

const localVue = createLocalVue();
localVue.use(Vuetify);

export function mountWithVuetify(component, options = {}) {
  const app = createApp(component);
  app.use(vuetify);
  return mount(component, {
    global: {
      plugins: [vuetify],
      ...options
    }
  });
}
