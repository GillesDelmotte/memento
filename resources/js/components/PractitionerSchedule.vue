<template>
  <section id="practitionerSchedule" v-if="componentReady">
    <div class="date">
      <span>
        <i class="previousDate" @click="previousDate"></i>
        {{days[dayNumber]}}, {{date}}
        <i class="nextDate" @click="nextDate"></i>
      </span>
      <img src="../../img/picker.svg" alt class="picker" @click="datePicker">
    </div>
    <input type="date" class="datePicker" @change="changeDate">
    <div class="practitioner__infos" ref="practitioner__infos">
      <div v-if="practitioner.image != null" class="photo">
        <img :src="'./images/profile/' + practitioner.image.image_name" alt>
      </div>
      <div v-else class="photo"></div>
      <div class="name__job">
        <h2>{{practitioner.name}}</h2>
        <span>{{practitioner.job.name}}</span>
      </div>
      <div class="pills">
        <div class="pill phone">
          <a :href="'tel:' + practitioner.gsm"></a>
          <img src="../../img/phone-call.svg" alt>
        </div>
        <div class="pill message">
          <a :href="'mailto:' + practitioner.email"></a>
          <img src="../../img/speech-bubble.svg" alt>
        </div>
      </div>
    </div>

    <ul class="list">
      <li
        v-for="(hour, index) in createListMorning"
        :key="hour"
        class="list__item"
        ref="list__morning"
      >
        <div v-if="index != createListMorning.length - 1" class="hours">
          <p>{{hour}}</p>
          <p>{{createListMorning[index + 1]}}</p>
        </div>
        <div class="person" v-if="index != createListMorning.length - 1 && reserved(hour) === true">
          <a href @click="reserve($event, hour)"></a>
        </div>
        <div
          v-else-if="index != createListMorning.length - 1  && reserved(hour) === false"
          class="person disabled"
        ></div>
        <div
          v-else-if="index != createListMorning.length - 1  && reserved(hour) === 'myAppointment'"
          class="person myAppointment"
        >
          <a href @click="deleteAppointment($event,hour)"></a>
          {{currentUser.name}}
          <div class="cross">
            <div class="cross__first"></div>
            <div class="cross__second"></div>
          </div>
        </div>
      </li>
    </ul>
    <ul class="list">
      <li
        v-for="(hour, index) in createListAfternoon"
        :key="hour"
        class="list__item"
        ref="list__afternoon"
      >
        <div v-if="index != createListAfternoon.length - 1" class="hours">
          <p>{{hour}}</p>
          <p>{{createListAfternoon[index + 1]}}</p>
        </div>

        <div
          class="person"
          v-if="index != createListAfternoon.length - 1 && reserved(hour) === true"
        >
          <a href @click="reserve($event, hour)"></a>
        </div>
        <div
          v-else-if="index != createListMorning.length - 1 && reserved(hour) === false"
          class="person disabled"
        ></div>
        <div
          v-else-if="index != createListMorning.length - 1  && reserved(hour) === 'myAppointment'"
          class="person myAppointment"
        >
          <a href @click="deleteAppointment($event, hour)"></a>
          {{currentUser.name}}
          <div class="cross">
            <div class="cross__first"></div>
            <div class="cross__second"></div>
          </div>
        </div>
      </li>
    </ul>
    <div
      class="noSchedule"
      v-if="this.displayed === 'noSchedule'"
      ref="noSchedule"
    >votre praticien n'a pas encore d'agenda en ligne</div>
    <div
      v-if="this.displayed === 'holiday'"
      class="holiday"
      ref="holiday"
    >votre praticien est en congé</div>
  </section>
  <div ref="loader" v-else class="loader"></div>
</template>

