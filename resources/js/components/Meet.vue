<template>
  <section id="meet">
    <div v-if="componentReady">
      <div v-if="myAppointments.length === 0" class="noMeeting">
        <p>vous n'avez pas de rendez-vous</p>
      </div>
      <div v-else>
        <ul class="list cards">
          <li class="list__item card" v-for="appointment in myAppointments" :key="appointment.id">
            <div class="date__hour">
              <span class="hour">{{appointment.hour}}</span>
              <span class="date">{{dateformat(appointment.date)}}</span>
            </div>

            <div class="practitioner__pills">
              <span class="practitioner">{{appointment.schedule.practitioner.name}}</span>
              <div class="pills">
                <div class="pill phone">
                  <a :href="'tel:' + appointment.schedule.practitioner.gsm"></a>
                  <img src="../../img/phone-call.svg" alt>
                </div>
                <div class="pill message">
                  <img src="../../img/speech-bubble.svg" alt>
                </div>
                <div class="pill delete">
                  <a
                    href
                    @click="deleteAppointment($event, appointment.schedule.id,appointment.hour,appointment.date)"
                  ></a>
                  <div class="cross__first"></div>
                  <div class="cross__second"></div>
                </div>
              </div>
            </div>
          </li>
        </ul>
      </div>
    </div>
    <div v-else class="loader">plz wait...</div>
  </section>
</template>

<script>
import store from "../store.js";
import { mapState } from "vuex";
import { mapMutations } from "vuex";
export default {
  name: "Meet",
  data() {
    return {
      componentReady: false,
      myAppointments: null
    };
  },
  computed: {
    ...mapState(["currentUser"])
  },
  methods: {
    deleteAppointment(e, schedule_id, hour, date) {
      e.preventDefault();
      e.stopPropagation();
      window.axios
        .post("/deleteAppointment", {
          schedule_id: schedule_id,
          hour: hour,
          date: date
        })
        .then(response => {
          window.axios
            .post("/getMyAppointments")
            .then(response => {
              this.myAppointments = response.data;
              this.componentReady = true;
            })
            .catch(error => console.error(error));
        })
        .catch(error => console.error(error));
    },
    dateformat(date) {
      const splitDate = date.split("-");

      return splitDate[2] + "-" + splitDate[1] + "-" + splitDate[0];
    }
  },
  beforeMount() {
    store.commit("setComponentDisplayed", "Rendez-vous");
  },
  mounted() {
    this.$store.dispatch("setCurrentUser").then(() => {
      window.axios
        .post("/getMyAppointments")
        .then(response => {
          this.myAppointments = response.data;
          this.componentReady = true;
        })
        .catch(error => console.error(error));
    });
  }
};
</script>

<style scoped>
</style>