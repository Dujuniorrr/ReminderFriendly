<template>
  <v-menu>
    <template v-slot:activator="{ props }">
      <v-btn
        position="fixed"
        location="top right"
        icon="mdi-filter-variant"
        elevation="8"
        style="z-index: 2000"
        class="mb-3 text-primary border-md border-primary border-opacity-75 ma-3"
        v-bind="props"
      >
      </v-btn>
    </template>

    <v-list class="bg-opacity-0">
      <v-list-item>
        <v-chip
          @click="updateModel('notSend')"
          color="red-darken-1"
          append-icon="mdi-close"
          class="ms-1"
          :variant="$route.query.status == 'notSend' ? 'flat' : 'outlined'"
          :ripple="false"
          link
        >
          Não enviados
        </v-chip>
      </v-list-item>
      <v-list-item>
        <v-chip
          @click="updateModel('send')"
          color="blue-darken-1"
          :variant="$route.query.status == 'send' ? 'flat' : 'outlined'"
          append-icon="mdi-check"
          class="ms-1"
          :ripple="false"
          link
        >
          Enviados
        </v-chip>
      </v-list-item>

      <v-list-item>
        <v-select
          @click.stop=""
          :items="items"
          color="primary"
          density="compact"
          label="Por página"
          variant="underlined"
          class="my-3 ms-2 text-primary"
          v-model="limit"
        ></v-select>
      </v-list-item>
    </v-list>
  </v-menu>
</template>

<script lang="ts">
import { defineComponent } from "vue";

export default defineComponent({
  data() {
    return {
      status: "notSend",
      limit: 9,
      items: [6, 9, 12, 24, 36, 48, 60, 72, 84, 96, 100],
    };
  },
  created() {
    this.limit = this.modelValue.limit;
  },
  watch: {
    limit: {
      handler() {
        this.updateModel();
      },
    },
  },
  props: {
    modelValue: {
      type: Object,
      required: true,
    },
  },
  methods: {
    updateModel(newValue: string | null | undefined) {
      let status = this.modelValue.status;
      let page = this.modelValue.page;
      if (typeof newValue == "string") {
        status = newValue;
        page = 1;
      }

      this.$emit("update:modelValue", {
        status,
        limit: this.limit,
        page,
      });
    },
  },
});
</script>