<script>
import { TimelineMax } from "gsap";
import store from "../store.js";
import { mapMutations } from "vuex";
import router from "../router.js";
import { mapState } from "vuex";
export default {
  name: "PractitionerSchedule",
  data() {
    return {
      componentReady: false,
      days: [
        "Dimanche",
        "Lundi",
        "Mardi",
        "Mercredi",
        "Jeudi",
        "Vendredi",
        "Samedi"
      ],
      dayNumber: null,
      date: null,
      displayed: "schedule"
    };
  },
  computed: {
    ...mapState(["schedule", "allPractitioner", "currentUser", "appointments"]),
    practitioner() {
      const practitioner = this.allPractitioner.filter(
        practitioner => practitioner.id === this.$route.params.id
      );
      return practitioner[0];
    },
    day() {
      var d = new Date();

      var today = new Date();
      var dd = String(today.getDate()).padStart(2, "0");
      var mm = String(today.getMonth() + 1).padStart(2, "0");
      var yyyy = today.getFullYear();
      today = dd + "-" + mm + "-" + yyyy;

      this.date = today;

      this.dayNumber = d.getDay();
    },
    createListMorning() {
      const morning = [];

      if (this.schedule.length === 0) {
        this.displayed = "noSchedule";
        return;
      }

      const day = this.schedule.days.find(day => {
        return day.name === this.days[this.dayNumber];
      });

      if (day === undefined) {
        this.displayed = "holiday";
        return;
      }

      this.displayed = "schedule";

      var ms = day.ms.split(":");
      var msh = parseInt(ms[0], 10);
      var msm = parseInt(ms[1], 10);

      morning.push(msh + ":" + msm);

      const milliDateStart = new Date("1970-01-01T" + day.ms + "Z").getTime();
      const milliDateEnd = new Date("1970-01-01T" + day.me + "Z").getTime();

      const diff = (milliDateEnd - milliDateStart) / (day.time * 60000);

      for (var i = 1; i <= diff; i++) {
        //var test = msm;
        msm = msm + day.time;

        if (msm >= 60) {
          msm = msm - 60;
          msh += 1;
          morning.push(msh + ":" + msm);
        } else {
          morning.push(msh + ":" + msm);
        }
      }
      return morning;
    },
    createListAfternoon() {
      const afternoon = [];

      if (this.schedule.length === 0) {
        return;
      }

      const day = this.schedule.days.find(day => {
        return day.name === this.days[this.dayNumber];
      });

      if (day === undefined) {
        return;
      }

      var as = day.as.split(":");
      var ash = parseInt(as[0], 10);
      var asm = parseInt(as[1], 10);

      afternoon.push(ash + ":" + asm);

      const milliDateStart = new Date("1970-01-01T" + day.as + "Z").getTime();
      const milliDateEnd = new Date("1970-01-01T" + day.ae + "Z").getTime();

      const diff = (milliDateEnd - milliDateStart) / (day.time * 60000);

      for (var i = 1; i <= diff; i++) {
        //var test = msm;
        asm = asm + day.time;

        if (asm >= 60) {
          asm = asm - 60;
          ash += 1;
          afternoon.push(ash + ":" + asm);
        } else {
          afternoon.push(ash + ":" + asm);
        }
      }
      return afternoon;
    }
  },
  methods: {
    datePicker() {
      const picker = document.querySelector(".datePicker");
      if (picker.classList.contains("displayed")) {
        picker.classList.remove("displayed");
      } else {
        picker.classList.add("displayed");
        picker.focus();
      }
    },
    changeDate() {
      const picker = document.querySelector(".datePicker");
      const newDate = document.querySelector(".datePicker").value;
      const splitDate = newDate.split("-");

      if (splitDate[0] < 2018 || splitDate[0] > 9999) {
        return;
      }

      const fullDate = new Date(newDate);

      this.date = splitDate[2] + "-" + splitDate[1] + "-" + splitDate[0];
      this.dayNumber = fullDate.getDay();
      picker.classList.remove("displayed");
    },
    previousDate() {
      const splitDate = this.date.split("-");
      const date = splitDate[1] + "-" + splitDate[0] + "-" + splitDate[2];

      const newDate = new Date(date);
      newDate.setDate(newDate.getDate() - 1);
      this.dayNumber = newDate.getDay();

      var dd = String(newDate.getDate()).padStart(2, "0");
      var mm = String(newDate.getMonth() + 1).padStart(2, "0"); //January is 0!
      var yyyy = newDate.getFullYear();

      this.date = dd + "-" + mm + "-" + yyyy;
    },
    nextDate() {
      const splitDate = this.date.split("-");
      const date = splitDate[1] + "-" + splitDate[0] + "-" + splitDate[2];

      const newDate = new Date(date);
      newDate.setDate(newDate.getDate() + 1);
      this.dayNumber = newDate.getDay();

      var dd = String(newDate.getDate()).padStart(2, "0");
      var mm = String(newDate.getMonth() + 1).padStart(2, "0"); //January is 0!
      var yyyy = newDate.getFullYear();

      this.date = dd + "-" + mm + "-" + yyyy;
    },
    reserve(e, hour) {
      e.preventDefault();
      e.stopPropagation();

      const splitDate = this.date.split("-");

      const data = {
        user_id: this.currentUser.id,
        schedule_id: this.schedule.id,
        hour: hour,
        date: splitDate[2] + "-" + splitDate[1] + "-" + splitDate[0]
      };

      window.axios
        .post("/createAppointment", data)
        .then(response => {
          this.$store.dispatch("setAppointments", {
            id: this.schedule.id,
            client: false
          });
        })
        .catch(function(error) {
          console.log(error.response.data.message);
        });
    },
    reserved(hour) {
      const splitDate = this.date.split("-");

      const appointment = this.appointments.filter(
        appointment =>
          appointment.hour === hour &&
          appointment.date ===
            splitDate[2] + "-" + splitDate[1] + "-" + splitDate[0]
      );

      if (appointment[0] != undefined) {
        if (appointment[0].user_id === this.currentUser.id) {
          return "myAppointment";
        }
        return false;
      } else {
        return true;
      }
    },
    deleteAppointment(e, hour) {
      e.preventDefault();
      e.stopPropagation();

      const splitDate = this.date.split("-");

      window.axios
        .post("/deleteAppointment", {
          schedule_id: this.schedule.id,
          hour: hour,
          date: splitDate[2] + "-" + splitDate[1] + "-" + splitDate[0]
        })
        .then(response => {
          this.$store.dispatch("setAppointments", {
            id: this.schedule.id,
            client: false
          });
        })
        .catch(error => console.error(error));

      window.axios
        .post("/sendEmail", {
          type: "remove",
          user_id: this.practitioner.id,
          hour: hour,
          date: splitDate[2] + "-" + splitDate[1] + "-" + splitDate[0]
        })
        .then(response => {})
        .catch(function(error) {
          console.log(error.response.data.message);
        });
    }
  },
  mounted() {
    var { loader } = this.$refs;
    var timeline = new TimelineMax({
      repeat: -1,
      yoyo: true
    });
    timeline.to(loader, 1, { autoAlpha: 0.3 });
    this.$store.dispatch("setScheduleDays", this.$route.params.id).then(() => {
      this.$store
        .dispatch("setAppointments", { id: this.schedule.id, client: false })
        .then(() => {
          this.componentReady = true;
          this.day;
        })
        .then(() => {
          const {
            list__morning,
            list__afternoon,
            holiday,
            noSchedule,
            practitioner__infos
          } = this.$refs;

          var tl = new TimelineMax();

          if (list__morning) {
            tl.from(practitioner__infos, 0.3, { autoAlpha: 0 })
              .staggerFrom(
                list__morning,
                0.3,
                { autoAlpha: 0, top: 50, ease: Power2.easeInOut },
                0.1,
                0.2
              )
              .staggerFrom(
                list__afternoon,
                0.3,
                { autoAlpha: 0, top: 50, ease: Power2.easeInOut },
                0.1
              );
          }

          if (holiday) {
            tl.from(practitioner__infos, 0.3, { autoAlpha: 0 }).from(
              holiday,
              0.3,
              {
                autoAlpha: 0,
                top: "+=50px",
                ease: Power2.easeInOut
              },
              0.2
            );
          }

          if (noSchedule) {
            tl.from(practitioner__infos, 0.3, { autoAlpha: 0 }).from(
              holiday,
              0.3,
              {
                autoAlpha: 0,
                top: "+=50px",
                ease: Power2.easeInOut
              },
              0.2
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