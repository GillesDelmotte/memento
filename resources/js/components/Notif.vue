<template>
  <section id="notifications" v-if="componentReady">
    <p class="explanation" ref="explanation">
      <span>Vous pouvez ici gerer l'envoi de vos notifications pour rappeler à vos clients qu'ils ont un rendez-vous.</span>
      <span>Pour ce faire, si vous voulez ajouter la date utilisez ceci [date] et si vous voulez ajouter l'heure utilisez ceci [heure]</span>
    </p>
    <div class="card" ref="card">
      <textarea
        name="desc"
        id="desc"
        cols="30"
        rows="4"
        v-model="notif.message"
        @blur="updateNotif($event)"
      ></textarea>
    </div>
    <div class="when" ref="when">
      <p>Quand devons-nous envoyer le message ?</p>
      <div>
        <i class="arrow"></i>
        <select name="when" id="when" v-on:change="updateDelay($event)">
          <option
            v-for="option in options"
            :key="option"
            :value="option"
            :selected="selected(option)"
          >{{option}} jours avant</option>
        </select>
      </div>
    </div>
  </section>
  <div ref="loader" v-else class="loader"></div>
</template>

<script>
import { TimelineMax } from "gsap";
import store from "../store.js";
import { mapMutations } from "vuex";
import { mapState } from "vuex";
export default {
  name: "Notif",
  data() {
    return {
      notif: null,
      componentReady: false,
      options: [1, 2, 3]
    };
  },
  computed: {
    ...mapState(["currentUser"])
  },
  methods: {
    selected(number) {
      if (this.notif.delay == number) {
        return "selected";
      }
    },
    updateNotif(e) {
      window.axios
        .post("/updateNotif", { message: e.target.value, type: "message" })
        .then(response => {
          this.notif = response.data;
        })
        .catch(error => console.error(error));
    },
    updateDelay(e) {
      window.axios
        .post("/updateNotif", { delay: e.target.value, type: "delay" })
        .then(response => {
          this.notif = response.data;
        })
        .catch(error => console.error(error));
    }
  },
  beforeMount() {
    store.commit("setComponentDisplayed", "Notifications");
  },
  mounted() {
    var { loader } = this.$refs;
    var timeline = new TimelineMax({
      repeat: -1,
      yoyo: true
    });
    timeline.to(loader, 1, { autoAlpha: 0.3 });
    window.axios
      .post("/getNotif")
      .then(response => {
        this.notif = response.data;
        this.componentReady = true;
      })
      .then(() => {
        const { explanation, card, when } = this.$refs;
        var tl = new TimelineMax();

        tl.from(explanation, 0.3, {
          autoAlpha: 0,
          top: 50,
          ease: Power2.easeInOut
        })
          .from(
            card,
            0.3,
            {
              autoAlpha: 0,
              top: 50,
              ease: Power2.easeInOut
            },
            "-=0.2"
          )
          .from(
            when,
            0.3,
            {
              autoAlpha: 0,
              top: 50,
              ease: Power2.easeInOut
            },
            "-=0.2"
          );
      })
      .catch(error => console.error(error));
  }
};
</script>

<style scoped>
</style>