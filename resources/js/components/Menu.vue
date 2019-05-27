<template>
  <section class="container menu">
    <a @click="redirect($event, 'scheduleList')" ref="agenda">Mes agendas</a>
    <a v-if="this.currentUser.is_admin" @click="redirect($event, 'adminStat')" ref="admin">admin</a>
    <a @click="redirect($event, 'profile')" ref="profil">Mon profil</a>
    <a @click="logout" ref="logout">Déconnexion</a>
  </section>
</template>

<script>
import store from "../store.js";
import router from "../router.js";
import { mapMutations } from "vuex";
import { mapState } from "vuex";
export default {
  name: "Menu",
  beforeMount() {
    store.commit("setComponentDisplayed", "Menu");
  },
  computed: {
    ...mapState(["currentUser"])
  },
  methods: {
    logout(e) {
      e.preventDefault();
      e.stopPropagation();
      document.getElementById("logout-form").submit();
    },
    redirect(e, name) {
      e.preventDefault();
      e.stopPropagation();
      router.push({ name: name });
    }
  },
  mounted() {
    const { agenda, admin, profil, logout } = this.$refs;

    const tl = new TimelineMax();

    tl.from(agenda, 0.3, { autoAlpha: 0, top: 50, ease: Power2.easeInOut });
    if (admin) {
      tl.from(
        admin,
        0.3,
        { autoAlpha: 0, top: 50, ease: Power2.easeInOut },
        "-=0.2"
      );
    }

    tl.from(
      profil,
      0.3,
      { autoAlpha: 0, top: 50, ease: Power2.easeInOut },
      "-=0.2"
    ).from(
      logout,
      0.3,
      { autoAlpha: 0, top: 50, ease: Power2.easeInOut },
      "-=0.2"
    );
  }
};
</script>

<style scoped>
</style>