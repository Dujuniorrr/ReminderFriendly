<template>
  <div class="h-100">
    <div >
        <v-text-field
          @input="searchReminder"
          density="comfortable"
          placeholder="Pesquise um lembrete!"
          prepend-inner-icon="mdi-magnify"
          style="max-width: 350px"
          variant="solo"
          base-color="primary"
          class="mx-auto mx-sm-0"
          auto-select-first
          item-props
          rounded
        ></v-text-field>
    </div>

    <div
      v-if="loading"
      class="text-center d-flex justify-center align-top pa-10"
    >
      <v-progress-circular
        color="white"
        indeterminate
        :size="40"
        :width="5"
      ></v-progress-circular>
    </div>
    <v-row v-else-if="reminders.length > 0" class="rounded-lg">
      <v-col
        cols="12"
        sm="6"
        md="4"
        v-for="reminder in reminders"
        :key="reminder.id"
      >
        <ReminderCard
          @deleteReminder="deleteReminder"
          @sendReminder="sendReminder"
          :reminder="reminder"
        />
      </v-col>
    </v-row>
    <div v-else>
      <v-empty-state
        class="text-white"
        color="white"
        title="Parece que nenhum lembrete foi encontrado!"
        text="The page you were looking for does not exist"
        icon="mdi-close"
      >
        <template v-slot:text>
          <div class="text-caption">
            Um lembrete por dia mantém a confusão à distância. Que tal criar um
            agora mesmo?
          </div>
          <v-btn
            @click="openModal"
            class="activator-target text-primary mt-3"
            prepend-icon="mdi-plus"
            >Adicionar</v-btn
          >
        </template>
      </v-empty-state>
    </div>
    <v-pagination
      v-if="reminders.length > 0 && !loading"
      bottom
      active-color="primary"
      color="white"
      base-color="primary"
      variant="flat"
      density="comfortable"
      v-model="page"
      :length="total"
      rounded="circle"
      class="my-4 rounded-lg text-primary"
    ></v-pagination>
  </div>
</template>

<script lang="ts">
import { defineComponent } from "vue";
import ReminderCard from "../cards/ReminderCard.vue";

export default defineComponent({
  components: {
    ReminderCard,
  },
  data() {
    return {
      page: 1,
      timeout: () => {},
    };
  },
  created() {
    this.page = Number.parseInt(this.pagination.page);
  },
  props: {
    loading: {
      type: Boolean,
      required: true,
    },
    reminders: {
      type: Array,
      required: true,
    },
    total: {
      type: Number,
      required: true,
    },
    pagination: {
      type: Object,
      required: true,
    },
  },
  watch: {
    page(newPage) {
      this.$emit("update:modelValue", newPage);
    },
  },
  methods: {
    searchReminder(event: any) {
      clearTimeout(this.timeout);

      this.timeout = setTimeout(() => {
        this.$emit("searchReminder", { val: event.target.value });
      }, 700);
    },
    sendReminder(data: Object) {
      this.$emit("sendReminder", data);
    },
    deleteReminder(data: Object) {
      this.$emit("deleteReminder", data);
    },
    openModal() {
      document.getElementById("activator-target").click();
    },
  },
});
</script>
