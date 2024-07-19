<template>
  <v-col>
    <v-row>
      <v-col cols="12" lg="4" class="p-1">
        <calendar />
      </v-col>
      <v-col cols="12" lg="8" class="pa-6">
        <v-row class="bg-white rounded-lg pa-3">
          <v-col cols="12" sm="6" md="4" v-for="n in 12" :key="n">
            <ReminderCard />
          </v-col>
        </v-row>
        <v-pagination
          active-color="blue-darken-4"
          color="blue-darken-2"
          v-model="page"
          :length="4"
          rounded="circle"
          class="my-4 rounded-lg"
        ></v-pagination>
      </v-col>
    </v-row>
  </v-col>

  <div class="text-center">
    <v-menu>
      <template v-slot:activator="{ props }">
        <v-btn
          position="fixed"
          location="top right"
          icon="mdi-filter-variant"
          color="blue-darken-2"
          elevation="8"
          class="ma-3"
          v-bind="props"
        >
        </v-btn>
      </template>

      <v-list class="bg-opacity-0">
        <v-list-item>
          <v-chip
           color="red-darken-1"
            prepend-icon="mdi-close"
            class="ms-2"
            variant="flat"
            :ripple="false"
            link
          >
            Não enviados
          </v-chip>
        </v-list-item>
        <v-list-item>
          <v-chip
           color="blue-darken-1"
            variant="flat"
            prepend-icon="mdi-check"
            class="ms-2"
            :ripple="false"
            link
          >
            Enviados
          </v-chip>
        </v-list-item>
      </v-list>
    </v-menu>
  </div>

  <AddReminderModal />
</template>

<script lang="ts">
import { defineComponent } from "vue";
import Calendar from "../components/calendars/Calendar.vue";
import ReminderCard from "../components/cards/ReminderCard.vue";
import AddReminderModal from "../components/modal/AddReminderModal.vue";

export default defineComponent({
  components: { ReminderCard, Calendar, AddReminderModal },
  data() {
    return {};
  },
});
</script>