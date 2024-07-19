<template>
  <v-col class="mb-10">
    <v-row>
      <v-col cols="12" lg="4" class="pt-0 mt-3">
        <Calendar />
      </v-col>
      <v-col cols="12" lg="8 rounded-lg h-100">
        <ReminderList
          :pagination="pagination"
          :total="total"
          :reminders="reminders"
          v-model="pagination.page"
        />
      </v-col>
    </v-row>
  </v-col>

  <div class="text-center">
    <ReminderFilter v-model="pagination" />
  </div>

  <AddReminderModal />
</template>

<script lang="ts">
import { defineComponent } from "vue";
import Calendar from "../components/calendars/Calendar.vue";
import ReminderCard from "../components/cards/ReminderCard.vue";
import AddReminderModal from "../components/modal/AddReminderModal.vue";
import ListReminders from "../core/application/command/ListReminders";
import APIReminderGateway from "../core/infra/gateway/APIReminderGateway";
import ReminderGateway from "../core/application/gateway/ReminderGateway";
import HttpClient from "../core/application/http/HttpClient";
import AxiosHttpClient from "../core/infra/http/AxiosHttpClient";
import ReminderList from "../components/lists/ReminderList.vue";
import ReminderFilter from "../components/filters/ReminderFilter.vue";

const httpClient: HttpClient = new AxiosHttpClient();
const reminderGateway: ReminderGateway = new APIReminderGateway(httpClient);
const listReminder: ListReminders = new ListReminders(reminderGateway);

export default defineComponent({
  components: {
    ReminderCard,
    Calendar,
    AddReminderModal,
    ReminderList,
    ReminderFilter,
  },
  data() {
    return {
      reminders: [],
      pagination: {
        page: 1,
        limit: 9,
        status: "notSend",
      },
      total: 0,
    };
  },

  watch: {
    pagination: {
      deep: true,
      handler() {
        this.fetchReminders();
      },
    },
  },
  created() {
    this.pagination.page = this.$route.query.page ?? this.pagination.page;
    this.pagination.limit = this.$route.query.limit ?? this.pagination.limit;
    this.pagination.status = this.$route.query.status ?? this.pagination.status;
    this.fetchReminders();
  },
  methods: {
    async fetchReminders() {
      this.$router.push({ query: this.pagination });
      this.reminders = await listReminder.execute(this.pagination);
      this.total = Math.ceil(
        reminderGateway.totalRequisited / this.pagination.limit
      );
    },
  },
});
</script>

<style >
.v-pagination__item *:not(.v-pagination__item--is-active *),
.v-pagination__next *,
.v-pagination__prev * {
  color: #11558d !important;
}
.v-empty-state__headline {
  color: white !important;
}
</style>