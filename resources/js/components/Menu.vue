<template>
  <section class="container menu">
    <a @click="redirect($event, 'scheduleList')">Mes agendas</a>
    <a @click="redirect($event, 'profile')">Mon profil</a>
    <a @click="logout">Déconnexion</a>
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
  }
};
</script>

<style scoped>
</style>