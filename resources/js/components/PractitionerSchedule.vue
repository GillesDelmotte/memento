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
    <h2>{{practitioner.name}}</h2>
    <ul class="list">
      <li v-for="(hour, index) in createListMorning" :key="hour" class="list__item">
        <div v-if="index != createListMorning.length - 1" class="hours">
          <p>{{hour}}</p>
          <p>{{createListMorning[index + 1]}}</p>
        </div>
        <div class="person" v-if="index != createListMorning.length - 1">
          <a href @click="reserve($event, hour)"></a>
        </div>
      </li>
    </ul>
    <ul class="list">
      <li v-for="(hour, index) in createListAfternoon" :key="hour" class="list__item">
        <div v-if="index != createListAfternoon.length - 1" class="hours">
          <p>{{hour}}</p>
          <p>{{createListAfternoon[index + 1]}}</p>
        </div>
        <div class="person" v-if="index != createListAfternoon.length - 1">
          <a href @click="reserve($event, hour)"></a>
        </div>
      </li>
    </ul>
    <div
      class="noSchedule"
      v-if="this.displayed === 'noSchedule'"
    >votre praticien n'a pas encore d'agenda en ligne</div>
    <div v-if="this.displayed === 'holiday'" class="holiday">votre praticien est en congé</div>
  </section>
  <section v-else class="loader">plz wait...</section>
</template>

<script>
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
        "dimanche",
        "lundi",
        "mardi",
        "mercredi",
        "jeudi",
        "vendredi",
        "samedi"
      ],
      dayNumber: null,
      date: null,
      displayed: "schedule"
    };
  },
  computed: {
    ...mapState(["schedule", "allPractitioner", "currentUser"]),
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

      const data = {
        user_id: this.practitioner.id,
        client_id: this.currentUser.id,
        hour: hour,
        date: this.date
      };

      window.axios
        .post("/createAppointment", data)
        .then(response => {
          console.log(response);
        })
        .catch(function(error) {
          console.log(error.response.data.message);
        });
    }
  },
  mounted() {
    this.$store.dispatch("setScheduleDays", this.$route.params.id).then(() => {
      this.componentReady = true;
      this.day;
    });
  }
};
</script>

<style scoped>
</style>