<template>
  <section class="container">
    <div v-if="componentReady"></div>
    <div v-else>plz wait...</div>
  </section>
</template>

<script>
import store from "../store.js";
import { mapState } from "vuex";
import { mapMutations } from "vuex";
export default {
  name: "Meet",
  data() {
    return {
      componentReady: false
    };
  },
  computed: {
    ...mapState(["currentUser"])
  },
  methods: {},
  beforeMount() {
    store.commit("setComponentDisplayed", "Rendez-vous");
  },
  mounted() {
    this.$store.dispatch("setCurrentUser").then(() => {
      this.componentReady = true;
    });
  }
};
</script>

<style scoped>
</style>