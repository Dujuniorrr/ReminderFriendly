<template>
  <v-col class="mb-10">
    <v-row>
      <v-col cols="12" :lg="!allscreenCalendar ? 4 : 12" class="pt-0 mt-3">
        <Calendar :fullScreen="allscreenCalendar" @allscreenCalendar="onAllscreenCalendar" />
      </v-col>
      <v-col cols="12" :lg="!allscreenCalendar ? 8 : 12" class="rounded-lg" style="min-height: 50vh !important">
        <ReminderList
          @deleteReminder="deleteReminder"
          @sendReminder="sendReminder"
          :loading="loadingList"
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

  <v-btn
    id="activator-target"
    position="fixed"
    location="bottom center"
    icon="mdi-plus"
    size="x-large"
    color="white"
    elevation="8"
    class="mb-3 text-primary border-md border-primary border-opacity-75"
  />

  <AddReminderModal @reminderAdded="fetchReminders" />
  <SimpleToast :show="toast.show" :message="toast.message" :type="toast.type" />
</template>

<script lang="ts">
import { defineComponent } from "vue";

import Calendar from "../components/calendars/Calendar.vue";
import ReminderCard from "../components/cards/ReminderCard.vue";
import AddReminderModal from "../components/modal/AddReminderModal.vue";
import ReminderList from "../components/lists/ReminderList.vue";
import ReminderFilter from "../components/filters/ReminderFilter.vue";
import SimpleToast from "../components/toasts/SimpleToast.vue";

import ListReminders from "../core/application/command/ListReminders";
import APIReminderGateway from "../core/infra/gateway/APIReminderGateway";
import ReminderGateway from "../core/application/gateway/ReminderGateway";
import HttpClient from "../core/application/http/HttpClient";
import AxiosHttpClient from "../core/infra/http/AxiosHttpClient";
import SendReminder, { Output } from "../core/application/command/SendReminder";
import DeleteReminder from "../core/application/command/DeleteReminder";

const httpClient: HttpClient = new AxiosHttpClient();
const reminderGateway: ReminderGateway = new APIReminderGateway(httpClient);
const listReminder: ListReminders = new ListReminders(reminderGateway);
const sendReminder: SendReminder = new SendReminder(reminderGateway);
const deleteReminder: DeleteReminder = new DeleteReminder(reminderGateway);

export default defineComponent({
  components: {
    ReminderCard,
    Calendar,
    AddReminderModal,
    ReminderList,
    ReminderFilter,
    SimpleToast,
  },
  data() {
    return {
      allscreenCalendar: false,
      loadingList: true,
      reminders: [],
      pagination: {
        page: 1,
        limit: 9,
        status: "notSend",
      },
      toast: {
        show: false,
        message: "test",
        type: "success",
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
    onAllscreenCalendar(){
      this.allscreenCalendar = !this.allscreenCalendar;
    },  
    async sendReminder(data: Object) {
      const output = await sendReminder.execute(data["id"]);
      this.presentResponse(output);
    },
    async deleteReminder(data: Object) {
      const output = await deleteReminder.execute(data["id"]);
      this.presentResponse(output);
    },
    async fetchReminders() {
      this.loadingList = true;
      this.$router.push({ query: this.pagination });
      this.reminders = await listReminder.execute(this.pagination);
      this.total = Math.ceil(
        reminderGateway.totalRequisited / this.pagination.limit
      );
      
      if(this.reminders.length < 1 && this.total != 0) this.pagination.page = 1;
      
      setTimeout(() => (this.loadingList = false), 250);

    },
    presentResponse(output: Output) {
      if (output.success) this.fetchReminders();

      this.toast.message = output.message;
      this.toast.type = output.success ? "success" : "error";
      this.toast.show = true;

      this.timeOutToast();
    },
    timeOutToast() {
      setTimeout(() => {
        this.toast.show = !this.toast.show;
      }, 1000);
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