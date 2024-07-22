<template>
  <div class="bg-white rounded-lg pa-3 py-5">
    <v-fab
      class="ms-4 d-lg-none"
      location="bottom center"
      size="x-small"
      elevation="0"
      :icon="show ? 'mdi-chevron-up' : 'mdi-chevron-down'"
      @click="show = !show"
      absolute
      offset
    ></v-fab>
    <v-fab
      class="ms-4 d-none d-lg-flex"
      location="bottom center"
      size="x-small"
      elevation="0"
      :icon="fullScreen ? 'mdi-chevron-left' : 'mdi-chevron-right'"
      @click="$emit('allscreenCalendar')"
      absolute
      offset
    ></v-fab>
    <v-expand-transition >
      <div v-show="show" class="mt-3">
     
        <div>
          <v-container>
            <v-row class="fill-height">
              <v-col>
                <v-sheet>
                  <v-calendar
                    ref="calendar"
                    v-model="date"
                    :events="events"
                    :view-mode="type"
                    :weekdays="weekday"
                    class="text-primary"
                    :hide-header="true"
                    :year="year"
                  ></v-calendar>
                </v-sheet>
              </v-col>
            </v-row>
          </v-container>
        </div>
      </div>
    </v-expand-transition>
  </div>
</template>
<script lang="ts">
import { useDate } from "vuetify";

import HttpClient from "../../core/application/http/HttpClient";
import AxiosHttpClient from "../../core/infra/http/AxiosHttpClient";
import ReminderGateway from "../../core/application/gateway/ReminderGateway";
import APIReminderGateway from "../../core/infra/gateway/APIReminderGateway";
import ListRemindersByMonth from "../../core/application/command/ListRemindersByMonth";

const httpClient: HttpClient = new AxiosHttpClient();
const reminderGateway: ReminderGateway = new APIReminderGateway(httpClient);
const listRemindersByMonth = new ListRemindersByMonth(reminderGateway);

const currentDate = new Date();
const currentMonth = currentDate.getMonth() + 1;
const currentYear = currentDate.getFullYear();
export default {
  props: {
    fullScreen: {
      type: Boolean,
      default: false
    }
  },
  data: () => ({
    year: currentYear,
    show: true,
    type: "month",
    types: [
      {
        title: "Mês",
        value: "month",
      },
      {
        title: "Dia",
        value: "day",
      },
    ],
    weekday: [0, 1, 2, 3, 4, 5, 6],
    events: [],
    date: [new Date()],
  }),
  mounted() {
    const adapter = useDate();
    this.getEvents({
      start: adapter.startOfDay(adapter.startOfMonth(new Date())),
      end: adapter.endOfDay(adapter.endOfMonth(new Date())),
    });
  },
  methods: {
    async getEvents({ start, end }) {
      const events = [];

      const reminders = await listRemindersByMonth.execute({
        month: currentMonth,
        year: currentYear,
      });

      for (const reminder of reminders) {
        const allDay = false;

        const reminderDate = reminder.date;

        const first = new Date(reminderDate);

        const second = new Date(first);

        second.setMinutes(first.getMinutes() + 15);

        events.push({
          title: reminder.originalMessage,
          start: first,
          end: second,
          color: reminder.character.color,
          allDay: allDay,
        });
      }
      this.events = events;
    },
  
    rnd(a: number, b: number) {
      return Math.floor((b - a + 1) * Math.random()) + a;
    },
  },
};
</script>

 <style>
.v-calendar-month__days > .v-calendar-month__day {
  min-height: 0px !important;
}
</style>