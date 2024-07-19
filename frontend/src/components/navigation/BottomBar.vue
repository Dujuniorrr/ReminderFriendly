<template>
  <v-bottom-navigation
    color="info"
    active
    v-model="value"
    bg-color="white"
    mode="shift"
    class="bg-purple-4"
  >
    <v-btn
      base-color="blue-grey-darken-1"
      rounded="lg"
      :to="{ name: 'home' }"
      class="pa-5"
    >
      <v-icon size="x-large" icon="mdi-bell-ring" class="mb-2"></v-icon>
      <span>Lembretes</span>
    </v-btn>

    <v-btn
      base-color="blue-grey-darken-1"
      rounded="lg"
      :to="{ name: 'add-reminder' }"
      class="pa-5"
    >
      <v-icon size="x-large" icon="mdi-plus" class="mb-2"></v-icon>
      <span>Adicionar</span>
    </v-btn>

    <v-btn
      base-color="blue-grey-darken-1"
      rounded="lg"
      :to="{ name: 'calendar' }"
    >
      <v-icon
        size="x-large"
        icon="mdi-calendar-multiselect"
        class="mb-2"
      ></v-icon>

      <span>Agenda</span>
    </v-btn>
  </v-bottom-navigation>
</template>
<script lang="ts">
import { defineComponent } from "vue";

export default defineComponent({
  data: () => ({ value: 0 }),
});
</script>