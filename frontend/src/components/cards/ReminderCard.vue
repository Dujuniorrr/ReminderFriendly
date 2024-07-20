<template>
  <v-card
    class="mx-auto rounded-lg border-md border-opacity-75 h-100"
    :class="`border-${reminder.character.color}`"
    max-width="400 h-100"
  >
    <v-card-actions :class="`px-0 bg-${reminder.character.color}-lighten-1`">
      <v-list-item class="w-100">
        <template v-slot:prepend>
          <v-avatar
            color="grey-darken-3"
            :class="`border-${reminder.character.color}`"
            class="border-md border border-opacity-100"
            :image="reminder.character.imagePath"
          ></v-avatar>
        </template>

        <v-list-item-title class="character-name">{{
          reminder.character.name
        }}</v-list-item-title>

        <v-list-item-subtitle class="reminder-date">
          {{ reminder.date }}
        </v-list-item-subtitle>

        <template v-slot:append>
          <div class="justify-self-end">
            <v-menu>
              <template v-slot:activator="{ props }">
                <v-btn
                  class="menu-btn"
                  icon="mdi-dots-vertical"
                  v-bind="props"
                ></v-btn>
              </template>

              <v-list class="rounded-lg">
                <v-list-item v-if="!reminder.send">
                  <v-btn
                    @click.stop="sendReminder(reminder.id)"
                    append-icon="mdi-whatsapp"
                    size="small"
                    rounded="xl"
                    color="green-darken-1 "
                    class="mb-2"
                    id="send-whatsapp"
                  >
                    Enviar
                  </v-btn>
                </v-list-item>
                <v-list-item>
                  <v-btn
                    @click.stop="deleteReminder(reminder.id)"
                    rounded="xl"
                    size="small"
                    append-icon="mdi-trash-can"
                    color="red-darken-1"
                    class="mb-2"
                  >
                    Deletar
                  </v-btn>
                </v-list-item>
              </v-list>
            </v-menu>
          </div>
        </template>
      </v-list-item>
    </v-card-actions>

    <v-card-text class="py-2 reminder-message">
      {{ reminder.originalMessage }}
    </v-card-text>
  </v-card>
</template>
 

<script  lang="ts">
import { defineComponent } from "vue";
import { Output } from "../../core/application/command/ListReminders";

export default defineComponent({
  data: () => ({ show: false }),
  props: {
    reminder: {
      type: Object as () => Output,
      default: [],
    },
  },
  methods: {
    sendReminder(id: string) {
      this.$emit("sendReminder", { id: id });
    },
    deleteReminder(id: string) {
      this.$emit("deleteReminder", { id: id });
    },
  },
});
</script>

<style scoped>
.headerClass {
  white-space: nowrap;
  word-break: normal;
  overflow: hidden;
  text-overflow: ellipsis;
}
</style>