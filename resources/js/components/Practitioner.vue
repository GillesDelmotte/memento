<template>
  <div class="profile" v-if="componentReady">
    <button @click="back" class="back">
      <div class="cross__first"></div>
      <div class="cross__second"></div>
    </button>
    <div class="profile__img" v-if="practitioner.image">
      <img :src="'./images/profile/' + practitioner.image.image_name" alt>
    </div>
    <div class="profile__img" v-else></div>
    <h2>{{practitioner.name}}</h2>
    <div class="card">
      <span>Profession</span>
      <p>{{practitioner.job.name}}</p>
    </div>
    <div class="card">
      <span>Gsm</span>
      <p>{{practitioner.gsm}}</p>
    </div>
    <div class="card">
      <span>Adresse</span>
      <p>{{practitioner.address}}</p>
    </div>
    <div class="card">
      <span>Description</span>
      <p>{{practitioner.description}}</p>
    </div>
    <button class="button" @click="getSchedule(practitioner.id)">prendre rendez-vous</button>
  </div>
  <div v-else class="loader"></div>
</template>

<script>
import store from "../store.js";
import { mapMutations } from "vuex";
import router from "../router.js";
import { mapState } from "vuex";
export default {
  name: "Practitioner",
  data() {
    return {
      componentReady: false
    };
  },
  computed: {
    ...mapState(["allJob", "allPractitioner"]),
    practitioner() {
      const practitioner = this.allPractitioner.filter(
        practitioner => practitioner.id === this.$route.params.id
      );
      return practitioner[0];
    }
  },
  methods: {
    back() {
      router.go(-1);
    },
    getSchedule(id) {
      router.push({ name: "practitionerSchedule", params: { id: id } });
    }
  },
  mounted() {
    this.$store.dispatch("setAllJob").then(() => {
      this.$store.dispatch("setAllPractitioner").then(() => {
        this.componentReady = true;
      });
    });
  }
};
</script>

<style scoped>
</style>