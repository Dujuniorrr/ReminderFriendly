<template>
  <v-dialog
    content-class="custom-dialog"
    transition="dialog-top-transition"
    top
    center
    v-model="show"
    width="auto"
  >
    <v-list
      :class="`bg-${appearances[type].color}`"
      class="py-2 absolute"
      elevation="0"
      rounded="lg"
    >
      <v-list-item :prepend-icon="appearances[type].icon" :title="message">
        <template v-slot:prepend>
          <v-expand-x-transition>
            <div class="pe-4">
              <v-icon size="x-large"></v-icon>
            </div>
          </v-expand-x-transition>
        </template>
      </v-list-item>
    </v-list>
  </v-dialog>
</template>

<script lang="ts">
import { defineComponent } from "vue";

export default defineComponent({
  data() {
    return {
      appearances: {
        success: {
          color: "green-darken-1",
          icon: "mdi-check",
        },
        error: {
          color: "red-darken-1",
          icon: "mdi-close",
        },
      },
    };
  },

  props: {
    show: {
      type: Boolean,
      default: false,
    },
    message: {
      type: String,
      required: true,
    },
    type: {
      type: String,
      required: true,
    },
  },
});
</script>
 
 <style>
.custom-dialog {
  position: absolute;
  right: 0;
  margin: 0;
  top: 0;
  min-height: 100%;
}
.absolute {
  position: absolute;
}
</style>