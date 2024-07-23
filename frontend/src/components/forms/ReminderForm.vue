<template>
  <v-form
    ref="form"
    @submit.prevent="submit"
    class="bg-white elevation-23 pa-3 pt-5 rounded-lg text-center"
  >
    <div
      v-if="content_message"
      class="speech-dialog-comic text-blue-darken-4 elevation-6 fade-in"
    >
      {{ content_message }}
    </div>
    <v-avatar
      class="border-lg border-opacity-100"
      :class="`border-${character.color}`"
      :image="character.imagePath"
      size="200"
    ></v-avatar>
    <h2 class="mt-2" :class="`text-${character.color}`">
      {{ character.name }}
    </h2>
    <p>Hora de anotar um lembrete! {{ getRandomReminder() }}</p>
    <div class="text-start">
      <v-text-field
        v-model="content"
        :rules="rules"
        counter="200"
        bg-color="light-blue-lighten-5"
        color="primary "
        class="my-2 text-primary"
        variant="outlined"
      ></v-text-field>
    </div>
    <v-btn
      :loading="loading"
      type="submit"
      rounded
      color="primary"
      prepend-icon="mdi-check"
    >
      Adicionar lembrete!
    </v-btn>
  </v-form>
</template>


<script lang="ts">
import { defineComponent } from "vue";

export default defineComponent({
  data() {
    return {
      reminderSelected: undefined,
      content: "",
      rules: [
        (reminderContent: string) => {
          if (!reminderContent || reminderContent.length == 0)
            return "Epa! Esqueceu do lembrete?";

          if (reminderContent.length > 0 && reminderContent.length <= 200)
            return true;
          return "Nada disso! O lembrete deve ter no máximo 200 caracteres.";
        },
      ],
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
  props: {
    content_message: {
      type: String,
      required: true,
    },
    loading: {
      type: Boolean,
      required: true,
    },
    character: {
      type: Object,
      required: true,
    },
  },
  methods: {
    async submit() {
      const { valid } = await this.$refs.form.validate();
      this.$emit("submitedForm", { content: this.content, valid });
    },
    getRandomReminder(): string {
      if (!this.reminderSelected) {
        this.reminderSelected = Math.floor(
          Math.random() * this.reminders.length
        );
      }
      return this.reminders[this.reminderSelected];
    },
  },
});
</script>
