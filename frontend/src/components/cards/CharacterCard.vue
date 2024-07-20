<template>
  <v-hover open-delay="200">
    <template v-slot:default="{ isHovering, props }">
      <v-card
        :class="{ 'on-hover': isHovering }"
        :elevation="isHovering ? 10 : 2"
        v-bind="props"
        role="button"
        class="mx-auto border-lg rounded-lg border-green border-opacity-100"
      >
        <v-img
          class="align-end text-white"
          height="150"
          src="http:\/\/localhost:9000\/storage\/yoda.jpeg"
          cover
        >
        </v-img>
        <h3
          class="py-2 border-t border-t-lg bg-green-darken-2"
        >
          The Flash
        </h3>
      </v-card>
    </template>
  </v-hover>
</template>

<script lang="ts">
import { defineComponent } from "vue";

export default defineComponent({});
</script>
