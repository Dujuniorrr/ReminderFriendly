<template>
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

  <v-dialog
    activator="#activator-target"
    transition="dialog-bottom-transition"
    fullscreen
    v-model="dialog"  
  >
    <v-card>
      <v-toolbar class="bg-blue-lighten-1">
        <v-btn icon="mdi-close" @click="dialog = false"></v-btn>

        <v-spacer></v-spacer>

        <v-toolbar-items>
          <v-btn text="Save" variant="text" @click="dialog = false"></v-btn>
        </v-toolbar-items>
      </v-toolbar>

      <v-container>
        <v-row>
          <v-col cols="4">
            <v-avatar
              class="border-lg border-info border-opacity-100"
              image="http://localhost:9000/storage/flash.jpeg"
              size="70%"
            ></v-avatar>
            <h1>Homem Aranha</h1>
          </v-col>
        </v-row>
      </v-container>
    </v-card>
  </v-dialog>
</template>
<script>
export default {
  data() {
    return {
      dialog: false,
      notifications: false,
      sound: true,
      widgets: false,
    };
  },
};
</script>