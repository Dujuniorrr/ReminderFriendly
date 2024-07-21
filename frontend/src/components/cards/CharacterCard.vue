<template>
  <v-hover open-delay="200">
    <template v-slot:default="{ isHovering, props }">
      <v-card
        @click="$emit('selectedCharacter', character)"
        :class="{
          'on-hover': isHovering,
          [`border-${character.color}`]: true,
        }"
        :elevation="isHovering ? 10 : 2"
        v-bind="props"
        role="button"
        class="mx-auto border-lg rounded-lg border-opacity-100"
      >
        <v-img
          class="align-end text-white"
          height="150"
          :src="character.imagePath"
          cover
        >
        </v-img>
        <h4
          class="py-2 border-t border-t-lg"
          :class="`bg-${character.color}-darken-2`"
        >
          {{ character.name }}
        </h4 >
      </v-card>
    </template>
  </v-hover>
</template>

<script lang="ts">
import { defineComponent } from "vue";
import { Output } from "../../core/application/command/ListCharacters";

export default defineComponent({
   emits: ['selectedCharacter'],

  props: {
    character: {
      type: Object as () => Output,
      required: true,
    },
  },
});
</script>
