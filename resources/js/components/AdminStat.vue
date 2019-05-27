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
  <div ref="loader" v-else class="loader"></div>
</template>

<script>
import { TimelineMax } from "gsap";
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
    var { loader } = this.$refs;

    var timeline = new TimelineMax({
      repeat: -1,
      yoyo: true
    });
    timeline.to(loader, 1, { autoAlpha: 0.3 });
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