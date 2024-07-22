<template>
  <v-dialog
    activator="#activator-target"
    transition="dialog-bottom-transition"
    fullscreen
    v-model="dialog"
  >
    <v-card class="card-bg">
        <v-toolbar
          style="background: transparent !important"
          class="text-white"
        >
          <v-btn icon="mdi-close" @click="dialog = false"></v-btn>

          <v-spacer></v-spacer>
        </v-toolbar>

        <v-container elvation="23">
          <v-row>
            <v-col id="reminder-form" class="h-100 py-0 mb-5" cols="12" md="4">
              <ReminderForm
                :content_message="content_message"
                :loading="loading"
                @submitedForm="submitReminder"
                :character="selectedCharacter"
              />
            </v-col>
            <v-col cols="12" md="8" class="mt-3 h-100 py-0">
              <div
                class="bg-white elevation-23 px-5 rounded-lg text-center w-100 h-100"
              >
                <v-row>
                  <v-col
                    class="h-100"
                    v-for="character in characters"
                    :key="character.id"
                    cols="6"
                    sm="6"
                    md="4"
                    lg="3"
                  >
                    <CharacterCard
                      @selectedCharacter="onSelectedCharacter"
                      :character="character"
                    />
                  </v-col>
                </v-row>
              </div>
            </v-col>
          </v-row>
        </v-container>
    </v-card>
    <SimpleToast
      :message="toast.message"
      :show="toast.show"
      :type="toast.type"
    />
  </v-dialog>
</template>
<script lang="ts">
import { defineComponent } from "vue";

import CharacterCard from "../cards/CharacterCard.vue";
import ReminderForm from "../forms/ReminderForm.vue";

import ListCharacters from "../../core/application/command/ListCharacters";
import CreateReminder, {
  Output,
} from "../../core/application/command/CreateReminder";

import CharacterGateway from "../../core/application/gateway/CharacterGateway";
import HttpClient from "../../core/application/http/HttpClient";
import APICharacterGateway from "../../core/infra/gateway/APICharacterGateway";
import AxiosHttpClient from "../../core/infra/http/AxiosHttpClient";
import ReminderGateway from "../../core/application/gateway/ReminderGateway";
import APIReminderGateway from "../../core/infra/gateway/APIReminderGateway";
import SimpleToast from "../toasts/SimpleToast.vue";

const httpClient: HttpClient = new AxiosHttpClient();
const characterGteway: CharacterGateway = new APICharacterGateway(httpClient);
const reminderGateway: ReminderGateway = new APIReminderGateway(httpClient);
const listCharacters = new ListCharacters(characterGteway);
const createReminder = new CreateReminder(reminderGateway);

const initialCharacterState = {
  color: "primary",
  name: "Escolha um personagem!",
  imagePath: "question-mark.png",
};

const notSelectedCharacterState = {
  color: "error",
  name: "Oops! E o personagem??",
  imagePath: "question-mark.png",
};

const TIMEOUT = 15 * 1000;

export default defineComponent({
  components: { CharacterCard, ReminderForm, SimpleToast },
  data() {
    return {
      toast: {
        show: false,
        message: "test",
        type: "success",
      },
      content_message: undefined,
      selectedCharacter: initialCharacterState,
      characters: [],
      dialog: false,
      loading: false,
    };
  },
  created() {
    this.fetchCharacters();
  },
  watch: {
    dialog: {
      handler() {
        this.selectedCharacter = initialCharacterState;
      },
    },
  },
  methods: {
    onSelectedCharacter(character: Object) {
      document.querySelector("#reminder-form").scrollIntoView({
        behavior: "smooth",
      });
      this.selectedCharacter = character;
    },
    async fetchCharacters() {
      this.characters = await listCharacters.execute({});
    },

    async submitReminder(data) {
      if (await this.validateCharacter()) {
        if (data["valid"]) {
          const output = await this.handleValidData(data);
          this.handleResponse(output);
        }
      }
    },

    async validateCharacter() {
      if (!this.selectedCharacter?.id) {
        this.selectedCharacter = notSelectedCharacterState;
        return false;
      }
      return true;
    },

    async handleValidData(data: Object) {
      this.loading = true;

      const output = await createReminder.execute({
        content: data["content"],
        characterId: this.selectedCharacter.id,
      });

      return output;
    },

    handleResponse(output: Output) {
      if (output.content_error) {
        this.content_message = output.message;

        setTimeout(() => {
          this.content_message = undefined;
        }, TIMEOUT);
          this.loading = false;

      } else {
        this.toast.message = output.message;
        this.toast.type = output.success ? "success" : "error";
        this.toast.show = !output.success;

        setTimeout(() => {
          this.toast.show = false;
          if (output.success) {
            this.dialog = false;
            this.$emit("reminderAdded");
          }
          this.loading = false;
        }, 1000);
      }
    },
  },
});
</script>

 