
<template>
  <v-app class="bg-grey-lighten-3">
    <!-- <TopBar />   -->
    <v-main class="main-bg">
      <div class="mx-3 my-3 mx-md-6">
        <RouterView />
      </div>
    </v-main>
 
  </v-app>
</template>

<script setup lang="ts">
import { RouterLink, RouterView } from "vue-router";

import { defineComponent } from "vue";
import BottomBar from "./components/navigation/BottomBar.vue";
import ReminderCard from "./components/cards/ReminderCard.vue";
import TopBar from "./components/navigation/TopBar.vue";
</script>

<style>
</style>