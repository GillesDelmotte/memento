<template>
  <div class="profile" v-if="componentReady">
    <button @click="back" class="back">
      <div class="cross__first"></div>
      <div class="cross__second"></div>
    </button>
    <div class="profile__img" v-if="practitioner.image" ref="image">
      <img :src="'./images/profile/' + practitioner.image.image_name" alt>
    </div>
    <div class="profile__img" v-else ref="image"></div>
    <h2 ref="name">{{practitioner.name}}</h2>
    <div class="card" ref="job">
      <span>Profession</span>
      <p>{{practitioner.job.name}}</p>
    </div>
    <div class="card" ref="gsm">
      <span>Gsm</span>
      <p>{{practitioner.gsm}}</p>
    </div>
    <div class="card" ref="address">
      <span>Adresse</span>
      <p>{{practitioner.address}}</p>
    </div>
    <div class="card" ref="desc">
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
      this.$store
        .dispatch("setAllPractitioner")
        .then(() => {
          this.componentReady = true;
        })
        .then(() => {
          const { image, name, job, gsm, address, desc } = this.$refs;
          const tl = new TimelineMax();

          tl.from(image, 0.3, { autoAlpha: 0 })
            .from(name, 0.3, { autoAlpha: 0 }, 0)
            .from(
              job,
              0.3,
              { autoAlpha: 0, top: 50, ease: Power2.easeInOut },
              "-=0.1"
            )
            .from(
              gsm,
              0.3,
              { autoAlpha: 0, top: 50, ease: Power2.easeInOut },
              "-=0.2"
            )
            .from(
              address,
              0.3,
              { autoAlpha: 0, top: 50, ease: Power2.easeInOut },
              "-=0.2"
            )
            .from(
              desc,
              0.3,
              { autoAlpha: 0, top: 50, ease: Power2.easeInOut },
              "-=0.2"
            );
        });
    });
  }
};
</script>

<style scoped>
</style>