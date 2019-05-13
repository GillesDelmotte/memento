<template>
  <div id="newSchedule">
    <div class="schedule__name">
      <input type="text" id="name" name="name" required autocomplete="off">
      <label for="name">Nom de l'agenda&nbsp;:</label>
    </div>
    <ul class="days">
      <li v-for="day in days" :key="day.key" :class="day.key === 1? 'day open' : 'day'">
        <h3 class="day__name" @click="open($event)">
          <span>{{day.name}}</span>
          <i class="closer"></i>
        </h3>
        <div class="day__content">
          <div>
            <input type="checkbox" :id="day.name + '_conge'">
            <label :for="day.name + '_conge'">congé</label>
          </div>
          <div>
            <label :for="day.name + '_time'">choississez la durée de vos séances</label>
            <select :name="day.name + '_time'" :id="day.name + '_time'">
              <option value="15">15</option>
              <option value="30">30</option>
              <option value="45">45</option>
              <option value="60">60</option>
            </select>
          </div>
          <div class="morning">
            <!-- <span class="morning__span">Matin</span> -->
            <div class="morning__time">
              <input
                type="time"
                class="input__time"
                :id="day.name + '_morning_start'"
                value="08:30"
              >

              <input type="time" class="input__time" :id="day.name + '_morning_end'" value="12:30">
            </div>
          </div>
          <div class="midi">
            <span class="midi__span">Temps de midi</span>
          </div>
          <div class="afternoon">
            <!-- <span class="afternoon__span">Après-midi</span> -->
            <div class="afternoon__time">
              <input
                type="time"
                class="input__time"
                :id="day.name + '_afternoon_start'"
                value="13:30"
              >

              <input
                type="time"
                class="input__time"
                :id="day.name + '_afternoon_end'"
                value="17:30"
              >
            </div>
          </div>
        </div>
      </li>
    </ul>
    <button class="saveSchedule button" @click="saveSchedule">Enregister l'agenda</button>
  </div>
</template>

<script>
import store from "../store.js";
import router from "../router.js";
import { mapMutations } from "vuex";
export default {
  name: "NewSchedule",
  data() {
    return {
      days: [
        { key: 1, name: "Lundi" },
        { key: 2, name: "Mardi" },
        { key: 3, name: "Mercredi" },
        { key: 4, name: "Jeudi" },
        { key: 5, name: "Vendredi" },
        { key: 6, name: "Samedi" },
        { key: 7, name: "Dimanche" }
      ]
    };
  },
  methods: {
    open(e) {
      if (e.currentTarget.parentElement.classList.contains("open")) {
        e.currentTarget.parentElement.classList.remove("open");
      } else {
        e.currentTarget.parentElement.classList.add("open");
      }
    },
    saveSchedule() {
      const name = document.getElementById("name").value;

      const scheduledays = [];

      //----------------------
      // Lundi
      //----------------------

      if (document.getElementById("Lundi_conge").checked === false) {
        const ms = document.getElementById("Lundi_morning_start").value;
        const me = document.getElementById("Lundi_morning_end").value;
        const as = document.getElementById("Lundi_afternoon_start").value;
        const ae = document.getElementById("Lundi_afternoon_end").value;
        const time = document.getElementById("Lundi_time").value;
        const lundi = {
          name: "lundi",
          ms: ms,
          me: me,
          as: as,
          ae: ae,
          time: time
        };
        scheduledays.push(lundi);
      }

      //----------------------
      // Mardi
      //----------------------

      if (document.getElementById("Mardi_conge").checked === false) {
        const ms = document.getElementById("Mardi_morning_start").value;
        const me = document.getElementById("Mardi_morning_end").value;
        const as = document.getElementById("Mardi_afternoon_start").value;
        const ae = document.getElementById("Mardi_afternoon_end").value;
        const time = document.getElementById("Mardi_time").value;
        const mardi = {
          name: "mardi",
          ms: ms,
          me: me,
          as: as,
          ae: ae,
          time: time
        };
        scheduledays.push(mardi);
      }

      //----------------------
      // Mercredi
      //----------------------

      if (document.getElementById("Mercredi_conge").checked === false) {
        const ms = document.getElementById("Mercredi_morning_start").value;
        const me = document.getElementById("Mercredi_morning_end").value;
        const as = document.getElementById("Mercredi_afternoon_start").value;
        const ae = document.getElementById("Mercredi_afternoon_end").value;
        const time = document.getElementById("Mercredi_time").value;
        const mercredi = {
          name: "mercredi",
          ms: ms,
          me: me,
          as: as,
          ae: ae,
          time: time
        };
        scheduledays.push(mercredi);
      }

      //----------------------
      // Jeudi
      //----------------------

      if (document.getElementById("Jeudi_conge").checked === false) {
        const ms = document.getElementById("Jeudi_morning_start").value;
        const me = document.getElementById("Jeudi_morning_end").value;
        const as = document.getElementById("Jeudi_afternoon_start").value;
        const ae = document.getElementById("Jeudi_afternoon_end").value;
        const time = document.getElementById("Jeudi_time").value;
        const jeudi = {
          name: "jeudi",
          ms: ms,
          me: me,
          as: as,
          ae: ae,
          time: time
        };
        scheduledays.push(jeudi);
      }

      //----------------------
      // Vendredi
      //----------------------

      if (document.getElementById("Vendredi_conge").checked === false) {
        const ms = document.getElementById("Vendredi_morning_start").value;
        const me = document.getElementById("Vendredi_morning_end").value;
        const as = document.getElementById("Vendredi_afternoon_start").value;
        const ae = document.getElementById("Vendredi_afternoon_end").value;
        const time = document.getElementById("Vendredi_time").value;
        const vendredi = {
          name: "vendredi",
          ms: ms,
          me: me,
          as: as,
          ae: ae,
          time: time
        };
        scheduledays.push(vendredi);
      }

      //----------------------
      // Samedi
      //----------------------

      if (document.getElementById("Samedi_conge").checked === false) {
        const ms = document.getElementById("Samedi_morning_start").value;
        const me = document.getElementById("Samedi_morning_end").value;
        const as = document.getElementById("Samedi_afternoon_start").value;
        const ae = document.getElementById("Samedi_afternoon_end").value;
        const time = document.getElementById("Samedi_time").value;
        const samedi = {
          name: "samedi",
          ms: ms,
          me: me,
          as: as,
          ae: ae,
          time: time
        };
        scheduledays.push(samedi);
      }

      //----------------------
      // Dimanche
      //----------------------

      if (document.getElementById("Dimanche_conge").checked === false) {
        const ms = document.getElementById("Dimanche_morning_start").value;
        const me = document.getElementById("Dimanche_morning_end").value;
        const as = document.getElementById("Dimanche_afternoon_start").value;
        const ae = document.getElementById("Dimanche_afternoon_end").value;
        const time = document.getElementById("Dimanche_time").value;
        const dimanche = {
          name: "dimanche",
          ms: ms,
          me: me,
          as: as,
          ae: ae,
          time: time
        };
        scheduledays.push(dimanche);
      }

      window.axios
        .post("/createSchedule", {
          name: name,
          days: scheduledays
        })
        .then(response => {
          router.go(-1);
        })
        .catch(function(error) {
          console.log(error.response.data.message);
        });
    }
  },
  beforeMount() {
    store.commit("setComponentDisplayed", "Nouvel horaire");
  }
};
</script>

<style scoped>
</style>