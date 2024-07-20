<template>
  <v-form
    ref="form"
    @submit.prevent="submit"
    class="bg-white elevation-23 pa-3 pt-5 rounded-lg text-center"
  >
    <div class="speech-dialog-comic text-blue-darken-4 elevation-6 fade-in">
      Ei, amigão da vizinhança aqui! Parece que você se esqueceu de me dizer
      qual é a tarefa. Sem uma tarefa clara, até mesmo o Spider-Main fica
      perdido! 🕷️😅
    </div>
    <v-avatar
      class="border-lg border-primary border-opacity-100"
      image="question-mark.png"
      size="200"
    ></v-avatar>
    <h2 class="my-2 text-primary">Escolha um personagem!</h2>
    <p>Hora de anotar um lembrete! {{ getRandomReminder() }}</p>
    <div class="text-start">
      <v-text-field
        v-model="content"
        :rules="rules"
        prepend-inner-icon="mdi-calendar"
        counter="200"
        bg-color="light-blue-lighten-5"
        color="primary "
        class="mt-2 mb-3 text-primary"
        variant="outlined"
      ></v-text-field>
    </div>
    <v-btn type="submit" rounded color="primary" prepend-icon="mdi-check">
      Adicionar lembrete!
    </v-btn>
  </v-form>
</template>


<script lang="ts">
import { defineComponent } from "vue";

export default defineComponent({
  data() {
    return {
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
  methods: {
    async submit() {
      const { valid } = await this.$refs.form.validate();

      if (valid) alert("Form is valid");
      this.$emit("submitedForm", { content: this.content });
    },
    getRandomReminder(): string {
      const randomIndex = Math.floor(Math.random() * this.reminders.length);
      return this.reminders[randomIndex];
    },
  },
});
</script>
