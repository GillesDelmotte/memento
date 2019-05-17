<template>
  <section id="adminStat" v-if="componentReady">
    <div class="card">
      <p>Nombre d'utilisateur</p>
      <span>{{stats.user}}</span>
    </div>
    <div class="card">
      <p>Nombre d'agenda</p>
      <span>{{stats.schedule}}</span>
    </div>
    <div class="card">
      <p>Nombre de rendez-vous</p>
      <span>{{stats.appointment}}</span>
    </div>
    <div class="card">
      <p>Nombre de profession</p>
      <span>{{stats.job}}</span>
    </div>
  </section>
  <section class="loader" v-else>plz wait...</section>
</template>

<script>
import store from "../store.js";
import { mapMutations } from "vuex";
export default {
  name: "AdminStat",
  data() {
    return {
      componentReady: null,
      stats: null
    };
  },
  mounted() {
    window.axios
      .post("/getStats")
      .then(response => {
        this.stats = response.data;
        this.componentReady = true;
      })
      .catch(error => console.error(error));
  }
};
</script>

<style scoped>
</style>