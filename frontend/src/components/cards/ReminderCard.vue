<template>
  <v-card
    class="mx-auto rounded-lg border-md border-primary border-opacity-75 bg-"
    max-width="400 h-100"
    @click="show = !show"
    role="button"
  >
    <v-card-actions class="px-0 bg-blue-lighten-3">
      <v-list-item class="w-100">
        <template v-slot:prepend>
          <v-avatar
            color="grey-darken-3"
            class=" border-md border-primary border-opacity-100"
            image="http://localhost:9000/storage/spider-man.png"
          ></v-avatar>
        </template>

        <v-list-item-title>Homem Aranha</v-list-item-title>

        <v-list-item-subtitle>21 de mar. ás 08:30</v-list-item-subtitle>

        <template v-slot:append>
          <div class="justify-self-end">
            <v-menu >
              <template v-slot:activator="{ props }">
                <v-btn icon="mdi-dots-vertical" v-bind="props"></v-btn>
              </template>

              <v-list class="rounded-lg">
                <v-list-item>
                  <v-btn
                    @click.stop="() => {}"
                    append-icon="mdi-whatsapp"
                    size="small"
                    rounded="xl"
                    color="green-darken-1"
                    class="mb-2"
                  >
                    Enviar
                  </v-btn>
                </v-list-item>
                <v-list-item>
                  <v-btn
                     @click.stop="() => {}"
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

     <v-card-text class="py-2">
      Passear com o cachorro daqui 3 dias as 13:30.
    </v-card-text>

    <v-expand-transition>
      <div v-show="show">
        <v-divider></v-divider>

        <v-card-text>
          Ei amigão, Spider-Main aqui! 🕸️ Lembre-se: daqui a 3 dias às 13:30 é
          hora de levar o super-cão pra dar aquele passeio. 🚶‍♂️🐕 Não esqueça o
          traje de herói, nunca se sabe quando uma aventura pode começar no
          Central Park! E olha, evite os pombos, eles têm uma mira terrível! 😂
        </v-card-text>
      </div>
    </v-expand-transition>
  </v-card>
</template>
 

<script  lang="ts">
import { defineComponent } from "vue";

export default defineComponent({
  data: () => ({ show: false }),
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