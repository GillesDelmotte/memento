<template>
  <section id="admin">Admin component</section>
</template>

<script>
import store from "../store.js";
import { mapMutations } from "vuex";
export default {
  name: "Admin",
  beforeMount() {
    store.commit("setComponentDisplayed", "Admin");
  }
};
</script>

<style scoped>
</style>