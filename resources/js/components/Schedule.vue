<template>
  <section v-if="componentReady" id="mySchedule">
    <div class="date">
      <span>
        <i class="previousDate" @click="previousDate"></i>
        {{days[dayNumber]}}, {{date}}
        <i class="nextDate" @click="nextDate"></i>
      </span>
      <img src="../../img/picker.svg" alt class="picker" @click="datePicker">
    </div>
    <input type="date" class="datePicker" @change="changeDate">
    <ul class="list">
      <li
        v-for="(hour, index) in createListMorning"
        :key="hour"
        class="list__item"
        v-hammer:press="(event)=> openMenu(event,hour)"
      >
        <div v-if="index != createListMorning.length - 1" class="hours">
          <p>{{hour}}</p>
          <p>{{createListMorning[index + 1]}}</p>
        </div>
        <div class="person" v-if="index != createListMorning.length - 1">{{getAppointement(hour)}}</div>
      </li>
    </ul>
    <ul class="list">
      <li
        v-for="(hour, index) in createListAfternoon"
        :key="hour"
        class="list__item"
        v-hammer:press="(event)=> openMenu(event, hour)"
      >
        <div v-if="index != createListAfternoon.length - 1" class="hours">
          <p>{{hour}}</p>
          <p>{{createListAfternoon[index + 1]}}</p>
        </div>
        <div class="person" v-if="index != createListAfternoon.length - 1">{{getAppointement(hour)}}</div>
      </li>
    </ul>
    <div class="noSchedule" v-if="this.displayed === 'noSchedule'">
      <p>vous n'avez pas encore créer d'agenda</p>
      <button class="button" @click="redirect">Créer un agenda</button>
    </div>
    <div v-if="this.displayed === 'holiday'" class="holiday">
      <p>vous êtes en congé</p>
    </div>
    <div class="deleteAppointment">
      <div>
        <p>Voulez vous vraiment supprimer ce rendez-vous ?</p>
        <p>{{this.date}}, {{this.updateHour}}, {{this.updateName}}</p>
        <button @click="deleteAppointment">oui</button>
        <button @click="notDelete">non</button>
      </div>
    </div>
    <div class="addAppointment">
      <div>
        <p>Qui voulez vous ajouter à cette date ?</p>
        <p>{{this.date}}, {{this.updateHour}}</p>
        <select name id="client__name" class="select">
          <option :value="client.id" v-for="client in this.clients" :key="client.id">{{client.name}}</option>
        </select>
        <button @click="addAppointment">Ajouter</button>
        <button @click="notAdd">Annuler</button>
      </div>
    </div>
  </section>

  <section v-else class="loader">plz wait...</section>
</template>

<script>
import { VueHammer } from "vue2-hammer";
import store from "../store.js";
import { mapMutations } from "vuex";
import router from "../router.js";
import { mapState } from "vuex";
export default {
  name: "Schedule",
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
      displayed: "schedule",
      updateName: null,
      updateHour: null,
      clients: []
    };
  },
  computed: {
    ...mapState(["schedule", "currentUser", "appointments"]),
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
    redirect() {
      router.push({ name: "newSchedule" });
    },
    getAppointement(hour) {
      const splitDate = this.date.split("-");
      const appointment = this.appointments.filter(
        appointment =>
          appointment.hour === hour &&
          appointment.date ===
            splitDate[2] + "-" + splitDate[1] + "-" + splitDate[0]
      );

      if (appointment[0] != undefined) {
        return appointment[0].client.name;
      }
    },
    openMenu(e, hour) {
      const splitDate = this.date.split("-");
      const appointment = this.appointments.filter(
        appointment =>
          appointment.hour === hour &&
          appointment.date ===
            splitDate[2] + "-" + splitDate[1] + "-" + splitDate[0]
      );

      if (appointment[0] != undefined) {
        this.updateHour = hour;
        this.updateName = appointment[0].client.name;
        document.querySelector(".deleteAppointment").classList.add("open");
      } else {
        this.updateHour = hour;
        document.querySelector(".addAppointment").classList.add("open");
      }
    },
    deleteAppointment() {
      const splitDate = this.date.split("-");

      window.axios
        .post("/deleteAppointment", {
          schedule_id: this.schedule.id,
          hour: this.updateHour,
          date: splitDate[2] + "-" + splitDate[1] + "-" + splitDate[0]
        })
        .then(response => {
          this.$store.dispatch("setAppointments", {
            id: this.schedule.id,
            client: true
          });
          this.updateHour = null;
          this.updateName = null;
          document.querySelector(".deleteAppointment").classList.remove("open");
        })
        .catch(error => console.error(error));
    },
    notDelete() {
      this.updateHour = null;
      this.updateName = null;
      document.querySelector(".deleteAppointment").classList.remove("open");
    },
    addAppointment() {
      const splitDate = this.date.split("-");

      const data = {
        user_id: document.getElementById("client__name").value,
        schedule_id: this.schedule.id,
        hour: this.updateHour,
        date: splitDate[2] + "-" + splitDate[1] + "-" + splitDate[0]
      };

      window.axios
        .post("/createAppointment", data)
        .then(response => {
          this.$store.dispatch("setAppointments", {
            id: this.schedule.id,
            client: true
          });
          document.querySelector(".addAppointment").classList.remove("open");
          window.axios
            .post("/sendEmail", {
              type: "add",
              user_id: document.getElementById("client__name").value,
              hour: this.updateHour,
              date: splitDate[2] + "-" + splitDate[1] + "-" + splitDate[0]
            })
            .then(response => {
              this.updateHour = null;
            })
            .catch(function(error) {
              console.log(error.response.data.message);
            });
        })
        .catch(function(error) {
          console.log(error.response.data.message);
        });
    },
    notAdd() {
      this.updateHour = null;
      document.querySelector(".addAppointment").classList.remove("open");
    }
  },
  beforeMount() {
    store.commit("setComponentDisplayed", "Horaire");
  },
  mounted() {
    this.$store.dispatch("setScheduleDays", this.currentUser.id).then(() => {
      this.$store
        .dispatch("setAppointments", { id: this.schedule.id, client: true })
        .then(() => {
          window.axios
            .post("/getClients", { id: this.schedule.id })
            .then(response => {
              this.clients = response.data;
              this.componentReady = true;
              this.day;
            })
            .catch(error => console.error(error));
        });
    });
  }
};
</script>

<style scoped>
</style>