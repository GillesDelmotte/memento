<template>
  <section id="meet">
    <div v-if="componentReady">
      <div v-if="myAppointments.length === 0" class="noMeeting">
        <p ref="noMeeting__p">vous n'avez pas de rendez-vous</p>
        <button
          class="button"
          ref="noMeeting__button"
          @click="takeAppointment"
        >Prendre un rendez-vous</button>
      </div>
      <div v-else>
        <ul class="list cards">
          <li
            class="list__item card"
            ref="card"
            v-for="appointment in myAppointments"
            :key="appointment.id"
          >
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
                  <a :href="'mailto:' + appointment.schedule.practitioner.email"></a>
                  <img src="../../img/speech-bubble.svg" alt>
                </div>
                <div class="pill delete">
                  <a
                    href
                    @click="deleteAppointment($event, appointment.schedule.id,appointment.hour,appointment.date, appointment.schedule.practitioner.id)"
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
    <div ref="loader" v-else class="loader"></div>
  </section>
</template>

<script>
import { TimelineMax } from "gsap";
import store from "../store.js";
import { mapState } from "vuex";
import { mapMutations } from "vuex";
import router from "../router.js";
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
    deleteAppointment(e, schedule_id, hour, date, id) {
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
        .then(() => {
          const { card, noMeeting__p, noMeeting__button } = this.$refs;
          var tl2 = new TimelineMax();
          if (noMeeting__p) {
            tl2
              .from(noMeeting__p, 0.3, {
                autoAlpha: 0,
                top: 50,
                ease: Power2.easeInOut
              })
              .from(
                noMeeting__button,
                0.3,
                {
                  autoAlpha: 0,
                  top: 50,
                  ease: Power2.easeInOut
                },
                0.1
              );
          }
        })
        .catch(error => console.error(error));

      window.axios
        .post("/sendEmail", {
          type: "remove",
          user_id: id,
          hour: hour,
          date: date
        })
        .then(response => {})
        .catch(function(error) {
          console.log(error.response.data.message);
        });
    },
    dateformat(date) {
      const splitDate = date.split("-");

      return splitDate[2] + "-" + splitDate[1] + "-" + splitDate[0];
    },
    takeAppointment() {
      router.push({ name: "practitionersFilter" });
    }
  },
  beforeMount() {
    store.commit("setComponentDisplayed", "Rendez-vous");
  },
  mounted() {
    var { loader } = this.$refs;

    var timeline = new TimelineMax({
      repeat: -1,
      yoyo: true
    });
    timeline.to(loader, 1, { autoAlpha: 0.3 });
    this.$store.dispatch("setCurrentUser").then(() => {
      window.axios
        .post("/getMyAppointments")
        .then(response => {
          this.myAppointments = response.data;
          this.componentReady = true;
        })
        .then(() => {
          const { card, noMeeting__p, noMeeting__button } = this.$refs;
          var tl = new TimelineMax();
          var tl2 = new TimelineMax();
          tl.staggerFrom(
            card,
            0.3,
            { autoAlpha: 0, top: 50, ease: Power2.easeInOut },
            0.1
          );
          if (noMeeting__p) {
            tl2
              .from(noMeeting__p, 0.3, {
                autoAlpha: 0,
                top: 50,
                ease: Power2.easeInOut
              })
              .from(
                noMeeting__button,
                0.3,
                {
                  autoAlpha: 0,
                  top: 50,
                  ease: Power2.easeInOut
                },
                0.1
              );
          }
        })
        .catch(error => console.error(error));
    });
  }
};
</script>

<style scoped>
</style>