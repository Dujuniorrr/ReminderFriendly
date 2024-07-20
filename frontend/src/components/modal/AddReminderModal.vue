<template>
  <v-dialog
    activator="#activator-target"
    transition="dialog-bottom-transition"
    fullscreen
    v-model="dialog"
  >
    <v-card style="background: transparent !important">
      <div class="h-100 w-100 main-bg">
        <v-toolbar
          style="background: transparent !important"
          class="text-white"
        >
          <v-btn icon="mdi-close" @click="dialog = false"></v-btn>

          <v-spacer></v-spacer>
        </v-toolbar>

        <v-container elvation="23">
          <v-row>
            <v-col class="h-100 py-0 mb-5" cols="12" md="4">
              <ReminderForm />
            </v-col>
            <v-col cols="12" md="8" class="mt-3 h-100 py-0">
              <div
                class="bg-white elevation-23 px-5 rounded-lg text-center w-100 h-100"
              >
                <v-row>
                  <v-col
                    class="h-100"
                    v-for="i in 8"
                    :key="i"
                    cols="6"
                    sm="6"
                    md="4"
                    lg="3"
                  >
                    <CharacterCard />
                  </v-col>
                </v-row>
              </div>
            </v-col>
          </v-row>
        </v-container>
      </div>
    </v-card>
  </v-dialog>
</template>
<script lang="ts">
import { defineComponent } from "vue";
import CharacterCard from "../cards/CharacterCard.vue";
import ReminderForm from "../forms/ReminderForm.vue";

export default defineComponent({
  components: { CharacterCard, ReminderForm },
  data() {
    return {
      dialog: false,
    
      reminders: [
        "Não se esqueça de não esquecer!",
        "Seu eu futuro irá te agradecer.",
        "Lembre-se: até o procrastinador tem um limite.",
        "Pois um lembrete por dia mantém a confusão à distância.",
        "Lembre-se: o amanhã começa hoje!",
        "Cada pequeno passo conta, lembre-se disso!",
        "A procrastinação é inimiga do progresso, não se esqueça!",
        "Pois um lembrete amigável pode salvar o seu dia.",
        "Não deixe para depois o que você pode lembrar agora.",
        "Sua lista de tarefas não se completará sozinha, lembre-se!",
      ],
    };
  },
  methods: {
    getRandomReminder(): string {
      const randomIndex = Math.floor(Math.random() * this.reminders.length);
      return this.reminders[randomIndex];
    },
  },
});
</script>

 