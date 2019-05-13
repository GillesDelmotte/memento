<template>
  <div class="profile">
    <button @click="back" class="back">
      <div class="cross__first"></div>
      <div class="cross__second"></div>
    </button>
    <div class="profile__img"></div>
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
</template>

<script>
import store from "../store.js";
import { mapMutations } from "vuex";
import router from "../router.js";
import { mapState } from "vuex";
export default {
  name: "Practitioner",
  data() {
    return {};
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
      router.push({ name: "practitionersFilter" });
    },
    getSchedule(id) {
      router.push({ name: "practitionerSchedule", params: { id: id } });
    }
  }
};
</script>

<style scoped>
</style>