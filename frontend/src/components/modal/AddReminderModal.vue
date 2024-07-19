<template>
  <div class="text-center pa-4">
    <v-dialog v-model="dialog" transition="dialog-bottom-transition" fullscreen>
      <template v-slot:activator="{ props: activatorProps }">
        <v-btn
          position="fixed"
          location="bottom center"
          icon="mdi-plus"
          size="x-large"
          color="primary"
          elevation="8"
          class="mb-3"
          v-bind="activatorProps"
        />
      </template>

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
              <v-avatar class="border-lg border-info border-opacity-100" image="http://localhost:9000/storage/spider-man.png" size="70%"></v-avatar>
              <h1>Homem Aranha</h1>
            </v-col>
          </v-row>
        </v-container>
      </v-card>
    </v-dialog>
  </div>
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