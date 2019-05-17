<template>
  <div v-if="componentReady">
    <div class="filter">
      <input
        type="text"
        name="filter"
        id="filter"
        v-model="filter"
        autocomplete="off"
        placeholder="Nom, profession"
      >
    </div>
    <div>
      <ul class="practitioners" v-if="filterPractitionerComputed.length !== 0">
        <h3 v-if="filter !== '' && filterPractitionerComputed.length !== 0" @click="close($event)">
          <span>Nom</span>
          <i class="closer"></i>
        </h3>
        <li
          v-for="practitioner in filterPractitionerComputed"
          :key="practitioner.id"
          class="practitioner"
          v-hammer:swipe.horizontal="(event)=> onSwipe(event)"
        >
          <a href class="practitioner__link" @click="findPratitioner($event, practitioner.id)"></a>
          <div class="photo"></div>
          <div>
            <span class="name">{{practitioner.name}}</span>
            <span class="job__name">{{practitioner.job.name}}</span>
          </div>
          <div class="pills">
            <div class="phone">
              <img src="../../img/phone-call.svg" alt>
            </div>
            <div class="message">
              <img src="../../img/speech-bubble.svg" alt>
            </div>
            <div class="calendar" @click="redirect(practitioner.id)">
              <img src="../../img/calendar.svg" alt>
            </div>
          </div>
          <i class="arrow"></i>
        </li>
      </ul>
      <ul class="jobs" v-if="filter !== ''">
        <h3 v-if="filterJobPractitionerComputed.length !== 0" @click="close($event)">
          <span>Professions</span>
          <i class="closer"></i>
        </h3>
        <li
          v-for="practitioner in filterJobPractitionerComputed"
          :key="practitioner.id"
          class="job"
          v-hammer:swipe.horizontal="(event)=> onSwipe(event)"
        >
          <a href class="practitioner__link" @click="findPratitioner($event, practitioner.id)"></a>
          <div class="photo"></div>
          <div>
            <span class="job__name">{{practitioner.job.name}}</span>
            <span class="name">{{practitioner.name}}</span>
          </div>
          <div class="pills">
            <div class="phone">
              <img src="../../img/phone-call.svg" alt>
            </div>
            <div class="message">
              <img src="../../img/speech-bubble.svg" alt>
            </div>
            <div class="calendar" @click="redirect(practitioner.id)">
              <img src="../../img/calendar.svg" alt>
            </div>
          </div>
          <i class="arrow"></i>
        </li>
      </ul>
    </div>
  </div>
  <div v-else class="loader">plz wait...</div>
</template>

<script>
import { VueHammer } from "vue2-hammer";
import store from "../store.js";
import { mapMutations } from "vuex";
import router from "../router.js";
import { mapState } from "vuex";
export default {
  name: "PractitionersFilter",
  data() {
    return {
      componentReady: false,
      filter: "",
      filterJobId: null,
      filterJobName: null
    };
  },
  methods: {
    toggleList(e, add, remove) {
      e.target.classList.add("check");
      document
        .querySelector("." + remove + "__button")
        .classList.remove("check");

      document.querySelector(".displayed").classList.remove("displayed");
      document.querySelector("." + add).classList.add("displayed");
    },
    findPratitioner(e, id) {
      e.preventDefault();
      e.stopPropagation();
      router.push({ name: "practitioner", params: { id: id } });
    },
    findJob(e, id, name) {
      e.preventDefault();
      e.stopPropagation();
      this.filterJobId = id;
      this.filterJobName = name;
      this.filter = "";
      document.querySelector(".displayed").classList.remove("displayed");
      document.querySelector(".job__filtered").classList.add("displayed");
    },
    close(e) {
      if (e.currentTarget.parentElement.classList.contains("close")) {
        e.currentTarget.parentElement.classList.remove("close");
      } else {
        e.currentTarget.parentElement.classList.add("close");
      }
    },
    onSwipe(e) {
      if (e.direction === 2) {
        const item = document.querySelector(".swiped");
        if (item !== null) {
          item.classList.remove("swiped");
        }
        e.target.parentElement.classList.add("swiped");
      } else if (e.direction === 4) {
        e.target.parentElement.classList.remove("swiped");
      }
    },
    redirect(id) {
      router.push({ name: "practitionerSchedule", params: { id: id } });
    }
  },
  computed: {
    ...mapState(["allJob", "allPractitioner"]),
    filterJobComputed() {
      if (this.filter.length === 0) {
        return this.allJob;
      } else {
        return this.allJob.filter(job => {
          return job.name.toLowerCase().match(this.filter.toLowerCase());
        });
      }
    },
    filterPractitionerComputed() {
      if (this.filter.length === 0) {
        return this.allPractitioner;
      } else {
        return this.allPractitioner.filter(practitioner => {
          return practitioner.name
            .toLowerCase()
            .match(this.filter.toLowerCase());
        });
      }
    },
    practitioners() {
      const practitioners = this.allPractitioner.filter(
        practitioner => practitioner.job.id === this.filterJobId
      );
      return practitioners;
    },
    filterJobPractitionerComputed() {
      if (this.filter.length === 0) {
        return [];
      } else {
        return this.allPractitioner.filter(practitioner => {
          return practitioner.job.name
            .toLowerCase()
            .match(this.filter.toLowerCase());
        });
      }
    }
  },
  beforeMount() {
    store.commit("setComponentDisplayed", "Praticiens");
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