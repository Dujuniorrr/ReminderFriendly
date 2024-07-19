<template>
  <div>
    <v-row v-if="reminders.length > 0" class="rounded-lg">
      <v-col
        cols="12"
        sm="6"
        md="4"
        v-for="reminder in reminders"
        :key="reminder.id"
      >
        <ReminderCard :reminder="reminder" />
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
      v-if="reminders.length > 0"
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
import { defineComponent, watch } from "vue";
import ReminderCard from "../cards/ReminderCard.vue";

export default defineComponent({
  components: {
    ReminderCard,
  },
  data() {
    return {
      page: 1,
    };
  },
  created() {
    this.page = this.pagination.page;
  },
  props: {
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
    openModal() {
      document.getElementById("activator-target").click();
    },
  },
});
</script>
