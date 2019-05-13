<template>
  <section id="notifications">
    <p
      class="explanation"
    >Vous pouvez ici gerer l'envoi de vos notifications pour rappeler à vos clients qu'ils ont un rendez-vous</p>
    <div class="card">
      <p>Bonjour, vous avez rendez-vous avec Didier Delmotte le ... à ...</p>
      <i>icon</i>
    </div>
    <div>
      <p>Quand devons-nous envoyer le message ?</p>
    </div>
  </section>
</template>

<script>
import store from "../store.js";
import { mapMutations } from "vuex";
export default {
  name: "Notif",
  beforeMount() {
    store.commit("setComponentDisplayed", "Notifications");
  }
};
</script>

<style scoped>
</style>