<template>
  <section id="scheduleList">
    <div v-if="componentReady">
      <ul class="schedules">
        <li
          v-for="schedule in allSchedule"
          :key="schedule.id"
          class="schedule"
          v-hammer:swipe.horizontal="(event)=> onSwipe(event)"
        >
          <a href class="schedule__link"></a>
          <div>
            <span class="name">{{schedule.name}}</span>
            <ul class="days">
              <li class="day" v-for="day in schedule.days" :key="day.id">{{day.name.charAt(0)}}</li>
            </ul>
          </div>
          <div class="pills">
            <div class="delete" @click="deleteSchedule(schedule.id)">
              <div class="cross__first"></div>
              <div class="cross__second"></div>
            </div>
          </div>
          <i class="arrow"></i>
        </li>
      </ul>
      <button @click="redirect($event, 'newSchedule')" class="button">Créer un agenda</button>
    </div>
    <div v-else class="loader">plz wait...</div>
  </section>
</template>


<script>
import store from "../store.js";
import router from "../router.js";
import { mapMutations } from "vuex";
import { mapState } from "vuex";
export default {
  name: "ScheduleRouter",
  data() {
    return {
      componentReady: false
    };
  },
  computed: {
    ...mapState(["allSchedule"])
  },
  methods: {
    redirect(e, name) {
      router.push({ name: name });
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
    deleteSchedule(id) {
      window.axios
        .post("/deleteSchedule", { id: id })
        .then(response => {
          this.$store.dispatch("setAllSchedule");
        })
        .catch(error => console.error(error));
    }
  },
  beforeMount() {
    store.commit("setComponentDisplayed", "Mes agendas");
  },
  mounted() {
    this.$store.dispatch("setAllSchedule").then(() => {
      this.componentReady = true;
    });
  }
};
</script>

<style scoped>
</style>