
<template>
  <v-app class="bg-cover">
    <v-main class="main-bg">
      <div class="mx-3 my-3 mx-md-6">
        <RouterView />
      </div>
    </v-main>
  </v-app>
</template>

<script setup lang="ts">
import { defineComponent } from "vue";
import ReminderCard from "./components/cards/ReminderCard.vue";
</script>

 