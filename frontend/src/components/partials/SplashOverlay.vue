    <template>
  <div class="text-center">
    <v-overlay

      :model-value="overlay"
      class="align-center text-center justify-center bg-primary "
    >
      <v-img
        class="align-center text-white mb-4"
        width="320"
        src="/logo.png"
        cover
      />
      <v-progress-linear
        color="white"
        height="6"
        indeterminate
        rounded
      ></v-progress-linear>
    </v-overlay>
  </div>
</template>

    <script>
export default {
  data: () => ({
    overlay: true,
  }),

  mounted() {
    setTimeout(() => {
      this.overlay = false;
    }, 1500);
  },
};
</script>

    <style scoped>
.text-center {
  text-align: center;
}
.align-center {
  display: flex;
  align-items: center;
  justify-content: center;
}
</style>
